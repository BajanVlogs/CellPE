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

    public function getX1(): int {
        return $this->x1;
    }

    public function getX2(): int {
        return $this->x2;
    }

    public function getY(): int {
        return $this->y;
    }

    public function getZ1(): int {
        return $this->z1;
    }

    public function getZ2(): int {
        return $this->z2;
    }

    public function getOwner(): ?string {
        return $this->owner;
    }

    public function setOwner(string $owner): void {
        $this->owner = $owner;
    }

    public function getHelpers(): array {
        return $this->helpers;
    }

    public function addHelper(string $helper): void {
        $this->helpers[$helper] = $helper;
    }

    public function removeHelper(string $helper): void {
        unset($this->helpers[$helper]);
    }

    public function isHelper(string $name): bool {
        return isset($this->helpers[$name]);
    }

    public function getDate(): string {
        return $this->date;
    }

    public function getLevel(): string {
        return $this->level;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function setPrice(float

