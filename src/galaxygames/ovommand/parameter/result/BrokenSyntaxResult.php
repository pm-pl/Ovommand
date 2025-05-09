<?php
declare(strict_types=1);

namespace galaxygames\ovommand\parameter\result;

use galaxygames\ovommand\utils\MessageParser;
use shared\galaxygames\ovommand\fetus\result\IFailedResult;

class BrokenSyntaxResult extends BaseResult implements IFailedResult{
	public const CODE_BROKEN_SYNTAX = 0;
	public const CODE_NOT_ENOUGH_INPUTS = 1;
	public const CODE_TOO_MUCH_INPUTS = 2;
	public const CODE_INVALID_INPUTS = 3;

	protected int $matchedParameter = 0;
	protected int $code = self::CODE_BROKEN_SYNTAX;

	public function __construct(protected string $brokenSyntax, protected string $fullSyntax = "", protected string $expectedType = "", protected string $preLabel = ""){}

	public static function create(string $brokenSyntax, string $fullSyntax = "", string $expectedType = "", string $preLabel = "") : self{
		return new BrokenSyntaxResult($brokenSyntax, $fullSyntax, $expectedType, $preLabel);
	}

	public function getBrokenSyntax() : string{
		return $this->brokenSyntax;
	}

	public function getFullSyntax() : string{
		return $this->fullSyntax;
	}

	public function setMatchedParameter(int $match = 0) : self{
		$this->matchedParameter = $match;
		return $this;
	}

	public function setPreLabel(string $preLabel) : void{
		$this->preLabel = $preLabel;
	}

	public function getPreLabel() : string{
		return $this->preLabel;
	}

	public function getMatchedParameter() : int{
		return $this->matchedParameter;
	}

	public function getCode() : int{
		return $this->code;
	}

	public function setCode(int $code) : self{
		$this->code = match ($code) {
			self::CODE_BROKEN_SYNTAX => self::CODE_BROKEN_SYNTAX,
			self::CODE_NOT_ENOUGH_INPUTS => self::CODE_NOT_ENOUGH_INPUTS,
			self::CODE_TOO_MUCH_INPUTS => self::CODE_TOO_MUCH_INPUTS,
			self::CODE_INVALID_INPUTS => self::CODE_INVALID_INPUTS,
			default => throw new \InvalidArgumentException(MessageParser::EXCEPTION_BROKEN_SYNTAX_RESULT_INVALID_CODE->translate(["code" => (string) $code]))
		};
		return $this;
	}

	public function getExpectedType() : string{
		return $this->expectedType;
	}
}
