<?php
namespace mhndev\digipeykLogisticClient\interfaces;



/**
 * Interface iClient
 * @package mhndev\digipeykLogisticClient
 */
interface iClient
{

    /**
     * @return iHttpClient
     */
    function getHttpClient();

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function createOrder(iEntityOrder $order);

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function cancelOrder(iEntityOrder $order);

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function editOrder(iEntityOrder $order);

    /**
     * @return mixed
     */
    function listMyOrders();

    /**
     * @param iEntityOrder $order
     * @return string
     */
    function getOrderTrackingLink(iEntityOrder $order);

}
