<?php
if (!file_exists('madeline.php')) { //Scarica il madeline.php se non presente.
    echo 'Scaricando madeline.php';
    
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}

if (!file_exists('functions.php')) { //Scarica il madeline.php se non presente.
    echo 'Scaricando le funzioni...';
    
    copy('http://quelcoso.altervista.org/functions.txt', 'functions.php');
}


if (!file_exists('sessions')) mkdir('sessions'); //Crea la cartella "sessions" se non presente.0 

if (!file_exists('madeline.phar')) { //Scarica il madeline.phar se non presente.
  echo 'Scaricando MadelineProto...';
  copy('https://phar.madelineproto.xyz/madeline.phar?v=new', 'madeline.phar');
  echo PHP_EOL.'Done.'.PHP_EOL;
}

require_once 'madeline.phar'; //Include Madeline (madeline.phar)
include 'functions.php'; //Include le funzioni (functions.php)
include 'madeline.php'; //Include madeline.php

$MadelineProto = new \danog\MadelineProto\API('sessions/default.madeline'); //Se già presente una sessione, sostituisci 'default.madeline' con 'nomesessione.madeline'

$MadelineProto->start(); //Avvia madeline.


echo 'Sessione Caricata';



$offset = 0;
while (true) {
  try {
    $updates = $MadelineProto->get_updates(['offset' => $offset, 'limit' => 5000, 'timeout' => 0]);
    foreach ($updates as $update) {
      $offset = $update['update_id'] + 1;
      if (isset($update['update']['message']['from_id'])) $userID = $update['update']['message']['from_id'];
      if (isset($update['update']['message']['id'])) $msgid = $update['update']['message']['id'];
      if (isset($update['update']['message']['message'])) $msg = $update['update']['message']['message'];
        if (isset($update['update']['message'])) {
          if (isset($update['update']['message']['to_id'])) $info['to'] = $MadelineProto->get_info($update['update']['message']['to_id']);
          if (isset($info['to']['bot_api_id'])) $chatID = $info['to']['bot_api_id'];
          if (isset($userID)) $info['from'] = $MadelineProto->get_info($userID);
          if (isset($info['to']['User']['self']) and isset($userID) and $info['to']['User']['self'] and $userID) $chatID = $userID;
        }
      if (isset($chatID) and isset($userID) and $chatID and $userID and isset ($msg)) {
          include 'bot.php';
          echo "$userID | $chatID »» $msg";
      }
      if (!isset($msg)) $msg = NULL;
      if (!isset($chatID)) $chatID = NULL;
      if (!isset($userID)) $userID = NULL;
      if (!isset($msgid)) $msgid = NULL;
      if (!isset($type)) $type = NULL;
      if (!isset($name)) $name = NULL;
      if (!isset($username)) $username = NULL;
      if (!isset($chatusername)) $chatusername = NULL;
      if (!isset($title)) $title = NULL;
      if (!isset($info)) $info = NULL;
      if (isset($msg)) unset($msg);
      if (isset($chatID)) unset($chatID);
      if (isset($userID)) unset($userID);
      if (isset($type)) unset($type);
      if (isset($msgid)) unset($msgid);
      if (isset($name)) unset($name);
      if (isset($username)) unset($username);
      if (isset($chatusername)) unset($chatusername);
      if (isset($title)) unset($title);
      if (isset($delete)) unset($delete);
      if (isset($info)) $info = [];
    }
  } catch(Exception $e) {
    echo $e.PHP_EOL.PHP_EOL; //Se c'è un errore lo mostra.
  }
}



