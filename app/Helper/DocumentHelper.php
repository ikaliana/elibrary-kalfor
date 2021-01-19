<?php

namespace App\Helper;

use App\Helper\ApiHelper;
use App\Models\Document;

class DocumentHelper extends ApiHelper 
{
	public static $document_mapper = [
            'Audio' => 'App\Models\Audio',
            'Image' => 'App\Models\Image',
            'Map' => 'App\Models\Map',
            'Video' => 'App\Models\Video',
        ];

	private $api_url;

    public function __construct()
    {
        // $protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
        // $host = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : env('APP_URL');
        // $this->api_url = $protocol . $host . '/api/document';
        $this->api_url = url('/api') . '/document';
    }

	public function List($type,$page=null) 
	{
	    if(is_null($type)) $type = '/all';
	    else $type = '/list/'.$type;

	    $url = $this->api_url.$type;

	    if($page != null) 
	    	if (is_numeric($page)) $url .= '?page='.$page;

	    $response = $this->OpenRequest('GET', $url,
	    	['headers' => [
	            // 'Authorization' => 'Bearer '.session()->get('token.access_token'),
	            'Accept' => 'application/json',
	        	]
	    	]);
	    $statusCode = $response->getStatusCode();

	    if($statusCode == '200') 
	    	return json_decode((string) $response->getBody(), true);
	    else 
	    	abort($statusCode, $response->getBody());
	}

	public function Category($category,$page=null) 
	{
	    if(is_null($category)) $category = '/all';
	    else $category = '/category/'.$category;

	    $url = $this->api_url.$category;

	    if($page != null) 
	    	if (is_numeric($page)) $url .= '?page='.$page;

	    $response = $this->OpenRequest('GET', $url,
	    	['headers' => [
	            // 'Authorization' => 'Bearer '.session()->get('token.access_token'),
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
	            // 'Authorization' => 'Bearer '.session()->get('token.access_token'),
	            'Accept' => 'application/json',
	        	]
	    	]);
	    $statusCode = $response->getStatusCode();

	    if($statusCode == '200') 
	    	return json_decode((string) $response->getBody(), true);
	    else 
	    	abort($statusCode, $response->getBody());
	}

	public function Save(Document $document, $file, $datasource)
	{
		$isNew = is_null($document->id);
		$method = ($isNew) ? "POST" : "PUT";
		$url = $this->api_url.( (($isNew) ? "" : '/'.$document->id) );

		$params = [
			[ 'name' => 'name', 'contents' => $document->name ],
			[ 'name' => 'description', 'contents' => $document->description ],
			[ 'name' => 'visibility', 'contents' => $document->visibility ],
			[ 'name' => 'license', 'contents' => $document->license ],
			[ 'name' => 'type', 'contents' => $document->type ],
			[ 'name' => 'category', 'contents' => $document->category ],
			[ 'name' => 'datasource', 'contents' => $datasource ],
			[ 'name' => 'gallery_id', 'contents' => $document->gallery_id ],
			[
                'Content-type' => 'multipart/form-data',
                'name' => 'file',
                'contents' => fopen($file, 'r'),
                'filename' => $file->getClientOriginalName(),
            ],
		];

	    $response = $this->OpenRequest($method, $url,
	    	[
	    		'headers' => [
		            'Authorization' => 'Bearer '.session()->get('token.access_token'),
		            'Accept' => 'application/json',
		        	]
		        ,'multipart' => $params
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
	            'Authorization' => 'Bearer '.session()->get('token.access_token'),
	            'Accept' => 'application/json',
	        	]
	    	]);
	    $statusCode = $response->getStatusCode();

	    if($statusCode == '204') 
	    	return null;
	    else 
	    	abort($statusCode, $response->getBody());
	}

	public function Search($keyword)
	{
	    $response = $this->OpenRequest('GET', $this->api_url.'/search' ,
	    	[
	    		'headers' => [
		            // 'Authorization' => 'Bearer '.session()->get('token.access_token'),
		            'Accept' => 'application/json',
	        	],
	        	'query' => ['key' => $keyword]
	    	]);
	    $statusCode = $response->getStatusCode();

	    if($statusCode == '200') 
	    	return json_decode((string) $response->getBody(), true);
	    else 
	    	abort($statusCode, $response->getBody());
	}

	public function Recent()
	{
	    $response = $this->OpenRequest('GET', $this->api_url.'/recent' ,
	    	[
	    		'headers' => [
		            // 'Authorization' => 'Bearer '.session()->get('token.access_token'),
		            'Accept' => 'application/json',
	        	]
	    	]);
	    $statusCode = $response->getStatusCode();

	    if($statusCode == '200') 
	    	return json_decode((string) $response->getBody(), true);
	    else 
	    	abort($statusCode, $response->getBody());
	}
}