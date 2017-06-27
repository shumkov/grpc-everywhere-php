<?php


namespace GrpcEverywhere\Test\ResponseData;


use GrpcEverywhere\ResponseData\SuccessResponseData;
use GrpcEverywhere\Test\Stub\Simple;

class SuccessResponseDataTest extends \PHPUnit_Framework_TestCase
{


    public function testSuccess()
    {
        $simple = new Simple();
        $simple->setBool(true);
        $simple->setString("test");
        $simple->setInt32(32);

        $data = (string)new SuccessResponseData($simple);

        static::assertEquals('{"isSuccess":true,"message":{"int32":32,"bool":true,"string":"test"}}', $data);
    }
}
