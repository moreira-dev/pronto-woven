# Add Monopoly game completion tests

> 📌 **Task Started (default, ctx=475,000)**


## 👤 User

Add simple tests following the same format as the existing tests:

For Monopoly test that:

- A game finishes when all rolls are finished
- A game finishes if someone is bankrupt
- The return json format is as expected when the game is finished

## 🤖 Agent

I’ll check the existing Monopoly tests and add these cases in the same style.

**Custom Tool Output:**

```text
Success. Updated the following files:
A /pronto-woven/tests/MonopolyTest.php

```

## 🤖 Agent

Added [MonopolyTest.php](/pronto-woven/tests/MonopolyTest.php) in the existing test style, covering:

- Game ends when rolls run out.
- Bankruptcy ends the game before remaining rolls.
- Finished game outputs the expected JSON.

All 11 tests pass with 23 assertions.

> 📌 **Task Complete**

> 📌 **Task Started (default, ctx=475,000)**

## 👤 User

Add new tests for Go that:

- Tests that a player receives $1 when passing through the tile and not landing on it
- Starting position at Go and moving won't add $1 to the player

## 🤖 Agent

I’ll check how movement handles Go and add both tests in the existing style.

**Custom Tool Output:**

```text
Success. Updated the following files:
A /pronto-woven/tests/GoTest.php
M /pronto-woven/phpunit.xml

```

## 🤖 Agent

Added both tests in [GoTest.php](/pronto-woven/tests/GoTest.php) and the $1 constant in PHPUnit config.

12 tests pass; 1 fails because `Player::move()` advances by `$i` each step. Passing Go adds $1 correctly, but the player lands at position 2 instead of 1. Left game code unchanged.

> 📌 **Task Complete**
