<?php
namespace mhndev\digipeykLogisticClient\interfaces;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface iHttpClient
 * @package mhndev\digipeykLogisticClient\interfaces
 */
interface iHttpClient
{


    /**
     * @param string $method
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    function sendRequest($method = 'GET', $body, array $headers = []) : ResponseInterface;



}
