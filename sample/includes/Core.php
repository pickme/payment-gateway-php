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
    
    /**
     * get model by name
     *
     * @access public
     * @param  array
     * @return Model class following provide name
     */
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
    /**
     * set value to stash with key ( this can use in teplate)
     *
     * @access public
     * @param  key and value
     * @return void
     */
    public function setStash($key, $val)
    {
    	$this->_stash[$key] = $val;
    }

    public function setRoute($r)
    {
        $this->_route = $r;
    }
    /**
     * get value from stash with key
     *
     * @access public
     * @param  key
     * @return value
     */
    public function getStash($val)
    {
    	if(isset($val)) {
    		return $this->_stash[$val];
    	}
    	else {
    		return $this->_stash;
    	}
    }
    /**
     * render view in view folder following provide name
     *
     * @access public
     * @param  view name
     * @return void
     */
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
    /**
     * get request params from HTTP request
     *
     * @access public
     * @param  params name or null to get all params
     * @return array
     */
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
    /**
     * load all config in to core
     *
     * @access public
     * @param  array
     * @return void
     */
    public function loadConfig($val)
    {
        $this->_config = $val;
    }
}

?>
