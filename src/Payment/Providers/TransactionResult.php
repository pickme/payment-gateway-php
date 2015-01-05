<?php namespace Payment\Providers;

class TransactionResult  {
	
	private $_success = null;
	private $_errorMsg = null;
	private $_referenceId = null;
	private $_provider = null;
	
	/**
	 * Construct the result.
	 *
	 * @access public
	 * @param  array $params (default: array())
	 * @return void
	 */
	public function __construct($params=array())
	{
		$this->_success = $params['success'];
		$this->_errorMsg = $params['error'];
		$this->_referenceId = $params['referenceid'];
		$this->_provider = $params['provider'];
	}
    /**
     *  transaction success
     *
     * @access public
     * @return  bool
     */
    public function isSuccess()
    {
    	if(isset($this->_sandBox)) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }
    /**
     * return transaction error message.
     *
     * @access public
     * @return string
     */
    public function getErrorMsg()
    {
	    return $this->_success;
    }
    /**
     * return transaction reference id link to provider.
     *
     * @access public
     * @return string
     */
    public function getReferenceId()
    {
        return $this->_referenceId;
    }
    /**
     * return provider name of the result.
     *
     * @access public
     * @return string
     */
    public function getProviderName()
    {
    	return $this->_provider;
    }
}
