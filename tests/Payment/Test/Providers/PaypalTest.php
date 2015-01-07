<?php namespace Payment\Test\Providers;

use Payment\Providers\Paypal;

class PaypalTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Gets config for paypal provider.
	 * @return array
	 */
	public static function getConfig()
	{
        $config = array(
            'logfile' => '/tmp/paypal.log',
            'clientid' => 'AXWCshAD1aAEe3rmhqVBJU8jjl8NZvDP4sWE5utK6F30-jB80BTNWmnN2IvL',
            'clientSecret' => 'EJs8yRDtVU30otbO1olx20UqhCJK8X13kekGKVrUZGhwtqAoPc_jRLqRunLK',
    	    'sandboxmode' => 1,
    	    'productionurl' => 'https://api.paypal.com',
    	    'sandboxurl' => 'https://api.sandbox.paypal.com',
    	    'timeout' => 30
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
		$obj = new Paypal(self::getConfig());
		$this->assertNotNull($obj);
		$this->assertEquals($obj->isSandbox(), true);
	}
	/**
	 * test do payment function.
	 */
	public function testPaymentFunction()
	{
	    $obj = new Paypal(self::getConfig());
	    $this->assertNotNull($obj);
	    $result = $obj->doPayment(self::getParams());
	    $this->assertNotNull($result);
	    $this->assertEquals($result->isSuccess(), true);
	    $this->assertNotNull($result->getReferenceId());	    
	}
	/**
	 * test do payment with incorrect parms.
	 */
	public function testPaymentFailed()
	{
	    $obj = new Paypal(self::getConfig());
	    $this->assertNotNull($obj);
	    $result = $obj->doPayment(null);
	    $this->assertNotNull($result);
	    $this->assertEquals($result->isSuccess(), false);
	    $this->assertNotNull($result->getErrorMsg());
	}
}