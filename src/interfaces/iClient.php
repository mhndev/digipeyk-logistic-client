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
     * @return array
     */
    function createOrder(iEntityOrder $order);

    /**
     * @param iEntityOrder $order
     * @return array
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


    /**
     * @param int $perPage
     * @param int $page
     * @param string $sort
     * @return mixed
     */
    function listMyAddresses(int $perPage = 10, int $page = 1 , $sort = 'created_at');

}
