<?php namespace Payment\Providers;

use Braintree_Gateway;
use Payment\Providers\TransactionResult;

class Braintree extends ProviderAbstract implements ProviderInterface {

    /**
     * Provider name
     */
    const PROVIDER = "Braintree";

    private $_gateway = null;
    private $_merchantId = null;
    private $_publicKey = null;
    private $_privateKey = null;
    /**
     * Construct the payment adapter.
     *
     * @access public
     * @param  array $params (default: array())
     * @return void
     */
    public function __construct($params=array())
    {
        parent::__construct($params);
        $this->_gateway = $this->_getBranTreeGateway();
    }


     /**
     * Do a payment.
     *
     * @param string $val
     */
    public function doPayment($val)
    {
        $transaction = $this->_gateway->transaction();
        $result = $transaction->sale(array(
                        'amount' => '1000.00',
                        'creditCard' => array(
                                        'number' => '5105105105105100',
                                        'expirationDate' => '05/12'
                        )
        ));
        return $this->_getTransactionResult($result);  
    }

    protected function setMerchantid($val)
    {
        $this->_merchantId = $val;
    }
    protected function setPublickey($val)
    {
        $this->_publicKey = $val;
    }
    protected function setPrivatekey($val)
    {
        $this->_privateKey = $val;
    }
    private function _getBranTreeGateway()
    {
    	$config = array(
    	   'merchantId' => $this->_merchantId,
    	   'publicKey' => $this->_publicKey,
    	   'privateKey' => $this->_privateKey,
    	   'environment' => 'sandbox'
    	);
    	if( $this->_isSandbox() ) {
    	    $config['environment'] = 'sandbox';
    	}
    	$gateway = new Braintree_Gateway($config);
    	return $gateway;
    }
    private function _getTransactionResult($result)
    {
    	$res = new TransactionResult(array(
    	    'success' => $result->success,
    		'provider' => self::PROVIDER
    	));
    	if ($result->success) {
    		$res->setReferenceId($result->transaction->id);
    	}
    	else if ($result->transaction) {
    		$res->setErrorMsg($result->transaction->processorResponseText);
    	} else {
    		$res->setErrorMsg("Validation errors".$result->errors->deepAll());
    	}
    	return $res;
    }
}
