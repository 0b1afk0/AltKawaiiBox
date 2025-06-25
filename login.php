<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $connect = new mysqli('localhost', 'root', '', 'alt_kawaii_box');
    if ($connect->connect_error) {
        die("Ошибка подключения: " . $connect->connect_error);
    }
    
    $email = $connect->real_escape_string($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $errors[] = "Все поля обязательны для заполнения";
    }
    
    if (empty($errors)) {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = $connect->query($query);
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'user_name' => $user['user_name'],
                    'last_name' => $user['last_name'],
                    'role' => $user['role'],
                ];
                
                header('Location: profile.php');
                exit();
            } else {
                $errors[] = "Неверный пароль";
            }
        } else {
            $errors[] = "Пользователь с таким email не найден";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - AltKawaiiBox</title>
    <style>
        body {
    background-color: #20262E;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    color: #000;
}

/* Контейнер для формы авторизации */
.auth-container {
    max-width: 400px;
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
    font-size: 24px;
}

/* Группа формы */
.auth-form .form-group {
    margin-bottom: 20px;
}

/* Метки */
.auth-form label {
    display: block;
    margin-bottom: 8px;
    color: #fff; /* изменено на белый для лучшей видимости на темном фоне */
    font-weight: 500;
    font-size: 14px;
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

/* Кнопка отправки */
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

/* Переключатель авторизации, например, ссылка на регистрацию или вход */
.auth-switch {
    text-align: center;
    margin-top: 20px;
    color: white;
    font-size: 14px;
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
    font-size: 14px;
}

/* Медиазапрос для мобильных устройств */
@media (max-width: 768px) {
    .auth-container {
        width: 90%;
        margin: 30px auto;
        padding: 20px;
    }
    .auth-title {
        font-size: 20px;
        margin-bottom: 20px;
    }
    .auth-form label {
        font-size: 13px;
    }
    .auth-form input {
        font-size: 14px;
    }
    .auth-form button {
        font-size: 14px;
    }
    .auth-switch {
        font-size: 13px;
        margin-top: 15px;
    }
    .error-message {
        font-size: 13px;
        padding: 8px;
    }
}
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="auth-container">
        <h1 class="auth-title">Вход</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form class="auth-form" method="POST">
            <div class="form-group">
                <input type="email" id="email" name="email" required placeholder="Email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
            </div>
            
            <div class="form-group">
                <input type="password" id="password" name="password" required placeholder="Пароль">
            </div>
            
            <button type="submit">Войти</button>
        </form>
        
        <div class="auth-switch">
            Нет аккаунта? <a href="reg.php">Зарегистрироваться</a>
        </div>
    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>