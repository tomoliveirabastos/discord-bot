<?php

namespace App;

use Discord\Parts\Channel\Message;

class ActionsMessage
{
       public function isAuthor(Message $message, string $authorName): bool
       {
              $author = $message->author->username;

              $nomeExplode = explode(" ", $author);

              return in_array($authorName, $nomeExplode);
       }

       public function verificaSeFoiMencionado(string $text, string $name){
              $text = strtolower($text);
              $name = strtolower($name);

              $explode = explode(' ', $text);

              return in_array($name, $explode);
       }
}
