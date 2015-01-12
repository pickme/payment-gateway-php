<?php namespace Payment\Sample\Model;

class DB extends \SQLite3 {
	
    private $_config = null;
    /**
     * Construct the DB model
     * @access public
     * @param  array $params (default: array())
     * @return void
     */
	public function __construct($config)
	{
	    $params = $config['filename'];
	    parent::__construct($params);
	    $this->_createSchema();
	    $this->_config = $config;
	}

	/**
	 * save success or to data base
	 *
	 * @access public
	 * @param  array
	 */
	public function saveOrder($val)
	{
	    $cardinfo = $val['payer']['cardinfo'];
	    $amount = $val['amount'];
	    $response = $val['response'];
	    $card_id = $this->querySingle('SELECT id from CreditCards where card_number = "'.$this->_encryptData($cardinfo['number']).'"');
	    if( !isset($card_id) ) {
	        $this->exec('INSERT INTO CreditCards (holder, card_number, expired, cvv) VALUES ("'.$cardinfo['holder'].'","'.$this->_encryptData($cardinfo['number']).'","'.$cardinfo['expired'].'","'.$this->_encryptData($cardinfo['cvv']).'")');
	        $card_id = $this->lastInsertRowid();
	    }
 	    $this->exec('INSERT INTO Orders (customer, amount, currency, card_id) VALUES ("'.$val['customer'].'",'.$amount['total'].',"'.$amount['currency'].'",'.$card_id.')');
 	    $order_id = $this->lastInsertRowid();
 	    $this->exec('INSERT INTO Transactions (order_id, response,  referrence_id, provider, created) VALUES ('.$order_id.',"'.$response['status'].'","'.$response['id'].'","'.$response['provider'].'","'.microtime().'")');

	}

    private function _createSchema()
    {       
        $this->exec('CREATE TABLE IF NOT EXISTS Transactions (id int, order_id int, response text, referrence_id text, provider text, created text,PRIMARY KEY (id))');
        $this->exec('CREATE TABLE IF NOT EXISTS Orders (id int, customer text, amount number, currency text, card_id int, PRIMARY KEY (id))');
        $this->exec('CREATE TABLE IF NOT EXISTS CreditCards (id int, holder text, card_number text, expired text, cvv text, PRIMARY KEY (id))');
    }

    private function _encryptData($str)
    {
        $encryption_key = $this->_config['encryptKey'];
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($str), MCRYPT_MODE_ECB, $iv);
        return $encrypted_string;
    }

    private function _decryptData($str)
    {
        $encryption_key = $this->_config['encryptKey'];
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $str, MCRYPT_MODE_ECB, $iv);
        return $decrypted_string;
    }
}