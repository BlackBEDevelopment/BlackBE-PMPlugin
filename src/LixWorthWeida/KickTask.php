<?php
/**
 * KickTask.php
 *
 * @project BlackBE-PMPlugin
 * @author lixworth <lixworth@outlook.com>
 * @copyright BlackBE-PMPlugin
 * @create 2021/7/17 1:09
 */

declare(strict_types=1);

namespace LixWorthWeida;


use pocketmine\Player;
use pocketmine\scheduler\Task;

class KickTask extends Task
{

    public BlackBE $that;
    public Player $that_player;

    public function __construct(BlackBE $blackBE,Player $player)
    {
        $this->that_player = $player;
        $this->that = $blackBE;
    }

    public function onRun(int $currentTick)
    {
        $this->that_player->kick("你在BlackBE云黑存在封禁记录，已踢出");
        $this->that->getLogger()->notice("玩家 " . $this->that_player->getName() . "存在云黑记录，已踢出。");
    }
}
