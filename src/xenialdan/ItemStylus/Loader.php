<?php

namespace xenialdan\ItemStylus;

use pocketmine\plugin\PluginBase;

class Loader extends PluginBase
{
    /** @var Loader */
    private static $instance;
    /** @var array */
    public static $editingLore = [];

    public function onLoad()
    {
        self::$instance = $this;
    }

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register(Commands::class, new Commands($this));
    }

    /**
     * Returns an instance of the plugin
     * @return Loader
     */
    public static function getInstance()
    {
        return self::$instance;
    }
}