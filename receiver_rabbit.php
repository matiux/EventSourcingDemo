<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;


$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

$channel = $connection->channel();

/**
 * Il terzo parametro messo a true rende la coda "durable". Questo, se impostato anche nella coda del sender,
 * e creando il messaggio (AMQPMessage) come durable, fa in modo che i messaggi non vengano persi anche se il serve
 * va giù
 */
$channel->queue_declare('main-exchange', false, true, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg) {

    $message = json_decode($msg->body, true);

    //echo " [x] Received ", $msg->body, "\n";
    echo " [x] Received (Event ID)", $message['event_id'], "\n";

    sleep(rand(3, 6));

    echo " [x] Done", "\n";

    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

/**
 * $channel->basic_qos(null, 1, null); e il 4° parametro di basic_consume() messo a false attiva il Message acknowledgment
 */
$channel->basic_qos(null, 1, null);
$channel->basic_consume('main-exchange', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {

    $channel->wait();
}

$channel->close();
$connection->close();
