<?php
require_once 'header.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AltKawaiiBox - Главная страница</title>
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

/* Контейнер для всей страницы */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Заголовки */
h1 {
    color: rgb(255, 255, 255);
    margin-bottom: 30px;
    text-align: center;
}
h2 {
    color: rgb(255, 255, 255);
    margin: 25px 0 15px;
    text-align: center;
}

/* Разделы */
.section {
    width: 100%;
    margin-bottom: 20px;
    text-align: center;
}

/* Блоки features и categories */
.features, .categories {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
    margin-top: 15px;
    text-align: center;
}

.feature, .category {
    border-radius: 8px;
    padding: 10px 15px;
    text-align: center;
    background-color: #2C3440; /* добавим фон для визуальной ясности */
    min-width: 100px;
}

/* Блок join */
.join {
    margin-top: 30px;
    font-size: 18px;
    text-align: center;
    font-weight: bold;
}

/* Списки */
ul {
    text-align: left;
    padding-left: 20px;
}
li {
    margin-bottom: 8px;
}

/* Обратная связь */
.form-feedback {
    background-color: #CD5888;
}
.title-feedback {
    color: white;
}

/* Контактная секция */
.contact-section {
    background-color: #CD5888;
    color: white;
    margin: 0 auto;
    border-radius: 40px;
    width: 1000px;
    max-width: 95%; /* добавляем ограничение ширины для мобильных */
    text-align: center;
    padding: 40px 20px;
}

/* Форма контакта */
.contact-form {
    max-width: 500px;
    margin: 0 auto;
}

/* Группы формы */
.form-group {
    margin-bottom: 20px;
    text-align: left;
}

/* Поля ввода */
input, textarea {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 4px;
    margin-top: 5px;
    box-sizing: border-box;
}

/* Высота textarea */
textarea {
    height: 120px;
    resize: vertical;
}

/* Кнопка отправки */
.submit-btn {
    background-color: #913175;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}
.submit-btn:hover {
    background-color: #7a2a5d;
}

/* Заголовок обратной связи */
.feedback-title {
    color: white;
}

/* Медиазапросы для адаптивности */
@media (max-width: 768px) {
    /* Ограничение ширины contact-section для мобильных */
    .contact-section {
        width: 90%;
        padding: 20px;
        border-radius: 20px;
    }

    /* Центрирование и уменьшение шрифтов для заголовков */
    h1, h2 {
        font-size: 1.8em;
    }

    /* Блоки features и categories */
    .features, .categories {
        flex-direction: column;
        align-items: center;
    }

    /* Блоки feature и category */
    .feature, .category {
        width: 90%;
        min-width: unset;
    }

    /* Кнопка и поля формы */
    .submit-btn {
        width: 100%;
        padding: 12px;
        font-size: 14px;
    }
    input, textarea {
        font-size: 14px;
    }
}
    </style>
</head>
<body>
    <main>
      <h1>О нас</h1>
        
        <div class="section">
            <p>AltKawaiiBox — это онлайн-нагазин с уникальным ассортиментом продукции из мира японской анимации и культуры.<br> Мы создаем уютную атмосферу, вдохновленную теплым светом ночного Токио,<br> и предлагаем качественные товары для фанатов аниме и манги.</p>
        </div>
        
        <h2>Основная концепция</h2>
        
        <div class="section">
            <p>От коллекционных фигурок до оригинальной японской еды — наш каталог постоянно обновляется и предлагает удобную навигацию для быстрой покупки.</p>
        </div>
        
        <h2>Почему именно мы?</h2>
        
        <div class="features">
            <div class="feature">
                <ul>
                    <li>Атмосферный дизайн сайта в японском стиле</li>
                    <li>Эксклюзивные и редкие товары</li>
                    <li>Интуитивный интерфейс покупок</li>
                    <li>Возможность оставлять отзывы и делиться впечатлениями</li>
                </ul>
            </div>
        </div>
            
        <h2>Особенности нашего сервиса</h2>
        
        <div class="features">
            <div class="feature">
                <ul>
                    <li>Дружелюбный и заботливый сервис</li>
                    <li>Безопасная защита данных</li>
                    <li>Широкий ассортимент от японских брендов</li>
                </ul>
            </div>
        </div>
        
        <h2>Категории товаров</h2>
        
        <div class="categories">
            <div class="category">
                <ul>
                    <li>Коллекционные фигурки</li>
                    <li>Манга и журналы</li>
                    <li>Японская кухня и сладости</li>
                </ul>
            </div>
            <div class="category">
                <ul>
                    <li>Аксессуары и одежда</li>
                    <li>Канцелярия и арт-материалы</li>
                    <li>Постеры и плакаты</li>
                </ul>
            </div>
        </div>
    </div>

    <?php 
$connect = include 'connect.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $message = mysqli_real_escape_string($connect, $_POST['message']);
    $created_at = date('Y-m-d H:i:s');
    
    $query = "INSERT INTO feedback (name, message, created_at) VALUES ('$name', '$message', '$created_at')";
    
    if (mysqli_query($connect, $query)) {
        echo '<p style="color: white; text-align: center;">Спасибо! Ваше сообщение отправлено.</p>';
    } else {
        echo '<p style="color: white; text-align: center;">Ошибка: ' . mysqli_error($connect) . '</p>';
    }
}
?>


    <section class="contact-section">
        <h1 class="feedback-title">Есть вопрос? Свяжитесь с нами!</h1>
        
<form class="contact-form" method="POST" action="">
    <div class="form-group">
        <label for="name">Ваше имя</label>
        <input type="text" id="name" name="name" required>
    </div>
    
    <div class="form-group">
        <label for="message">Сообщение</label>
        <textarea id="message" name="message" required></textarea>
    </div>
    
    <button type="submit" name="submit" class="submit-btn">Отправить вопрос</button>
</form>
    </section>
    </main>
    <?php
    include 'footer.php';
    ?>
</body>
</html>