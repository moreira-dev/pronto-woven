<?php

namespace ProntoWoven\Model\Tiles;

use ProntoWoven\Interface\TileInterface;
use ProntoWoven\Model\Board;
use ProntoWoven\Model\Player;

class Go implements TileInterface
{
	public string $name;
	public string $type;

	public function landed(Player $player, Board $board): void
	{
		$player->money += GO_MONEY_ADD;
	}

}
