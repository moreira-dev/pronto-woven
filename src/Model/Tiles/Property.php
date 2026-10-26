<?php

namespace ProntoWoven\Model\Tiles;

use ProntoWoven\Interface\TileInterface;

class Property implements TileInterface
{
	public string $name;
	public string $type;
	public string $price;
	public string $colour;

}
