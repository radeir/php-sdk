<?php

namespace Radeir\Services;

use Radeir\DTOs\ShahkarDTO;
use Radeir\Enums\ServiceEnum;
use Radeir\Exceptions\RadeException;
use Radeir\Rules\MobileValidationRule;
use Radeir\Rules\NationalityCodeValidationRule;
use Radeir\Services\TokenManager\TokenManagerInterface;
use Throwable;

class ShahkarService extends AbstractServices
{
	public function __construct(
		TokenManagerInterface $tokenManager,
		array                 $config
	) {
		parent::__construct($tokenManager, $config);
	}

	public function shahkar(string $mobile, string $nationalityCode): ShahkarDTO {
		try {
			$nationalityCode = NationalityCodeValidationRule::passes($nationalityCode);
			$mobile          = MobileValidationRule::passes($mobile);

			$response = $this->makeRequest('POST', '/service/shahkar', [
				'json' => [
					'mobile' => $mobile,
					'nid'    => $nationalityCode
				]
			]);

			$data = json_decode($response->getBody()->getContents(), true);
			if (isset($data['data']['result'])) {
				return new ShahkarDTO(
					$data['data']['RadeTraceID'],
					$data['data']['result']
				);
			}

			throw new RadeException('Invalid Response');
		} catch (Throwable $throwable) {
			throw $this->handleRequestException($throwable, ServiceEnum::SHAHKAR);
		}
	}
}
