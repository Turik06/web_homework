<?php


interface TransactionInterface {
    public function deposit($amount);
    public function withdraw($amount);
}


trait LoggerTrait {
    protected $logs = [];

    public function logOperation($message) {
        $this->logs[] = $message;
        echo "[LOG]: " . $message . "<br/>";
    }

    public function getLogs() {
        return $this->logs;
    }
}

class BankAccount {
    public $ownerName;
    protected $balance;
    
    private $secretPin;

    public function __construct($ownerName, $initialBalance, $pin) {
        $this->ownerName = $ownerName;
        $this->balance = (float)$initialBalance; 
        $this->secretPin = (int)$pin;
    }

    // Метод для чтения защищенного свойства
    public function getBalance() {
        return $this->balance;
    }

    public function changePin($oldPin, $newPin) {
        if ($this->secretPin === (int)$oldPin) {
            $this->secretPin = (int)$newPin;
            echo "Успешно: PIN-код обновлен.<br/>";
        } else {
            echo "Ошибка: Неверный старый PIN-код.<br/>";
        }
    }
}

class CreditAccount extends BankAccount implements TransactionInterface {
    
    use LoggerTrait;

    protected $creditLimit;

    public function __construct($ownerName, $initialBalance, $pin, $creditLimit) {
        parent::__construct($ownerName, $initialBalance, $pin);
        $this->creditLimit = (float)$creditLimit;
    }

    public function deposit($amount) {
        $amount = (float)$amount;
        if ($amount > 0) {
            $this->balance += $amount;
            $this->logOperation("Пополнение на $amount. Новый баланс: $this->balance");
        }
    }

    public function withdraw($amount) {
        $amount = (float)$amount;
        $availableFunds = $this->balance + $this->creditLimit;

        if ($amount <= $availableFunds) {
            $this->balance -= $amount;
            $this->logOperation("Снятие $amount. Новый баланс: $this->balance");
        } else {
            $this->logOperation("ОШИБКА: Превышен кредитный лимит при попытке снять $amount!");
        }
    }

    public function getAccountInfo() {
        return "Счет клиента: {$this->ownerName} | Текущий Баланс: {$this->balance} | Доступный лимит: {$this->creditLimit}<br/>";
    }
}


echo "<h3>Банковский Счет</h3>";
$baseAcc = new BankAccount('Tural Great', 1000, 1234);
echo "Владелец: " . $baseAcc->ownerName . "<br/>";
echo "Баланс: " . $baseAcc->getBalance() . "<br/>";

$baseAcc->changePin(9999, 4321); 
$baseAcc->changePin(1234, 4321); 

echo "<h3>=== Кредитный Счет (наследник) ===</h3>";
$creditAcc = new CreditAccount('Mary Smith', 500, 8888, 2000);
echo $creditAcc->getAccountInfo();


$creditAcc->withdraw(1000); 
$creditAcc->deposit(200);  
$creditAcc->withdraw(3000); 

echo "<br/><b>История операций из трейта:</b><br/>";
$logs = $creditAcc->getLogs();
foreach ($logs as $i => $log) {
    echo ($i + 1) . '. ' . $log . "<br/>";
}
