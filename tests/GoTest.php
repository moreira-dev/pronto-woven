<?php

namespace ProntoWoven\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ProntoWoven\Model\Board;
use ProntoWoven\Model\Player;
use ProntoWoven\Model\Tiles\Go;

final class GoTest extends TestCase
{
	use CreatesProperties;

	#[Test]
	public function Move_PassesGoWithoutLanding_ReceivesOneDollar(): void
	{
		$player = new Player('Peter', position: 2);
		$property = $this->createProperty(owner: $player);
		$otherProperty = $this->createProperty(owner: $player);
		$board = new Board([new Go(), $property, $otherProperty]);

		$player->move(2, $board);

		self::assertSame('17', $player->money);
	}

	#[Test]
	public function Move_StartsAtGo_DoesNotReceiveOneDollar(): void
	{
		$player = new Player('Peter', position: 0);
		$property = $this->createProperty(owner: $player);
		$board = new Board([new Go(), $property]);

		$player->move(1, $board);

		self::assertSame('16', $player->money);
	}
}
