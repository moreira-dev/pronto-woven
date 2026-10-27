<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ProntoWoven\Model\Board;
use ProntoWoven\Model\Player;
use ProntoWoven\Monopoly;
use ProntoWoven\Service\BoardLoader;
use ProntoWoven\Service\RollsLoader;

$assetsPath = __DIR__ . '/../assets/';

// TODO move to config
const LOG_FILE = __DIR__ . '/../assets/logs/debug.txt';
const INITIAL_MONEY = 16; // Starting money for each player
const GO_MONEY_ADD = 1; // Money received when passing GO
const RENT_RATIO = 0.2; // % of the property price that is paid as rent
const RENT_ALL_COLOURS_RATIO = 2; // Multiplier for rent if the owner has all properties of that colour


$jsonOutput = array_search('--json', $argv, true);

$boardFilePath = $argv[1] ?? null;
$rollsFilePath = $argv[2] ?? null;

if (!$boardFilePath || !$rollsFilePath) {
	echo "Error: Missing required arguments.\n";
	echo "Usage: php index.php <board_file_path> <rolls_file_path> [--json]\n";
	exit(1);
}



// Game Setup

$rolls = new RollsLoader($rollsFilePath)->load();

// Rolls will follow the order of the array
$players = [
	new Player('Peter'),
	new Player('Billy'),
	new Player('Charlotte'),
	new Player('Sweedal'),
];

$boardArray = new BoardLoader($boardFilePath)->load();
$board = new Board($boardArray);

$monopoly = new Monopoly($board, $players, $rolls);

$monopoly->startGame($jsonOutput);
