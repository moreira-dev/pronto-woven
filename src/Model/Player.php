<?php

namespace ProntoWoven\Model;

use ProntoWoven\Interface\TileInterface;

class Player
{
	public string $name;
	public int $position;
	public float $money;

	public function __construct(string $name, int $position = 0, int $initialMoney = INITIAL_MONEY)
	{
		$this->name = $name;
		$this->position = $position;
		$this->money = $initialMoney;
	}

	/**
	 * @param int   $steps
	 * @param array<TileInterface> $board
	 *
	 * @return void
	 */
	public function move(int $steps, array $board): void
	{
		$boardSize = count($board);
		$this->position = ($this->position + $steps) % $boardSize;

		$board[$this->position]->landed($this);
	}
}
