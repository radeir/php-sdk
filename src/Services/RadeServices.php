<?php

namespace Radeir\Services;

use Radeir\DTOs\CardToDepositDTO;
use Radeir\DTOs\CardToIbanDTO;
use Radeir\DTOs\DepositToIbanDTO;
use Radeir\DTOs\IbanInquiryDTO;
use Radeir\DTOs\IbanOwnerVerificationDTO;
use Radeir\DTOs\ShahkarDTO;
use Radeir\Services\TokenManager\DefaultTokenManager;
use Radeir\Services\TokenManager\TokenManagerInterface;

class RadeServices
{

	private TokenManagerInterface $tokenManager;

	private array $config;

	private ServiceFactory $serviceFactory;

	public function __construct(
		array                  $config,
		?TokenManagerInterface $tokenManager = null
	) {
		$this->config         = $config;
		$this->tokenManager   = $tokenManager ?? new DefaultTokenManager($config);
		$this->serviceFactory = new ServiceFactory($this->tokenManager, $this->config);
	}

	public function cardToIban(string $cardNumber): CardToIbanDTO {
		return $this->serviceFactory->createCardToIbanService()->cardToIban($cardNumber);
	}

	public function cardToDeposit(string $cardNumber): CardToDepositDTO {
		return $this->serviceFactory->createCardToDepositService()->cardToDeposit($cardNumber);
	}

	public function depositToIban(string $depositNumber, string $bankCode): DepositToIbanDTO {
		return $this->serviceFactory->createDepositToIbanService()->depositToIban($depositNumber, $bankCode);
	}

	public function depositToIbanBankList(): array {
		return $this->serviceFactory->createDepositToIbanService()->getBankList();
	}

	public function ibanInquiry(string $iban): IbanInquiryDTO {
		return $this->serviceFactory->createIbanInquiryService()->ibanInquiry($iban);
	}

	public function ibanOwnerVerification(
		string $iban,
		string $nationalityCode,
		string $birthDateYear,
		string $birthDateMonth,
		string $birthDateDay,
	): IbanOWnerVerificationDTO {
		return $this->serviceFactory->createIbanOwnerVerificationService()->ibanOwnerVerification(
			$iban,
			$nationalityCode,
			$birthDateYear,
			$birthDateMonth,
			$birthDateDay,
		);
	}

	public function shahkar(
		string $mobile,
		string $nationalityCode,
	): ShahkarDTO {
		return $this->serviceFactory->createShahkarService()->shahkar(
			$mobile,
			$nationalityCode,
		);
	}
}
