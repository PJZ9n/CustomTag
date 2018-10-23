<?php

    namespace CustomTag;


    use pocketmine\command\Command;
    use pocketmine\command\CommandSender;
    use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
    use pocketmine\Player;

    class tagCommand extends Command
    {

        private $main;

        public function __construct(main $main)
        {
            $this->main = $main;
            parent::__construct("tag", "称号", "/tag");
            $this->setPermission("customtag.command.tag");
            $this->setDescription("称号");
            $this->setUsage("/tag");
        }

        public function execute(CommandSender $sender, string $commandLabel, array $args): bool
        {
            if (!$sender instanceof Player) {
                $sender->sendMessage(main::ERROR_TAG . "このコマンドはプレイヤーのみ実行できます");
                return true;
            } else {
                $player = $sender->getPlayer();
                $name = $player->getName();
            }
            $form = new ModalFormRequestPacket();
            $form->formId = $this->main->formId[0];
            $form_data["type"] = "form";
            $form_data["title"] = $this->main->getDescription()->getName();
            if (!$player->isOp()) {
                $form_data["content"] = "行いたい動作を選択してください\n§l§f[ 一般モード ]";
                $form_data["buttons"][] = array(
                    "text" => "§l§a称号を購入する",
                );
                $form_data["buttons"][] = array(
                    "text" => "§l§a称号を設定する",
                );
            } else {
                $form_data["content"] = "行いたい動作を選択してください\n§l§c[ 管理者モード ]";
                $form_data["buttons"][] = array(
                    "text" => "§l§a称号を購入する",
                );
                $form_data["buttons"][] = array(
                    "text" => "§l§a称号を設定する",
                );
                $form_data["buttons"][] = array(
                    "text" => "§l§6[OP]§a称号を追加する",
                );
                $form_data["buttons"][] = array(
                    "text" => "§l§6[OP]§a称号を削除する",
                );
            }
            $form->formData = json_encode($form_data);
            $player->sendDataPacket($form);
            return true;
        }

    }