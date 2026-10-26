<?php

namespace ProntoWoven;

/*
 * ## Game rules

* There are four players who take turns in the following order:
  * Peter
  * Billy
  * Charlotte
  * Sweedal
* Each player starts with $16
* Everybody starts on GO
* You get $1 when you pass GO (this excludes your starting move)
* If you land on a property, you must buy it
* If you land on an owned property, you must pay rent to the owner
* If the same owner owns all property of the same colour, the rent is doubled
* Once someone is bankrupt, whoever has the most money remaining is the winner
* There are no chance cards, jail or stations
* The board wraps around (when you reach the last space, the next space is the first space)
 */

use ProntoWoven\Interface\TileInterface;

class Monopoly
{
	public const string BOARD_FILE = 'board.json';

	public const string ROLLS_FOLDER = 'rolls';

	public string $assetsPath;

	private array $board;
	private array $players;
	private array $rolls;


	public function __construct(string $assetsPath, array $players)
	{
		$this->assetsPath = $assetsPath;
		$this->players = $players;

		$this->board = $this->loadBoard();
		$this->rolls = $this->loadRolls();

		foreach ($this->rolls as $rollName => $roll) {

			$playerTurn = 0;

			while (!$roll->isEmpty()) {
				$die = $roll->dequeue();


				echo "Turn: " . $this->players[$playerTurn]->name . " rolls a $die\n";

				$this->players[$playerTurn]->move($die, $this->board);
				$playerTurn = ($playerTurn + 1) % count($this->players);

			}
		}

		print_r($this->board);
		print_r($this->rolls);
		print_r($this->players);
	}

	/**
	 * Loads the board from a BOARD_FILE JSON file
	 *
	 * @return array<TileInterface> $typedBoard
	 */
	private function loadBoard(): array
	{

		$boardFile = $this->assetsPath . self::BOARD_FILE;
		if (!file_exists($boardFile)) {
			throw new \RuntimeException("Board file not found: $boardFile");
		}
		$boardData = file_get_contents($boardFile);
		if ($boardData === false) {
			throw new \RuntimeException("Failed to read board file: $boardFile");
		}
		$board = json_decode($boardData, true);
		if ($board === null) {
			throw new \RuntimeException("Failed to decode board JSON: $boardFile");
		}

		$typedBoard = [];

		foreach ($board as $tile) {
			$tileClass = 'ProntoWoven\Model\Tiles\\' . ucfirst($tile['type']);
			$tileObject = new $tileClass();

			foreach ($tile as $key => $value) {
				if (!property_exists($tileObject, $key)) {
					throw new \RuntimeException("Invalid property $key in board JSON: $boardFile");
				}

				$tileObject->$key = $value;
			}

			$typedBoard[] = $tileObject;
		}

		return $typedBoard;
	}

	/**
	 * Loads all json files in the rolls folder
	 *
	 * @return array<string, \SplQueue> $rolls
	 */
	private function loadRolls(): array
	{
		$rollsFolder = $this->assetsPath . self::ROLLS_FOLDER;
		if (!is_dir($rollsFolder)) {
			throw new \RuntimeException("Rolls folder not found: $rollsFolder");
		}

		$rollFiles = glob($rollsFolder . '/*.json');
		if ($rollFiles === false) {
			throw new \RuntimeException("Failed to read rolls folder: $rollsFolder");
		}

		$rolls = [];

		foreach ($rollFiles as $rollFile) {
			$rollName = basename($rollFile, '.json');

			$rollData = file_get_contents($rollFile);
			if ($rollData === false) {
				throw new \RuntimeException("Failed to read roll file: $rollFile");
			}
			$roll = json_decode($rollData, true);
			if ($roll === null) {
				throw new \RuntimeException("Failed to decode roll JSON: $rollFile");
			}


			$rollQueue = new \SplQueue();
			foreach ($roll as $die) {
				$rollQueue->enqueue($die);
			}

			$rolls[$rollName] = $rollQueue;
		}

		return $rolls;
	}

}
