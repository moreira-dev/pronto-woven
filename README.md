# Woven monopoly implementation


See the [Woven Monopoly brief](docs/WOVEN_BRIEF.md) to understand initial rules and requirements.

## How to run

For simplicity and compatibility, running this program using Docker is recommended.

Run the game with json output:
```bash
docker compose run --rm -T -q app ./assets/board.json ./assets/rolls/rolls_1.json --json 2>/dev/null
```

Run the game with human output:
```bash
docker compose run --rm -T -q app ./assets/board.json ./assets/rolls/rolls_1.json
```

Run the tests:
```bash
docker compose run --rm --entrypoint composer app test
```

See test coverage:
```bash
docker compose run --rm --entrypoint composer app test:coverage
```

Run the linter:
```bash
docker compose run --rm --entrypoint composer app lint
```

Fix linting:
```bash
docker compose run --rm --entrypoint composer app lint:fix
```

**Please note that the json files must be on the assets folder for the docker container to be able to access them**

## **ASSUMPTIONS**

- Peter always starts the game
- Board.json structure is valid and contains all required fields
- Money can have cents
- If a player cannot purchase a property they go bankrupt and the game ends
- If a player doesn't have enough money to pay rent, the player receiving rent gets only the amount of money the player has left.
- The game only ends when a player goes bankrupt or when all rolls have been used.
- Rolls are always a positive integer greater than 0



## Extending the game

The game can be extended to add new tile types.

All tile types used in the board.json must have a corresponding class in the `src/Model/Tiles/` directory that implements [TileInterface](src/Interface/TileInterface.php).

## Improvements and rough edges

With time constrains, there were some aspects of the game that can be improved with more time:

- The Monopoly class is doing too much and is hard to unit test. The output logic should be on a different class.
- The index.php file is setting up the config and the game. Ideally the config should live in a separate file and have the game setup on a separate class.
- We throw exceptions but we don't present helpful guidance to the user. Ideally exceptions should be caught and presented with recommendations when running the cli.
- Code coverage is at 40% and can be improved.
