<?php

namespace ProntoWoven\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ProntoWoven\Model\Board;
use ProntoWoven\Model\Player;

final class PropertyTest extends TestCase
{
	use CreatesProperties;

	#[Test]
	public function Landed_OwnedByAnotherPlayer_PaysRent(): void
	{
		$owner = new Player('Peter');
		$player = new Player('Billy');
		$property = $this->createProperty(owner: $owner);
		$otherProperty = $this->createProperty();
		$board = new Board([$property, $otherProperty]);

		$property->landed($player, $board);

		self::assertSame(15.8, $player->money);
		self::assertSame(16.2, $owner->money);
		self::assertSame($owner, $property->owner);
	}

	#[Test]
	public function Landed_OwnedByPlayer_DoesNotPayRent(): void
	{
		$player = new Player('Peter');
		$property = $this->createProperty(owner: $player);
		$board = new Board([$property]);

		$property->landed($player, $board);

		self::assertSame(16.0, $player->money);
		self::assertSame($player, $property->owner);
	}

	#[Test]
	public function Landed_NoOwner_PurchasesProperty(): void
	{
		$player = new Player('Peter');
		$property = $this->createProperty();
		$board = new Board([$property]);

		$property->landed($player, $board);

		self::assertSame($player, $property->owner);
		self::assertSame(14.0, $player->money);
	}

	#[Test]
	public function Landed_OwnerHasAllPropertiesOfColour_PaysDoubleRent(): void
	{
		$owner = new Player('Peter');
		$player = new Player('Billy');
		$property = $this->createProperty(owner: $owner);
		$otherProperty = $this->createProperty(owner: $owner);
		$board = new Board([$property, $otherProperty]);

		$property->landed($player, $board);

		self::assertSame(15.6, $player->money);
		self::assertSame(16.4, $owner->money);
	}
}
