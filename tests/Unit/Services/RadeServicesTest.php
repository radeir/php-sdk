<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use Radeir\DTOs\CardToDepositDTO;
use Radeir\DTOs\CardToIbanDTO;
use Radeir\DTOs\DepositToIbanDTO;
use Radeir\DTOs\IbanInquiryDTO;
use Radeir\DTOs\IbanOwnerVerificationDTO;
use Radeir\DTOs\ShahkarDTO;
use Radeir\Services\CardToDepositService;
use Radeir\Services\CardToIbanService;
use Radeir\Services\DepositToIbanService;
use Radeir\Services\IbanInquiryService;
use Radeir\Services\IbanOwnerVerificationService;
use Radeir\Services\RadeServices;
use Radeir\Services\ServiceFactory;
use Radeir\Services\ShahkarService;
use Radeir\Services\TokenManager\TokenManagerInterface;

class RadeServicesTest extends TestCase
{
	public function testCardToIban()
	{
		// 1. Create the mocks
		$serviceFactory = $this->createMock(ServiceFactory::class);
		$cardToIbanService = $this->createMock(CardToIbanService::class);
		$tokenManager = $this->createMock(TokenManagerInterface::class);

		// 2. Configure mocks to avoid HTTP calls
		$serviceFactory->method('createCardToIbanService')
			->willReturn($cardToIbanService);

		// 3. Set up the expected return value
		$mockDTO = new CardToIbanDTO(
			'trace123',           // trackID
			'Test Bank',          // bankName
			'TEST_BANK',          // bankEnum
			'https://example.com/logo.png', // bankLogo
			'IR123456789012345678901234',  // iban
			'6104337812345678',   // cardNumber
			'0123456789',         // deposit
			'John Doe'            // owners
		);

		// 4. Configure service mock to return expected value
		$cardToIbanService->method('cardToIban')
			->with('6104337812345678')
			->willReturn($mockDTO);

		// 5. Create a test double for RadeServices
		$radeServices = $this->getMockBuilder(RadeServices::class)
			->setConstructorArgs([['baseUrl' => 'https://test.com'], $tokenManager])
			->onlyMethods(['__construct'])
			->getMock();

		// 6. Set the mocked service factory
		$reflection = new \ReflectionProperty(RadeServices::class, 'serviceFactory');
		$reflection->setAccessible(true);
		$reflection->setValue($radeServices, $serviceFactory);

		// 7. Test the method
		$result = $radeServices->cardToIban('6104337812345678');

		// 8. Assert the result
		$this->assertInstanceOf(CardToIbanDTO::class, $result);
		$this->assertEquals('trace123', $result->trackID);
		$this->assertEquals('Test Bank', $result->bankName);
		$this->assertEquals('IR123456789012345678901234', $result->iban);
		$this->assertEquals('6104337812345678', $result->cardNumber);
	}

	public function testCardToDeposit()
	{
		// 1. Create the mocks
		$serviceFactory = $this->createMock(ServiceFactory::class);
		$cardToDepositService = $this->createMock(CardToDepositService::class);
		$tokenManager = $this->createMock(TokenManagerInterface::class);

		// 2. Configure mocks to avoid HTTP calls
		$serviceFactory->method('createCardToDepositService')
			->willReturn($cardToDepositService);

		// 3. Set up the expected return value
		$mockDTO = new CardToDepositDTO(
			'trace456',           // trackID
			'Test Bank',          // bankName
			'TEST_BANK',          // bankEnum
			'https://example.com/logo.png', // bankLogo
			'0123456789',         // deposit
			'6104337812345678',   // destCard
			'John Doe'            // owners
		);

		// 4. Configure service mock to return expected value
		$cardToDepositService->method('cardToDeposit')
			->with('6104337812345678')
			->willReturn($mockDTO);

		// 5. Create a test double for RadeServices
		$radeServices = $this->getMockBuilder(RadeServices::class)
			->setConstructorArgs([['baseUrl' => 'https://test.com'], $tokenManager])
			->onlyMethods(['__construct'])
			->getMock();

		// 6. Set the mocked service factory
		$reflection = new \ReflectionProperty(RadeServices::class, 'serviceFactory');
		$reflection->setAccessible(true);
		$reflection->setValue($radeServices, $serviceFactory);

		// 7. Test the method
		$result = $radeServices->cardToDeposit('6104337812345678');

		// 8. Assert the result
		$this->assertInstanceOf(CardToDepositDTO::class, $result);
		$this->assertEquals('trace456', $result->trackID);
		$this->assertEquals('Test Bank', $result->bankName);
		$this->assertEquals('TEST_BANK', $result->bankEnum);
		$this->assertEquals('0123456789', $result->deposit);
	}

