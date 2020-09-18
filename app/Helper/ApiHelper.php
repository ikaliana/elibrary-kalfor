<?php

namespace App\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class ApiHelper {
	
    protected function InitClient() {
    	return new Client([
		    'verify' => false,
		    'curl' => [
		        CURLOPT_SSL_VERIFYHOST => false,
		        CURLOPT_SSL_VERIFYPEER => false
		    ]
		]);
    }

    protected function OpenRequest($method, $url, $params) {
	    $client = $this->InitClient();

	    try {
	    	$response = $client->request($method, $url, $params);
	    	return $response;
	    } catch (RequestException $e) {
	    	if($e->getCode() == 401) return $e->getResponse();
	    	else abort($e->getCode(), $e->getResponse()->getBody());
	    }
    }

}