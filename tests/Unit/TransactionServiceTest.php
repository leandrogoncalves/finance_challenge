<?php

namespace Tests\Unit;

use App\Exceptions\TransactionException;
use App\Models\Balance;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\Contracts\TransactionServiceInterface;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Sets a protected property on a given object via reflection
     *
     * @param $object - instance in which protected value is being modified
     * @param $property - property on instance being modified
     * @param $value - new value of the property being modified
     *
     * @return void
     */
    public static function setProtectedProperty($className, $object, $property, $value)
    {
        $reflection = new \ReflectionClass($className);
        $reflection_property = $reflection->getProperty($property);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, $value);
    }

    public static function callProtectedMethod($obj, $name, array $args = []) {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }
    /**
     * Test of api method performTransaction from transaction service
     */
    public function testPerformTransactionsByService()
    {
        $service = app(TransactionService::class);

        $isTransactionSuccessfull = $service->performTransaction([
            'payer' => 2,
            'payee' => 1,
            'value' => 100.50,
        ]);

        $this->assertTrue($isTransactionSuccessfull);
    }

    public function testIfTransactionValueIsPositive()
    {
        $service = app(TransactionService::class);

        self::setProtectedProperty(TransactionService::class, $service, 'transactionValue', 100);

        $this->assertInstanceOf(
            TransactionServiceInterface::class,
            self::callProtectedMethod($service, 'checkPositiveValue')
        );
    }

    public function testIfPayerHasntEnoughBalance()
    {
        $service = app(TransactionService::class);

        self::setProtectedProperty(TransactionService::class, $service, 'transactionValue', 100);

        $payerMock = $this->mock(Wallet::class)->makePartial();
        $payerMock->shouldReceive('getAttribute')
            ->with('value')
            ->andReturn(100);
        $payerMock->shouldReceive(
            'getAttribute'
            , 'hasGetMutator'
            , 'getCasts'
            , 'getIncrementing'
            , 'getKeyName'
            , 'getKeyType'
            , 'getRelationValue'
            , 'relationLoaded'
        )->passthru();

        self::setProtectedProperty(TransactionService::class, $service, 'payer', $payerMock);

        $payeeBalanceMock = $this->getMockBuilder(Balance::class)
            ->disableOriginalConstructor()
            ->getMock();
        $payeeBalanceMock->value = 100;

        $payeeMock = $this->mock(Wallet::class)->makePartial();
        $payeeMock->shouldReceive('getAttribute')
            ->with('current_balance')
            ->andReturn($payeeBalanceMock);

        self::setProtectedProperty(TransactionService::class, $service, 'payee', $payeeMock);

        $this->expectException(TransactionException::class);
        self::callProtectedMethod($service, 'checkBalanceEnough');

        $this->assertInstanceOf(
            TransactionServiceInterface::class,
            self::callProtectedMethod($service, 'checkBalanceEnough')
        );
    }
}
