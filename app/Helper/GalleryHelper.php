<?php

namespace App\Helper;

use App\Helper\ApiHelper;
use App\Models\Gallery;

class GalleryHelper extends ApiHelper 
{
	private $api_url;

    public function __construct()
    {
        $protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $this->api_url = $protocol . $_SERVER['HTTP_HOST'] . '/api/gallery';
    }

	public function List() 
	{
	    $response = $this->OpenRequest('GET', $this->api_url,
	    	['headers' => [
	            //'Authorization' => 'Bearer '.session()->get('token.access_token'),
	            'Accept' => 'application/json',
	        	]
	    	]);
	    $statusCode = $response->getStatusCode();

	    if($statusCode == '200') 
	    	return json_decode((string) $response->getBody(), true);
	    else 
	    	abort($statusCode, $response->getBody());
	}

	public function Get($id)
	{
	    $response = $this->OpenRequest('GET', $this->api_url.'/'.$id ,
	    	['headers' => [
	            //'Authorization' => 'Bearer '.session()->get('token.access_token'),
	            'Accept' => 'application/json',
	        	]
	    	]);
	    $statusCode = $response->getStatusCode();

	    if($statusCode == '200') 
	    	return json_decode((string) $response->getBody(), true);
	    else 
	    	abort($statusCode, $response->getBody());
	}

	public function Save(Gallery $gallery)
	{
		$isNew = is_null($gallery->id);
		$method = ($isNew) ? "POST" : "PUT";
		$url = $this->api_url.( (($isNew) ? "" : '/'.$gallery->id) );

	    $response = $this->OpenRequest($method, $url,
	    	[
	    		'headers' => [
		            //'Authorization' => 'Bearer '.session()->get('token.access_token'),
		            'Accept' => 'application/json',
		        	]
		        ,'form_params' => ['name'=>$gallery->name,'description'=>$gallery->description,'visibility'=>$gallery->visibility]
	    	]);
	    $statusCode = $response->getStatusCode();

	    if($statusCode == '200' || $statusCode == '201') 
	    	return json_decode((string) $response->getBody(), true);
	    else 
	    	abort($statusCode, $response->getBody());
	}

	public function Delete($id)
	{
	    $response = $this->OpenRequest("DELETE", $this->api_url.'/'.$id,
	    	['headers' => [
	            //'Authorization' => 'Bearer '.session()->get('token.access_token'),
	            'Accept' => 'application/json',
	        	]
	    	]);
	    $statusCode = $response->getStatusCode();

	    if($statusCode == '204') 
	    	return null;
	    else 
	    	abort($statusCode, $response->getBody());
	}
}