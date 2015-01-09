<?php namespace Payment\Sample\Controller;


class Root {
	
	private $c = null;

	public function __construct($c)
	{
	    $this->c = $c;
	    
	}
	
	public function index()
	{
	    $this->c->setStash('User','Yo');
	    $this->c->renderView('Root');
	}

    public function process()
    {
    	$result = null;
        $params = $this->_getPaymentParams($this->c->requestParams());
        
        try 
        {
            $result = $this->c->model('PaymentGateway')->doPayment($params);
        if($result->isSuccess() ) {
            print "Transaction success with id".$result->getReferenceId();
        }
        else {
            print "Transaction failed with msg ".$result->getErrorMsg();
        }
        }
        catch ( \Exception $ex ) 
        {
            $this->c->setStash("ErrMsg",$ex->getMessage());
        	$this->c->renderView('Root');
        }
        echo "Finish";
    }

    private function _getPaymentParams($val)
    {
        return array(
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