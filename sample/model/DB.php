<?php namespace Payment\Sample\Model;

class DB extends SQLiteDatabase {
	
    private $_config = null;
	public function __construct($config)
	{
	    $params = $config['filename'];
	    parent::__construct($params);
	    $this->__createSchema();
	    $this->_config = $config;
	}
	
	public function saveOrder($val)
	{
	    $cardinfo = $val['cardinfo'];
	    $amount = $val['amount'];
	    $response = $val['response'];
	    $card_id = $this->querySingle('SELECT id from CreditCard where card_number = '.$cardinfo['number']);
	    if( !isset($card_id) ) {
	        $this->exec('INSERT INTO CreditCard (holder, card_number, expired, cvv) VALUES ("'.$cardinfo['holder'].'","'.$cardinfo['number'].'","'.$cardinfo['expired'].'","'.$cardinfo['cvv'].'")');
	        $card_id = $this->lastInsertRowid();
	    }
	    $this->exec('INSERT INTO CreditCard (customer, amount, currency, card_id) VALUES ("'.$val['customer'].'",'.$amout['total'].',"'.$amount['currency'].'",'.$card_id.')');
	    $order_id = $this->lastInsertRowid();
	    $this->exec('INSERT INTO Transaction (order_id, response, created) VALUES ('.$order_id.',"'.$response.'","'.$cardinfo['expired'].'")');
	}
	
    private function _createSchema()
    {
        $this->exec('CREATE TABLE IF NOT EXISTS Transaction (id int, order_id int, response text, created text,PRIMARY KEY (id))');
        $this->exec('CREATE TABLE IF NOT EXISTS Order (id int, customer text, amount number, currency text, card_id int, PRIMARY KEY (id))');
        $this->exec('CREATE TABLE IF NOT EXISTS CreditCard (id int, holder text, card_number text, card_number text, cvv text, PRIMARY KEY (id))');
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