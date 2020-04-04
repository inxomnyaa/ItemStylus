<?php

declare(strict_types=1);

namespace xenialdan\ItemStylus\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\item\WritableBook;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use xenialdan\ItemStylus\Loader;

class LoreSubCommand extends SubCommand
{

    public const CHANGE_THE_TEXT_OF_THE_BOOK_TO_EDIT_THE_LORE_DROP_THE_BOOK_TO_STOP_EDITING = 'Change the text of the book to edit the lore. Drop the book to stop editing';

    public function canUse(CommandSender $sender):bool
    {
        return ($sender instanceof Player) and $sender->hasPermission('itemStylus.command.lore');
    }

    public function getUsage():string
    {
        return 'lore';
    }

    public function getName():string
    {
        return 'lore';
    }

    public function getDescription():string
    {
        return 'Edit the lore of an item';
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
        /** @var Player $sender */
        Loader::$editingLore[$sender->getName()] = $sender->getInventory()->getHeldItemIndex();
        $sender->sendMessage(TextFormat::GREEN . self::CHANGE_THE_TEXT_OF_THE_BOOK_TO_EDIT_THE_LORE_DROP_THE_BOOK_TO_STOP_EDITING);
        $book = new WritableBook();
        $book->setCustomName(self::CHANGE_THE_TEXT_OF_THE_BOOK_TO_EDIT_THE_LORE_DROP_THE_BOOK_TO_STOP_EDITING);
        $text = implode("\n", $sender->getInventory()->getItemInHand()->getLore());
        $book->setPageText(0, $text);
        $sender->getInventory()->addItem($book);
        $sender->sendMessage(TextFormat::GREEN . 'Please modify the text of the book to edit the particle. First line is the title.');
        return true;
    }
}
