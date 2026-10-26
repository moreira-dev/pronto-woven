# Woven monopoly implementation


See the [Woven Monopoly brief](docs/WOVEN_BRIEF.md) to understand initial rules and requirements.

## How to run

For simplicity and compatibility, running this program using Docker is recommended.

```bash
docker compose up
```


## **ASSUMPTIONS**

- Peter always starts the game




## Extending the game

The game can be extended to add new tile types.

All tile types used in the board.json must have a corresponding class in the `src/Model/Tiles/` directory that implements [TileInterface](src/Interface/TileInterface.php).
