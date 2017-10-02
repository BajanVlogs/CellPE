<?php

namespace Bajan\CellPE\commands\subcommands;

use pocketmine\Player;

class CheckSub extends SubCommand{

    public function execute(Player $player, array $args){
        if($cell = $this->plugin->getCellManager()->isInCell($player->getPosition())){
            if($cell->getOwner() == null){
                $player->sendMessage($this->plugin->getMessage('cell.check.owner.null', [$cell->getName()]));
                return;
            }
            $player->sendMessage($this->plugin->getMessage('cell.check.success', [$cell->getName(), $cell->getOwner(), implode(', ', $cell->getHelpers())]));
            return;
        }
        $player->sendMessage($this->plugin->getMessage('cell.check.not.in.cell'));
    }

}
