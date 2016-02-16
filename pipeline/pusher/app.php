<?php

require_once __DIR__ . '/../vendor/autoload.php';

$context = new ZMQContext;
$pusher  = new ZMQSocket($context, ZMQ::SOCKET_PUSH);

$pusher->bind('tcp://*:5557');
$pusher->send('logo.png');

sleep(2);
