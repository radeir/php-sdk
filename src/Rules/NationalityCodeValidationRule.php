<?php

namespace Radeir\Rules;

use Radeir\Exceptions\InvalidInputException;

class NationalityCodeValidationRule
{
	public static function passes(string $nationalityCode): string {
		if (in_array(preg_match("/^\d{10}$/", $nationalityCode), [0, false], true)) {
			throw new InvalidInputException('کد ملی وارد شده معتبر نیست.', 422);
		}

		$check = (int)$nationalityCode[9];
		$sum   = array_sum(array_map(function ($x) use ($nationalityCode): int
			{
				return ((int)$nationalityCode[$x]) * (10 - $x);
			}, range(0, 8))) % 11;

		if (($sum < 2 && $check == $sum) || ($sum >= 2 && $check + $sum == 11)) {
			return $nationalityCode;
		}
        
		throw new InvalidInputException('کد ملی وارد شده معتبر نیست.', 422);

	}
}
