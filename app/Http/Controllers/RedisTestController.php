<?php

namespace App\Http\Controllers;

use App\Services\DataExportHandlerFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage; 

class RedisTestController extends Controller
{
    public function index()
    {
		$xml = Storage::disk('local')->get('public/config.xml');
        $data = simplexml_load_string($xml);

        $exportHandler = DataExportHandlerFactory::make('cookies');
        $exportHandler->prepareXMLObject($xml);
        $exportHandler->exportDataToRedis();

         dd($exportHandler);


//        if(isset($data->lala))
//        {
// dd("sub");
//        }else{
//        	dd("nie sub");
//        }

        //$cookies = $data->cookies;

        foreach($data->cookies as $cookies){
        	foreach($cookies as $cookie){
				//$temp['cookie:'.$cookie->attributes()->name.':'.$cookie->attributes()->host] = json_decode(json_encode($cookie),true)[0];
				Redis::hset('cookies','cookie:'.$cookie->attributes()->name.':'.$cookie->attributes()->host, json_decode(json_encode($cookie),true)[0]);
        	}

        }

		//dd($temp);

		$xml_temp = simplexml_load_string($xml);

		$data = json_decode(json_encode($xml_temp->subdomains),true);



		//dd($data);

		foreach($data as $subdomain )
		{
			$temp['subdomains'] = $subdomain;
		}

//dd(stripslashes(json_encode($temp['subdomains'])));

//dd(Redis::hgetall('coookies'));
		Redis::set('subdomains', json_encode($temp['subdomains']));
		//dd(Redis::keys('cookie:*'));
		//dd(Redis::get('cookie:dlp-avast:amazon'));
    }
}
