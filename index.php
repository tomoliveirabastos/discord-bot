<?php

require __DIR__ . "/vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;

$discord = new Discord(['token' => $_ENV['TOKEN']]);

$discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {
       $temp_file = __DIR__ . "/files.txt";

       if ($message->author->bot) return;

       // $message->reply("");
       $actionMessage = new \App\ActionsMessage();

       // $username = $message->author->username;
       $text = trim($message->content);

       $name = $_ENV['USER_NAME'];

       if ($actionMessage->isAuthor($message, $name)) {

              $text = strtolower($text);

              if ($text === "responda tomzinha") {
                     $message->reply("Olá sr(a) {$name}");

                     return;
              }

              if ($text === "tomzinha, leia as mensagens") {

                     if (!file_exists($temp_file)) {

                            $message->reply("Olá sr(a) {$name}, nenhuma mensagem registrada");

                            return;
                     }

                     $content = file_get_contents($temp_file);

                     $message->reply($content);

                     unlink($temp_file);

                     return;
              }
       }

       $now = date('Y-m-d H:i:s');

       $msg = $discord::VERSION . " - {$now} - {$message->author->username}: {$message->content}" . PHP_EOL;

       echo $msg;

       if ($actionMessage->verificaSeFoiMencionado($text, $name) || $actionMessage->verificaSeFoiMencionado($text, $_ENV['USER_ID'])) {

              $message->reply("Essa mensagem foi registrada, o sr(a) {$name} vai ler depois");

              $temp_file = __DIR__ . "/files.txt";

              file_put_contents($temp_file, $msg, FILE_APPEND);
       }
       // echo "{$message->author->username}: {$message->content}" . PHP_EOL;
});

$discord->run();
