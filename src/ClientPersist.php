<?php
namespace mhndev\digipeykLogisticClient;

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
    function __construct(iHttpClient $httpClient, iOrderRepository $orderRepository)
    {
        parent::__construct($httpClient);

        $this->orderRepository = $orderRepository;
    }


    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function createOrder(iEntityOrder $order)
    {
        parent::createOrder($order);

        $this->orderRepository->insert($order);
    }

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function cancelOrder(iEntityOrder $order)
    {
        $canceledOrder = parent::cancelOrder($order);

        $this->orderRepository->update($canceledOrder);
    }

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function editOrder(iEntityOrder $order)
    {
        $updatedOrder = parent::editOrder($order);

        $this->orderRepository->update($updatedOrder);
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
        return 'https://digipeyk.com/t/'.$order->getIdentifier();
    }



}
