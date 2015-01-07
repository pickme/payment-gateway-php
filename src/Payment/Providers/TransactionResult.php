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
    	return $this->_success;
    }
    /**
     * return transaction error message.
     *
     * @access public
     * @return string
     */
    public function getErrorMsg()
    {
	    return $this->_errorMsg;
    }
    
    /**
     * set transaction error message.
     *
     * @access public
     * @param string $val
     * @return string
     */
    public function setErrorMsg($val)
    {
    	$this->_errorMsg = $val;
    }
    /**
     * return transaction reference id link to provider.
     *
     * @access public
     * @return void
     */
    public function getReferenceId()
    {
        return $this->_referenceId;
    }
    /**
     * set transaction reference id link to provider.
     *
     * @access public
     * @param string $val
     * @return void
     */
    public function setReferenceId($val)
    {
    	$this->_referenceId = $val;
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
