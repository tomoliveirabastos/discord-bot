<?php
require 'vendor/autoload.php';

use App\ActionsMessage;

$action = new ActionsMessage();

$des = "Desejo ao senhor Tom uma longa vida";

$app = $action->verificaSeFoiMencionado(strtolower($des), "tom");

var_dump($app);