<?php 

namespace PandiSelvamPS\LaravelPhorest;

use Illuminate\Support\Facades\Http;

class Phorest {
    public $apiKey;
    public $http;
    public $apiHeaders;
    public $baseUrl = "https://api-gateway-us.phorest.com/third-party-api-server/api/";
    public $request;
    public $response = null;
    public $statusCode;

    public function __construct($apiKey,$country = null) {
        switch ($country) {
            case 'UK':
                $this->baseUrl = "https://platform.phorest.com/third-party-api-server/api/";
                break;
            case 'EU':
                $this->baseUrl = "https://api-gateway-eu.phorest.com/third-party-api-server/api/";
                break;
            default:
                $this->baseUrl = "https://api-gateway-us.phorest.com/third-party-api-server/api/";
                break;
        }
        $this->apiKey = $apiKey;
        $this->apiHeaders = [
            'Authorization' => 'Basic '.$this->token,
        ];
        $this->http = Http::withHeaders($this->apiHeaders);
    }

    public function setBaseUrl($url) {
        $this->baseUrl = $url;
    }

    public function fetch($method, $endpoint, $data = [])
    {
        $this->request = $data;
        $baseUrl = $this->baseUrl;
        $this->baseUrl .= $endpoint;
        [$this->method, $this->bodyData] = [$method, $data];
        try {
            $this->response = $this->http->$method($this->baseUrl, $this->bodyData);
            $result = $this->response->json();
            if ($this->response->ok()) {
                $this->baseUrl = $baseUrl;
                return ['status' => true, 'result' => $result];
            } else {
                $error = @$result['error'] ?: @$result['detail'];
                $this->baseUrl = $baseUrl;
                return ['status' => false, 'message' => 'Phorest Error : '.@$error];
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
}
