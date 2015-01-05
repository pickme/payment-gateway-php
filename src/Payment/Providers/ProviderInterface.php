<?php namespace Payment\Providers;

interface ProviderInterface {

    /**
     * Construct the adapter
     */
    public function __construct($opts=array());

    /**
     * Enable sandbox API
     *
     * @param string $val
     */
    public function setSandboxMode($val);

     /**
     * Do a payment.
     *
     * @param string $val
     */
    public function doPayment($val);


}
