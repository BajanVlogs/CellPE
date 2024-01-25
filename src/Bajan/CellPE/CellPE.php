<?php

namespace Bajan\CellPE;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

use Bajan\CellPE\cell\CellManager;
use Bajan\CellPE\commands\MainCommand;
use Bajan\CellPE\listener\EventListener;
use Bajan\CellPE\task\ExpireTask;
use Bajan\CellPE\utils\Format;
use Bajan\CellPE\session\Session; // Make sure to import the Session class

use DateTime;
use DateTimeZone;

use onebone\economyapi\EconomyAPI;

class CellPE extends PluginBase {

    /** @var Config */
    private $cfg;
    /** @var Config */
    private $messages;
    /** @var CellManager */
    private $cellManager;
    /** @var Format */
    private $format;
    /** @var Session */
    private $session;

    public function onEnable() {
        $economyAPI = $this->getServer()->getPluginManager()->getPlugin('EconomyAPI');
        if($economyAPI === null || !$economyAPI->isEnabled()){
            $this->getLogger()->critical('EconomyAPI not found or not enabled. Disabling plugin...');
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return;
        }
        
        $this->saveResource('config.yml');
        $this->saveResource('messages.yml');
        $this->cfg = new Config($this->getDataFolder() . 'config.yml', Config::YAML, []);
        $this->messages = new Config($this->getDataFolder() . 'messages.yml', Config::YAML, []);
        $this->cellManager = new CellManager($this);
        $this->format = new Format();
        $this->session = new Session($this);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->initCells();
        $this->initCommand();
        if($this->getValue('enable.expire') === true) {
            $this->createTask();
        }
    }

    public function initCells() {
        if(!file_exists($this->getDataFolder() . 'cells.json')){
            file_put_contents($this->getDataFolder() . 'cells.json', "[]");
        }
        $cells = json_decode(file_get_contents($this->getDataFolder() . 'cells.json', true), true);
        $this->cellManager->initCells($cells);
    }

    public function initCommand() {
        $this->getServer()->getCommandMap()->register('cell', new MainCommand($this));
    }

    public function createTask() {
        $a = new ExpireTask($this);
        $b = $this->getScheduler()->scheduleRepeatingTask($a, 72000);
        $a->setHandler($b);
    }

    // ... (the rest of your methods remain unchanged)

    public function onDisable() {
        $this->cellManager->saveCells();
    }
}
