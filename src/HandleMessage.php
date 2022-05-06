<?php

namespace App;

class HandleMessage
{
       private string $token;
       private $url;
       public function __construct(string $token, string $url)
       {
              $this->token = $token;
              $this->url = $url;
       }

       public function sendMessage(string $channelId, string $msg)
       {
              $client = new \GuzzleHttp\Client();

              $client->request('POST', $this->url . "/channels/{$channelId}/messages", [
                     'json' => [
                            'content' => $msg
                     ],
                     'headers' => [
                            'Content-Type' => 'application/json',
                            'Content-Length' => strlen($msg),
                            'Authorization' => "Bot {$this->token}"
                     ]
              ]);
       }

       public function getChannels(string $guildId): array
       {
              $client = new \GuzzleHttp\Client();

              $res = $client->request('GET', $this->url . "/guilds/{$guildId}/channels", [
                     'headers' => [
                            'Content-Type' => 'application/json',
                            'Authorization' => "Bot {$this->token}"
                     ]
              ]);

              $content = $res->getBody();

              $json = $content->getContents();

              return json_decode($json, true);
       }
}
