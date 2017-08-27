<?php
namespace mhndev\digipeykLogisticClient;

use mhndev\digipeykLogisticClient\entities\EntityOrder;
use mhndev\digipeykLogisticClient\interfaces\iClient;
use mhndev\digipeykLogisticClient\interfaces\iEntityOrder;
use mhndev\digipeykLogisticClient\interfaces\iHttpClient;
use Psr\Http\Message\ResponseInterface;

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
     * array
     */
    const endpoints = [
            'createOrder'  => 'https://digipeyk.com/order',
            'cancelOrder'  => 'https://digipeyk.com/order/cancel-customer',
            'editOrder'    => 'https://digipeyk.com/order',
            'listMyOrders' => 'https://digipeyk.com/order/me',
    ];


    /**
     * Client constructor.
     * @param iHttpClient $httpClient
     */
    function __construct(iHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function createOrder(iEntityOrder $order)
    {
        var_dump($order->toArray()); die;
        $response = $this->httpClient->sendRequest(
            'POST',
            self::endpoints[__METHOD__],
            json_encode($order->toArray()),
            ['Content-type' => 'application/json', 'Authorization' => 'Bearer '.$this->getToken()]
        );

        return EntityOrder::fromOptions($this->getJsonResult($response));
    }

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function cancelOrder(iEntityOrder $order)
    {
        $response = $this->httpClient->sendRequest(
            'PATCH',
            self::endpoints[__METHOD__],
            json_encode($order->toArray()),
            ['Content-type' => 'application/json', 'Authorization' => 'Bearer '.$this->getToken()]
        );

        return EntityOrder::fromOptions($this->getJsonResult($response));
    }

    /**
     * @param iEntityOrder $order
     * @return iEntityOrder
     */
    function editOrder(iEntityOrder $order)
    {
        $response = $this->httpClient->sendRequest(
            'PUT',
            self::endpoints[__METHOD__],
            json_encode($order->toArray()),
            ['Content-type' => 'application/json', 'Authorization' => 'Bearer '.$this->getToken()]
        );

        return EntityOrder::fromOptions($this->getJsonResult($response));
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param array $sort
     * @return mixed
     */
    function listMyOrders($offset = 0, $limit = 10, array $sort = [])
    {
        $response = $this->httpClient->sendRequest(
            'GET',
            self::endpoints[__METHOD__],
            null,
            ['Content-type' => 'application/json', 'Authorization' => 'Bearer '.$this->getToken()]
        );

        return EntityOrder::fromOptions($this->getJsonResult($response));
    }

    /**
     * @param iEntityOrder $order
     * @return string
     */
    function getOrderTrackingLink(iEntityOrder $order)
    {
        return 'https://digipeyk.com/t/'.$order->getIdentifier();
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

    /**
     * @param string $token
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }


    /**
     * @param ResponseInterface $response
     * @return array
     */
    private function getJsonResult(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }

}
