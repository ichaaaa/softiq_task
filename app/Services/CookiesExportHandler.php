<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class CookiesExportHandler
{
	private $key;
	private $xml;
	private $data;

	public function __construct($key)
	{
		$this->key = $key;
	}

	public function prepareXMLObject($file)
	{
		$this->xml = simplexml_load_string($file);
	}

	public function exportDataToRedis()
	{
		$this->prepareData();
        foreach($this->data as $cookies){
        	foreach($cookies as $cookie){
				//$temp['cookie:'.$cookie->attributes()->name.':'.$cookie->attributes()->host] = json_decode(json_encode($cookie),true)[0];
				Redis::set('cookie:'.$cookie->attributes()->name.':'.$cookie->attributes()->host, json_decode(json_encode($cookie),true)[0]);
        	}

        }
	}

	private function prepareData()
	{
		$key = $this->key;
		$this->data = $this->xml->$key;
	}	
}