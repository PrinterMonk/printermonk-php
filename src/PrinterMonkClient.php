<?php

namespace PrinterMonk;

use PrinterMonk\Exceptions\PrinterMonkClientException;
use PrinterMonk\Exceptions\PrinterMonkRateLimitException;
use PrinterMonk\Exceptions\PrinterMonkUnauthorizedException;

class PrinterMonkClient
{
    const URL_LIVE = 'https://api.printermonk.com/';
    const API_VERSION = 'v1';

    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function get($endpoint)
    {
        return $this->sendRequest('GET', $endpoint);
    }

    public function post($endpoint, $data = null)
    {
        return $this->sendRequest('POST', $endpoint, $data);
    }

    private function sendRequest($method, $endpoint, $data = null)
    {
        $url = $this->getUrlFromEndpoint($endpoint);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'PrinterMonk PHP client');
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ':');

        if (in_array($method, ['POST', 'PUT', 'DELETE']) && !is_null($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } elseif ($method == 'GET' && !empty($data)) {
            $suffix = '?';
            foreach ($data as $key => $value) {
                $suffix .= $key . '=' . $value;
            }
            curl_setopt($ch, CURLOPT_URL, $url . $suffix);
        }

        $result = curl_exec($ch);
        $headerInfo = curl_getinfo($ch);
        
        $this->checkAndHandleErrors($ch, $headerInfo, $result);

        curl_close($ch);

        return $result;
    }

    protected function getUrlFromEndpoint($endpoint)
    {
        return self::URL_LIVE . self::API_VERSION . '/' . $endpoint;
    }

    protected function checkAndHandleErrors($ch, $headerInfo, $result)
    {
        $errorMessage = null;
        $errorNumber = 0;

        $result = json_decode($result);
        if ($result !== false && isset($result->data)) {
            if (isset($result->data->error_code)) {
                $errorNumber = (int)$result->data->error_code;
            }

            if (isset($result->data->error_message)) {
                $errorMessage = (int)$result->data->error_message;
            }
        }

        if (curl_errno($ch)) {
            throw new PrinterMonkClientException(curl_errno($ch));
        }

        if (in_array($headerInfo['http_code'], ['401', '400'])) {
            throw new PrinterMonkUnauthorizedException($errorMessage, $errorNumber);
        }

        if ($headerInfo['http_code'] == '409') {
            throw new PrinterMonkRateLimitException($errorMessage, $errorNumber);
        }

        if (!in_array($headerInfo['http_code'], array('200', '201', '204'))) { // API returns error
            if (!empty($result)) {
                throw new PrinterMonkClientException($errorMessage, $errorNumber);
            }
        }
    }
}