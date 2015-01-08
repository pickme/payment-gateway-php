<?php namespace Payment\Sample;

class Router {

    /*
    * @the controller path
    */
    private $path;

    private $args = array();

    public $file;

    public $controller;

    public $action;
    
    private $_core;
    
    public function __construct($core)
    {
        $this->_core = $core;
    }


    /**
    *
    * @set controller directory path
    *
    * @param string $path
    *
    * @return void
    *
    */
    public function setPath($path) {

	   /*** check if path i sa directory ***/
	   if (is_dir($path) == false)
	   {
		  throw new Exception ('Invalid controller path: `' . $path . '`');
	   }
	   /*** set the path ***/
 	  $this->path = $path;
    }


    /**
     *
     * @load the controller
    *
    * @access public
    *
    * @return void
    *
    */
    public function loader($r)
    {
	   /*** check the route ***/
	   $this->setController($r);

	   /*** if the file is not there diaf ***/
	   if (is_readable($this->file) == false)
	   {
		  $this->file = $this->path.'/Err404.php';
            $this->controller = 'Err404';
	   }

	   /*** include the controller ***/
	   include $this->file;

	   /*** a new controller class instance ***/
	   $class =  $modelName = "\\Payment\\Sample\\Controller\\".$this->controller;
	   
	   $controller = new $class($this->_core);

	   /*** check if the action is callable ***/
	   if (is_callable(array($controller, $this->action)) == false)
	   {
		  $action = 'index';
	   }
	   else
	   {
		  $action = $this->action;
	   }
	   /*** run the action ***/
	   $controller->$action();
    }

    /**
    *
    * @get the controller
    *
    * @access private
    *
    * @return void
    *
    */
    private function setController($r) {

        $route = null;
        if( $r ) {
            $route = $r;
        }
        else {
            /*** get the route from the url ***/
            $route = (empty($_GET['route'])) ? '' : $_GET['route'];
        }


	   if (empty($route))
	   {
		  $route = 'Root';
	   }
	   else
	   {
		  /*** get the parts of the route ***/
		  $parts = explode('/', $route);
		  $this->controller = $parts[0];
		  if(isset( $parts[1]))
		  {
			 $this->action = $parts[1];
		  }
	   }

	   if (empty($this->controller))
	   {
		  $this->controller = 'Root';
	   }

	   /*** Get action ***/
	   if (empty($this->action))
	   {
		  $this->action = 'index';
	   }

	   /*** set the file path ***/
	   $this->file = $this->path .'/'. $this->controller . '.php';
    }

}
?>
