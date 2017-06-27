<?php


namespace GrpcEverywhere\Test\ResponseData;


use GrpcEverywhere\ResponseData\ErrorResponseData;

class ErrorResponseDataTest extends \PHPUnit_Framework_TestCase
{


    public function testSuccess()
    {
        $data = (string)new ErrorResponseData('test', 125);

        static::assertEquals('{"isSuccess":false,"error":{"message":"test","code":125}}', $data);
    }
}