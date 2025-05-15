<?php
declare(strict_types=1);

namespace galaxygames\ovommand\parameter;

use galaxygames\ovommand\exception\ParameterException;
use galaxygames\ovommand\parameter\result\BaseResult;
use galaxygames\ovommand\parameter\result\BrokenSyntaxResult;
use galaxygames\ovommand\parameter\result\ValueResult;
use galaxygames\ovommand\utils\Messages;
use pocketmine\network\mcpe\protocol\types\command\CommandParameter;
use shared\galaxygames\ovommand\fetus\IParameter;

abstract class BaseParameter implements IParameter{
	protected int $flag = 0;

	final public function getName() : string{ return $this->name; }
	/**
	 * some parameters have 2 or more spans, but may only require one as those spans can be written in one span! <br>
	 * EG: these input parameters are valid for position: `~~~`, `~~ ~`, `~ ~ ~`
	 */
	public function hasCompactParameter() : bool{ return false; }
	public function getSpanLength() : int{ return 1; }
	public function getFlag() : int{ return $this->flag; }

	public function __construct(protected string $name, protected bool $optional = false, int $flag = 0){
		$this->setFlag($flag);
	}

	abstract public function getValueName() : string;
	abstract public function getNetworkType() : ParameterTypes;
	public function isOptional() : bool{ return $this->optional; }

	/** @param string[] $parameters */
	public function parse(array $parameters) : BaseResult{
		$cParam = count($parameters);
		$span = $this->getSpanLength();
		return match (true) {
			$cParam > $span => BrokenSyntaxResult::create($parameters[$this->getSpanLength()], implode(" ", $parameters), $this->getValueName())->setCode(BrokenSyntaxResult::CODE_TOO_MUCH_INPUTS),
			$cParam < $span => BrokenSyntaxResult::create("", implode(" ", $parameters), $this->getValueName())->setCode(BrokenSyntaxResult::CODE_NOT_ENOUGH_INPUTS),
			default => ValueResult::create($parameters)
		};
	}

	private function setFlag(int $flag) : void{
		$this->flag = match ($flag) {
			0, 1 => $flag,
			default => throw new ParameterException(Messages::EXCEPTION_PARAMETER_INVALID_FLAG->translate(['flag' => (string) $flag]), ParameterException::PARAMETER_INVALID_FLAG)
		};
	}

	public function getNetworkParameterData() : CommandParameter{
		return CommandParameter::standard($this->name, $this->getNetworkType()->encode(), $this->flag, $this->optional);
	}
}