	public function testDepositToIban()
	{
		// 1. Create the mocks
		$serviceFactory = $this->createMock(ServiceFactory::class);
		$depositToIbanService = $this->createMock(DepositToIbanService::class);
		$tokenManager = $this->createMock(TokenManagerInterface::class);

		// 2. Configure mocks to avoid HTTP calls
		$serviceFactory->method('createDepositToIbanService')
			->willReturn($depositToIbanService);

		// 3. Set up the expected return value
		$mockDTO = new DepositToIbanDTO(
			'trace789',           // trackID
			'Test Bank',          // bankName
			'TEST_BANK',          // bankEnum
			'https://example.com/logo.png', // bankLogo
			'IR123456789012345678901234',  // iban
			'0123456789',         // deposit
			'John Doe'            // owners
		);

		// 4. Configure service mock to return expected value
		$depositToIbanService->method('depositToIban')
			->with('0123456789', 'TESTBANK')
			->willReturn($mockDTO);

		// 5. Create a test double for RadeServices
		$radeServices = $this->getMockBuilder(RadeServices::class)
			->setConstructorArgs([['baseUrl' => 'https://test.com'], $tokenManager])
			->onlyMethods(['__construct'])
			->getMock();

		// 6. Set the mocked service factory
		$reflection = new \ReflectionProperty(RadeServices::class, 'serviceFactory');
		$reflection->setAccessible(true);
		$reflection->setValue($radeServices, $serviceFactory);

		// 7. Test the method
		$result = $radeServices->depositToIban('0123456789', 'TESTBANK');

		// 8. Assert the result
		$this->assertInstanceOf(DepositToIbanDTO::class, $result);
		$this->assertEquals('trace789', $result->trackID);
		$this->assertEquals('Test Bank', $result->bankName);
		$this->assertEquals('IR123456789012345678901234', $result->iban);
		$this->assertEquals('0123456789', $result->deposit);
	}

	public function testDepositToIbanBankList()
	{
		// 1. Create the mocks
		$serviceFactory = $this->createMock(ServiceFactory::class);
		$depositToIbanService = $this->createMock(DepositToIbanService::class);
		$tokenManager = $this->createMock(TokenManagerInterface::class);

		// 2. Configure mocks to avoid HTTP calls
		$serviceFactory->method('createDepositToIbanService')
			->willReturn($depositToIbanService);

		// 3. Set up the expected return value
		$mockBankList = [
			[
				'name' => 'Test Bank 1',
				'code' => 'BANK1'
			],
			[
				'name' => 'Test Bank 2',
				'code' => 'BANK2'
			]
		];

		// 4. Configure service mock to return expected value
		$depositToIbanService->method('getBankList')
			->willReturn($mockBankList);

		// 5. Create a test double for RadeServices
		$radeServices = $this->getMockBuilder(RadeServices::class)
			->setConstructorArgs([['baseUrl' => 'https://test.com'], $tokenManager])
			->onlyMethods(['__construct'])
			->getMock();

		// 6. Set the mocked service factory
		$reflection = new \ReflectionProperty(RadeServices::class, 'serviceFactory');
		$reflection->setAccessible(true);
		$reflection->setValue($radeServices, $serviceFactory);

		// 7. Test the method
		$result = $radeServices->depositToIbanBankList();

		// 8. Assert the result
		$this->assertIsArray($result);
		$this->assertCount(2, $result);
		$this->assertEquals('Test Bank 1', $result[0]['name']);
		$this->assertEquals('BANK1', $result[0]['code']);
		$this->assertEquals('Test Bank 2', $result[1]['name']);
		$this->assertEquals('BANK2', $result[1]['code']);
	}

	public function testIbanInquiry()
	{
		// 1. Create the mocks
		$serviceFactory = $this->createMock(ServiceFactory::class);
		$ibanInquiryService = $this->createMock(IbanInquiryService::class);
		$tokenManager = $this->createMock(TokenManagerInterface::class);

		// 2. Configure mocks to avoid HTTP calls
		$serviceFactory->method('createIbanInquiryService')
			->willReturn($ibanInquiryService);

		// 3. Set up the expected return value
		$mockDTO = new IbanInquiryDTO(
			'trace012',           // trackID
			'Test Bank',          // bankName
			'TEST_BANK',          // bankEnum
			'https://example.com/logo.png', // bankLogo
			'John Doe',           // owners
			null,                 // depositComment (optional)
			null                  // depositDescription (optional)
		);

		// 4. Configure service mock to return expected value
		$ibanInquiryService->method('ibanInquiry')
			->with('IR123456789012345678901234')
			->willReturn($mockDTO);

		// 5. Create a test double for RadeServices
		$radeServices = $this->getMockBuilder(RadeServices::class)
			->setConstructorArgs([['baseUrl' => 'https://test.com'], $tokenManager])
			->onlyMethods(['__construct'])
			->getMock();

		// 6. Set the mocked service factory
		$reflection = new \ReflectionProperty(RadeServices::class, 'serviceFactory');
		$reflection->setAccessible(true);
		$reflection->setValue($radeServices, $serviceFactory);

		// 7. Test the method
		$result = $radeServices->ibanInquiry('IR123456789012345678901234');

		// 8. Assert the result
		$this->assertInstanceOf(IbanInquiryDTO::class, $result);
		$this->assertEquals('trace012', $result->trackID);
		$this->assertEquals('Test Bank', $result->bankName);
		$this->assertEquals('John Doe', $result->owners);
	}

