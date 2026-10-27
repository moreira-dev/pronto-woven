<?php

namespace ProntoWoven\Tests;

use ProntoWoven\Model\Player;
use ProntoWoven\Model\Tiles\Property;

trait CreatesProperties
{
	private function createProperty(
		string $name = 'Red Property',
		string $type = 'property',
		float $price = 2,
		string $colour = 'Red',
		?Player $owner = null,
	): Property {
		$property = new Property();
		$property->name = $name;
		$property->type = $type;
		$property->price = $price;
		$property->colour = $colour;
		$property->owner = $owner;

		return $property;
	}
}
