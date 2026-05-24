<?php

class Application {

    public $name;
    public $surname;
    public $email;
    public $phone;
    public $topic;
    public $payment;
    public $newsletter;

    public static $topicsMap = [
        1 => 'Бизнес и коммуникации',
        2 => 'Технологии',
        3 => 'Реклама',
        4 => 'Маркетинг',
        5 => 'Проектирование'
    ];

    public static $paymentsMap = [
        1 => 'WebMoney',
        2 => 'Яндекс.Деньги',
        3 => 'PayPal',
        4 => 'Кредитная карта',
        5 => 'Робокасса'
    ];

    public function __construct($data = []) {
        $this->name = trim($data['name'] ?? '');
        $this->surname = trim($data['surname'] ?? '');
        $this->email = trim($data['email'] ?? '');
        $this->phone = trim($data['phone'] ?? '');
        $this->topic = (int)($data['topic'] ?? 0);
        $this->payment = (int)($data['payment'] ?? 0);
        $this->newsletter = !empty($data['newsletter']) ? 1 : 0;
    }

    public function validate() {
        $errors = [];
        if (empty($this->name)) $errors['name'] = 'Поле с именем обязательно к заполнению!';
        if (empty($this->surname)) $errors['surname'] = 'Поле с фамилией обязательно к заполнению!';
        if (empty($this->email)) $errors['email'] = 'Поле с email обязательно к заполнению!';
        if (empty($this->phone)) $errors['phone'] = 'Поле с телефоном обязательно к заполнению!';
        if (empty($this->topic) || !isset(self::$topicsMap[$this->topic])) $errors['topic'] = 'Выберите корректную тематику!';
        if (empty($this->payment) || !isset(self::$paymentsMap[$this->payment])) $errors['payment'] = 'Выберите корректный метод оплаты!';
        return $errors;
    }

    // Сохранение в базу данных
    public function save($pdo) {
        $sql = "INSERT INTO participants (name, lastname, email, tel, subject, payment, mailing) 
                VALUES (:name, :lastname, :email, :tel, :subject, :payment, :mailing)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $this->name,
            ':lastname' => $this->surname,
            ':email' => $this->email,
            ':tel' => $this->phone,
            ':subject' => $this->topic,
            ':payment' => $this->payment,
            ':mailing' => $this->newsletter
        ]);
    }

    // Чтение активных заявок 
    public static function getAll($pdo) {
        $sql = "SELECT * FROM participants WHERE deleted_at IS NULL ORDER BY created_at DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    // Мягкое удаление 
    public static function delete($pdo, $ids) {
        if (empty($ids)) return;
        
        $inQuery = implode(',', array_fill(0, count($ids), '?'));
        $sql = "UPDATE participants SET deleted_at = NOW() WHERE id IN ($inQuery)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($ids);
    }
}