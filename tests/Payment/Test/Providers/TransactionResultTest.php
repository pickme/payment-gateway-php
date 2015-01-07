<?php namespace Payment\Test\Providers;

use Payment\Providers\TransactionResult;

class TransactionResultTest extends \PHPUnit_Framework_TestCase
{
	public function testinitializeObject()
	{
        $obj = new TransactionResult(array(
    	    'success' => true,
    		'provider' => 'TestProvider'
    	));
        $this->assertNotNull($obj);
        $this->assertEquals($obj->isSuccess(), true);
        $this->assertEquals($obj->getProviderName(), "TestProvider");
	}
	public function testGetters()
	{
		$obj = new TransactionResult(array(
	        'success' => true,
	        'provider' => 'TestProvider'
		));
		$obj->setReferenceId("TestId");
		$obj->setErrorMsg("TestErrorMsg");
		$this->assertEquals($obj->getReferenceId(), "TestId");
		$this->assertEquals($obj->getErrorMsg(), "TestErrorMsg");
	}
}