<?php
declare(strict_types=1);
namespace galaxygames\ovommand\utils;

use galaxygames\ovommand\BaseCommand;
use galaxygames\ovommand\BaseSubCommand;
use galaxygames\ovommand\Ovommand;
use galaxygames\ovommand\parameter\default\IntParameter;

class OvommandTreeOverload{

}

class OvommandTree{
	public readonly BaseCommand|BaseSubCommand $command;
	/** @var OvommandTree */
	public readonly array $children;
	public function __construct(){

	}

	public static function create() : self{
		return new OvommandTree();
	}

	public function int(string $name) : self{
		$this->command->registerParameters(new IntParameter($name));
		return $this;
	}

	public function float(string $name) : self{
		return $this;
	}

	public function string(string $name) : self{
		return $this;
	}

	public function position(string $name) : self{
		return $this;
	}

	public function blockPosition(string $name) : self{
		return $this;
	}

	public function target(string $name) : self{
		return $this;
	}
}

class OvommandHelper{
	public static function createCommand() : Ovommand{
	}
}