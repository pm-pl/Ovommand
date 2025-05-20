<?php
declare(strict_types=1);

namespace galaxygames\ovommand\exception;

use shared\galaxygames\ovommand\fetus\OvommandException;

final class CommandException extends OvommandException{
	public const SUB_COMMAND_REGISTER_SELF = 0;
	public const SUB_COMMAND_DUPLICATE_ALIAS = 1;
	public const SUB_COMMAND_EMPTY_ALIAS = 2;
}
