<?php
/**
 * BlackBE.php
 *
 * @project BlackBE-PMPlugin
 * @author lixworth <lixworth@outlook.com>
 * @copyright BlackBE-PMPlugin
 * @create 2021/7/17 0:41
 */

declare(strict_types=1);

namespace LixWorthWeida;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

/**
 * Class BlackBE
 * @package LixWorthWeida
 */
class BlackBE extends PluginBase implements Listener
{

    public static string $api_version = "2.0[BETA]";
    public static string $api_domain = "https://api.blackbe.xyz/api";


    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("BlackBE云黑插件加载完成,API版本" . self::$api_version);

    }

    public function onPlayerJoin(PlayerJoinEvent $playerJoinEvent)
    {
        $player = $playerJoinEvent->getPlayer();
        $data = @file_get_contents(self::$api_domain . "/check?v2=true&id=" . $player->getName());
        if ($data) {
            $result = json_decode($data);
            if ($result->error == "2002") {
                $this->getScheduler()->scheduleDelayedTask(new KickTask($this, $player), 10);
            }
            unset($result);
        } else {
            $this->getLogger()->error("云黑可能炸了呢");
        }
        unset($data);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if ($command->getName() == "blackbe") {
            $message = "本服务器使用BlackBE云黑限制违禁玩家 API版本：" . self::$api_version . "。 BlackBE云黑(https://blackbe.xyz)致力于维护MCBE的服务器环境，用最简单粗暴的方式，让广大服主开服省心、放心。";
            if ($sender->getName() === "CONSOLE") {
                $this->getLogger()->info(TextFormat::GREEN . $message);
            } else {
                $player = $this->getServer()->getPlayer(TextFormat::GREEN . $sender->getName());
                $player->sendMessage($message);
            }
        }
        return true;
    }
}
