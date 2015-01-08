<?php

require_once './includes/Core.php';
include './includes/Router.php';
include './includes/Config.php';

use Payment\Sample\Core;
use Payment\Sample\Router;


$c = new Core();
$c->loadConfig($config);

$r = new Router($c);
$r->setPath('./controller');
$c->setRoute($r);
