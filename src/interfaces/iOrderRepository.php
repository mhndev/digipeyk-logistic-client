<?php
namespace mhndev\digipeykLogisticClient\interfaces;

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

    /**
     * @param $ownerIdentifier
     * @param int $offset
     * @param int $limit
     * @param array $sort
     * @param bool $preview
     * @return mixed
     */
    function findByOwnerIdentifier($ownerIdentifier, $offset = 0, $limit = 10, array $sort = [], $preview = true);

    /**
     * @param $identifier
     * @return iEntityOrder
     */
    function findByIdentifier($identifier) :iEntityOrder;

}
