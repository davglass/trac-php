<?php
$debug = true;
define('ENV_PATH', '/trac-php/');
include('../../inc/include.php');
include('../../inc/class.module.ticket.php');

$env = new Env('../../env/');
$env->db = new DB($env);

$ticket = new Ticket(array('id' => 2527699, 'env' => $env, 'username' => 'davglass-change'));

$ticket->setField('status', 'accepted::'.mktime());
$ticket->setFields(array(
    'owner' => 'davglass::'.mktime(),
    'reporter' => 'foo::'.mktime(),
    'priority' => 'P1 (critical)::'.mktime(),
));
$ticket->save();

$ticket->logger('Ticket', $ticket);

?>
