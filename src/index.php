<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ProntoWoven\Monopoly;
use ProntoWoven\Model\Player;

$assetsPath = __DIR__ . '/../assets/';

// Rolls will follow the order of the array
$players = [
	new Player('Peter'),
	new Player('Billy'),
	new Player('Charlotte'),
	new Player('Sweedal'),
];


new Monopoly($assetsPath, $players);
