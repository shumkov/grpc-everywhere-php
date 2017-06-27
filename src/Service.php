<?php


namespace GrpcEverywhere;

use GrpcEverywhere\Exception\HandlerNotPresentException;

/**
 * Class Service
 * @package GrpcEverywhere
 */
class Service
{
    /**
     * @var string
     */
    protected $package;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var callable[]
     */
    protected $handlers;

    /**
     * Service constructor.
     * @param $package
     * @param $name
     */
    public function __construct($package, $name)
    {
        $this->package = $package;
        $this->name = $name;
    }

    /**
     * @param string   $methodName
     * @param callable $callable
     */
    public function setHandler($methodName, callable $callable)
    {
        $this->handlers[$methodName] = $callable;
    }

    /**
     * @param Request $request
     * @return callable
     * @throws HandlerNotPresentException
     */
    public function getHandlerByRequest(Request $request)
    {
        if ($this->package !== $request->getPackageName() ||
            $this->name !== $request->getServiceName() ||
            !array_key_exists($request->getMethodName(), $this->handlers)
        ) {
            $descriptorParams = [$request->getPackageName(), $request->getServiceName(), $request->getMethodName()];
            $descriptor = implode('.', $descriptorParams);

            throw new HandlerNotPresentException("Handler for {$descriptor} not present");
        }

        return $this->handlers[$request->getMethodName()];
    }
}