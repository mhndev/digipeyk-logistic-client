<?php
namespace mhndev\digipeykLogisticClient\interfaces;

use mhndev\digipeykLogisticClient\iEntityOrder;

/**
 * Interface iOrderRepository
 * @package mhndev\digipeykLogisticClient\interfaces
 */
interface iOrderRepository
{

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function insert(iEntityOrder $order);


    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function update(iEntityOrder $order);


    /**
     * @param int $offset
     * @param int $limit
     * @param array $sort
     * @return mixed
     */
    function listAll($offset = 0, $limit = 10, array $sort = []);


}
