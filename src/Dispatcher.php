<?php

namespace GrpcEverywhere;

use GrpcEverywhere\Exception\GrpcEverywhereException;
use GrpcEverywhere\Exception\HandlerNotPresentException;
use GrpcEverywhere\Exception\InvalidRequestException;
use GrpcEverywhere\Exception\InvalidResponseMessage;
use GrpcEverywhere\ResponseData\ErrorResponseData;
use GrpcEverywhere\ResponseData\ResponseDataInterface;
use GrpcEverywhere\ResponseData\SuccessResponseData;
use DrSlump\Protobuf\CodecInterface;
use DrSlump\Protobuf\Message;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Dispatcher
 * @package GrpcEverywhere
 */
class Dispatcher
{
    /**
     * @var CodecInterface
     */
    protected $codec;

    /**
     * @var MessageClassNameResolver
     */
    protected $messageClassNameResolver;

    /**
     * Dispatcher constructor.
     *
     * @param CodecInterface           $codec
     * @param MessageClassNameResolver $messageClassNameResolver
     */
    public function __construct(
        CodecInterface $codec,
        MessageClassNameResolver $messageClassNameResolver
    ) {
        $this->codec = $codec;
        $this->messageClassNameResolver = $messageClassNameResolver;
    }

    /**
     * @param Service           $service
     * @param Request           $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     *
     * @throws HandlerNotPresentException
     * @throws InvalidRequestException
     * @throws InvalidResponseMessage
     */
    public function dispatch(Service $service, Request $request, ResponseInterface $response)
    {
        $handler = $service->getHandlerByRequest($request);

        $requestMessage = $this->createRequestMessage($request);

        $responseData = $this->callHandler($handler, $requestMessage, $request);

        $response->getBody()->write($responseData);

        return $response;
    }

    /**
     * @param callable $handler
     * @param Message  $requestMessage
     * @param Request  $request
     *
     * @return ResponseDataInterface
     * @throws InvalidResponseMessage
     */
    public function callHandler($handler, $requestMessage, Request $request)
    {
        try {
            $responseMessage = call_user_func($handler, $requestMessage);
        } catch (GrpcEverywhereException $e) {
            return new ErrorResponseData($e->getMessage(), $e->getCode());
        }

        /** @var Message $responseMessage */
        $responseMessageClassName = $this->messageClassNameResolver->resolve(
            $request,
            $request->getResponseMessageName()
        );

        if (!is_a($responseMessage, $responseMessageClassName)) {
            $message = sprintf(
                'Invalid response message %s. Expected %s.',
                get_class($responseMessage),
                $responseMessageClassName
            );

            throw new InvalidResponseMessage($message);
        }

        return new SuccessResponseData($responseMessage);
    }

    /**
     * @param Request $request
     *
     * @return object
     * @throws InvalidRequestException
     */
    protected function createRequestMessage(Request $request)
    {
        $messageClassName = $this->messageClassNameResolver->resolve(
            $request,
            $request->getRequestMessageName()
        );

        $json = $request->getMessage()->getContents();

        /** @var Message $message */
        $message = new $messageClassName();
        $message->parse($json, $this->codec);

        return $message;
    }
}