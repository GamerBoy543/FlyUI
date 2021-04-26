<?php

namespace FlyUI;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;

class Main extends PluginBase implements Listener {

    public function onEnable(){
        $this->getLogger()->info("FlyUI was enabled!!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onDisable(){
        $this->getLogger()->info("FlyUI was disabled");
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $str, array $args) : bool{

        switch($cmd->getName()){
            case "flyui":
                if($sender instanceof Player){
                    if($sender->hasPermission("flyui.use")){
                        $this->openFlyui($sender);
                    } else {
                        $sender->sendMessage("§cYou dont have permisson to use this command!");
                    }
                }
        }
    return true;
    }

    public function openFlyui($player){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $player, int $data = null){
            $result = $data;
            if($result === null){
                return true;
            }
            switch($result){
                case 0:
                    $player->setAllowFlight(true);
                    $player->sendMessage("§bYou have enabled fly!");
                    break;
                    
                case 1:
                    $player->setAllowFlight(false);
                    $player->setFlying(false);
                    $player->sendMessage("§CYou have disabled fly!");
                    break;
            }
        });
        $form->setTitle("§l§cFlyUI");
        $form->setContent("§eSelect a Fly Mode");
        $form->addButton("§aEnable Fly");
        $form->addButton("§cDisable Fly");
        $form->sendToPlayer($player);
        return $form;
    }
}