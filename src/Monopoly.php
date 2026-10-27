<?php

namespace ProntoWoven;

use ProntoWoven\Model\Board;
use ProntoWoven\Model\Player;
use SplQueue;

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
		while (!$this->rolls->isEmpty()) {
			$die = $this->rolls->dequeue();

			echo 'Turn: ' . $this->players[$this->playerTurn]->name . " rolls a $die with \${$this->players[$this->playerTurn]->money}\n";

			$this->players[$this->playerTurn]->move($die, $this->board);

			if ($this->players[$this->playerTurn]->money < 0) {
				echo $this->players[$this->playerTurn]->name . " is bankrupt!\n";
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
			echo 'Winners with $' . $winners[0]->money . ': ' . implode(', ', array_map(fn (Player $player) => $player->name, $winners)) . "\n";
		}
	}

}
