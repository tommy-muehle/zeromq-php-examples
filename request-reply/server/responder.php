<?php

require_once __DIR__ . '/vendor/autoload.php';

use Ivory\HttpAdapter\CurlHttpAdapter;
use Geocoder\Provider\GoogleMaps;

$context   = new ZMQContext;
$responder = new ZMQSocket($context, ZMQ::SOCKET_REP);

$responder->bind('tcp://*:5555');

$curl     = new CurlHttpAdapter;
$geocoder = new GoogleMaps($curl);

while (true) {
    $address = $responder->recv();
    echo sprintf('Search coordinates for: %s', $address) . PHP_EOL;

    $result = $geocoder->geocode($address)->first();
    $responder->send(sprintf(
        'The coordinates are %s, %s.', $result->getCoordinates()->getLatitude(), $result->getCoordinates()->getLongitude()
    ));

    sleep(2);
}
