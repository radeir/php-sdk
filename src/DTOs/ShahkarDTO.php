<?php

namespace Radeir\DTOs;

class ShahkarDTO
{

	public function __construct(
		public string $trackID,
		public bool $result,
	) {
	}
}
