<?php

namespace ProntoWoven\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ProntoWoven\Model\Board;
use ProntoWoven\Model\Player;
use ProntoWoven\Monopoly;
use SplQueue;

final class MonopolyTest extends TestCase
{
	use CreatesProperties;

	#[Test]
	public function StartGame_AllRollsFinished_EndsGame(): void
	{
		$player = new Player('Peter');
		$property = $this->createProperty(owner: $player);
		$otherProperty = $this->createProperty(owner: $player);
		$board = new Board([$property, $otherProperty]);
		$rolls = new SplQueue();
		$rolls->enqueue(1);
		$rolls->enqueue(1);
		$game = new Monopoly($board, [$player], $rolls);
		$this->expectOutputRegex('/"winners":/');

		$game->startGame(jsonOutput: true);

		self::assertTrue($rolls->isEmpty());
		self::assertSame(0, $player->position);
		self::assertSame('16', $player->money);
	}

	#[Test]
	public function StartGame_PlayerIsBankrupt_EndsGameBeforeRemainingRolls(): void
	{
		$player = new Player('Peter');
		$otherPlayer = new Player('Billy');
		$property = $this->createProperty();
		$expensiveProperty = $this->createProperty(price: 20);
		$board = new Board([$property, $expensiveProperty]);
		$rolls = new SplQueue();
		$rolls->enqueue(1);
		$rolls->enqueue(1);
		$game = new Monopoly($board, [$player, $otherPlayer], $rolls);
		$this->expectOutputRegex('/"winners":/');

		$game->startGame(jsonOutput: true);

		self::assertSame('-4', $player->money);
		self::assertSame(1, $rolls->count());
		self::assertSame(0, $otherPlayer->position);
		self::assertSame('16', $otherPlayer->money);
	}

	#[Test]
	public function StartGame_GameFinished_OutputsExpectedJson(): void
	{
		$player = new Player('Peter');
		$otherPlayer = new Player('Billy');
		$property = $this->createProperty(name: 'Starting Property');
		$otherProperty = $this->createProperty(name: 'Other Property');
		$board = new Board([$property, $otherProperty]);
		$rolls = new SplQueue();
		$rolls->enqueue(1);
		$game = new Monopoly($board, [$player, $otherPlayer], $rolls);
		$this->expectOutputString(json_encode([
			'winners' => ['Billy'],
			'players' => [
				['name' => 'Peter', 'money' => 14, 'space' => 'Other Property'],
				['name' => 'Billy', 'money' => 16, 'space' => 'Starting Property'],
			],
		], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR) . PHP_EOL);

		$game->startGame(jsonOutput: true);
	}
}
