<?php

/**
 * Receives messages from publisher with "DRS" socket-filter
 */

$context    = new ZMQContext;
$subscriber = new ZMQSocket($context, ZMQ::SOCKET_SUB);

$subscriber->connect('tcp://localhost:5556', true);
$subscriber->setSockOpt(ZMQ::SOCKOPT_SUBSCRIBE, 'DRS');

echo 'Show flights to DRS (Dresden International Airport) ...' . PHP_EOL;

while (true) {
    $message = $subscriber->recv();
    $flight = json_decode(substr($message, 4), true);

    echo sprintf('Flight number %s from %s', $flight['code'], $flight['from']) . PHP_EOL;

    sleep(2);
}
