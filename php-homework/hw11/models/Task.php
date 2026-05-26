<?php
class Task {
    private PDO $dbo;

    public function __construct(PDO $dbo) {
        $this->dbo = $dbo;
    }

    public function getTasks(int $userId, string $filter = 'current', ?string $date = null): array {
        $sql = "SELECT * FROM `tasks` WHERE `user_id` = :user_id";
        $params = [':user_id' => $userId];

        if ($filter === 'current') {
            $sql .= " AND `status` = 'Текущая' AND `task_datetime` >= NOW()";
        } elseif ($filter === 'overdue') {
            $sql .= " AND `status` = 'Текущая' AND `task_datetime` < NOW()";
        } elseif ($filter === 'completed') {
            $sql .= " AND `status` = 'Выполнена'";
        } elseif ($filter === 'date' && $date) {
            $sql .= " AND DATE(`task_datetime`) = :date";
            $params[':date'] = $date;
        } elseif ($filter === 'this_week') {
            $sql .= " AND YEARWEEK(`task_datetime`, 1) = YEARWEEK(CURDATE(), 1)";
        } elseif ($filter === 'next_week') {
            $sql .= " AND YEARWEEK(`task_datetime`, 1) = YEARWEEK(CURDATE() + INTERVAL 1 WEEK, 1)";
        }

        $sql .= " ORDER BY `task_datetime` ASC";

        $stmt = $this->dbo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTaskById(int $id, int $userId): array|false {
        $stmt = $this->dbo->prepare("SELECT * FROM `tasks` WHERE `id` = :id AND `user_id` = :user_id LIMIT 1");
        $stmt->execute([':id' => $id, ':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTask(array $data, int $userId): bool {
        $stmt = $this->dbo->prepare("INSERT INTO `tasks` (`user_id`, `theme`, `type`, `place`, `task_datetime`, `duration`, `comment`) VALUES (:user_id, :theme, :type, :place, :task_datetime, :duration, :comment)");
        return $stmt->execute([
            ':user_id' => $userId,
            ':theme' => $data['theme'],
            ':type' => $data['type'],
            ':place' => $data['place'],
            ':task_datetime' => $data['task_datetime'],
            ':duration' => $data['duration'],
            ':comment' => $data['comment']
        ]);
    }

    public function updateTask(int $id, array $data, int $userId): bool {
        $stmt = $this->dbo->prepare("UPDATE `tasks` SET `theme` = :theme, `type` = :type, `place` = :place, `task_datetime` = :task_datetime, `duration` = :duration, `comment` = :comment, `status` = :status WHERE `id` = :id AND `user_id` = :user_id LIMIT 1");
        return $stmt->execute([
            ':theme' => $data['theme'],
            ':type' => $data['type'],
            ':place' => $data['place'],
            ':task_datetime' => $data['task_datetime'],
            ':duration' => $data['duration'],
            ':comment' => $data['comment'],
            ':status' => $data['status'],
            ':id' => $id,
            ':user_id' => $userId
        ]);
    }

    public function deleteTask(int $id, int $userId): bool {
        $stmt = $this->dbo->prepare("DELETE FROM `tasks` WHERE `id` = :id AND `user_id` = :user_id LIMIT 1");
        return $stmt->execute([':id' => $id, ':user_id' => $userId]);
    }
}