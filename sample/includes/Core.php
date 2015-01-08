<?php namespace Payment\Sample;

Class Core {

 /*
 * @the models array
 * @access private
 */
    private $_models = array();
    private $_stash = array();
    private $_parms = array();
    private $_config = array();
    private $_route = null;

    public function model($name)
    {
 	    if( !isset($this->_models[$name]) ) {
     	    $modelName = "\\Payment\\Sample\\Model\\".$name;
     	
     	    include ('model/'.$name.'.php');
     	    if( isset($this->_config[$name])) {
     	        $this->_models[$name] = new $modelName($this->_config[$name]);
     	    }
     	    else {
     	        $this->_models[$name] = new $modelName();
     	    }
        }
        return $this->_models[$name];
    }
    public function setStash($key, $val)
    {
    	$this->_stash[$key] = $val;
    }
    public function setRoute($r)
    {
        $this->_route = $r;
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
    public function renderView($name)
    {
        $path = './views' . '/' . $name . '.php';
        
        if (file_exists($path) == false)
        {
            die('Template not found in '. $path);
        }
        
        // Load variables
        foreach ($this->_stash as $key => $value)
        {
            $$key = $value;
        }
        include ($path);
    }
    public function requestParams($name)
    {
        if( count( $this->_parms) == 0 ) {
            foreach($_POST as $key=>$val) {
                $this->_parms[$key]= $val;
            }      
            foreach($_GET as $key=>$val) {
                $this->_parms[$key]= $val;
            }
            unset($this->_parms['route']);

        }
        if ( isset($name) ) {
            return $this->_parms[$val];
        }
        else {
            return $this->_parms;
        }
    }
    public function loadConfig($val)
    {
        $this->_config = $val;
    }
    public function redirect($r)
    {
        $this->_route->loader($r);
    }
}

?>
