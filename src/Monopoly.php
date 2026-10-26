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


	public function startGame(): void
	{
		while (!$this->rolls->isEmpty()) {
			$die = $this->rolls->dequeue();

			echo 'Turn: ' . $this->players[$this->playerTurn]->name . " rolls a $die with \${$this->players[$this->playerTurn]->money}\n";

			$this->players[$this->playerTurn]->move($die, $this->board);

			if ($this->players[$this->playerTurn]->money < 0) {
				echo $this->players[$this->playerTurn]->name . " is bankrupt!\n";
				// TODO end the game
				break;
			}

			$this->playerTurn = ($this->playerTurn + 1) % count($this->players);

		}

		//print_r($this->board);
		//print_r($this->rolls);
		print_r($this->players);
	}

}
