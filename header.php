<?php 
if(session_status() === PHP_SESSION_NONE) session_start();
?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    a {
    color: #E9E8E8;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
}

body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
}

/* Шапка сайта */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 30px;
    background: #913175;
    color: #E9E8E8;
    flex-wrap: wrap; /* добавляем перенос для мобильных */
}

/* Логотип */
.logo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    font-size: 24px;
    margin-left: 11%;
    cursor: pointer;
}

/* hover эффект для логотипа */
.logo:hover {
    cursor: pointer;
}

/* Размер логотипа или изображения */
.logo_header {
    width: 90px;
}

/* Цвет текста */
.alt {
    color: #20262E;
    font-size: 19px;
}

.kawaiibox {
    font-size: 19px;
}

/* Блок меню или списка */
.center_spisok {
    display: flex;
    gap: 25px;
    flex-wrap: wrap; /* перенос элементов */
}

/* Кнопки в шапке */
.btn_header {
    margin: 0 9px;
    padding: 3px;
    border-bottom: 2px solid transparent;
    transition: border-color 0.3s ease-in-out;
}

.btn_header:hover {
    border-bottom: 2px solid #20262E;
    color: #20262E;
}

/* Кнопка-ссылка */
.btn_lk {
    padding: 15px 12px;
    background-color: #CD5888;
    border-radius: 20px;
    transition: background-color 0.3s;
    cursor: pointer;
}

.btn_lk:hover {
    background-color: rgb(173, 81, 119);
}

/* Блок с кнопками или логинами */
.lk_block {
    display: flex;
    margin-right: 11%;
    gap: 20px;
    flex-wrap: wrap; /* перенос при необходимости */
}

/* Медиазапрос для мобильных устройств */
@media (max-width: 768px) {
    header {
        flex-direction: column;
        align-items: center;
        padding: 20px;
    }
    .logo {
        margin-left: 0;
        font-size: 20px;
        margin-bottom: 15px;
    }
    .center_spisok {
        justify-content: center;
        gap: 15px;
    }
    .lk_block {
        justify-content: center;
        margin: 10px 0;
        width: 100%;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
    .btn_header {
        margin: 5px 0;
    }
}

    </style>
</head>
<body>
    <header>
        <div class="logo" onclick="location.href='index.php'">
            <img src="img/AltKawaiiBox_LOGO 1.svg" alt="AltKawaiiBox" class="logo_header">
            <div><a href="index.php" class="alt">Alt</a><a href="index.php" class="kawaiibox">KawaiiBox</a></div>
        </div>
<?php /// echo '<pre>';
 /// print_r($_SESSION);
 /// echo '</pre>';?> 
        <nav class="center_spisok">
            <a href="index.php" class="btn_header"><b>О Магазине</b></a>
            <a href="catalog.php" class="btn_header"><b>Каталог</b></a>
            <a href="reviews.php" class="btn_header"><b>Отзывы</b></a>
            <a href="contacts.php" class="btn_header"><b>Контакты</b></a>
        </nav>
        <div class="lk_block">
            <a href="<?php echo isset($_SESSION['user']) ? 'profile.php' : 'login.php'; ?>" class="btn_lk"><b>Личный кабинет</b></a>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
            <a href="admin_panel.php" class="btn_lk"><b>Админ-панель</b></a>
        <?php endif; ?>
        </div>
    </header>