<?php
$debug = true;
define('ENV_PATH', '/trac-php/');
include('../../inc/include.php');
include('../../inc/class.module.ticket.php');

$env = new Env('../../env/');
$env->db = new DB($env);



$ticket = new Ticket(array('id' => 2527699, 'env' => $env));

$ticket->setField('status', 'accepted');
$ticket->setFields(array(
    'owner' => 'davglass',
    'reporter' => 'foo',
    'priority' => 'P1 (critical)',
));

$ticket->logger('Ticket', $ticket);

?>
