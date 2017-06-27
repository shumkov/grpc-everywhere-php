<?php

namespace GrpcEverywhere;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Middleware
 * @package GrpcEverywhere
 */
class Middleware
{
    /**
     * @var Service
     */
    protected $service;

    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * Middleware constructor.
     *
     * @param Service    $service
     * @param Dispatcher $dispatcher
     */
    public function __construct(Service $service, Dispatcher $dispatcher)
    {
        $this->service = $service;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable               $next
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $serverParams = $request->getServerParams();

        if (!array_key_exists('SERVER_SOFTWARE', $serverParams) ||
            $serverParams['SERVER_SOFTWARE'] !== 'GRPC everywhere'
        ) {
            return $next($request, $response);
        }

        $grpcRequest = Request::fromHttpRequest($request);

        return $this->dispatcher->dispatch($this->service, $grpcRequest, $response);
    }
}
