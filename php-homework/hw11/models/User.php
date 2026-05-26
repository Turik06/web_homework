<?php
class User {
    private PDO $dbo;

    public function __construct(PDO $dbo) {
        $this->dbo = $dbo;
    }

    public function register(string $username, string $password): bool {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            $stmt = $this->dbo->prepare("INSERT INTO `users` (`username`, `password_hash`) VALUES (:username, :password_hash)");
            return $stmt->execute([
                ':username' => $username,
                ':password_hash' => $hash
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function authenticate(string $username, string $password): int|false {
        $stmt = $this->dbo->prepare("SELECT `id`, `password_hash` FROM `users` WHERE `username` = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            return (int)$user['id'];
        }
        return false;
    }
}