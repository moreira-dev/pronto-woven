<?php

namespace ProntoWoven\Model;

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
	 * @param Board $board
	 *
	 * @return void
	 */
	public function move(int $steps, Board $board): void
	{
		$boardSize = count($board->tiles);
		$this->position = ($this->position + $steps) % $boardSize;

		$board->tiles[$this->position]->landed($this, $board);
	}

	public function hasAllPropertiesOfColour(string $colour, Board $board): bool
	{
		$propertiesOfColour = $board->getPropertiesByColour($colour);

		return array_all($propertiesOfColour, fn ($property) => $property->owner === $this);
	}
}
