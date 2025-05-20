<?php
declare(strict_types=1);

namespace galaxygames\ovommand;

use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;

class ClosureCommand extends Ovommand{
	private ?\Closure $setupClosure = null;
	private ?\Closure $preRunClosure = null;
	private ?\Closure $runClosure = null;
	public function __construct(Translatable|string $description = "", Translatable|string|null $usageMessage = null, ?string $permission = null){
		parent::__construct($description, $usageMessage, $permission);
		Utils::registerClosure($this, "setupClosure", "setup");
	}

	public function setup() : void{ $this->setupClosure?->call($this); }

	public function onPreRun(CommandSender $sender, array $args, array $nonParsedArgs = []) : bool{
		if ($this->preRunClosure !== null) {
			return $this->preRunClosure->call($this, $sender, $args, $nonParsedArgs);
		}
		return parent::onPreRun($sender, $args, $nonParsedArgs);
	}

	public function onRun(CommandSender $sender, string $label, array $args) : void{
		$this->runClosure?->call($this, $label, $args);
	}
}
