<?php namespace Payment\Providers;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use Payment\Providers\TransactionResult;

class Paypal extends ProviderAbstract implements ProviderInterface {

    /**
     * Provider name
     */
    const PROVIDER = "Paypal";

    private $_apiContext = null;
    private $_clientId = null;
    private $_clientSecret = null;
    private $_logfile= null;
    private $_sandBox = null;

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
        $this->_apiContext = $this->getApiContext();
    }
    /**
     * do payment process
     *
     * @access public
     * @param  array
     */
    public function doPayment($val)
    {
		if (is_array($val))
        {
            $opts = $val;
            $payer = $this->_getPayer($opts['CardInfo']);
            $itemList = $this->_getItemList($opts['Items']);
            $amount= $this->_getAmount($opts['Currency']);
            $transaction = new Transaction();
            
            $baseUrl = "127.0.0.1";
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/ExecutePayment.php?success=true")
    ->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");
            
            $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription("Payment description");
            $payment = new Payment();
            $payment->setIntent("sale")
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions(array($transaction));
            try {
                $payment->create($this->_apiContext);
            } catch (Exception $ex) {
                exit(1);
            }
        }
    }
    
    private function _getPayer($val)
    {
		$payer = new Payer();
        $payer->setPaymentMethod("paypal");
        return $payer;
	}
	
	private function _getItemList($val)
    {
		$item1 = new Item();
$item1->setName('Ground Coffee 40 oz')
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setPrice(7.5);
$item2 = new Item();
$item2->setName('Granola bars')
    ->setCurrency('USD')
    ->setQuantity(5)
    ->setPrice(2);

          $itemList = new ItemList();
          $itemList->setItems(array($item1, $item2));

         return $itemList;
	}
	private function _getAmount($val)
    {
     	$details = new Details();
$details->setShipping(1.2)
    ->setTax(1.3)
    ->setSubtotal(17.50);

// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
$amount = new Amount();
$amount->setCurrency("USD")
    ->setTotal(20)
    ->setDetails($details);
        return $amount;
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
    function getApiContext()
    {

        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $this->_clientId,
                $this->_clientSecret
            )
        );

        // Comment this line out and uncomment the PP_CONFIG_PATH
        // 'define' block if you want to use static file
        // based configuration
        $config = array(
            'http.ConnectionTimeOut' => 30,
            'cache.enabled' => 'true',
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log',
            'service.EndPoint' => 'https://api.sandbox.paypal.com'
        );
        if( $this->_isSandbox() ) {
			$config['mode'] = 'sandbox';
		}
		$config['log.FileName'] = $this->_logfile;
        $apiContext->setConfig($config);

        return $apiContext;
    }
}
