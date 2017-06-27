<?php

namespace GrpcEverywhere\ResponseData;

/**
 * Interface ResponseDataInterface
 * @package GrpcEverywhere\ResponseData
 */
interface ResponseDataInterface
{
    /**
     * @return array
     */
    public function getData();


    /**
     * For writing in response
     *
     * @return mixed
     */
    public function __toString();


}