<?php namespace Payment\Sample\Model;

use Payment\Gateway;

class PaymentGateway {
	
	private $_gateway = null;

	public function __construct($config)
	{
	    $this->_gateway = new Gateway($config);
	}
	
	public function doPayment($parms)
	{
		$provider = $this->_selectProvider($params);
		return $provider->doPayment($parms);
	}
	
	private function _selectProvider($params)
	{
	    $getFunction = "getBrainereeProvider";
	    $payer = $params['payer'];
		$cardinfo = $payer['cardinfo'];
		$amount = $params['amount'];
		$type = $this->_validateCard($cardinfo['number']);
		if( $type != $cardinfo['type']) {
		    die("Invalid card number or card type");
		}
		if( $type == 'amex' ) {
		    if( $amount['currency'] != 'USD' ) {
		        die(" AMEX is possible to use only for USD");
		    }
		    $getFunction = "getPaypalProvider";
		}
		else if (in_array($amount['currency'], array('USD', 'EUR', 'AUD'))) {
		    $getFunction = "getPaypalProvider";
		}
		return $this->_gateway->$getFunction();
	}

	private function _validateCard($card)
	{
		$cards = array(
            "visa" => "(4\d{12}(?:\d{3})?)",
	        "amex" => "(3[47]\d{13})",
		    "jcb" => "(35[2-8][89]\d\d\d{10})",
            "maestro" => "((?:5020|5038|6304|6579|6761)\d{12}(?:\d\d)?)",
            "solo" => "((?:6334|6767)\d{12}(?:\d\d)?\d?)",
            "mastercard" => "(5[1-5]\d{14})",
            "switch" => "(?:(?:(?:4903|4905|4911|4936|6333|6759)\d{12})|(?:(?:564182|633110)\d{10})(\d\d)?\d?)",
		);
		$names = array("visa", "amex", "jcb", "maestro", "solo", "mastercard", "switch");
		$matches = array();
		$pattern = "#^(?:".implode("|", $cards).")$#";
		$result = preg_match($pattern, str_replace(" ", "", $card), $matches);
		
		return ($result>0)?$names[sizeof($matches)-2]:false;
	}
}