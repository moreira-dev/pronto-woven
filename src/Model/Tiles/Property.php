<?php

namespace ProntoWoven\Model\Tiles;

use ProntoWoven\Interface\TileInterface;
use ProntoWoven\Model\Player;
use ProntoWoven\Model\Board;
use ProntoWoven\Service\Logger;

class Property implements TileInterface
{
	public const array REQUIRED_PROPERTIES = ['name', 'type', 'price', 'colour'];


	public string $name;
	public string $type;
	public float $price;
	public string $colour;

	public ?Player $owner = null;

	public function landed(Player $player, Board $board): void
	{
		Logger::log($player->name . ' landed on ' . $this->name . ".\n");


		if (!$this->owner) {
			$this->purchaseProperty($player);
		} else {
			$this->payRent($player, $board);
		}
	}

	private function purchaseProperty(Player $player): void
	{
		$player->money -= $this->price;
		$this->owner = $player;

		Logger::log($player->name . ' purchased ' . $this->name . ' for $' . $this->price . ".\n");

	}
	private function payRent(Player $player, Board $board): void
	{
		if ($this->owner !== $player) {
			$rent = $this->price * RENT_RATIO;

			if ($this->owner->hasAllPropertiesOfColour($this->colour, $board)) {
				Logger::log($this->owner->name . ' has all properties of colour ' . $this->colour . ".\n");

				$rent *= RENT_ALL_COLOURS_RATIO;
			}

			$this->owner->money += min($player->money, $rent);
			Logger::log($player->name . ' paid rent of $' . $rent . ' to ' . $this->owner->name . ".\n");
			$player->money -= $rent;
		}
	}

}
