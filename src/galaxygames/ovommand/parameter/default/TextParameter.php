<?php
declare(strict_types=1);

namespace galaxygames\ovommand\parameter\default;

use galaxygames\ovommand\parameter\BaseParameter;
use galaxygames\ovommand\parameter\ParameterTypes;

class TextParameter extends BaseParameter{
	public function getValueName() : string{ return "text"; }
	public function getNetworkType() : ParameterTypes{ return ParameterTypes::TEXT; }
	public function getSpanLength() : int{ return PHP_INT_MAX; }
}
