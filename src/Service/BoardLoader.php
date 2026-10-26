<?php

namespace ProntoWoven\Service;

use ProntoWoven\Interface\TileInterface;

class BoardLoader {

	public const string BOARD_FILE = 'board.json';

	public function __construct(private readonly string $assetsPath) {}

	/**
	 * Loads the board from a BOARD_FILE JSON file
	 *
	 * @return array<TileInterface> $typedBoard
	 */
	public function load(): array
	{

		$boardFile = $this->assetsPath . self::BOARD_FILE;
		if (!file_exists($boardFile)) {
			throw new \RuntimeException("Board file not found: $boardFile");
		}
		$boardData = file_get_contents($boardFile);
		if ($boardData === false) {
			throw new \RuntimeException("Failed to read board file: $boardFile");
		}
		$board = json_decode($boardData, true);
		if ($board === null) {
			throw new \RuntimeException("Failed to decode board JSON: $boardFile");
		}

		$typedBoard = [];

		foreach ($board as $tile) {
			$tileClass = 'ProntoWoven\Model\Tiles\\' . ucfirst($tile['type']);
			$tileObject = new $tileClass();

			foreach ($tile as $key => $value) {
				if (!property_exists($tileObject, $key)) {
					throw new \RuntimeException("Invalid property $key in board JSON: $boardFile");
				}

				$tileObject->$key = $value;
			}

			$typedBoard[] = $tileObject;
		}

		return $typedBoard;
	}

}
