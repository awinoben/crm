<?php


namespace App\Traits;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

trait ProcessingGate
{
    /**
     * ---------------------------
     * cache access token here
     * @return mixed
     * --------------------------
     */
    private function cacheAccessToken()
    {
        if (Cache::has('sms_access_token'))
            return Cache::get('sms_access_token');
        return Cache::rememberForever('sms_access_token', function () {
            return config('sms.keys.token');
        });
    }


    /**
     * -------------------------
     * create header details
     * for any request
     * -------------------------
     * @param array $data
     * @return array[]
     */
    private function setRequestOptions(array $data)
    {
        return [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->cacheAccessToken(),
            ],
            'json' => $data,
        ];
    }

    /**
     * ---------------------------------
     * process the request
     * @param string $requestUrl
     * @param array $data
     * @param string $method
     * @return string
     * ---------------------------------
     */
    public function processRequest(string $requestUrl, $data = [], string $method = 'GET')
    {
        try {
            // define the guzzle client
            $client = new Client([
                'base_uri' => $this->baseUri,
                'timeout' => config('sms.timeout'),
                'connect_timeout' => config('sms.connect_timeout'),
                'protocols' => ['http', 'https'],
            ]);

            $response = $client->request($method, $requestUrl, $this->setRequestOptions($data));
            return ($response->getBody()->getContents());

        } catch (ClientException $clientException) {
            $exception = $clientException->getResponse()->getBody()->getContents();
            Log::critical('client-exception' . $clientException->getMessage());
            return $exception;
        } catch (ServerException $serverException) {
            $exception = $serverException->getResponse()->getBody()->getContents();
            Log::critical('server-exception' . $serverException->getMessage());
            return $exception;
        } catch (GuzzleException $guzzleException) {
            Log::critical('guzzle-exception' . $guzzleException->getMessage());
            return $guzzleException;
        }
    }

}
