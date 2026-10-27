<?php

namespace ProntoWoven\Service;

class RollsLoader
{
	public function __construct(private readonly string $rollsFilePath)
	{
	}

	/**
	 * Loads the rolls from a rolls file
	 */
	public function load(): \SplQueue
	{
		$rollFile = $this->rollsFilePath;
		if (!file_exists($rollFile)) {
			throw new \RuntimeException("Roll file not found: $rollFile");
		}
		$rollData = file_get_contents($rollFile);
		if ($rollData === false) {
			throw new \RuntimeException("Failed to read roll file: $rollFile");
		}
		$rolls = json_decode($rollData, true);
		if ($rolls === null) {
			throw new \RuntimeException("Failed to decode roll JSON: $rollFile");
		}

		// TODO validate positive integer

		$rollQueue = new \SplQueue();
		foreach ($rolls as $die) {
			$rollQueue->enqueue($die);
		}

		return $rollQueue;
	}

}
