<?php

    namespace CustomTag;

    use pocketmine\plugin\PluginBase;
    use pocketmine\utils\Config;

    class main extends PluginBase
    {
        const SUCCESS_TAG = "§l§bSUCCESS §a>> §r";
        const ERROR_TAG = "§l§4ERROR §a>> §r";

        public $tag_data;
        public $formId;

        public function onEnable(): void
        {
            $this->getLogger()->info("{$this->getDescription()->getName()} {$this->getDescription()->getVersion()} が読み込まれました");
            $this->getServer()->getPluginManager()->registerEvents(new eventListener($this), $this);
            $this->getServer()->getCommandMap()->register("tag", new tagCommand($this));
            if (!file_exists($this->getDataFolder())) {
                mkdir($this->getDataFolder(), 0777);
            }
            $this->tag_data = new Config($this->getDataFolder() . "tag_data_v2.json", Config::JSON, array(
                "player_tag" => array(),
                "shop_tag" => array(),
            ));
            for ($i = 0; $i < 6; $i++) {
                $this->formId[$i] = mt_rand(450000, 500000);
            }
        }

        public function onDisable(): void
        {
            $this->tag_data->save();
            $this->getLogger()->info("{$this->getDescription()->getName()} {$this->getDescription()->getVersion()} が終了しました");
        }
    }