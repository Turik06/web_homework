<?php

class Application {

    public $name;
    public $surname;
    public $email;
    public $phone;
    public $topic;
    public $payment;
    public $newsletter;
    public $date;
    public $ip;
    public $status;

    const FILENAME = 'applications.txt';
    const DELIMITER = '|';

    // Справочники для корректного отображения имен в админке 
    public static $topicsMap = [
        'business' => 'Бизнес',
        'tech' => 'Технологии',
        'marketing' => 'Реклама и Маркетинг'
    ];

    public static $paymentsMap = [
        'webmoney' => 'WebMoney',
        'yandex' => 'Яндекс.Деньги',
        'paypal' => 'PayPal',
        'card' => 'кредитная карта'
    ];

    public function __construct($data = []) {
        $this->name = trim($data['name'] ?? '');
        $this->surname = trim($data['surname'] ?? '');
        $this->email = trim($data['email'] ?? '');
        $this->phone = trim($data['phone'] ?? '');
        $this->topic = $data['topic'] ?? '';
        $this->payment = $data['payment'] ?? '';
        $this->newsletter = !empty($data['newsletter']) ? 'Да' : 'Нет';
        $this->date = date('Y-m-d H:i:s');
        $this->ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $this->status = 'active';
    }

    // Метод проверки заявки 
    public function validate() {
        $errors = [];
        if (empty($this->name)) $errors['name'] = 'Поле с именем обязательно к заполнению!';
        if (empty($this->surname)) $errors['surname'] = 'Поле с фамилией обязательно к заполнению!';
        if (empty($this->email)) $errors['email'] = 'Поле с email обязательно к заполнению!';
        if (empty($this->phone)) $errors['phone'] = 'Поле с телефоном обязательно к заполнению!';
        if (empty($this->topic)) $errors['topic'] = 'Выберите тематику!';
        if (empty($this->payment)) $errors['payment'] = 'Выберите метод оплаты!';
        return $errors;
    }

    // Метод сохранения в файловую систему
    public function save() {
        $data = [
            $this->date, $this->ip, $this->name, $this->surname, 
            $this->email, $this->phone, $this->topic, $this->payment, 
            $this->newsletter, $this->status
        ];
        $line = implode(self::DELIMITER, $data) . PHP_EOL;
        file_put_contents(self::FILENAME, $line, FILE_APPEND);
    }

    // Метод чтения заявок 
    public static function getAll() {
        $apps = [];
        if (file_exists(self::FILENAME)) {
            $lines = file(self::FILENAME, FILE_IGNORE_NEW_LINES);
            foreach ($lines as $idx => $line) {
                $data = explode(self::DELIMITER, $line);
                if (($data[9] ?? '') !== 'deleted') {
                    $apps[$idx] = $data;
                }
            }
        }
        return $apps;
    }

    public static function delete($indices) {
        if (!file_exists(self::FILENAME)) return;
        $lines = file(self::FILENAME);
        foreach ($indices as $idx) {
            if (isset($lines[$idx])) {
                $data = explode(self::DELIMITER, trim($lines[$idx]));
                $data[9] = 'deleted';
                $lines[$idx] = implode(self::DELIMITER, $data) . PHP_EOL;
            }
        }
        file_put_contents(self::FILENAME, implode('', $lines));
    }
}