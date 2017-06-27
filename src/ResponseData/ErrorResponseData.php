<?php


namespace GrpcEverywhere\ResponseData;


/**
 * Class ErrorResponseData
 * @package GrpcEverywhere\ResponseData
 */
class ErrorResponseData extends AbstractResponseData
{

    /**
     * ErrorResponseData constructor.
     *
     * @param     $message
     * @param int $code
     */
    public function __construct($message, $code = 1)
    {
        $this->data = [
            'isSuccess' => false,
            'error' => [
                'message' => $message,
                'code' => $code,
            ]
        ];
    }

}