<?php namespace Payment\Providers;

class ProviderAbstract {

    /**
     * Sandbox mode
     *
     * @var boolean
     */
    protected $_sandbox = false;


    /**
     * Construct the adapter payment.
     *
     * @param array $params
     */
    public function __construct($params=array())
    {
        $this->initialize($params);
    }

    /**
     * Option intialize.
     *
     * @param  array $params
     * @return object
     */
    public function initialize($params)
    {

        if (count($params) > 0)
        {
            foreach ($params as $key => $val)
            {
                $method = "set".ucfirst($key);

                if (method_exists($this, $method))
                {
                    $this->$method($val);
                }
            }
        }

        return $this;
    }


    /**
     * Set to enable sandbox mode
     *
     * @access public
     * @param  bool
     */
    public function setSandboxMode($val)
    {
        $this->_sandBox = $val;
    }

    protected function _isSandbox()
    {
        if(isset($this->_sandBox)) {
            return true;
        }
        else {
            return false;
        }
    }

}
