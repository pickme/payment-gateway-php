<?php namespace Payment\Sample;

Class Core {

 /*
 * @the models array
 * @access private
 */
    private $_models = array();
    private $_stash = array();

    public function model($name)
    {
 	    if( !isset($this->_models[$name]) ) {
     	    $modelName = "\\Payment\\Sample\\Model\\".$name;
     	
     	    include ('model/'.$name.'.php');
     	    $this->_models[$name] = new $modelName();
        }
        return $this->_models[$name];
    }
    public function setStash($key, $val)
    {
    	$this->_models[$key] = $val;
    }
    public function getStash($val)
    {
    	if(isset($val)) {
    		return $this->_stash[$val];
    	}
    	else {
    		return $this->_stash;
    	}
    }
}

?>
