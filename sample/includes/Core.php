<?php namespace Payment\Sample;

Class Core {

 /*
 * @the models array
 * @access private
 */
    private $models = array();

    public function model($name)
    {
 	    if( !isset($this->models[$name]) ) {
     	    $modelName = "\\Payment\\Sample\\Model\\".$name;
     	
     	    include ('model/'.$name.'.php');
     	    $this->models[$name] = new $modelName();
        }
        return $this->models[$name];
    }

}

?>
