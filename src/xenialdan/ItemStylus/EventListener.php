<?php

declare(strict_types=1);

namespace xenialdan\ItemStylus;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerEditBookEvent;
use pocketmine\item\WritableBook;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;
use xenialdan\ItemStylus\subcommand\LoreSubCommand;

class EventListener implements Listener
{
    /** @var Loader */
    public $owner;

    public function __construct(Plugin $plugin)
    {
        $this->owner = $plugin;
    }

    public function onBookEdit(PlayerEditBookEvent $event): void
    {
        $player = $event->getPlayer();
        if ($event->getAction() !== PlayerEditBookEvent::ACTION_REPLACE_PAGE) {
            $event->setCancelled();
            $player->sendMessage(TextFormat::RED . 'Please only MODIFY the text, do NOT add or delete pages!');
            return;
        }
        $text = explode(TextFormat::EOL, $event->getNewBook()->getPageText(0));
        $index = Loader::$editingLore[$player->getName()];
        $item = $player->getInventory()->getItem($index);
        $item->setLore($text);
        $player->getInventory()->setItem($index, $item);
        $player->sendMessage(TextFormat::GREEN . 'Lore successfully changed');
        $player->sendMessage(TextFormat::GREEN . 'Drop book to stop editing');
    }

    public function onDrop(PlayerDropItemEvent $event): void
    {
        if (!$event->getItem() instanceof WritableBook || $event->getItem()->getCustomName() !== LoreSubCommand::CHANGE_THE_TEXT_OF_THE_BOOK_TO_EDIT_THE_LORE_DROP_THE_BOOK_TO_STOP_EDITING) {
            return;
        }
        $player = $event->getPlayer();
        if (isset(Loader::$editingLore[$player->getName()])) {
            unset(Loader::$editingLore[$player->getName()]);
            $event->setCancelled();
            $player->getInventory()->remove($event->getItem());
            $player->sendMessage(TextFormat::GOLD . 'Stopped editing lore');
        }
    }
}