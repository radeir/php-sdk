<?php

namespace Radeir\Services;

use Radeir\Enums\ServiceEnum;
use Radeir\Services\TokenManager\TokenManagerInterface;

class ServiceFactory
{

	private array $services = [];

	public function __construct(
		private TokenManagerInterface $tokenManager,
		private array                 $config
	) {
	}

	public function createCardToIbanService(): CardToIbanService {
		$serviceName = ServiceEnum::CARD_TO_IBAN->value;
		if (!isset($this->services[$serviceName])) {
			$this->services[$serviceName] = new CardToIbanService($this->tokenManager, $this->config);
		}

		return $this->services[$serviceName];
	}

	public function createCardToDepositService(): CardToDepositService {
		$serviceName = ServiceEnum::CARD_TO_DEPOSIT->value;
		if (!isset($this->services[$serviceName])) {
			$this->services[$serviceName] = new CardToDepositService($this->tokenManager, $this->config);
		}

		return $this->services[$serviceName];
	}

	public function createDepositToIbanService(): DepositToIbanService {
		$serviceName = ServiceEnum::DEPOSIT_TO_IBAN->value;
		if (!isset($this->services[$serviceName])) {
			$this->services[$serviceName] = new DepositToIbanService($this->tokenManager, $this->config);
		}

		return $this->services[$serviceName];
	}

	public function createIbanInquiryService(): IbanInquiryService {
		$serviceName = ServiceEnum::IBAN_INQUIRY->value;
		if (!isset($this->services[$serviceName])) {
			$this->services[$serviceName] = new IbanInquiryService($this->tokenManager, $this->config);
		}

		return $this->services[$serviceName];
	}

	public function createIbanOwnerVerificationService(): IbanOwnerVerificationService {
		$serviceName = ServiceEnum::IBAN_OWNER_VERIFICATION->value;
		if (!isset($this->services[$serviceName])) {
			$this->services[$serviceName] = new IbanOwnerVerificationService($this->tokenManager, $this->config);
		}

		return $this->services[$serviceName];
	}

	public function createShahkarService(): ShahkarService {
		$serviceName = ServiceEnum::SHAHKAR->value;
		if (!isset($this->services[$serviceName])) {
			$this->services[$serviceName] = new ShahkarService($this->tokenManager, $this->config);
		}

		return $this->services[$serviceName];
	}

}
