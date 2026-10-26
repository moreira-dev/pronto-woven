<?php

namespace ProntoWoven\Model\Tiles;

use ProntoWoven\Interface\TileInterface;
use ProntoWoven\Model\Player;

class Property implements TileInterface
{
	public string $name;
	public string $type;
	public string $price;
	public string $colour;

	public ?Player $owner = null;

	public function landed(Player $player): void
	{
		echo $player->name . " landed on " . $this->name . ".\n";


		if (!$this->owner) {
			$this->purchaseProperty($player);
		} else {
			$this->payRent($player);
		}
	}

	private function purchaseProperty(Player $player): void
	{
		$player->money -= $this->price;
		$this->owner = $player;

		echo $player->name . " purchased " . $this->name . " for $" . $this->price . ".\n";

	}

	private function payRent(Player $player): void
	{
		if ($this->owner !== $player) {
			$rent = $this->price * RENT_RATIO;
			$this->owner->money += min($player->money, $rent);
			echo $player->name . " paid rent of $" . $rent . " to " . $this->owner->name . ".\n";
			$player->money -= $rent;
		}
	}

}
