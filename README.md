# Woven monopoly implementation


See the [Woven Monopoly brief](docs/WOVEN_BRIEF.md) to understand initial rules and requirements.

## How to run

For simplicity and compatibility, running this program using Docker is recommended.

```bash
docker compose up
```


## **ASSUMPTIONS**

- Peter always starts the game
- Board.json structure is valid and contains all required fields
- Money can have cents
- If a player cannot purchase a property they go bankrupt and the game ends
- If a player doesn't have enough money to pay rent, the player receiving rent gets only the amount of money the player has left.
- The game only ends when a player goes bankrupt or when all rolls have been used.



## Extending the game

The game can be extended to add new tile types.

All tile types used in the board.json must have a corresponding class in the `src/Model/Tiles/` directory that implements [TileInterface](src/Interface/TileInterface.php).
