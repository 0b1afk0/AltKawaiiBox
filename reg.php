<?php
ob_start();
session_start();
include 'connect.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['user_name'] ?? '');
    $lastname = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = 'user';

    if (empty($name)) $errors[] = "Имя обязательно для заполнения";
    if (empty($lastname)) $errors[] = "Фамилия обязательна для заполнения";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Введите корректный email";
    if (empty($password)) $errors[] = "Пароль обязателен для заполнения";
    if (strlen($password) < 6) $errors[] = "Пароль должен содержать минимум 6 символов";
    if ($password !== $confirm_password) $errors[] = "Пароли не совпадают";

    if (empty($errors)) {
        $stmt = $connect->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Пользователь с таким email уже существует";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $connect->prepare("INSERT INTO users (user_name, last_name, email, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $lastname, $email, $hashed_password, $role);

            if ($stmt->execute()) {
                $user_id = $stmt->insert_id;
                
                $_SESSION['user'] = [
                    'id' => $user_id,
                    'user_name' => $name,
                    'last_name' => $lastname,
                    'email' => $email,
                    'role' => $role
                ];
                
                $_SESSION['success'] = "Регистрация прошла успешно!";
                header("Location: profile.php");
                ob_end_flush();
                exit();
            } else {
                $errors[] = "Ошибка при регистрации: " . $connect->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - AltKawaiiBox</title>
    <style>
        body {
    background-color: #20262E;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    color: #000;
}

/* Контейнер формы авторизации */
.auth-container {
    max-width: 400px;
    width: 90%; /* добавлено для мобильных устройств */
    margin: 50px auto;
    padding: 30px;
    background: #CD5888;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
}

/* Заголовок формы */
.auth-title {
    text-align: center;
    color: white;
    margin-bottom: 30px;
    font-weight: 700;
}

/* Группы формы */
.auth-form .form-group {
    margin-bottom: 20px;
}

/* Метки */
.auth-form label {
    display: block;
    margin-bottom: 8px;
    color: #000;
    font-weight: 500;
}

/* Поля ввода */
.auth-form input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
    background: #fff;
}

/* Кнопки */
.auth-form button {
    width: 100%;
    padding: 12px;
    background-color: #913175;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 600;
}

.auth-form button:hover {
    background-color: #7a2a5d;
    color: #fff;
}

/* Переключатель авторизации (например, "Нет аккаунта? Зарегистрироваться") */
.auth-switch {
    text-align: center;
    margin-top: 20px;
    color: white;
}

.auth-switch a {
    color: white;
    text-decoration: underline;
    font-weight: 600;
}

.auth-switch a:hover {
    color: rgb(231, 229, 229);
}

/* Сообщение об ошибке */
.error-message {
    color: #ff0000;
    margin-bottom: 20px;
    padding: 10px;
    background-color: rgba(255, 255, 255, 0.7);
    border-radius: 5px;
    text-align: center;
    font-weight: 500;
}

/* Адаптивность для мобильных устройств */
@media (max-width: 768px) {
    .auth-container {
        margin: 20px auto; /* уменьшить отступы */
        padding: 20px;
        width: 90%;
    }
    /* Можно добавить дополнительные стили для улучшения вида на мобильных, если нужно */
}
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="auth-container">
        <h1 class="auth-title">Регистрация</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form class="auth-form" method="POST">
            <div class="form-group">
                <input type="text" id="name" name="user_name" required placeholder="Имя">
            </div>
            
            <div class="form-group">
                <input type="text" id="lastname" name="last_name" required placeholder="Фамилия">
            </div>
            
            <div class="form-group">
                <input type="email" id="email" name="email" required placeholder="Email">
            </div>
            
            <div class="form-group">
                <input type="password" id="password" name="password" required placeholder="Пароль">
            </div>
            
            <div class="form-group">
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Подтвердите пароль">
            </div>
            
            <button type="submit">Зарегистрироваться</button>
        </form>
        
        <div class="auth-switch">
            Уже есть аккаунт? <a href="login.php">Войти</a>
        </div>
    </div>
        <?php include('footer.php'); ?>
</body>
</html>