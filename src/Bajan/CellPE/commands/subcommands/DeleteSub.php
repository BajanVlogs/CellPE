<?php

namespace Bajan\CellPE\commands\subcommands;

use pocketmine\Player;

class DeleteSub extends SubCommand{

    public function execute(Player $player, array $args){
        if(!isset($args[1])){
            $player->sendMessage($this->plugin->getMessage('cell.delete.usage'));
            return;
        }
        if($this->plugin->getCellManager()->existCell($args[1]) === false){
            $player->sendMessage($this->plugin->getMessage('cell.delete.not.exist'));
            return;
        }
        $this->plugin->getCellManager()->delCell($args[1]);
        $player->sendMessage($this->plugin->getMessage('cell.delete.success', [$args[1]]));
    }

}
