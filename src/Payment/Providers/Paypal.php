<?php namespace Payment\Providers;

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;
use PayPal\Exception\PPConnectionException;
use Payment\Providers\TransactionResult;


class Paypal extends ProviderAbstract implements ProviderInterface {

    /**
     * Provider name
     */
    const PROVIDER = "Paypal";

    private $_apiContext = null;
    private $_clientId = null;
    private $_clientSecret = null;
    private $_logfile = null;
    private $_productionUrl = null;
    private $_sandboxUrl = null;
    private $_connectTimeout = null;
    /**
     * Construct the payment provider
     *
     * @access public
     * @param  array $params (default: array())
     * @return void
     */
    
    public function __construct($params = array())
    {
        parent::__construct($params);
        $this->_apiContext = $this->_getApiContext();
    }
    /**
     * do payment process
     *
     * @access public
     * @param  array
     */
    public function doPayment($val)
    {
        $payer = $this->_getPayer($val['payer']);
        $transaction =  $this->_getTransaction($val['amount']);

		$payment = new Payment();
		$payment->setIntent("sale");
		$payment->setPayer($payer);
		$payment->setTransactions(array($transaction));
        $res = null;
        try {
	        $result = $payment->create($this->_apiContext);
	        $res = array(
	            'success' => true,
	        	'id' => $result->getId()
	        );
        } catch (PPConnectionException $ex) {
	        $res = array(
	            'success' => false,
	        	'message' => $ex->getData()
	        );
        }
        return $this->_getTransactionResult($res);
    }
    
    private function _getPayer($val)
    {
    	$card = $this->_getCardInfo($val['cardinfo']);

        $fi = new FundingInstrument();
        $fi->setCredit_card($card);

        $payer = new Payer();
        $payer->setPayment_method("credit_card");
        $payer->setFunding_instruments(array($fi));
        return $payer;
	}
	private function _getCardInfo($val)
	{
		$card = new CreditCard();
		$card->setType($val['type']);
		$card->setNumber($val['number']);
		list($month,$year) = explode("/", $val['expired']);
		$card->setExpire_month($month);
		$card->setExpire_year("20".$year);
		return $card;
	}
	private function _getTransaction($val)
    {
     	$amount = new Amount();
        $amount->setCurrency($val['currency']);
        $amount->setTotal($val['total']);

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription($val['description']);
        return $transaction;
	}
	protected function setClientid($val)
    {
		$this->_clientId = $val;	
	}
    protected function setClientsecret($val)
    {
		$this->_clientSecret = $val;
	}
	protected function setLogfile($val)
    {
		$this->_logfile = $val;
	}
	protected function setTimeout($val)
	{
		$this->_connectTimeout = $val;
	}
	protected function setProductionurl($val)
	{
		$this->_productionUrl= $val;
	}
	protected function setSandboxurl($val)
	{
		$this->_sandboxUrl = $val;
	}
    function _getApiContext()
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->_clientId,
                $this->_clientSecret
            )
        );
        $config = array(
            'http.ConnectionTimeOut' => $this->_connectTimeout,
            'cache.enabled' => 'true',
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log',
        );
        if( $this->isSandbox() ) {
			$config['mode'] = 'sandbox';
			$config['service.EndPoint'] = $this->_sandboxUrl;
		}
		else {
			$config['service.EndPoint'] = $this->_productionUrll;
		}
		$config['log.FileName'] = $this->_logfile;
        $apiContext->setConfig($config);

        return $apiContext;
    }
    private function _getTransactionResult($result)
    {
    	$res = new TransactionResult(array(
    			'success' => $result['success'],
    			'provider' => self::PROVIDER
    	));
    	if ($result['success']) {
    		$res->setReferenceId($result['id']);
    	}
    	else {
    		$res->setErrorMsg($result['message']);
    	}
    	return $res;
    }
}
