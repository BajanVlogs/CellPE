<?php

namespace Bajan\CellPE\cell;

use pocketmine\Player;
use pocketmine\level\Position;

use Bajan\CellPE\CellPE;

class CellManager {

    /** @var CellPE */
    private $plugin;
    /** @var Cell[] */
    private $cells = [];

    public function __construct(CellPE $plugin) {
        $this->plugin = $plugin;
    }

    public function initCells(?array $cells): void {
        if ($cells === null) {
            return;
        }

        foreach ($cells as $key => $value) {
            $this->createCell($key, $value['date'], $value['x1'], $value['x2'], $value['y'], $value['z1'], $value['z2'], $value['level'], $value['price'], $value['days']);

            if ($value['owner'] !== null) {
                $this->getCell($key)->setOwner($value['owner']);
            }

            if ($value['helpers'] !== null) {
                $helpers = (array)$value['helpers'];

                foreach ($helpers as $helper) {
                    $this->getCell($key)->addHelper($helper);
                }
            }
        }
    }

    public function saveCells(): void {
        if ($this->cells === null) {
            file_put_contents($this->plugin->getDataFolder() . 'cells.json', "[]");
            return;
        }

        $cells = [];
        foreach ($this->cells as $key => $value) {
            $cells[$key] = [
                'date' => $value->getDate(),
                'x1' => $value->getX1(),
                'x2' => $value->getX2(),
                'y' => $value->getY(),
                'z1' => $value->getZ1(),
                'z2' => $value->getZ2(),
                'level' => $value->getLevel(),
                'price' => $value->getPrice(),
                'days' => $value->getDays(),
                'owner' => $value->getOwner(),
                'helpers' => $value->getHelpers(),
            ];
        }

        file_put_contents($this->plugin->getDataFolder() . 'cells.json', json_encode($cells));
    }

    /**
     * @param Position $pos
     * @return bool|null|Cell
     */
    public function isInCell(Position $pos) {
        if ($this->cells === null) {
            return null;
        }

        foreach ($this->cells as $cell) {
            if ($cell->isInCell($pos)) {
                return $cell;
            }
        }

        return false;
    }

    /**
     * @param Position $pos
     * @param Player $player
     * @return bool|null
     */
    public function isInOwnCell(Position $pos, Player $player) {
        if ($this->cells === null) {
            return null;
        }

        foreach ($this->cells as $cell) {
            if ($cell->isInCell($pos)) {
                if (($cell->getOwner() !== null) && (strtolower($cell->getOwner()) == strtolower($player->getName()))) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param string $name
     * @param string $date
     * @param int $x1
     * @param int $x2
     * @param int $y
     * @param int $z1
     * @param int $z2
     * @param string $level
     * @param float $price
     * @param int|null $days
     */
    public function createCell(string $name, string $date, int $x1, int $x2, int $y, int $z1, int $z2, string $level, float $price, ?int $days = null): void {
        if (($price === null) || ($price === '')) {
            $price = $this->plugin->getValue('default.price');
        }

        if ($days === null) {
            $days = (int)$this->plugin->getValue('expire.days');
        }

        $this->cells[$name] = new Cell($name, $date, $x1, $x2, $y, $z1, $z2, $level, $price, $days);
    }

    /**
     * @return Cell[]
     */
    public function getCells(): array {
        return $this->cells;
    }

    /**
     * @param string $name
     * @return Cell
     */
    public function getCell(string $name): Cell {
        return $this->cells[$name];
    }

    /**
     * @param string $name
     */
    public function delCell(string $name): void {
        unset($this->cells[$name]);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function existCell(string $name): bool {
        return isset($this->cells[$name]);
    }
}
