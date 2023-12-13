<?php

namespace YOoSlim\TestK\Payment\Responses;

use YOoSlim\TestK\Payment\Requests\RegisterRequest;

class PaymentDetails
{
    /**
     * Constructor
     * 
     * @param  RegisterRequest $request
     * @param  string $id
     * @param  string $status
     * @param  string $redirect
     * @param  array $extra
     */
    public function __construct(
        public RegisterRequest $request,
        public string $id,
        public string $status,
        public string $redirect,
        public array $extra = []
    ) {
        //
    }
}