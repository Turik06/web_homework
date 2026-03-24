<?php
interface TransactionInterface {
    public function deposit($amount);
    public function withdraw($amount);
}

trait LoggerTrait {
    protected $logs = [];

    public function log_operation($message) {
        $this->logs[] = $message;
        echo "[LOG]: " . $message . "<br/>\n";
    }

    public function get_logs() {
        return $this->logs;
    }
}

class BankAccount {
    public $ownerName;
    protected $balance;
    private $secretPin;
    
    const CURRENCY = 'RUB';

    public function __construct($ownerName, $initialBalance, $pin) {
        $this->ownerName = $ownerName;
        $this->balance = $initialBalance; 
        $this->secretPin = $pin;
    }

    public function get_balance() {
        return $this->balance . ' ' . static::CURRENCY;
    }

    public function change_pin($oldPin, $newPin) {
        if ($this->secretPin === $oldPin) {
            $this->secretPin = $newPin;
            echo "Успешно: PIN-код обновлен.<br/>\n";
        } else {
            echo "Неверный старый PIN-код.<br/>\n";
        }
    }
}

class CreditAccount extends BankAccount implements TransactionInterface {
    
    use LoggerTrait;

    public $creditLimit;

    public function __construct($ownerName, $initialBalance, $pin, $creditLimit) {
        parent::__construct($ownerName, $initialBalance, $pin);
        $this->creditLimit = $creditLimit;
    }

    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            $this->log_operation("Пополнение на $amount. Баланс: {$this->get_balance()}");
        }
    }

    public function withdraw($amount) {
        $availableFunds = $this->balance + $this->creditLimit;

        if ($amount <= $availableFunds) {
            $this->balance -= $amount;
            $this->log_operation("Снятие $amount. Баланс: {$this->get_balance()}");
        } else {
            $this->log_operation("Недостаточно средств для снятия $amount");
        }
    }

    public function get_info() {
        return "Клиент: {$this->ownerName} | Баланс: {$this->get_balance()} | Лимит: {$this->creditLimit} " . static::CURRENCY . "<br/>\n";
    }
}

echo "<h3>Работа с базовым классом</h3>\n";
$baseAcc = new BankAccount('Турал Сулейманов', 1000, 1234);
echo "Владелец: " . $baseAcc->ownerName . "<br/>\n";
echo "Баланс: " . $baseAcc->get_balance() . "<br/>\n";

$baseAcc->change_pin(1234, 4321); 

echo "<h3>Работа с наследником (Кредитный счет)</h3>\n";
$creditAcc = new CreditAccount('Александр Шеметов', 500, 8888, 2000);
echo $creditAcc->get_info();

$creditAcc->withdraw(1000); 
$creditAcc->deposit(200);   
$creditAcc->withdraw(5000); 

echo "<br/><b>История операций:</b><br/>\n";
foreach ($creditAcc->get_logs() as $entry) {
    echo "- " . $entry . "<br/>\n";
}