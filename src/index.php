<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ProntoWoven\Model\Board;
use ProntoWoven\Model\Player;
use ProntoWoven\Monopoly;
use ProntoWoven\Service\BoardLoader;
use ProntoWoven\Service\RollsLoader;

$assetsPath = __DIR__ . '/../assets/';

// TODO move to config
const INITIAL_MONEY = 16; // Starting money for each player
const GO_MONEY_ADD = 1; // Money received when passing GO
const RENT_RATIO = 0.1; // % of the property price that is paid as rent
const RENT_ALL_COLOURS_RATIO = 2; // Multiplier for rent if the owner has all properties of that colour


$rollList = new RollsLoader($assetsPath)->load();

foreach ($rollList as $rollName => $rolls) {

	// Rolls will follow the order of the array
	$players = [
		new Player('Peter'),
		new Player('Billy'),
		new Player('Charlotte'),
		new Player('Sweedal'),
	];

	$boardArray = new BoardLoader($assetsPath)->load();
	$board = new Board($boardArray);

	$monopoly = new Monopoly($board, $players, $rolls);

	$monopoly->startGame();
}
