<?php

namespace Rules;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Radeir\Exceptions\InvalidInputException;
use Radeir\Rules\MobileValidationRule;

class MobileValidationRuleTest extends TestCase
{

	#[DataProvider('validMobilesProvider')]
	public function testValidMobiles(string $mobile): void
	{
		$result = MobileValidationRule::passes($mobile);
		$this->assertEquals($mobile, $result);
	}


	#[DataProvider('invalidMobilesProvider')]
	public function testInvalidMobiles(string $mobile): void
	{
		$this->expectException(InvalidInputException::class);
		$this->expectExceptionMessage('شماره موبایل صحیح نیست. مثال: 09123456789');
		$this->expectExceptionCode(422);

		MobileValidationRule::passes($mobile);
	}


	#[DataProvider('incorrectFormatMobilesProvider')]
	public function testIncorrectFormatMobiles(string $mobile): void
	{
		$this->expectException(InvalidInputException::class);
		$this->expectExceptionMessage('شماره موبایل صحیح نیست. مثال: 09123456789');
		$this->expectExceptionCode(422);

		MobileValidationRule::passes($mobile);
	}

	public static function validMobilesProvider(): array
	{
		return [
			['09123456789'],
			['09912345678'],
			['09012345678'],
		];
	}

	public static function invalidMobilesProvider(): array
	{
		return [
			['99123456789'],
			['19123456789'],
		];
	}


	public static function incorrectFormatMobilesProvider(): array
	{
		return [
			['123456789'],
			['12345678901'],
			['abcdefghij'],
			['123456789a'],
			['00123456789'],
			['0012345'],
			[''],
		];
	}
}
