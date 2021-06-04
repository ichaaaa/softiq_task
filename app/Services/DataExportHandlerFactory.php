<?php

namespace App\Services;

use App\Services\CookiesExportHandler;
use App\Services\SubdomainsExportHandler;

class DataExportHandlerFactory
{
	const SUBDOMAINS = 'subdomains';
	const COOKIES = 'cookies';

	public static function make($handlerName)
	{
		if($handlerName === self::SUBDOMAINS){
			return new SubdomainsExportHandler($handlerName);
		}elseif($handlerName === self::COOKIES){
			return new CookiesExportHandler($handlerName);
		}else{
			throw new \Exception("Xml object not found");
		}
	}
}