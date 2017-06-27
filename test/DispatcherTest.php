<?php


namespace GrpcEverywhere\Test;


use GrpcEverywhere\Dispatcher;
use GrpcEverywhere\MessageClassNameResolver;
use GrpcEverywhere\ResponseData\SuccessResponseData;
use GrpcEverywhere\Test\Stub\Simple;
use DrSlump\Protobuf\CodecInterface;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{


    public function testCallHandler()
    {

        $dispatcher = new Dispatcher(
            $this->getMockBuilder(CodecInterface::class)->getMock(),
            $this->getMockBuilder(MessageClassNameResolver::class)->getMock()
        );

        $message = new Simple();

        $responseData = $dispatcher->callHandler(function (Simple $message) {
            static::assertInstanceOf(Simple::class, $message);
            return $message;
        }, $message, Simple::class);

        static::assertInstanceOf(SuccessResponseData::class, $responseData);
    }
}