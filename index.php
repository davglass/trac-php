<?php
$debug = true;

define('ENV_PATH', '/trac-php/');

include('inc/include.php');

$env = new Env('./env/');

$env->db = new DB($env);

$req = new Request(array('env' => $env));
$req->registerHandler('ticket', 'TicketModule');
$req->registerHandler('report', 'ReportModule');
$req->respond();
?>
