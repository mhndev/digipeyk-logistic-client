<?php
namespace mhndev\digipeykLogisticClient\interfaces;

/**
 * Interface iEntity
 * @package mhndev\digipeykLogisticClient
 */
interface iEntity
{

    /**
     * @return array
     */
    function toArray();

    /**
     * @param array $array
     * @return iEntity
     */
    function fromArray(array $array);

    /**
     * @return array
     */
    function preview();
}

