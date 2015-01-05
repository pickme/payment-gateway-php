<?php namespace Payment;

class Gateway {

    private $_config = null;
    private $_paypalProvider = null;
    private $_braintreeProvider = null;
    
    public function __construct($config)
    {
        $this->_config = $config;
    }
    /**
     * Get an instance of the Paypal Provider.
     *
     * @return \Payment\Providers\Paypal
     */
    public function getPaypalProvider()
    {
		if(!isset($this->_paypalProvider))
		{
			$this->_paypalProvider = new \Payment\Providers\Paypal($this->_config['paypal']);
		}
		return $this->_paypalProvider;
    }

    /**
     * Get an instance of the Braintree Provider.
     *
     * @return \Payment\Providers\Braintree
     */
    public function getBraintreeProvider()
    {
		if(!isset($this->_braintreeProvider))
		{
			$this->_braintreeProvider = new \Payment\Providers\Braintree($this->_config['braintree']);
		}
		return $this->_braintreeProvider;
    }

    /**
     * Get the default provider.
     *
     * @return an instance of default provider.
     */
    public function getDefaultProvider()
    {
        return $this->getPaypalProvider();
    }

}
