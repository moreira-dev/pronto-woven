<?php

namespace ProntoWoven\Model;

class Player
{
	public string $name;
	public int $position;
	public string $money; // Workaround in PHP to avoid precision errors

	public function __construct(string $name, int $position = 0, float $initialMoney = INITIAL_MONEY)
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

		$newPosition = $this->position;

		for ($i = 1; $i <= $steps; $i++) {
			$newPosition = ($newPosition + 1) % $boardSize;
			$board->tiles[$newPosition]->passed($this);
		}

		$this->position = $newPosition;

		$board->tiles[$this->position]->landed($this, $board);
	}

	public function hasAllPropertiesOfColour(string $colour, Board $board): bool
	{
		$propertiesOfColour = $board->getPropertiesByColour($colour);

		return array_all($propertiesOfColour, fn ($property) => $property->owner === $this);
	}
}
