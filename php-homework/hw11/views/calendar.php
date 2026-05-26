<?php
/**
 * @var string $filter
 * @var string|null $filter_date
 * @var array|null $editTask
 * @var array $tasks
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Мой календарь</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #fff; color: #000; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; border: 2px solid #000; padding: 20px; }
        fieldset { border: 2px solid #000; padding: 20px; margin-bottom: 20px; }
        legend { font-weight: bold; padding: 0 5px; }
        .form-row { margin-bottom: 15px; display: flex; align-items: flex-start; }
        .form-row label { width: 150px; text-align: right; padding-right: 15px; margin-top: 5px; }
        .form-row input[type="text"], .form-row select, .form-row textarea { 
            border: 2px solid #000; padding: 5px; font-family: inherit; width: 300px; 
        }
        .form-row textarea { resize: vertical; }
        .submit-btn { border: 2px solid #000; background: #fff; padding: 5px 20px; margin-left: 165px; cursor: pointer; }
        .filter-nav { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
        .filter-nav a { text-decoration: none; color: #0066cc; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-left: 1px solid #000; border-right: 1px solid #000; }
        th { border-bottom: 2px solid #000; font-weight: normal; }
        tr:nth-child(even) { background-color: #f0f0f0; }
        .delete-btn { border: 2px solid #000; background: #ffcccc; padding: 5px 20px; cursor: pointer; margin-left: 10px; }
        .btn-group { margin-left: 165px; margin-top: 20px; }
    </style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="margin: 0;">Мой календарь</h1>
        <a href="auth.php?action=logout" style="color: red; text-decoration: none; border: 2px solid red; padding: 5px 15px; font-weight: bold; background: #fff;">Выйти</a>
    </div>

    <fieldset>
        <legend><?= isset($editTask) ? 'Редактировать задачу' : 'Новая задача' ?></legend>
        <form method="POST" action="index.php?filter=<?= htmlspecialchars($filter) ?>">
            <?php if (isset($editTask)): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($editTask['id']) ?>">
            <?php endif; ?>

            <div class="form-row">
                <label>Тема:</label>
                <input type="text" name="theme" value="<?= htmlspecialchars($editTask['theme'] ?? '') ?>" required>
            </div>
            
            <div class="form-row">
                <label>Тип:</label>
                <select name="type">
                    <?php foreach (['Встреча', 'Звонок', 'Совещание', 'Дело'] as $type): ?>
                        <option value="<?= $type ?>" <?= (isset($editTask) && $editTask['type'] === $type) ? 'selected' : '' ?>><?= $type ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-row">
                <label>Место:</label>
                <input type="text" name="place" value="<?= htmlspecialchars($editTask['place'] ?? '') ?>">
            </div>

            <div class="form-row">
                <label>Дата и время:</label>
                <div style="display: flex; gap: 10px;">
                    <input type="date" name="task_date" style="border: 2px solid #000; padding: 5px; font-family: inherit; width: 145px;" value="<?= isset($editTask) ? date('Y-m-d', strtotime($editTask['task_datetime'])) : date('Y-m-d') ?>" required>
                    <input type="time" name="task_time" style="border: 2px solid #000; padding: 5px; font-family: inherit; width: 100px;" value="<?= isset($editTask) ? date('H:i', strtotime($editTask['task_datetime'])) : date('H:i') ?>" required>
                </div>
            </div>

            <div class="form-row">
                <label>Длительность:</label>
                <input type="text" name="duration" value="<?= htmlspecialchars($editTask['duration'] ?? '1 час') ?>">
            </div>

            <div class="form-row">
                <label>Комментарий:</label>
                <textarea name="comment" rows="4"><?= htmlspecialchars($editTask['comment'] ?? '') ?></textarea>
            </div>

            <?php if (isset($editTask)): ?>
            <div class="form-row">
                <label>Статус:</label>
                <select name="status">
                    <option value="Текущая" <?= $editTask['status'] === 'Текущая' ? 'selected' : '' ?>>Текущая</option>
                    <option value="Выполнена" <?= $editTask['status'] === 'Выполнена' ? 'selected' : '' ?>>Выполнена</option>
                </select>
            </div>
            <?php endif; ?>
            
            <div class="form-row btn-group" style="margin-left: 165px;">
                <button type="submit" class="submit-btn" style="margin-left: 0;"><?= isset($editTask) ? 'Сохранить' : 'Добавить' ?></button>
                
                <?php if (isset($editTask)): ?>
                    <button type="submit" name="action" value="delete" class="delete-btn" formnovalidate onclick="return confirm('Вы уверены, что хотите удалить эту задачу?');">Удалить</button>
                    
                    <a href="index.php?filter=<?= htmlspecialchars($filter) ?>" style="margin-left:15px; margin-top: 5px;">Отмена</a>
                <?php endif; ?>
            </div>

        </form>
    </fieldset>

    <fieldset>
        <legend>Список задач</legend>
        
        <div class="filter-nav">
            <select onchange="location = this.value;">
                <option value="index.php?filter=current" <?= $filter === 'current' ? 'selected' : '' ?>>Текущие задачи</option>
                <option value="index.php?filter=overdue" <?= $filter === 'overdue' ? 'selected' : '' ?>>Просроченные задачи</option>
                <option value="index.php?filter=completed" <?= $filter === 'completed' ? 'selected' : '' ?>>Выполненные задачи</option>
            </select>

            <form method="GET" action="index.php" style="display:inline;">
                <input type="hidden" name="filter" value="date">
                <input type="date" name="date" value="<?= htmlspecialchars($filter_date ?? date('Y-m-d')) ?>" onchange="this.form.submit()">
            </form>

            <?php 
                $today = date('Y-m-d');
                $tomorrow = date('Y-m-d', strtotime('+1 day'));
            ?>

            <a href="index.php?filter=date&date=<?= $today ?>" <?= ($filter === 'date' && $filter_date === $today) ? 'style="color:#000; text-decoration:none;"' : '' ?>>сегодня</a> 
            <span style="margin: 0 5px; font-weight: bold;">|</span> 

            <a href="index.php?filter=date&date=<?= $tomorrow ?>" <?= ($filter === 'date' && $filter_date === $tomorrow) ? 'style="color:#000; text-decoration:none;"' : '' ?>>завтра</a> 
            <span style="margin: 0 5px; font-weight: bold;">|</span> 
            
            <a href="index.php?filter=this_week" <?= $filter === 'this_week' ? 'style="color:#000; text-decoration:none;"' : '' ?>>на эту неделю</a> 
            <span style="margin: 0 5px; font-weight: bold;">|</span> 
            
            <a href="index.php?filter=next_week" <?= $filter === 'next_week' ? 'style="color:#000; text-decoration:none;"' : '' ?>>на след. неделю</a>

        </div>

        <table>
            <thead>
                <tr>
                    <th>Тип</th>
                    <th>Задача</th>
                    <th>Место</th>
                    <th>Дата и время</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tasks)): ?>
                    <tr><td colspan="4" style="text-align:center;">Нет задач для отображения</td></tr>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?= htmlspecialchars($task['type']) ?></td>
                            <td><a href="index.php?action=edit&id=<?= $task['id'] ?>&filter=<?= htmlspecialchars($filter) ?>"><?= htmlspecialchars($task['theme']) ?></a></td>
                            <td><?= htmlspecialchars($task['place'] ?: '-') ?></td>
                            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($task['task_datetime']))) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </fieldset>
</div>

</body>
</html>