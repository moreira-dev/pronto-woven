<?php

namespace ProntoWoven;

class Monopoly
{

	const string BOARD_FILE = 'board.json';

	const string ROLLS_FOLDER = 'rolls';

	public string $assetsPath;

	private array $board;


	public function __construct(string $assetsPath)
	{
		$this->assetsPath = $assetsPath;

		$this->board = $this->loadBoard();

		print_r($this->board);
	}

	private function loadBoard(): array
	{

		$boardFile = $this->assetsPath . self::BOARD_FILE;
		if ( !file_exists($boardFile)) {
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

		// TODO validate schema

		return $board;
	}

}
