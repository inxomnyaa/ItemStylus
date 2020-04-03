<?php

namespace xenialdan\ItemStylus\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use xenialdan\ItemStylus\other\EditHighlightAllTask;

class RenameSubCommand extends SubCommand
{

    public function canUse(CommandSender $sender)
    {
        return ($sender instanceof Player) and $sender->hasPermission("itemStylus.command.rename");
    }

    public function getUsage()
    {
        return "rename <name>";
    }

    public function getName()
    {
        return "rename";
    }

    public function getDescription()
    {
        return "Rename an item";
    }

    public function getAliases()
    {
        return [];
    }

    /**
     * @param CommandSender $sender
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, array $args)
    {
        $name = implode(" ", $args ?? []);
        if (empty($args) || empty(trim(TextFormat::clean($name)))) {
            $sender->sendMessage(TextFormat::RED . "You need to provide a name");
            return false;
        }
        /** @var Player $sender */
        if (($item = $sender->getInventory()->getItemInHand())->isNull()) {
            $sender->sendMessage(TextFormat::RED . "You have no item in your hand");
            return true;
        }
        $item->setCustomName(($name = TextFormat::colorize($name)));
        $sender->sendMessage(TextFormat::GREEN . "The item has been renamed to $name");
        return true;
    }
}
