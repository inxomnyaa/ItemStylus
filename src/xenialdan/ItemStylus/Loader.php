<?php

declare(strict_types=1);

namespace xenialdan\ItemStylus;

use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginException;

class Loader extends PluginBase
{
    /** @var Loader */
    private static $instance;
    /** @var array */
    public static $editingLore = [];

    /**
     *
     */
    public function onLoad():void
    {
        self::$instance = $this;
    }

    /**
     * @throws PluginException
     */
    public function onEnable():void
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register("itemstylus", new Commands($this));
    }

    /**
     * Returns an instance of the plugin
     * @return Loader
     */
    public static function getInstance(): Loader
    {
        return self::$instance;
    }
}
