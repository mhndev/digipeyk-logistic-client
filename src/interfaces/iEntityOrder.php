<?php
namespace mhndev\digipeykLogisticClient;

use mhndev\digipeykLogisticClient\valueObjects\OrderItem;
use mhndev\digipeykLogisticClient\valueObjects\OrderPayment;
use mhndev\digipeykLogisticClient\valueObjects\OrderStatus;
use mhndev\phpStd\Collection;

/**
 * Interface iEntityOrder
 * @package mhndev\digipeykLogisticClient
 */
interface iEntityOrder
{

    /**
     * @return mixed string | integer
     */
    function getIdentifier();

    /**
     * @return mixed
     */
    function getOwnerIdentifier();

    /**
     * @return OrderStatus
     */
    function getStatus() : OrderStatus;

    /**
     * @return Collection
     */
    function getItems() : Collection;

    /**
     * @param OrderItem $orderItem
     * @return iEntityOrder
     */
    function addItem(OrderItem $orderItem) :iEntityOrder ;

    /**
     * @return iEntityOrder
     */
    function clearItems() :iEntityOrder ;

    /**
     * @return boolean
     */
    function isLocked() :bool ;

    /**
     * @return iEntityOrder
     */
    function lock() : iEntityOrder ;

    /**
     * @return iEntityOrder
     */
    function unlock() :iEntityOrder ;

    /**
     * @return bool
     */
    function isPaid();

    /**
     * @return OrderPayment
     */
    function getPayment();

    /**
     * @param OrderPayment $payment
     * @return $this
     */
    function pay(OrderPayment $payment);

    /**
     * @return array
     */
    function toArray();

}
