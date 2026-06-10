<?php

namespace Takshak\Alertt\Facades;

use Illuminate\Support\Facades\Facade;
use Takshak\Alertt\Alertt\AlerttService;

class Alertt extends Facade
{
	
	protected static function getFacadeAccessor()
	{
		return AlerttService::class;
	}

}