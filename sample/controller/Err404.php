<?php namespace Payment\Sample\Controller;


class Err404 {
	
	private $_c = null;

	public function __construct($c)
	{
	    $this->_c = $c;
	    
	}
	
	public function index()
	{
	   echo "Page not found";
	}
}