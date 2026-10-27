<?php

namespace ProntoWoven;

use ProntoWoven\Model\Board;
use ProntoWoven\Model\Player;
use ProntoWoven\Service\Logger;
use SplQueue;

/**
 * Handles the lifecycle of the Monopoly game
 */
class Monopoly
{
	private Board $board;
	private array $players;
	private SplQueue $rolls;

	private int $playerTurn = 0;


	/**
	 * @param Board $board
	 * @param array<Player>  $players
	 * @param SplQueue $rolls
	 */
	public function __construct(Board $board, array $players, SplQueue $rolls)
	{
		$this->players = $players;
		$this->board = $board;
		$this->rolls = $rolls;
	}


	public function startGame(bool $jsonOutput = false): void
	{
		Logger::reset();

		while (!$this->rolls->isEmpty()) {
			$die = $this->rolls->dequeue();

			Logger::log('Turn: ' . $this->players[$this->playerTurn]->name . " rolls a $die with \${$this->players[$this->playerTurn]->money}\n");

			$this->players[$this->playerTurn]->move($die, $this->board);

			if ($this->players[$this->playerTurn]->money < 0) {
				Logger::log($this->players[$this->playerTurn]->name . " is bankrupt!\n");
				break;
			}

			$this->playerTurn = ($this->playerTurn + 1) % count($this->players);

		}

		$this->endGame($jsonOutput);
	}

	private function endGame(bool $jsonOutput): void
	{
		$winners = $this->generateWinners();


		$this->outputResults($winners, $jsonOutput);

	}

	/**
	 * Generates an array of winners with the most money
	 *
	 * @return array<Player>
	 */
	private function generateWinners(): array
	{
		$winners = [];
		$maxMoney = -1;

		foreach ($this->players as $player) {
			if ($player->money === $maxMoney) {
				$winners[] = $player;
			}

			if ($player->money > $maxMoney) {
				$maxMoney = $player->money;
				$winners = [$player];
			}
		}

		return $winners;
	}

	/**
	 * Outputs the results of the game in either JSON or table format
	 *
	 * @param array<Player> $winners
	 * @param bool $jsonOutput
	 */
	private function outputResults(array $winners, bool $jsonOutput = false): void
	{
		if ($jsonOutput) {
			echo json_encode([
					'winners' => array_map(fn (Player $player) => $player->name, $winners),
					'players' => array_map(fn (Player $player) => [
						'name' => $player->name,
						'money' => (float) $player->money,
						'space' => $this->board->tiles[$player->position]->name,
					], $this->players),
				], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR) . PHP_EOL;
		} else {
			$this->outputTableResults($winners);
		}
	}

	/**
	 * Outputs the results of the game in a table format
	 *
	 * @param array<Player> $winners
	 */
	private function outputTableResults(array $winners): void
	{
		$winnerNames = array_map(fn (Player $player) => $player->name, $winners);
		$winnerString = implode(', ', $winnerNames);
		$winningAmount = number_format((float) $winners[0]->money, 2, '.', ',');

		echo "\n🎉 🏆 WE HAVE A WINNER! 🏆 🎉\n";
		echo "Massive congratulations to {$winnerString}!\n";
		echo 'They dominated the board and walked away with $' . $winningAmount . "!\n\n";

		$headers = ['Player', 'Money', 'Space'];
		$rows = [];

		foreach ($this->players as $player) {
			$rows[] = [
				$player->name,
				'$' . number_format((float) $player->money, 2, '.', ','),
				$this->board->tiles[$player->position]->name,
			];
		}

		$widths = [
			strlen($headers[0]),
			strlen($headers[1]),
			strlen($headers[2]),
		];

		foreach ($rows as $row) {
			$widths[0] = max($widths[0], strlen($row[0]));
			$widths[1] = max($widths[1], strlen($row[1]));
			$widths[2] = max($widths[2], strlen($row[2]));
		}

		$border = '+'
			. str_repeat('-', $widths[0] + 2) . '+'
			. str_repeat('-', $widths[1] + 2) . '+'
			. str_repeat('-', $widths[2] + 2) . "+\n";

		$renderRow = function (array $columns) use ($widths): string {
			$playerCol = str_pad($columns[0], $widths[0], ' ', STR_PAD_RIGHT);
			$moneyCol  = str_pad($columns[1], $widths[1], ' ', STR_PAD_LEFT);
			$spaceCol  = str_pad($columns[2], $widths[2], ' ', STR_PAD_RIGHT);

			return "| {$playerCol} | {$moneyCol} | {$spaceCol} |\n";
		};

		echo $border;
		echo $renderRow($headers);
		echo $border;

		foreach ($rows as $row) {
			echo $renderRow($row);
		}

		echo $border;
	}

}
