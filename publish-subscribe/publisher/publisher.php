<?php

$context   = new ZMQContext;
$publisher = new ZMQSocket($context, ZMQ::SOCKET_PUB);

$publisher->bind('tcp://*:5556');

$flights = [
    'DRS' => [
        ['code' => 'LH 2122', 'from' => 'Munich'],
        ['code' => 'LH 206', 'from' => 'Frankfurt'],
        ['code' => 'LH 2124', 'from' => 'Munich'],
    ],
    'MUC' => [
        ['code' => 'LH 1817', 'from' => 'Barcelona'],
        ['code' => 'LH 2505', 'from' => 'Manchester'],
    ],
];

echo 'Air Control, send flights ...' , PHP_EOL;

foreach ($flights as $destination => $data) {
    echo sprintf('Send flights to %s ...', $destination);

    foreach ($data as $flight) {
        sleep(1);
        $publisher->send(sprintf('%s %s', $destination, json_encode($flight)), ZMQ::MODE_DONTWAIT);
    }

    echo 'Done' . PHP_EOL;
}
