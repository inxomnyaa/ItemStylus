<?php

declare(strict_types=1);

namespace xenialdan\ItemStylus\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class RenameSubCommand extends SubCommand
{

    public function canUse(CommandSender $sender):bool
    {
        return ($sender instanceof Player) and $sender->hasPermission('itemStylus.command.rename');
    }

    public function getUsage():string
    {
        return 'rename <name>';
    }

    public function getName():string
    {
        return 'rename';
    }

    public function getDescription():string
    {
        return 'Rename an item';
    }

    public function getAliases():array
    {
        return [];
    }

    /**
     * @param CommandSender $sender
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, array $args):bool
    {
        $name = implode(' ', $args ?? []);
        if (empty($args) || empty(trim(TextFormat::clean($name)))) {
            $sender->sendMessage(TextFormat::RED . 'You need to provide a name');
            return false;
        }
        /** @var Player $sender */
        if (($item = $sender->getInventory()->getItemInHand())->isNull()) {
            $sender->sendMessage(TextFormat::RED . 'You have no item in your hand');
            return true;
        }
        $item->setCustomName(($name = TextFormat::colorize($name)));
        $sender->getInventory()->setItemInHand($item);
        $sender->sendMessage(TextFormat::GREEN . "The item has been renamed to $name");
        return true;
    }
}
