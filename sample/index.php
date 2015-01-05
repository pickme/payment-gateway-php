<?php
require_once('../autoload.php');

use Payment\Gateway;



$config = array(
    'paypal' => array(
        'logfile' => '/tmp/paypal.log',
        'clientid' => 'AXWCshAD1aAEe3rmhqVBJU8jjl8NZvDP4sWE5utK6F30-jB80BTNWmnN2IvL',
        'clientSecret' => 'EJs8yRDtVU30otbO1olx20UqhCJK8X13kekGKVrUZGhwtqAoPc_jRLqRunLK',
    	'sandbox' => '1'
     ),
    'braintree' => array(
        'merchantid' => '6wdpvcgyx8mrh9xs',
        'publickey' => 'rjzshvxbf2hdszdn',
        'privatekey' => '5a493c3625a3cf7b698b87fa1e68b223',
    	'sandbox' => '1'
     )
);


$parms = array(
    'CardInfo' => array(
        'Test' => 'Test',
     ),
    'Items' => array(
        'id' => 'id',
     ),
    'Currency' => 'USD'
);


$gateway = new Gateway($config);

$provider = $gateway->getBraintreeProvider();

$result = $provider->doPayment($parms);

if($result->isSuccess ) {
	print "Transaction success with id".$result->getReferenceId;
}

echo "Success";
