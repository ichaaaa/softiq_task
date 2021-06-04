<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class SubdomainsExportHandler
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
		Redis::set('subdomains', json_encode($this->data));
	}

	private function prepareData()
	{
		$key = $this->key;
		$temp = json_decode(json_encode($this->xml->$key),true);

		foreach($temp as $subdomain )
		{
			$data['subdomains'] = $subdomain;
		}

		$this->data = json_encode($data['subdomains']);
	}	
}