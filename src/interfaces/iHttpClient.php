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
     * @param array $queryParams
     * @return ResponseInterface|string
     */
    function sendRequest(
        string $method = 'GET',
        string $uri,
        string $body = '',
        array $headers = [],
        array $queryParams = []
    );

}
