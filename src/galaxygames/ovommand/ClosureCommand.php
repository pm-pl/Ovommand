<?php
declare(strict_types=1);

namespace galaxygames\ovommand;

use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\utils\Utils;

/**
 * @phpstan-type OvommandSetupClosure \Closure(Ovommand $command) : void
 * @phpstan-type OvommandPreRunClosure \Closure(Ovommand $command, CommandSender $sender, array $args, array $nonParsedArgs) : bool
 * @phpstan-type OvommandRunClosure \Closure(Ovommand $command, string $label, array $args) : void
 */
class ClosureCommand extends Ovommand{
	/** @phpstan-var ?OvommandSetupClosure $setupClosure */
	private ?\Closure $setupClosure;
	/** @phpstan-var ?OvommandPreRunClosure $preRunClosure */
	private ?\Closure $preRunClosure;
	/** @phpstan-var ?OvommandRunClosure $runClosure*/
	private ?\Closure $runClosure;

	/**
	 * @phpstan-param ?OvommandSetupClosure $setupClosure
	 * @phpstan-param ?OvommandPreRunClosure $preRunClosure
	 * @phpstan-param ?OvommandRunClosure $runClosure
	 */
	public function __construct(
		Translatable|string $description = "", Translatable|string|null $usageMessage = null, ?string $permission = null,
		?\Closure $setupClosure = null, ?\Closure $preRunClosure = null, ?\Closure $runClosure = null
	){
		parent::__construct($description, $usageMessage, $permission);
		Utils::validateCallableSignature(function (Ovommand $command) : void{}, $setupClosure);
		Utils::validateCallableSignature(
			fn (Ovommand $command, CommandSender $sender, array $args, array $nonParsedArgs) : bool => true,
			$preRunClosure,
		);
		Utils::validateCallableSignature(
			function (Ovommand $command, string $label, array $args) : void{},
			$runClosure,
		);
		$this->setupClosure = $setupClosure;
		$this->preRunClosure = $preRunClosure;
		$this->runClosure = $runClosure;
	}

	public function setup() : void{
		if ($this->setupClosure !== null) {
			($this->setupClosure)($this);
		}
	}

	public function onPreRun(CommandSender $sender, array $args, array $nonParsedArgs = []) : bool{
		if ($this->preRunClosure !== null) {
			return ($this->preRunClosure)($this, $sender, $args, $nonParsedArgs);
		}
		return parent::onPreRun($sender, $args, $nonParsedArgs);
	}

	public function onRun(CommandSender $sender, string $label, array $args) : void{
		$this->runClosure?->call($this, $label, $args);
	}
}
