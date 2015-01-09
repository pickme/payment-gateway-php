<?php

$config = array(
    'PaymentGateway' => array(
        'paypal' => array(
            'logfile' => '/tmp/paypal.log',
            'clientid' => 'AXWCshAD1aAEe3rmhqVBJU8jjl8NZvDP4sWE5utK6F30-jB80BTNWmnN2IvL',
            'clientSecret' => 'EJs8yRDtVU30otbO1olx20UqhCJK8X13kekGKVrUZGhwtqAoPc_jRLqRunLK',
            'sandboxmode' => '1',
            'productionurl' => 'https://api.paypal.com',
            'sandboxurl' => 'https://api.sandbox.paypal.com',
            'timeout' => 30
        ),
        'braintree' => array(
            'merchantid' => '6wdpvcgyx8mrh9xs',
            'publickey' => 'rjzshvxbf2hdszdn',
            'privatekey' => '5a493c3625a3cf7b698b87fa1e68b223',
            'sandboxmode' => '1'
        )
    ),
    'DB' => array(
        'filename' => '../../sample.db',
        'encryptKey' => 'ABC.1234'
    )
);