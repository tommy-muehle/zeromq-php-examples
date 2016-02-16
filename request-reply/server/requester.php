<?php

require_once __DIR__ . '/vendor/autoload.php';

$context   = new ZMQContext;
$requester = new ZMQSocket($context, ZMQ::SOCKET_REQ);

$requester->connect('tcp://localhost:5555');
$requester->send('Pariser Platz, 10117 Berlin');

echo $requester->recv() . PHP_EOL;
