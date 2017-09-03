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
    const endpoints =  [
        'createOrder'     => 'https://digipeyk.com/services/digipeyk/order',
        'cancelOrder'     => 'https://digipeyk.com/services/digipeyk/order/cancel-customer/',
        'editOrder'       => 'https://digipeyk.com/services/digipeyk/order',
        'listMyOrders'    => 'https://digipeyk.com/services/digipeyk/order/me',
        'listMyAddresses' => 'https://digipeyk.com/services/digipeyk/address/me'
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
     * @return array
     */
    function createOrder(iEntityOrder $order)
    {
        /** @var array $response */
        $response = $this->httpClient->sendRequest(
            'POST',
            self::endpoints[__FUNCTION__],
            json_encode($order->toDigipeykArray()),
            [
                'Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . $this->getToken(),
                'Accept' => 'application/json'
            ]
        );

        return $response;
    }

    /**
     * @param iEntityOrder $order
     * @return array
     */
    function cancelOrder(iEntityOrder $order)
    {
        /** @var array $response */
        $response = $this->httpClient->sendRequest(
            'PATCH',
            self::endpoints[__FUNCTION__] . $order->getIdentifier(),
            '',
            ['Content-type' => 'application/json', 'Authorization' => 'Bearer ' . $this->getToken()]
        );

        return $response;
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
            ['Content-type' => 'application/json', 'Authorization' => 'Bearer ' . $this->getToken()]
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
            ['Content-type' => 'application/json', 'Authorization' => 'Bearer ' . $this->getToken()]
        );

        return EntityOrder::fromOptions($this->getJsonResult($response));
    }

    /**
     * @param iEntityOrder $order
     * @return string
     */
    function getOrderTrackingLink(iEntityOrder $order)
    {
        return 'https://digipeyk.com/t/' . $order->getIdentifier();
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

    /**
     * @param int $perPage
     * @param int $page
     * @param string $sort
     * @return mixed
     */
    public function listMyAddresses(int $perPage = 10, int $page = 1, $sort = 'created_at')
    {
        /** @var array $response */
        $response = $this->httpClient->sendRequest(
            'GET',
            self::endpoints[__FUNCTION__],
            '',
            [
                'Content-Type' => 'application/json', 'Authorization' => 'Bearer ' . $this->getToken(),
                'Accept' => 'application/json'
            ],
            [
                'perPage' => $perPage,
                'page'    => $page,
                'sort'    => $sort
            ]
        );

        return $response;
    }
}
