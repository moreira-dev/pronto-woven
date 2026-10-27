# Woven monopoly implementation

See the [Woven Monopoly brief](docs/WOVEN_BRIEF.md) to understand initial rules and requirements.

## How to run

For simplicity and compatibility, running this program using Docker is recommended.

Run the game with json output (the first run will take some time):
```bash
docker compose run --rm -T -q app ./assets/board.json ./assets/rolls/rolls_1.json --json 2>/dev/null
```
**Please note that the json files must be on the assets folder for the docker container to be able to access them**

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

If you find any issues with the docker commands above, try building the image first:
```bash
docker compose build app
```

## Language and architecture

The game is written in PHP 8.5.*, with only dependencies for testing and linting. The application is CLI only.

I went with PHP because it has strong OOP support and it's not compiled. My ability to quickly navigate changes is stronger in PHP than Ruby.

### File structure

The entrypoint of the application is the [index.php](src/index.php) file.

For this project, simplicity of onboarding was chosen over specific architectural conventions. I focused on keeping the code simple while extendable.

The `Model` folder contains the main entities taking part in the game. These classes include both state and behaviour.

The `Service` folder contains classes with just behaviour that integrate with other classes and provide support.

The `Monopoly` class is the orchestrator of the game, with the main responsibility of managing game state.

### Extending the game

The game can be extended to add new tile types.

All tile types used in the board.json must have a corresponding class in the `src/Model/Tiles/` directory that implements [TileInterface](src/Interface/TileInterface.php).


## Configuration

The following configuration can be changed via global constants in the [index.php](src/index.php) file.

- INITIAL_MONEY: The amount of money each player starts with. Default is 16.
- GO_BONUS: The amount of money a player receives when passing the GO tile.
- RENT_RATIO: The ratio of the property price that is paid as rent. Default is 0.2 (20%).
- RENT_ALL_COLOURS_RATIO: The multiplier applied to the RENT_RATIO when a player owns all properties of the same colour. Default is 2 (double rent).

## **ASSUMPTIONS**

- Peter always starts the game
- Board.json structure is valid and contains all required fields
- Money can have cents
- If a player cannot purchase a property they go bankrupt and the game ends
- If a player doesn't have enough money to pay rent, the player receiving rent gets only the amount of money the player has left.
- The game only ends when a player goes bankrupt or when all rolls have been used.
- Rolls are always a positive integer greater than 0
- Rent is 20% of the property price

## Roll tests

[rolls_3.json](assets/rolls/rolls_3.json) was added to verify that the board wraps around and that the players receive the Go bonus correctly.

In this roll test, Peter buys most properties, Billy constantly lands on Peter's properties paying rent, and Charlotte and Sweedal own a single property and never pay any rent.

The game lasts for 5 rounds and there are no bankruptcies. Due to the low rent amount and short game, Charlotte and Sweedal are the winners.

## Improvements and rough edges

With time constrains, there were some aspects of the game that can be improved with more time:

- The Monopoly class is doing too much and is hard to unit test. The output logic should be on a different class.
- The index.php file is setting up the config and the game. Ideally the config should live in a separate file and have the game setup on a separate class.
- We throw exceptions but we don't present helpful guidance to the user. Ideally exceptions should be caught and presented with recommendations when running the cli.
- Test coverage is at 40% and can be improved.
- Float precision can give unexpected calculations between decimals (PHP is not really good with money). Ideally we would store all money in cents with no decimals.
