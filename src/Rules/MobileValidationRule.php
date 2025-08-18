<?php

namespace Radeir\Rules;

use Radeir\Exceptions\InvalidInputException;

class MobileValidationRule
{
	public static function passes(string $mobile): string {
		if (in_array(preg_match("/^09\\d{9}\$/", $mobile), [0, false], true)) {
			throw new InvalidInputException('شماره موبایل صحیح نیست. مثال: 09123456789', 422);
		}

		return $mobile;
	}
}
