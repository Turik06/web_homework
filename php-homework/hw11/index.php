<?php
require_once 'db.php';
require_once 'Task.php';

$taskModel = new Task($dbo);

$action = $_GET['action'] ?? 'list';
$filter = $_GET['filter'] ?? 'current';
$filter_date = $_GET['date'] ?? null;

// Обработка данных формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!empty($_POST['action']) && $_POST['action'] === 'delete' && !empty($_POST['id'])) {
        $taskModel->deleteTask($_POST['id']);
    } else {
        if (!empty($_POST['task_date']) && !empty($_POST['task_time'])) {
            $_POST['task_datetime'] = $_POST['task_date'] . ' ' . $_POST['task_time'] . ':00';
        }

        if (!empty($_POST['id'])) {
            $taskModel->updateTask($_POST['id'], $_POST);
        } else {
            $taskModel->addTask($_POST);
        }
    }
    
    header('Location: index.php?filter=' . $filter);
    exit;
}

// Получение данных для редактирования
$editTask = null;
if ($action === 'edit' && !empty($_GET['id'])) {
    $editTask = $taskModel->getTaskById($_GET['id']);
}

// Выборка списка задач
$tasks = $taskModel->getTasks($filter, $filter_date);

// Подключение шаблона
include 'view.php';

