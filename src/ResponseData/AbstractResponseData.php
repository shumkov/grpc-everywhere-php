<?php


namespace GrpcEverywhere\ResponseData;


/**
 * Class AbstractResponseData
 * @package GrpcEverywhere\ResponseData
 */
abstract class AbstractResponseData implements ResponseDataInterface
{
    /**
     * @var array
     */
    public $data;

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->data);
    }

}