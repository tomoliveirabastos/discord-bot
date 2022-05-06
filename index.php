#!/usr/bin/php
<?php
require __DIR__ . "/vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;

$discord = new Discord(['token' => $_ENV['TOKEN']]);

$discord->on(Event::MESSAGE_CREATE, function (Message $message) {
       $temp_file = __DIR__ . "/files.txt";

       if ($message->author->bot) return;

       // $message->reply("");
       $actionMessage = new \App\ActionsMessage();

       // $username = $message->author->username;
       $text = trim($message->content);

       $name = $_ENV['USER_NAME'];

       $pregText = strtolower(preg_replace("/[^a-zA-Z0-9]/", "", $text));

       if ($pregText === "bomdiatomzinha") {
              $message->reply("Bom dia sr(a) {$message->author->username}");

              return;
       }

       if ($pregText === "boatardetomzinha") {
              $message->reply("Boa tarde sr(a) {$message->author->username}");

              return;
       }

       if ($pregText === "boanoitetomzinha") {
              $message->reply("Boa noite sr(a) {$message->author->username}");

              return;
       }

       if ($actionMessage->isAuthor($message, $name)) {

              if ($pregText === "help") {
                     $message->reply("1 - responda tomzinha, 2 - tomzinha, leia as mensagens, 3 - help");

                     return;
              }

              if ($pregText === "respondatomzinha") {
                     $message->reply("Olá sr(a) {$message->author->username}");

                     return;
              }

              if ($pregText === "tomzinhaleiaasmensagens") {

                     if (!file_exists($temp_file)) {

                            $message->reply("Olá sr(a) {$message->author->username}, nenhuma mensagem registrada");

                            return;
                     }

                     $content = file_get_contents($temp_file);

                     $message->reply($content);

                     unlink($temp_file);

                     return;
              }
       }

       $now = date('Y-m-d H:i:s');

       $msg = "{$now} - {$message->author->username}: {$message->content}" . PHP_EOL;

       echo $msg;

       if (
              $actionMessage->verificaSeFoiMencionado($text, $name) ||
              $actionMessage->verificaSeFoiMencionado($text, $_ENV['USER_ID']) ||
              $actionMessage->verificaSeFoiMencionado($text, $_ENV['USER_HELPER'])
       ) {

              $message->reply("Essa mensagem foi registrada, o sr(a) {$name} vai ler depois");

              $temp_file = __DIR__ . "/files.txt";

              file_put_contents($temp_file, $msg, FILE_APPEND);
       }
       // echo "{$message->author->username}: {$message->content}" . PHP_EOL;
});

$discord->run();
