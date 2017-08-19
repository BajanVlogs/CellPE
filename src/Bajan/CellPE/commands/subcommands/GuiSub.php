<?php

namespace Bajan\CellPE\commands\subcommands;

use pocketmine\block\Block;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\plugin\PluginBase;
use pocketmine\tile\Chest;
use pocketmine\tile\Tile;

class GuiSub extends SubCommand{


  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
  }

/*
*
* CellPE menu by BajanVlogs
*
*/
  public function sendChestInventory(Player $player, InventoryTransactionEvent $e){
    $block = Block::get(54);
    $player->getLevel()->setBlock(new Vector3($player->x, $player->y - 2, $player->z), $block, true, true);
    $nbt = new CompoundTag("", [
      new ListTag("Items", []),
      new StringTag("id", Tile::CHEST),
      new IntTag("x", floor($player->x)),
      new IntTag("y", floor($player->y) - 2),
      new IntTag("z", floor($player->z))
    ]);
    $nbt->Items->setTagType(NBT::TAG_Compound);
    $tile = Tile::createTile("Chest", $player->getLevel()->getChunk($player->getX() >> 4, $player->getZ() >> 4), $nbt);
    /* Items */
    $item = Item::get(310, 0, 1);
    $item2 = Item::get(276, 0, 1);
    $item2->setCustomName("Lmao");
    $tile->getInventory()->getSlotIndex(1)->setItem($item);
    $tile->getInventory()->addItem(2, $item);
    $player->addWindow($tile->getInventory());
   
        foreach($e->getTransaction()->getTransactions() as $t) {
            if($t->getInventory() instanceof ChestInventory) {
                $e->setCancelled(true);
	    }
	}
  }

  public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
    if($sender instanceof Player){
      switch(strtolower($cmd->getName())){
		  
		case "crate":
          $sender->sendMessage("§l§cCellPE §7»»§f§r §7Help Menu");
          $this->sendChestInventory($sender);
		  return true;
        break;
		
      }
    }
	else {
		$sender->sendMessage("Use this command in-game");
	}
  }
  
  
}
