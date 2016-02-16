<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

/**
 * Rotate the copied image
 */

$worker2 = new ZMQSocket(new ZMQContext, ZMQ::SOCKET_PULL);
$worker2->connect('tcp://localhost:5558');

while (true) {
    $filename = $worker2->recv();
    echo "Received file $filename" . PHP_EOL;

    $image = Image::make($filename);
    $image->rotate(180.0);
    $image->save($filename);

    sleep(2);
}
