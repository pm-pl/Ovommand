<?php
declare(strict_types=1);

namespace galaxygames\ovommand\parameter\result;

use galaxygames\ovommand\utils\Messages;
use shared\galaxygames\ovommand\fetus\result\IFailedResult;

class BrokenSyntaxResult2 extends BaseResult implements IFailedResult{
	public const CODE_BROKEN_SYNTAX = 0;
	public const CODE_NOT_ENOUGH_INPUTS = 1;
	public const CODE_TOO_MUCH_INPUTS = 2;
	public const CODE_INVALID_INPUTS = 3;

	protected int $code = self::CODE_BROKEN_SYNTAX;

	public function __construct(protected string $fullSyntax = "", protected string $brokenSyntax = "", protected int $offset = 0, protected string $expectedType = "") {}

	public static function create(string $fullSyntax = "", string $brokenSyntax = "", int $offset = 0, string $expectedType = "") : self{
		return new BrokenSyntaxResult2($fullSyntax, $brokenSyntax, $offset, $expectedType);
	}

	public function getFullSyntax() : string{ return $this->fullSyntax; }
	public function getBrokenSyntax() : string { return $this->brokenSyntax; }
	public function getOffset() : int { return $this->offset; }
	public function getExpectedType() : string{ return $this->expectedType; }
	public function getCode() : int{ return $this->code; }

	public function setCode(int $code) : self{
		$this->code = match ($code) {
			self::CODE_BROKEN_SYNTAX => self::CODE_BROKEN_SYNTAX,
			self::CODE_NOT_ENOUGH_INPUTS => self::CODE_NOT_ENOUGH_INPUTS,
			self::CODE_TOO_MUCH_INPUTS => self::CODE_TOO_MUCH_INPUTS,
			self::CODE_INVALID_INPUTS => self::CODE_INVALID_INPUTS,
			default => throw new \InvalidArgumentException(Messages::EXCEPTION_BROKEN_SYNTAX_RESULT_INVALID_CODE->translate(["code" => (string) $code]))
		};
		return $this;
	}
}
