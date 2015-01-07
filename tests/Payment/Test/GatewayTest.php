<?php namespace Payment\Test;

use Payment\Gateway;
use Payment\Providers\Braintree;
use Payment\Providers\Paypal;

class GatewayTest extends \PHPUnit_Framework_TestCase 
{
	/**
	 * Gets config for Gateway.
	 * @return array
	 */
	public static function getConfig()
	{
	    $config = array(
            'paypal' => array(
                'logfile' => '/tmp/paypal.log',
                'clientid' => 'AXWCshAD1aAEe3rmhqVBJU8jjl8NZvDP4sWE5utK6F30-jB80BTNWmnN2IvL',
                'clientSecret' => 'EJs8yRDtVU30otbO1olx20UqhCJK8X13kekGKVrUZGhwtqAoPc_jRLqRunLK',
                'sandboxmode' => '1',
                'productionurl' => 'https://api.paypal.com',
                'sandboxurl' => 'https://api.sandbox.paypal.com',
                'timeout' => 30
            ),
            'braintree' => array(
                'merchantid' => '6wdpvcgyx8mrh9xs',
                'publickey' => 'rjzshvxbf2hdszdn',
                'privatekey' => '5a493c3625a3cf7b698b87fa1e68b223',
                'sandboxmode' => '1'
            )
	    );
	    return $config;
	}
	/**
	 * Gets params to do payment
	 * @return array
	 */
	public static function getParams()
	{
        $parms = array(
            'payer' => array(
                'cardinfo' => array(
                    'type'   => 'visa',
                    'holder' => 'Test',
                    'number' => '4417119669820331',
                    'expired' => '05/16'
                ),
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
	    return $parms;
	}
	
	/**
	 * test initial object with constructure function.
	 */
	public function testSetInitialObj()
	{
		$obj = new Gateway(self::getConfig());
		$this->assertNotNull($obj);
	}
	/**
	 * test get provider.
	 */
	public function testgetProviders()
	{
	    $obj = new Gateway(self::getConfig());
	    $this->assertNotNull($obj);
	    $this->assertNotNull($obj->getBraintreeProvider());
	    $this->assertInstanceOf('Payment\Providers\Braintree', $obj->getBraintreeProvider());
	    $this->assertNotNull($obj->getPaypalProvider());
	    $this->assertInstanceOf('Payment\Providers\Paypal', $obj->getPaypalProvider());
	    $this->assertNotNull($obj->getDefaultProvider());
	}
}
