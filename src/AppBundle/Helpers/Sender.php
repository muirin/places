<?php
namespace AppBundle\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Class sending requests. Using Guzzle.
 */
class Sender {

    /**
     * Send GET request to specified $url
     * Expects JSON in response and decodes it to array.
     * @param string $url Base URL
     * @param array $parameters Request parameters to be sent
     * @param array $headers Headers array
     * @return array The response array
     */
    public function sendGetRequest($url, array $parameters, array $headers = []) {
        try {
            $parametersString = $this->getParametersString($parameters);
            $request = new Request('GET', $parametersString, $headers);
            $client = $this->getClient($url);
            
            $response = $client->send($request);
            if($response->getStatusCode() !== 200){
                throw new \Exception('Error API response code');
            }
            $body = $response->getBody();
            $contents = $body->getContents();
            return json_decode($contents, true);
        } catch (\Exception $e) {
            throw new \Exception('Error while sending GET request');
        }
    }
    
    /**
     * Prepare parameters string from paramters array
     * @param array $parameters
     * @return string
     */
    private function getParametersString(array $parameters){
        $parsed = array_map(function ($name, $value) {
            return $name . '=' . $value;
        }, array_keys($parameters), $parameters);

        $parametersString = '?' . implode('&', $parsed);
        return $parametersString;
    }

    /**
     * Get sender client
     * @param string $url base URL
     * @return Client
     */
    private function getClient($url) {
        $client = new Client([
            'base_uri' => $url,
            'timeout' => 2.0,
        ]);
        return $client;
    }

}
