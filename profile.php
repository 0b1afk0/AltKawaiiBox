<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if (isset($_FILES['avatar'])) {
    $userId = $_SESSION['user']['id'];
    $file = $_FILES['avatar'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = uniqid('avatar_') . '.' . $ext;
        $uploadPath = __DIR__ . '/../localhost/avatars/' . $newName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Обновим БД
            require_once 'connect.php'; // получаем $connect из return

            $stmt = mysqli_prepare($connect, "UPDATE users SET avatar = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'si', $newName, $userId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Обновим сессию
            $_SESSION['user']['avatar'] = $newName;
        }
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль - AltKawaiiBox</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
       html, body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background-color: #20262E;
    color: #E9E8E8;
}

/* Контейнер профиля */
.profile-container {
    max-width: 800px;
    margin: 50px auto;
    padding: 30px;
    background-color: #913175;
    border-radius: 10px;
}
@media (max-width: 768px) {
    .profile-container {
        width: 90%;
        margin: 20px auto;
        padding: 20px;
    }
}

/* Заголовок профиля */
.profile-title {
    text-align: center;
    margin-bottom: 30px;
    font-size: 24px;
    font-weight: 700;
}

/* Информация профиля */
.profile-info {
    margin-bottom: 30px;
}
@media (max-width: 768px) {
    .profile-info p {
        font-size: 16px;
        margin: 10px 0;
    }
}

/* Параграфы с информацией */
.profile-info p {
    font-size: 18px;
    margin: 15px 0;
}

/* Кнопка выхода */
.logout-btn {
    display: block;
    width: 200px;
    margin: 30px auto 0;
    padding: 12px;
    background-color: #CD5888;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
}

.avatar-container {
    text-align: center;
    margin-bottom: 20px;
    position: relative;
}

.avatar-container label {
    cursor: pointer;
    display: inline-block;
    position: relative;
}

.avatar-container input[type="file"] {
    display: none;
}

.avatar-img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    background-color: #fff;
    border: 3px solid #CD5888;
}

.avatar-placeholder {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    display: inline-block;
    background-color: #CD5888;
    border: 3px solid #CD5888;
    background-image: url('../img/defoult_avatar.svg'); /* сюда вставим SVG ниже */
    background-size: 60%;
    background-repeat: no-repeat;
    background-position: center;
}

@media (max-width: 768px) {
    .logout-btn {
        width: 100%;
        font-size: 14px;
        padding: 10px;
    }
}

.logout-btn:hover {
    background-color: rgb(179, 74, 117);
}
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="profile-container">
        <h1 class="profile-title">Личный кабинет</h1>
        <div class="profile-info">
            <div class="avatar-container">
                <form method="post" enctype="multipart/form-data">
                    <label>
                        <?php if (!empty($_SESSION['user']['avatar']) && file_exists(__DIR__ . '/../localhost/avatars/' . $_SESSION['user']['avatar'])): ?>
                            <img src="<?php echo '../avatars/' . htmlspecialchars($_SESSION['user']['avatar']); ?>" alt="Аватар" class="avatar-img">
                        <?php else: ?>
                            <div class="avatar-placeholder"></div>
                        <?php endif; ?>
                        <input type="file" name="avatar" onchange="this.form.submit();">
                    </label>
                </form>
                <p style="font-size: 14px; opacity: 0.7;">Нажмите на аватар, чтобы изменить</p>
            </div>
            <p><strong>Имя:</strong> <?php echo htmlspecialchars($_SESSION['user']['user_name']); ?></p>
            <p><strong>Фамилия:</strong> <?php echo htmlspecialchars($_SESSION['user']['last_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
        </div>
        
        <form method="POST">
            <a href="cart.php" class="logout-btn" style="margin-bottom: 15px;">Моя корзина</a>
            <button type="submit" name="logout" class="logout-btn">Выйти из аккаунта</button>
        </form>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>