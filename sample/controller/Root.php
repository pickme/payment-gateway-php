<?php namespace Payment\Sample\Controller;


class Root {
	
	private $_c = null;

	public function __construct($c)
	{
	    $this->_c = $c;
	    
	}
	
	public function index()
	{
	    $this->_c->setStash('User','Yo');
	    $this->_c->renderView('Root');
	}
}