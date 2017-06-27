<?php

namespace GrpcEverywhere\ResponseData;

use DrSlump\Protobuf\Codec\PhpArray;
use DrSlump\Protobuf\Message;

/**
 * Class SuccessResponseData
 * @package GrpcEverywhere\ResponseData
 */
class SuccessResponseData extends AbstractResponseData
{
    /**
     * SuccessResponseData constructor.
     *
     * @param $message
     */
    public function __construct(Message $message)
    {
        $this->data = [
            'isSuccess' => true,
            'message' => $message->serialize(new PhpArray()),
        ];
    }


}