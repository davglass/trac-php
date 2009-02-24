<?php
$debug = true;
define('ENV_PATH', '/trac-php/');
include('inc/include.php');

$env = new Env('./env/');
$env->db = new DB($env);

$req = new Request(array('env' => $env));
$req->registerHandler('ticket', 'TicketModule');
$req->registerHandler('report', 'ReportModule');
$req->registerHandler('timeline', 'TimelineModule');
$req->registerHandler('roadmap', 'RoadmapModule');
$req->registerHandler('browser', 'BrowserModule');
$req->registerHandler('search', 'SearchModule');
$req->registerHandler('login', 'LoginModule');
$req->registerHandler('prefs', 'PrefsModule');
$req->respond();
?>
