<?php
declare(strict_types=1);

namespace galaxygames\ovommand\parameter;

use galaxygames\ovommand\parameter\result\CoordinateResult;
use galaxygames\ovommand\parameter\result\BrokenSyntaxResult2;

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

	public static function parsePosition(string $value) : BrokenSyntaxResult2 | CoordinateResult{
		if (!preg_match_all("/([+-]+[^\d~]+|[^\d~^+-]*)([~^]?[+-]?\d+\.?\d*|[~^])([+-]+[^\d~^]+|[^\d~^+-]*)/", $value, $matches, PREG_OFFSET_CAPTURE)) {
			return BrokenSyntaxResult2::create($value)->setCode(BrokenSyntaxResult2::CODE_BROKEN_SYNTAX);
		}
		/** @var array<int, array<int, array<int, int|string>>> $matches */
//		dump($matches);
		$matchCount = count($matches[0]);
		if ($matchCount < 3) {
			return BrokenSyntaxResult2::create($value, "", strlen($value))->setCode(BrokenSyntaxResult2::CODE_NOT_ENOUGH_INPUTS);
		}
		for ($i = 0; $i < 3; $i++) {
			$preInvalid = !empty(ltrim($matches[1][$i][0]));
			$postInvalid = !empty(ltrim($matches[3][$i][0]));
			if ($preInvalid) {
				return BrokenSyntaxResult2::create($value, $matches[1][$i][0], $matches[1][$i][1])->setCode(BrokenSyntaxResult2::CODE_BROKEN_SYNTAX);
			}
			if ($postInvalid) {
				return BrokenSyntaxResult2::create($value, $matches[3][$i][0], $matches[3][$i][1])->setCode(BrokenSyntaxResult2::CODE_BROKEN_SYNTAX);
			}
		}

		if ($matchCount > 3) {
			return BrokenSyntaxResult2::create($value, substr($value, $matches[2][2][1] + 1), $matches[2][2][1] + 1)->setCode(BrokenSyntaxResult2::CODE_TOO_MUCH_INPUTS);
		}

		$xType = self::positionTagCast($matches[2][0][0][0]);
		$yType = self::positionTagCast($matches[2][1][0][0]);
		$zType = self::positionTagCast($matches[2][2][0][0]);

		$coordType = null;
		foreach ([$xType, $yType, $zType] as $i => $type) {
			if ($coordType === null) {
				$coordType = $type;
			}
			if ($type !== $coordType && ($type === CoordinateResult::TYPE_LOCAL || $coordType === CoordinateResult::TYPE_LOCAL)) {
				return BrokenSyntaxResult2::create($value, $matches[2][$i][0][0],$matches[2][$i][1] + 1)->setCode(BrokenSyntaxResult2::CODE_BROKEN_SYNTAX);
			}
			if ($type !== CoordinateResult::TYPE_DEFAULT) {
				$matches[2][$i][0] = substr($matches[2][$i][0], 1);
			}
		}
		return CoordinateResult::fromData((float) $matches[2][0], (float) $matches[2][1], (float) $matches[2][2], $xType, $yType, $zType);
	}
}