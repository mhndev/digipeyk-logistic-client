<?php
namespace mhndev\digipeykLogisticClient;

use mhndev\digipeykLogisticClient\interfaces\iHttpClient;

/**
 * Class Client
 * @package mhndev\digipeykLogisticClient
 */
class Client implements iClient
{

    /**
     * @var iHttpClient
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $token;

    /**
     * Client constructor.
     * @param iHttpClient $httpClient
     * @param string $token
     */
    function __construct(iHttpClient $httpClient, string $token)
    {
        $this->httpClient = $httpClient;
        $this->token      = $token;
    }

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function createOrder(iEntityOrder $order)
    {
        $this->httpClient->sendRequest(
            'POST',
            json_encode($order->toArray()),
            ['Content-type' => 'application/json', 'Authorization' => 'Bearer '.$this->getToken()]
        );
    }

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function cancelOrder(iEntityOrder $order)
    {
        // TODO: Implement cancelOrder() method.
    }

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function editOrder(iEntityOrder $order)
    {
        // TODO: Implement editOrder() method.
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param array $sort
     * @return mixed
     */
    function listMyOrders($offset = 0, $limit = 10, array $sort = [])
    {
        // TODO: Implement listMyOrders() method.
    }

    /**
     * @param iEntityOrder $order
     * @return string
     */
    function getOrderTrackingLink(iEntityOrder $order)
    {
        // TODO: Implement getOrderTrackingLink() method.
    }

    /**
     * @return iHttpClient
     */
    public function getHttpClient(): iHttpClient
    {
        return $this->httpClient;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

}
