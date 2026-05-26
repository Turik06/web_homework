<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit;
}

$userId = (int)$_SESSION['user_id']; 

require_once 'config/db.php';
require_once 'models/Task.php';

$taskModel = new Task($dbo);

$action = $_GET['action'] ?? 'list';
$filter = $_GET['filter'] ?? 'current';
$filter_date = $_GET['date'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!empty($_POST['action']) && $_POST['action'] === 'delete' && !empty($_POST['id'])) {
        $taskModel->deleteTask((int)$_POST['id'], $userId);
    } else {
        if (!empty($_POST['task_date']) && !empty($_POST['task_time'])) {
            $_POST['task_datetime'] = $_POST['task_date'] . ' ' . $_POST['task_time'] . ':00';
        }

        if (!empty($_POST['id'])) {
            $taskModel->updateTask((int)$_POST['id'], $_POST, $userId);
        } else {
            $taskModel->addTask($_POST, $userId);
        }
    }
    
    
    header('Location: index.php?filter=' . $filter . ($filter_date ? '&date=' . $filter_date : ''));
    exit;
}


$editTask = null;
if ($action === 'edit' && !empty($_GET['id'])) {
    $editTask = $taskModel->getTaskById((int)$_GET['id'], $userId);
}

$tasks = $taskModel->getTasks($userId, $filter, $filter_date);

include 'views/calendar.php';