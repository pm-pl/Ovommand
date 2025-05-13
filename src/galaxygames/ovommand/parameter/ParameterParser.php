<?php
declare(strict_types=1);

namespace galaxygames\ovommand\parameter;

use galaxygames\ovommand\parameter\result\BrokenSyntaxResult;
use galaxygames\ovommand\parameter\result\CoordinateResult;

class ParameterParser{
	public static function parseFloat(string $value) : float{ return floatval($value); }
	public static function parseInt(string $value) : int{ return intval($value); }

	public static function positionTagCast(string $value) : int{
		return match ($value) {
			"~" => CoordinateResult::TYPE_RELATIVE,
			"^" => CoordinateResult::TYPE_LOCAL,
			default => CoordinateResult::TYPE_DEFAULT
		};
	}

	public static function parsePosition(string $value) : BrokenSyntaxResult | CoordinateResult{
		if (!preg_match_all("/([+-]+[^\d~]+|[^\d~^+-]*)([~^]?[+-]?\d+\.?\d*|[~^])([+-]+[^\d~^]+|[^\d~^+-]*)/", $value, $matches, PREG_OFFSET_CAPTURE)) {
			return BrokenSyntaxResult::create($value, $value, "position")->setCode(BrokenSyntaxResult::CODE_BROKEN_SYNTAX);
		}
		dump($matches);
		$matchCount = count($matches[0]);
		if ($matchCount < 3) {
			return BrokenSyntaxResult::create("", $value, "position")->setCode(BrokenSyntaxResult::CODE_NOT_ENOUGH_INPUTS);
		} else if ($matchCount > 3) {
			return BrokenSyntaxResult::create($matches[0][3], $value, "position")->setCode(BrokenSyntaxResult::CODE_TOO_MUCH_INPUTS)->setMatchedParameter(3);
		}
		for ($i = 0; $i < 3; $i++) {
			$preInvalid = !empty(ltrim($matches[1][$i]));
			$postInvalid = !empty(ltrim($matches[3][$i]));
			if ($preInvalid) {
				return BrokenSyntaxResult::create($matches[1][$i], $value, "position")
					->setCode(BrokenSyntaxResult::CODE_BROKEN_SYNTAX)
					->setMatchedParameter($i);
			}
			if ($postInvalid) {
				return BrokenSyntaxResult::create($matches[3][$i], $value, "position")
					->setCode(BrokenSyntaxResult::CODE_BROKEN_SYNTAX)
					->setMatchedParameter($i + 1);
			}
		}

		$xType = self::positionTagCast($matches[2][0][0]);
		$yType = self::positionTagCast($matches[2][1][0]);
		$zType = self::positionTagCast($matches[2][2][0]);

		$coordType = null;
		foreach ([$xType, $yType, $zType] as $i => $type) {
			if ($coordType === null) {
				$coordType = $type;
			}
			if ($type !== $coordType && ($type === CoordinateResult::TYPE_LOCAL || $coordType === CoordinateResult::TYPE_LOCAL)) {
				return BrokenSyntaxResult::create($matches[2][$i], $value, "position")->setCode(BrokenSyntaxResult::CODE_BROKEN_SYNTAX)->setMatchedParameter($i);
			}
			if ($type !== CoordinateResult::TYPE_DEFAULT) {
				$matches[2][$i] = substr($matches[2][$i], 1);
			}
		}
		return CoordinateResult::fromData((float) $matches[2][0], (float) $matches[2][1], (float) $matches[2][2], $xType, $yType, $zType);
	}
}