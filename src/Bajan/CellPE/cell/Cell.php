<?php

namespace Bajan\CellPE\cell;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Position;

class Cell {

    /** @var string */
    private $name;
    private $date;
    private $x1;
    private $x2;
    private $y;
    private $z1;
    private $z2;
    private $level;
    private $price;
    /** @var string|null */
    private $owner = null;
    /** @var array */
    private $helpers = [];
    private $days;

    public function __construct(string $name, string $date, int $x1, int $x2, int $y, int $z1, int $z2, string $level, float $price, int $days) {
        $this->name = $name;
        $this->date = $date;
        $this->x1 = $x1;
        $this->x2 = $x2;
        $this->y = $y;
        $this->z1 = $z1;
        $this->z2 = $z2;
        $this->level = $level;
        $this->price = $price;
        $this->days = $days;
    }

    public function getName(): string {
        return $this->name;
    }

    // ... (other methods)

    public function getPrice(): float {
        return $this->price;
    }

    public function setPrice(float $price): void {
        $this->price = $price;
    }

    // ... (other methods)
}
