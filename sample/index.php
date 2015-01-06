<?php
require_once('../autoload.php');

use Payment\Gateway;


$config = array(
    'paypal' => array(
        'logfile' => '/tmp/paypal.log',
        'clientid' => 'AXWCshAD1aAEe3rmhqVBJU8jjl8NZvDP4sWE5utK6F30-jB80BTNWmnN2IvL',
        'clientSecret' => 'EJs8yRDtVU30otbO1olx20UqhCJK8X13kekGKVrUZGhwtqAoPc_jRLqRunLK',
    	'sandboxmode' => '1'
     ),
    'braintree' => array(
        'merchantid' => '6wdpvcgyx8mrh9xs',
        'publickey' => 'rjzshvxbf2hdszdn',
        'privatekey' => '5a493c3625a3cf7b698b87fa1e68b223',
    	'sandboxmode' => '1'
     )
);

$parms = array(
    'cardinfo' => array(
        'holder' => 'Test',
    	'number' => '5105105105105100',
    	'expired' => '05/12'
     ),
    'items' => array(
        'id' => 'id',
     ),
	'amount' => array(
		'total' => '1000.00',
		'currency' => 'USD',
		'description' => 'Test'
	)
);

$gateway = new Gateway($config);

$provider = $gateway->getBraintreeProvider();

$result = $provider->doPayment($parms);
 if($result->isSuccess() ) {
 	print "Transaction success with id".$result->getReferenceId();
 }

echo "Success";
