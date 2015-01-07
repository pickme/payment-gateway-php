<?php namespace Payment\Providers;

interface ProviderInterface {

    /**
     * Construct the adapter
     */
    public function __construct($opts=array());

     /**
     * Do a payment.
     *
     * @param string $val
     */
    public function doPayment($val);


}
