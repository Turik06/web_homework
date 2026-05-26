<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Регистрация - Мой календарь</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #fff; padding: 20px; }
        .container { max-width: 400px; margin: 50px auto; border: 2px solid #000; padding: 20px; }
        .form-row { margin-bottom: 15px; }
        .form-row label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-row input { width: 100%; border: 2px solid #000; padding: 8px; box-sizing: border-box; }
        .submit-btn { border: 2px solid #000; background: #fff; padding: 8px 20px; cursor: pointer; width: 100%; font-weight: bold; }
        .error { color: red; margin-bottom: 15px; }
        .link { display: block; margin-top: 15px; text-align: center; color: #0066cc; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>Регистрация</h2>
    <?php if (!empty($error)): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    
    <form method="POST" action="auth.php?action=register">
        <div class="form-row">
            <label>Придумайте логин:</label>
            <input type="text" name="username" required minlength="3">
        </div>
        <div class="form-row">
            <label>Придумайте пароль:</label>
            <input type="password" name="password" required minlength="4">
        </div>
        <button type="submit" class="submit-btn">Зарегистрироваться</button>
    </form>
    <a href="auth.php?action=login" class="link">Уже есть аккаунт? Войти</a>
</div>
</body>
</html>