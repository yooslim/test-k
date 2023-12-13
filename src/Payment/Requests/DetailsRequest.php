<?php

namespace YOoSlim\TestK\Payment\Requests;

class DetailsRequest
{
    /**
     * Constructor
     * 
     * @param  string $id
     */
    public function __construct(
        public string $id,
    ) {
        //
    }
}