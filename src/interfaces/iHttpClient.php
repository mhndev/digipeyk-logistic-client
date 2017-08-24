<?php
namespace mhndev\digipeykLogisticClient\interfaces;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface iHttpClient
 * @package mhndev\digipeykLogisticClient\interfaces
 */
interface iHttpClient
{

    /**
     * @param string $method
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    function sendRequest(
        string $method = 'GET',
        string $uri,
        string $body,
        array $headers = []
    ) : ResponseInterface;

}
