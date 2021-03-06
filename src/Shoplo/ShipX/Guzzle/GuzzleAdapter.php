<?php

namespace Shoplo\ShipX\Guzzle;

use Shoplo\ShipX\Exception\ExceptionManager;
use Shoplo\ShipX\ShipXAdapterInterface;
use GuzzleHttp\Client;

class GuzzleAdapter implements ShipXAdapterInterface
{
    /**
     * @var string|null
     */
    private $accessToken;

    /**
     * @var Client
     */
    private $guzzle;

    public function __construct(\GuzzleHttp\Client $guzzle, $accessToken = null)
    {
        $this->guzzle      = $guzzle;
        $this->accessToken = $accessToken;
    }

    /**
     * @param null $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return !$this->accessToken
            ? []
            : [
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type'  => 'application/json; charset=utf-8',
            ];
    }

    /**
     * @param $url
     * @param array $parameters
     * @param array $headers
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Shoplo\ShipX\Exception\AuthorizationException
     * @throws \Shoplo\ShipX\Exception\BackendException
     * @throws \Shoplo\ShipX\Exception\NotFoundException
     * @throws \Shoplo\ShipX\Exception\ValidationException
     * @throws \Throwable
     */
    public function get($url, $parameters = [], $headers = [])
    {
        $headers = array_merge($headers, $this->getHeaders());
        try {
            $rsp = $this->guzzle->request(
                'GET',
                $url,
                [
                    'headers' => $headers,
                    'query' => $parameters
                ]
            );

            return $rsp->getBody()->getContents();
        } catch (\Throwable $e) {
            ExceptionManager::throwException($e);
        }
    }

    /**
     * @param $url
     * @param $data
     * @param array $headers
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Shoplo\ShipX\Exception\AuthorizationException
     * @throws \Shoplo\ShipX\Exception\BackendException
     * @throws \Shoplo\ShipX\Exception\NotFoundException
     * @throws \Shoplo\ShipX\Exception\ValidationException
     * @throws \Throwable
     */
    public function put($url, $data, $headers = [])
    {
        try {
            $headers = array_merge($headers, $this->getHeaders());
            $rsp     = $this->guzzle->request(
                'PUT',
                $url,
                [
                    'headers' => $headers,
                    'body'    => $data,
                ]
            );

            return $rsp->getBody()->getContents();
        } catch (\Throwable $e) {
            ExceptionManager::throwException($e);
        }
    }

    /**
     * @param $url
     * @param $data
     * @param array $headers
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Shoplo\ShipX\Exception\AuthorizationException
     * @throws \Shoplo\ShipX\Exception\BackendException
     * @throws \Shoplo\ShipX\Exception\NotFoundException
     * @throws \Shoplo\ShipX\Exception\ValidationException
     * @throws \Throwable
     */
    public function post($url, $data, $headers = [])
    {
        try {
            $headers = array_merge($headers, $this->getHeaders());
            $rsp     = $this->guzzle->request(
                'POST',
                $url,
                [
                    'headers' => $headers,
                    'body'    => $data,
                ]
            );

            return $rsp->getBody()->getContents();
        } catch (\Throwable $e) {
            ExceptionManager::throwException($e);
        }
    }

    /**
     * @param $url
     * @param array $headers
     * @return string
     * @throws \Shoplo\ShipX\Exception\AuthorizationException
     * @throws \Shoplo\ShipX\Exception\BackendException
     * @throws \Shoplo\ShipX\Exception\NotFoundException
     * @throws \Shoplo\ShipX\Exception\ValidationException
     * @throws \Throwable
     */
    public function delete($url, $headers = [])
    {
        try {
            $headers = array_merge($headers, $this->getHeaders());
            $rsp     = $this->guzzle->delete(
                $url,
                [
                    'headers' => $headers,
                ]
            );

            return $rsp->getBody()->getContents();
        } catch (\Throwable $e) {
            ExceptionManager::throwException($e);
        }
    }

}
