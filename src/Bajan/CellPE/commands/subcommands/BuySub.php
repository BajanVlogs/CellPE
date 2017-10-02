<?php

namespace Bajan\CellPE\commands\subcommands;

use pocketmine\Player;

class BuySub extends SubCommand{

    public function execute(Player $player, array $args){
        if($cell = $this->plugin->getCellManager()->isInCell($player->getPosition())){
            if($cell->getOwner() == $player->getName()){
                $player->sendMessage($this->plugin->getMessage('cell.buy.in.own.cell'));
                return;
            }
            if($cell->getOwner() != null){
                $player->sendMessage($this->plugin->getMessage('cell.buy.owned', [$cell->getOwner()]));
                return;
            }
            if(($this->plugin->getMoney($player) - $cell->getPrice()) < 0){
                $player->sendMessage($this->plugin->getMessage('cell.buy.not.enough.money', [$cell->getPrice()]));
                return;
            }
            $this->plugin->reduceMoney($player, $cell->getPrice());
            $cell->setOwner($player->getName());
            $player->sendMessage($this->plugin->getMessage('cell.buy.success', [$cell->getName()]));
        }
        else {
            $player->sendMessage($this->plugin->getMessage('cell.buy.not.in.cell'));
        }
    }

}