	public function testIbanOwnerVerification()
	{
		// 1. Create the mocks
		$serviceFactory = $this->createMock(ServiceFactory::class);
		$ibanOwnerVerificationService = $this->createMock(IbanOwnerVerificationService::class);
		$tokenManager = $this->createMock(TokenManagerInterface::class);

		// 2. Configure mocks to avoid HTTP calls
		$serviceFactory->method('createIbanOwnerVerificationService')
			->willReturn($ibanOwnerVerificationService);

		// 3. Set up the expected return value
		$mockDTO = new IbanOwnerVerificationDTO(
			'trace345',           // trackID
			'yes'                 // result ('yes', 'no', or 'most_possible')
		);

		// 4. Configure service mock to return expected value
		$ibanOwnerVerificationService->method('ibanOwnerVerification')
			->with(
				'IR123456789012345678901234',
				'0082633053',
				'1370',
				'03',
				'05'
			)
			->willReturn($mockDTO);

		// 5. Create a test double for RadeServices
		$radeServices = $this->getMockBuilder(RadeServices::class)
			->setConstructorArgs([['baseUrl' => 'https://test.com'], $tokenManager])
			->onlyMethods(['__construct'])
			->getMock();

		// 6. Set the mocked service factory
		$reflection = new \ReflectionProperty(RadeServices::class, 'serviceFactory');
		$reflection->setAccessible(true);
		$reflection->setValue($radeServices, $serviceFactory);

		// 7. Test the method
		$result = $radeServices->ibanOwnerVerification(
			'IR123456789012345678901234',
			'0082633053',
			'1370',
			'03',
			'05'
		);

		// 8. Assert the result
		$this->assertInstanceOf(IbanOwnerVerificationDTO::class, $result);
		$this->assertEquals('trace345', $result->trackID);
		$this->assertEquals('yes', $result->result);
	}
	public function testShahkar()
	{
		// 1. Create the mocks
		$serviceFactory = $this->createMock(ServiceFactory::class);
		$ibanOwnerVerificationService = $this->createMock(ShahkarService::class);
		$tokenManager = $this->createMock(TokenManagerInterface::class);

		// 2. Configure mocks to avoid HTTP calls
		$serviceFactory->method('createShahkarService')->willReturn($ibanOwnerVerificationService);

		// 3. Set up the expected return value
		$mockDTO = new ShahkarDTO('trace345', true);

		// 4. Configure service mock to return expected value
		$ibanOwnerVerificationService->method('shahkar')->with('09123456789', '0082633053',)->willReturn($mockDTO);

		// 5. Create a test double for RadeServices
		$radeServices = $this->getMockBuilder(RadeServices::class)
			->setConstructorArgs([['baseUrl' => 'https://test.com'], $tokenManager])
			->onlyMethods(['__construct'])
			->getMock();

		// 6. Set the mocked service factory
		$reflection = new \ReflectionProperty(RadeServices::class, 'serviceFactory');
		$reflection->setAccessible(true);
		$reflection->setValue($radeServices, $serviceFactory);

		// 7. Test the method
		$result = $radeServices->shahkar('09123456789', '0082633053');

		// 8. Assert the result
		$this->assertInstanceOf(ShahkarDTO::class, $result);
		$this->assertEquals('trace345', $result->trackID);
		$this->assertEquals(true, $result->result);
	}

	public function testConstructorWithCustomTokenManager()
	{
		// Create a mock token manager
		$tokenManager = $this->createMock(TokenManagerInterface::class);

		// Create an instance of RadeServices with the mock token manager
		$radeServices = new RadeServices(['baseUrl' => 'https://test.com'], $tokenManager);

		// Get the tokenManager property using reflection
		$reflection = new \ReflectionProperty(RadeServices::class, 'tokenManager');
		$reflection->setAccessible(true);
		$actualTokenManager = $reflection->getValue($radeServices);

		// Assert that the token manager is the one we provided
		$this->assertSame($tokenManager, $actualTokenManager);
	}
}
