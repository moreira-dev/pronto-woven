<?php

namespace ProntoWoven\Model;

class Player
{
	public string $name;
	public int $position;
	public int $money;

	public function __construct(string $name, int $position = 0, int $initialMoney = 16)
	{
		$this->name = $name;
		$this->position = $position;
		$this->money = $initialMoney;
	}

	public function move(int $steps, array $board): void
	{
		$boardSize = count($board);
		$this->position = ($this->position + $steps) % $boardSize;
	}
}
