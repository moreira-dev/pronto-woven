<?php

namespace ProntoWoven\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ProntoWoven\Model\Player;
use ProntoWoven\Model\Tiles\Go;
use ProntoWoven\Model\Tiles\Property;

final class PlayerTest extends TestCase
{
	#[Test]
	public function Move_RollsMoreThanBoardSize_LandsOnExpectedTile(): void
	{
		$board = [new Go(), new Property(), new Property()];
		$player = new Player('Peter', position: 0);

		$player->move(4, $board);

		// Board wraps around
		self::assertSame(1, $player->position);
	}
}
