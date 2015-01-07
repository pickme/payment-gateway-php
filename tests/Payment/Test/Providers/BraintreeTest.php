<?php namespace Payment\Test\Providers;

use Payment\Providers\Braintree;

class BraintreeTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Gets config for BrainTree provider.
	 * @return array
	 */
	public static function getConfig()
	{
        $config = array(
            'merchantid' => '6wdpvcgyx8mrh9xs',
	        'publickey' => 'rjzshvxbf2hdszdn',
	        'privatekey' => '5a493c3625a3cf7b698b87fa1e68b223',
            'sandboxmode' => true,
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
	                            'number' => '5105105105105100',
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
		$obj = new Braintree(self::getConfig());
		$this->assertNotNull($obj);
		$this->assertEquals($obj->isSandbox(), true);
	}
	/**
	 * test do payment function.
	 */
	public function testPaymentFunction()
	{
	    $obj = new Braintree(self::getConfig());
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
	    $obj = new Braintree(self::getConfig());
	    $this->assertNotNull($obj);
	    $result = $obj->doPayment(null);
	    $this->assertNotNull($result);
	    $this->assertEquals($result->isSuccess(), false);
	    $this->assertNotNull($result->getErrorMsg());
	}
}
