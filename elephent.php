<?php

require __DIR__ . '/vendor/autoload.php';

use ElephantIO\Client as ElephantIOClient;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

$host = '';
if (isset($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['HTTP_HOST'];
}
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$host:5000";
$client = new Client(new Version2X($actual_link));

$client->initialize();
// var_dump($client);
// send message to connected clients
$client->emit('new_message', ['name' => 'notification', 'email' => 'Hello There!', 'subject' => 'Hello There!', 'created_at' => 'Hello There!', 'id' => 'Hello There!']);
$client->close();
