<?php
declare(strict_types=1);

namespace galaxygames\ovommand\parameter\default;

use galaxygames\ovommand\parameter\BaseParameter;
use galaxygames\ovommand\parameter\ParameterTypes;
use galaxygames\ovommand\parameter\parser\ParameterParser;
use galaxygames\ovommand\parameter\result\BrokenSyntaxResult;
use galaxygames\ovommand\parameter\result\CoordinateResult;

class PositionParameter extends BaseParameter{
	public function getValueName() : string{ return "x y z"; }
	public function getNetworkType() : ParameterTypes{ return ParameterTypes::POSITION; }
	public function hasCompactParameter() : bool{ return true; }
	public function getSpanLength() : int{ return 3; }

	public function parse(array $parameters) : CoordinateResult | BrokenSyntaxResult{
		return ParameterParser::parsePosition(implode(' ', $parameters));
	}
}
