<?php

namespace ProntoWoven\Interface;

use ProntoWoven\Model\Board;
use ProntoWoven\Model\Player;

interface TileInterface
{
	public const array REQUIRED_PROPERTIES = ['name', 'type'];

	public string $name { get; set; }

	public string $type { get; set; }

	/**
	 * Applies the effect of the tile on the player when they land on it
	 */
	public function landed(Player $player, Board $board): void;

	public function passed(Player $player): void;
}
