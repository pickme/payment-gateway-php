<?php namespace Payment\Sample\Controller;


class Root {
	
	private $c = null;

	public function __construct($c)
	{
	    $this->c = $c;
	    
	}
	
	public function index()
	{
	    $this->c->renderView('Root');
	}

    public function process()
    {
    	$result = null;
        $params = $this->_getPaymentParams($this->c->requestParams());
        
        try 
        {
            $result = $this->c->model('PaymentGateway')->doPayment($params);
            if( $result->isSuccess() ) {
                $params['response'] = array(
                    'status' => 'success',
                    'id' => $result->getReferenceId(),
                    'provider' => $result->getProviderName()
                );
                $this->c->model('DB')->saveOrder($params);
                $this->c->setStash("Message","Pay to ".$result->getProviderName(). " success with Reference ID: ".$result->getReferenceId());
                $this->c->renderView('Root');
            }
            else {         
                $this->c->setStash("ErrMsg",$ex->getMessage());
        	    $this->c->renderView('Root');
            }
        }
        catch ( \Exception $ex ) 
        {
            $this->c->setStash("ErrMsg",$ex->getMessage());
        	$this->c->renderView('Root');
        }
 
    }

    private function _getPaymentParams($val)
    {
        return array(
            'customer' => $val['customer'],
            'payer' => array(
                'cardinfo' => array(
                    'type'   => $val['card_type'],
                    'holder' => $val['holder'],
                    'number' => $val['number'],
                    'expired' => $val['mm'].'/'.$val['yy']
                ),
            ),
            'amount' => array(
                'total' => $val['total'],
                'currency' => $val['currency'],
                'description' => 'Descriptions'
            )
        );
    }
}