<?php

namespace YOoSlim\TestK\Facades;

use Illuminate\Support\Facades\Facade;

class Payment extends Facade
{
    /**
     * Define the alias name of the binded object
     * 
     * @return string
     */
    protected static function getFacadeAccessor()
    {
         return 'paymentService';
    }
}