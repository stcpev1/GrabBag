<?php

use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use aliuly\grabbag\common\Cmd;

class AliasCmd implements CommandExecutor{
	protected $cmd;

	public function __construct($owner, $alias, $cmd){
		Cmd::addCommand($owner, $this, $alias, [
			"description" => mc::_("Alias for %1%", $cmd),
			"usage" => mc::_("/%1% [options]", $alias),
		]);
		$this->cmd = $cmd;
	}

	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
		$cmdline = $this->cmd;
		if(count($args)) $cmdline .= " " . implode(" ", $args);
		Cmd::exec($sender, [$cmdline], false);
		return true;
	}

	public function getCmd(){
		return $this->cmd;
	}
}