<?php

namespace ProntoWoven\Interface;

use ProntoWoven\Model\Player;

interface TileInterface
{
	public string $name { get; set; }

	public string $type { get; set; }

	/**
	 * Applies the effect of the tile on the player when they land on it.
	 *
	 * @param Player $player
	 *
	 * @return void
	 */
	public function landed(Player $player): void;
}
