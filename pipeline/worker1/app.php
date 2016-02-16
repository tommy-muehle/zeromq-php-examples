<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

/**
 * Copy the received image and notify next worker
 */

$worker1 = new ZMQSocket(new ZMQContext, ZMQ::SOCKET_PULL);
$worker1->connect('tcp://localhost:5557');

$worker2 = new ZMQSocket(new ZMQContext, ZMQ::SOCKET_PUSH);
$worker2->bind('tcp://*:5558');

while (true) {
    $filename = $worker1->recv();
    echo "Received file: $filename" . PHP_EOL;

    $newFilename = 'copied.png';

    $image = Image::make($filename);
    $image->save($newFilename);

    $worker2->send($newFilename);

    sleep(2);
}
