<?php

namespace ProntoWoven\Model;

use ProntoWoven\Interface\TileInterface;
use ProntoWoven\Model\Tiles\Property;

class Board
{
	/**
	 * @var array<TileInterface>
	 */
	public array $tiles = [];

	private array $properties = [];

	public function __construct(array $tiles)
	{
		$this->tiles = $tiles;

		$this->loadProperties();
	}

	public function loadProperties(): void
	{
		foreach ($this->tiles as $tile) {
			if ($tile instanceof Property) {
				if (!isset($this->properties[$tile->colour])) {
					$this->properties[$tile->colour] = [];
				}

				$this->properties[$tile->colour][] = $tile;
			}
		}
	}

	public function getPropertiesByColour(string $colour): array
	{
		return $this->properties[$colour] ?? [];
	}

}
