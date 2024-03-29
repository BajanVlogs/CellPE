<?php

namespace Bajan\CellPE\commands;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;

use Bajan\CellPE\CellPE;
use Bajan\CellPE\commands\subcommands\AddHelperSub;
use Bajan\CellPE\commands\subcommands\AdminSub;
use Bajan\CellPE\commands\subcommands\BuySub;
use Bajan\CellPE\commands\subcommands\CheckSub;
use Bajan\CellPE\commands\subcommands\DeleteSub;
use Bajan\CellPE\commands\subcommands\RemoveHelperSub;
use Bajan\CellPE\commands\subcommands\SellSub;
use Bajan\CellPE\commands\subcommands\SetSub;
use Bajan\CellPE\commands\subcommands\SubCommand;
use Bajan\CellPE\commands\subcommands\TeleportSub;
use Bajan\CellPE\commands\subcommands\UpgradeSub;

class MainCommand implements CommandExecutor {

    /** @var CellPE */
    private $plugin;
    /** @var SubCommand[] */
    private $subCommands = [];

    public function __construct(CellPE $plugin) {
        $this->plugin = $plugin;
        $this->initSubCommands();
    }

    private function initSubCommands() {
        $this->registerSubCommand(new AddHelperSub($this->plugin, 'addhelper', 'cell.addhelper', 'Add a helper for your cell'));
        $this->registerSubCommand(new AdminSub($this->plugin, 'admin', 'cell.admin', 'Manage cells'));
        $this->registerSubCommand(new BuySub($this->plugin, 'buy', 'cell.buy', 'Buy a cell you\'re standing on'));
        $this->registerSubCommand(new CheckSub($this->plugin, 'check', 'cell.check', 'Check a cell you\'re standing on'));
        $this->registerSubCommand(new DeleteSub($this->plugin, 'delete', 'cell.delete', 'Delete a cell'));
        $this->registerSubCommand(new RemoveHelperSub($this->plugin, 'removehelper', 'cell.removehelper', 'Remove one of your helpers'));
        $this->registerSubCommand(new SellSub($this->plugin, 'sell', 'cell.sell', 'Sell one of your cells'));
        $this->registerSubCommand(new SetSub($this->plugin, 'set', 'cell.set', 'Set a cell location'));
        $this->registerSubCommand(new TeleportSub($this->plugin, 'teleport', 'cell.teleport', 'Teleport to one of your cells'));
        $this->registerSubCommand(new UpgradeSub($this->plugin, 'upgrade', 'cell.upgrade', 'Upgrade your cell'));
    }

    private function registerSubCommand(SubCommand $subCommand) {
        $this->subCommands[$subCommand->getName()] = $subCommand;
    }

    private function sendHelp(Player $sender) {
        $sender->sendMessage($this->plugin->getMessage('cell.help.header'));
        foreach ($this->subCommands as $subCommand) {
            if ($subCommand->isAllowed($sender)) {
                $sender->sendMessage($this->plugin->getMessage('cell.help', [
                    'sub' => $subCommand->getName(),
                    'desc' => $subCommand->getDescription()
                ]));
            }
        }
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch ($cmd->getName()) {
            case 'cell':
                if (!$sender instanceof Player) {
                    $sender->sendMessage($this->plugin->getMessage('cell.in.game'));
                    return true;
                }
                if (!isset($args[0])) {
                    $this->sendHelp($sender);
                    return true;
                }
                if (!isset($this->subCommands[$args[0]])) {
                    $this->sendHelp($sender);
                    return true;
                }
                $subCommand = $this->subCommands[$args[0]];
                if ($subCommand->isAllowed($sender) === false) {
                    $sender->sendMessage($this->plugin->getMessage('cell.' . $subCommand->getName() . '.no.permission'));
                    return true;
                }
                $subCommand->execute($sender, $args);
                break;
        }
        return true;
    }
}
