<?php

namespace YOoSlim\TestK\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use YOoSlim\TestK\Contracts\DefaultPaymentProviderInterface;
use YOoSlim\TestK\Payment\Providers\PayPalPaymentProvider;
use YOoSlim\TestK\Payment\Services\PaymentService;

class ServiceProvider extends LaravelServiceProvider
{
    /**
	 * Register service provider.
	 * 
	 * @return void
	 */
	public function register(): void
	{
        $this->app->bind(DefaultPaymentProviderInterface::class, PayPalPaymentProvider::class);

        $this->app->bind('paymentService', function() {
            return new PaymentService();
        });
	}

	/**
	 * Bootstrap any package services.
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->publishes([
			__DIR__.'/../../config/testk.php' => config_path('testk.php'),
		]);
	}
}
