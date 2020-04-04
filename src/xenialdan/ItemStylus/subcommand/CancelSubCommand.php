<?php

declare(strict_types=1);

namespace xenialdan\ItemStylus\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\item\ItemIds;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use xenialdan\ItemStylus\Loader;

class CancelSubCommand extends SubCommand{

	public function canUse(CommandSender $sender):bool{
		return ($sender instanceof Player) and $sender->hasPermission('itemStylus.command.cancel');
	}

	public function getUsage():string
    {
		return 'cancel';
	}

	public function getName():string
    {
		return 'cancel';
	}

	public function getDescription():string {
		return 'Cancel editing item lore';
	}

	public function getAliases():array {
		return [];
	}

	/**
	 * @param CommandSender $sender
	 * @param array $args
	 * @return bool
	 */
	public function execute(CommandSender $sender, array $args):bool {
		unset(Loader::$editingLore[$sender->getName()]);
		/** @var Player $sender */
		foreach($sender->getInventory()->getContents() as $item){
		    if($item->getId() === ItemIds::WRITABLE_BOOK && $item->getCustomName() === LoreSubCommand::CHANGE_THE_TEXT_OF_THE_BOOK_TO_EDIT_THE_LORE_DROP_THE_BOOK_TO_STOP_EDITING) {
                $sender->getInventory()->remove($item);
            }
        }
        $sender->sendMessage(TextFormat::RED . 'Editing item lore was cancelled');
		return true;
	}
}
