<?php

namespace ProntoWoven\Tests;

use PHPUnit\Framework\TestCase;

final class HelloWorldTest extends TestCase
{
	public function testHelloWorld(): void
	{
		$greeting = sprintf('Hello, %s!', 'world');

		self::assertSame('Hello, world!', $greeting);
	}
}
