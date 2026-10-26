<?php

namespace ProntoWoven\Model\Tiles;

use ProntoWoven\Interface\TileInterface;
use ProntoWoven\Model\Player;

class Go implements TileInterface
{
	public string $name;
	public string $type;

	public function landed(Player $player): void
	{
		$player->money += GO_MONEY_ADD;
	}

}
