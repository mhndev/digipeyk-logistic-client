<?php
namespace mhndev\digipeykLogisticClient;

use mhndev\digipeykLogisticClient\exceptions\CanNotConnectToDigipeykServer;
use mhndev\digipeykLogisticClient\interfaces\iClient;
use mhndev\digipeykLogisticClient\interfaces\iEntityOrder;
use mhndev\digipeykLogisticClient\interfaces\iHttpClient;
use mhndev\digipeykLogisticClient\interfaces\iOrderRepository;

/**
 * Class ClientPersist
 * @package mhndev\digipeykLogisticClient
 */
class ClientPersist extends Client implements iClient
{

    /**
     * @var iOrderRepository
     */
    protected $orderRepository;


    /**
     * ClientPersist constructor.
     * @param iHttpClient $httpClient
     * @param iOrderRepository $orderRepository
     */
    function __construct(
        iHttpClient $httpClient,
        iOrderRepository $orderRepository
    )
    {
        parent::__construct($httpClient);
        $this->orderRepository = $orderRepository;
    }


    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     * @throws CanNotConnectToDigipeykServer
     */
    function createOrder(iEntityOrder $order)
    {
        $result = parent::createOrder($order);

        $order->setIdentifier($result['identifier']);

        return $this->orderRepository->insert($order);
    }

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     * @throws CanNotConnectToDigipeykServer
     */
    function cancelOrder(iEntityOrder $order)
    {
        parent::cancelOrder($order);

        $this->orderRepository->update($order);
    }

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     * @throws CanNotConnectToDigipeykServer
     */
    function editOrder(iEntityOrder $order)
    {
        parent::editOrder($order);

        $this->orderRepository->update($order);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param array $sort
     * @param bool $update
     * @return mixed
     */
    function listMyOrders($offset = 0, $limit = 10, array $sort = [], $update = true)
    {
        if($update){
            return parent::listMyOrders($offset, $limit, $sort);
        }
        else{
            $this->orderRepository->listAll($offset, $limit, $sort);
        }
    }


    /**
     * @param iEntityOrder $order
     * @return string
     */
    function getOrderTrackingLink(iEntityOrder $order)
    {
        return parent::getOrderTrackingLink($order);
    }



}
