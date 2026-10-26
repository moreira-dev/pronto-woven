<?php

namespace ProntoWoven\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ProntoWoven\Model\Board;
use ProntoWoven\Model\Player;
use ProntoWoven\Model\Tiles\Go;

final class PlayerTest extends TestCase
{
	use CreatesProperties;

	#[Test]
	public function Move_RollsMoreThanBoardSize_LandsOnExpectedTile(): void
	{
		$property = $this->createProperty();
		$otherProperty = $this->createProperty();
		$board = new Board([new Go(), $property, $otherProperty]);
		$player = new Player('Peter', position: 0);

		$player->move(4, $board);

		// Board wraps around
		self::assertSame(1, $player->position);
	}

	#[Test]
	public function HasAllPropertiesOfColour_OwnsAllProperties_ReturnsTrue(): void
	{
		$player = new Player('Peter');
		$property = $this->createProperty(owner: $player);
		$otherProperty = $this->createProperty(owner: $player);
		$board = new Board([$property, $otherProperty]);

		self::assertTrue($player->hasAllPropertiesOfColour('Red', $board));
	}

	#[Test]
	public function HasAllPropertiesOfColour_OwnsSomeProperties_ReturnsFalse(): void
	{
		$player = new Player('Peter');
		$property = $this->createProperty(owner: $player);
		$otherProperty = $this->createProperty();
		$board = new Board([$property, $otherProperty]);

		self::assertFalse($player->hasAllPropertiesOfColour('Red', $board));
	}

	#[Test]
	public function HasAllPropertiesOfColour_OwnsNoProperties_ReturnsFalse(): void
	{
		$player = new Player('Peter');
		$property = $this->createProperty();
		$otherProperty = $this->createProperty();
		$board = new Board([$property, $otherProperty]);

		self::assertFalse($player->hasAllPropertiesOfColour('Red', $board));
	}
}
