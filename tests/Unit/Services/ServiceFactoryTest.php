<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use Radeir\Enums\ServiceEnum;
use Radeir\Services\CardToDepositService;
use Radeir\Services\CardToIbanService;
use Radeir\Services\DepositToIbanService;
use Radeir\Services\IbanInquiryService;
use Radeir\Services\IbanOwnerVerificationService;
use Radeir\Services\ServiceFactory;
use Radeir\Services\ShahkarService;
use Radeir\Services\TokenManager\TokenManagerInterface;

class ServiceFactoryTest extends TestCase
{
	private $tokenManager;
	private $config;
	private $serviceFactory;

	protected function setUp(): void
	{
		parent::setUp();

		// Create a mock for TokenManagerInterface
		$this->tokenManager = $this->createMock(TokenManagerInterface::class);

		// Sample configuration
		$this->config = [
			'baseUrl' => 'https://api.example.com'
		];

		// Create the ServiceFactory instance to test
		$this->serviceFactory = new ServiceFactory($this->tokenManager, $this->config);
	}

	public function testCreateCardToIbanService()
	{
		// Test that the service is created with correct type
		$service1 = $this->serviceFactory->createCardToIbanService();
		$this->assertInstanceOf(CardToIbanService::class, $service1);

		// Test that the same instance is returned when called again (caching works)
		$service2 = $this->serviceFactory->createCardToIbanService();
		$this->assertSame($service1, $service2, 'Factory should return the same instance on subsequent calls');
	}

	public function testCreateCardToDepositService()
	{
		// Test that the service is created with correct type
		$service1 = $this->serviceFactory->createCardToDepositService();
		$this->assertInstanceOf(CardToDepositService::class, $service1);

		// Test that the same instance is returned when called again (caching works)
		$service2 = $this->serviceFactory->createCardToDepositService();
		$this->assertSame($service1, $service2, 'Factory should return the same instance on subsequent calls');
	}

	public function testCreateDepositToIbanService()
	{
		// Test that the service is created with correct type
		$service1 = $this->serviceFactory->createDepositToIbanService();
		$this->assertInstanceOf(DepositToIbanService::class, $service1);

		// Test that the same instance is returned when called again (caching works)
		$service2 = $this->serviceFactory->createDepositToIbanService();
		$this->assertSame($service1, $service2, 'Factory should return the same instance on subsequent calls');
	}

	public function testCreateIbanInquiryService()
	{
		// Test that the service is created with correct type
		$service1 = $this->serviceFactory->createIbanInquiryService();
		$this->assertInstanceOf(IbanInquiryService::class, $service1);

		// Test that the same instance is returned when called again (caching works)
		$service2 = $this->serviceFactory->createIbanInquiryService();
		$this->assertSame($service1, $service2, 'Factory should return the same instance on subsequent calls');
	}

	public function testCreateIbanOwnerVerificationService()
	{
		// Test that the service is created with correct type
		$service1 = $this->serviceFactory->createIbanOwnerVerificationService();
		$this->assertInstanceOf(IbanOwnerVerificationService::class, $service1);

		// Test that the same instance is returned when called again (caching works)
		$service2 = $this->serviceFactory->createIbanOwnerVerificationService();
		$this->assertSame($service1, $service2, 'Factory should return the same instance on subsequent calls');
	}

	public function testCreateShahkarService()
	{
		// Test that the service is created with correct type
		$service1 = $this->serviceFactory->createShahkarService();
		$this->assertInstanceOf(ShahkarService::class, $service1);

		// Test that the same instance is returned when called again (caching works)
		$service2 = $this->serviceFactory->createShahkarService();
		$this->assertSame($service1, $service2, 'Factory should return the same instance on subsequent calls');
	}

	public function testDifferentServicesReturnDifferentInstances()
	{
		// Test that different service types return different instances
		$cardToIban = $this->serviceFactory->createCardToIbanService();
		$cardToDeposit = $this->serviceFactory->createCardToDepositService();
		$depositToIban = $this->serviceFactory->createDepositToIbanService();
		$ibanInquiry = $this->serviceFactory->createIbanInquiryService();
		$ibanOwnerVerification = $this->serviceFactory->createIbanOwnerVerificationService();

		// Assert that each service is a different instance
		$this->assertNotSame($cardToIban, $cardToDeposit, 'Different service types should return different instances');
		$this->assertNotSame($cardToIban, $depositToIban, 'Different service types should return different instances');
		$this->assertNotSame($cardToIban, $ibanInquiry, 'Different service types should return different instances');
		$this->assertNotSame($cardToIban, $ibanOwnerVerification, 'Different service types should return different instances');
		$this->assertNotSame($cardToDeposit, $depositToIban, 'Different service types should return different instances');
		$this->assertNotSame($cardToDeposit, $ibanInquiry, 'Different service types should return different instances');
		$this->assertNotSame($cardToDeposit, $ibanOwnerVerification, 'Different service types should return different instances');
		$this->assertNotSame($depositToIban, $ibanInquiry, 'Different service types should return different instances');
		$this->assertNotSame($depositToIban, $ibanOwnerVerification, 'Different service types should return different instances');
		$this->assertNotSame($ibanInquiry, $ibanOwnerVerification, 'Different service types should return different instances');
	}

	public function testServiceEnumValuesMatchFactoryKeys()
	{
		// Create services
		$cardToIban = $this->serviceFactory->createCardToIbanService();
		$cardToDeposit = $this->serviceFactory->createCardToDepositService();
		$depositToIban = $this->serviceFactory->createDepositToIbanService();
		$ibanInquiry = $this->serviceFactory->createIbanInquiryService();
		$ibanOwnerVerification = $this->serviceFactory->createIbanOwnerVerificationService();

		// Use reflection to access private property 'services'
		$reflectionClass = new \ReflectionClass(ServiceFactory::class);
		$servicesProperty = $reflectionClass->getProperty('services');
		$servicesProperty->setAccessible(true);
		$services = $servicesProperty->getValue($this->serviceFactory);

		// Verify that the services are stored with the correct ServiceEnum keys
		$this->assertArrayHasKey(ServiceEnum::CARD_TO_IBAN->value, $services);
		$this->assertArrayHasKey(ServiceEnum::CARD_TO_DEPOSIT->value, $services);
		$this->assertArrayHasKey(ServiceEnum::DEPOSIT_TO_IBAN->value, $services);
		$this->assertArrayHasKey(ServiceEnum::IBAN_INQUIRY->value, $services);
		$this->assertArrayHasKey(ServiceEnum::IBAN_OWNER_VERIFICATION->value, $services);

		// Verify that the stored services are the same instances we got from the factory
		$this->assertSame($cardToIban, $services[ServiceEnum::CARD_TO_IBAN->value]);
		$this->assertSame($cardToDeposit, $services[ServiceEnum::CARD_TO_DEPOSIT->value]);
		$this->assertSame($depositToIban, $services[ServiceEnum::DEPOSIT_TO_IBAN->value]);
		$this->assertSame($ibanInquiry, $services[ServiceEnum::IBAN_INQUIRY->value]);
		$this->assertSame($ibanOwnerVerification, $services[ServiceEnum::IBAN_OWNER_VERIFICATION->value]);
	}
}
