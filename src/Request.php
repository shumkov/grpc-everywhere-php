<?php

namespace GrpcEverywhere;

use GrpcEverywhere\Exception\InvalidRequestException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class Request
 * @package GrpcEverywhere
 */
class Request
{
    /**
     * @var string
     */
    protected $methodName;

    /**
     * @var string
     */
    protected $requestMessageName;

    /**
     * @var string
     */
    protected $responseMessageName;

    /**
     * @var string
     */
    protected $isRequestStream;

    /**
     * @var string
     */
    protected $isResponseStream;

    /**
     * @var string
     */
    protected $packageName;

    /**
     * @var string
     */
    protected $serviceName;

    /**
     * @var string
     */
    protected $options;

    /**
     * @var StreamInterface
     */
    protected $message;

    /**
     * Request constructor.
     * @param array           $params
     * @param StreamInterface $message
     * @throws InvalidRequestException
     */
    public function __construct(array $params, StreamInterface $message)
    {
        $paramsNames = [
            'methodName',
            'requestMessageName',
            'responseMessageName',
            'isRequestStream',
            'isResponseStream',
            'packageName',
            'serviceName',
            'options'
        ];

        foreach ($paramsNames as $name) {
            if (!array_key_exists($name, $params)) {
                throw new InvalidRequestException("Param $name is not present");
            }

            $this->{$name} = $params[$name];
        }

        $this->isRequestStream = (boolean)$this->isRequestStream;
        $this->isResponseStream = (boolean)$this->isResponseStream;

        $this->message = $message;
    }

    /**
     * @param ServerRequestInterface $request
     * @return Request
     * @throws InvalidRequestException
     */
    public static function fromHttpRequest(ServerRequestInterface $request)
    {
        return new static(
            $request->getQueryParams(),
            $request->getBody()
        );
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @return string
     */
    public function getRequestMessageName()
    {
        return $this->requestMessageName;
    }

    /**
     * @return string
     */
    public function getResponseMessageName()
    {
        return $this->responseMessageName;
    }

    /**
     * @return string
     */
    public function getIsRequestStream()
    {
        return $this->isRequestStream;
    }

    /**
     * @return string
     */
    public function getIsResponseStream()
    {
        return $this->isResponseStream;
    }

    /**
     * @return string
     */
    public function getPackageName()
    {
        return $this->packageName;
    }

    /**
     * @return string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return StreamInterface
     */
    public function getMessage()
    {
        return $this->message;
    }
}