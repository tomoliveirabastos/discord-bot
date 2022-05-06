<?php

use App\HandleMessage;

require 'vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();

$token = $_ENV['TOKEN'];

$client = new \GuzzleHttp\Client();

$handleMessage = new HandleMessage($token, $_ENV['URL']);

$channels = $handleMessage->getChannels($_ENV['CURRENT_GUILD']);

$channelsId = array_map(function ($item) {
       return $item['id'];
}, $channels);

[, $msg] = $argv;

foreach ($channelsId as $channelId) {
       try {

              $handleMessage->sendMessage($channelId, $msg);
       } catch (\Exception $e) {

              $error = $e->getMessage();

              file_put_contents(__DIR__ . "/error.txt", $error, FILE_APPEND);
       }
}
