<?php

namespace ProntoWoven\Service;

class RollsLoader {

	public const string ROLLS_FOLDER = 'rolls';

	public function __construct(private readonly string $assetsPath) {}

	/**
	 * Loads all json files in the rolls folder
	 *
	 * @return array<string, \SplQueue> $rolls
	 */
	public function load(): array
	{
		$rollsFolder = $this->assetsPath . self::ROLLS_FOLDER;
		if (!is_dir($rollsFolder)) {
			throw new \RuntimeException("Rolls folder not found: $rollsFolder");
		}

		$rollFiles = glob($rollsFolder . '/*.json');
		if ($rollFiles === false) {
			throw new \RuntimeException("Failed to read rolls folder: $rollsFolder");
		}

		$rolls = [];

		foreach ($rollFiles as $rollFile) {
			$rollName = basename($rollFile, '.json');

			$rollData = file_get_contents($rollFile);
			if ($rollData === false) {
				throw new \RuntimeException("Failed to read roll file: $rollFile");
			}
			$roll = json_decode($rollData, true);
			if ($roll === null) {
				throw new \RuntimeException("Failed to decode roll JSON: $rollFile");
			}


			$rollQueue = new \SplQueue();
			foreach ($roll as $die) {
				$rollQueue->enqueue($die);
			}

			$rolls[$rollName] = $rollQueue;
		}

		return $rolls;
	}

}
