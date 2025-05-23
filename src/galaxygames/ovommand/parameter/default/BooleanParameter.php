<?php
declare(strict_types=1);

namespace galaxygames\ovommand\parameter\default;

use galaxygames\ovommand\enum\DefaultEnums;

class BooleanParameter extends EnumParameter{
	public function __construct(string $name, bool $optional = false, int $flag = 0){
		parent::__construct($name, DefaultEnums::BOOLEAN, false, $optional, $flag);
	}
}
