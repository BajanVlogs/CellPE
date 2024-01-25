<?php

namespace Bajan\CellPE\listener;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\level\Position;

use Bajan\CellPE\CellPE;

class EventListener implements Listener {

    /** @var CellPE */
    private $plugin;
    /** @var Position[] */
    private $pos1 = [];
    /** @var Position[] */
    private $pos2 = [];

    public function __construct(CellPE $plugin) {
        $this->plugin = $plugin;
    }

    /**
     * @param PlayerInteractEvent $event
     * @priority MONITOR
     */
    public function onInteract(PlayerInteractEvent $event) {
        // ... (existing code)
    }

    /**
     * @param PlayerMoveEvent $event
     * @priority MONITOR
     */
    public function onMove(PlayerMoveEvent $event) {
        // ... (existing code)
    }

    /**
     * @param BlockBreakEvent $event
     * @priority MONITOR
     */
    public function onBreak(BlockBreakEvent $event) {
        $p = $event->getPlayer();
        $block = $event->getBlock();
        $pos = new Position($block->getX(), $block->getY(), $block->getZ(), $block->getLevel());

        // ... (existing code)

        if($cell = $this->plugin->getCellManager()->isInCell($pos)){
            if(($cell->getOwner() == $p->getName()) || ($cell->isHelper($p->getName()) === true)){
                $event->setCancelled(false);
            } else {
                $event->setCancelled(true);
            }
        }
    }
}
