<?php

namespace Radeir\Enums;

enum ServiceEnum: string
{

	case CARD_TO_IBAN = 'cardToIban';
	case CARD_TO_DEPOSIT = 'cardToDeposit';
	case DEPOSIT_TO_IBAN = 'depositToIban';
	case DEPOSIT_TO_IBAN_BANK_LIST = 'depositToIbanBankList';
	case IBAN_INQUIRY = 'ibanInquiry';
	case IBAN_OWNER_VERIFICATION = 'ibanOwnerVerification';
	case SHAHKAR = 'shahkar';
}
