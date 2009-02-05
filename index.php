<?php
$debug = true;

define('ENV_PATH', '/trac-php/');

include('inc/include.php');

$env = new Env('./env/');

$req = new Request(array('env' => $env));
$req->registerHandler('ticket', 'TicketModule');
$req->respond();
?>
