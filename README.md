# payment-gateway-php
PHP payment gateway module for braintree and paypal.

INSTALLATION

This module is installed via Composer. To install, simply add it to your composer.json file:

{
    "require": {
        "pickme/payment-gateway-php": : "*"
    }
}

And run composer to update  or install in your dependencies:

$ php composer.phar update or $ php composer.phar install

Usage

The gateway are provided by this package:
\Payment\Gateway

Using this by new object with provider params

Ex. 

    $gateway = new \Payment\Gateway( array(
            'paypal' => array(
                'logfile' => '/tmp/paypal.log',
                'clientid' => '[client id from paypal]',
                'clientSecret' => '[client secret from paypal',
                'sandboxmode' => '1', #not set mean production
                'productionurl' => 'https://api.paypal.com',   
                'sandboxurl' => 'https://api.sandbox.paypal.com',
                'timeout' => 30 #connnection timeout to paypal
            ),
            'braintree' => array(
                'merchantid' => '[your merchant key from braintree]',
                'publickey' => '[your public key from braintree]',
                'privatekey' => '[your private key from braintree]',
                'sandboxmode' => '1'  #not set mean production
            ) 
    );


LICENSE AND COPYRIGHT

Copyright (C) 2014 Ronnachate Gatekieo

This program is free software; you can redistribute it and/or modify it
under the terms of either: the GNU General Public License as published
by the Free Software Foundation; or the Artistic License.

