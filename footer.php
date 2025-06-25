<style>
/* Общие стили для ссылок */
a {
    color: #E9E8E8;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
}

/* Основной стиль для тела документа */
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
}

/* Стиль футера */
footer {
    background-color: #913175;
    padding: 40px 0;
    color: #E9E8E8;
    margin-top: 100px;
}

/* Контейнер внутри футера для расположения секций */
.footer-container {
    display: flex;
    flex-wrap: wrap; /* перенос элементов на мобильных */
    justify-content: space-around;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Разделы футера */
.footer-section {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
    flex: 1 1 200px; /* минимальная ширина для колонок */
}

/* Заголовки секций */
.footer-section h3 {
    margin-bottom: 20px;
    font-size: 18px;
}

/* Ссылки и параграфы внутри секций */
.footer-section a,
.footer-section p {
    margin-bottom: 10px;
    font-size: 14px; /* исправлено дублирование */
}

/* Иконки социальных сетей */
.social-icons {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

/* Ссылки внутри соц.сетей */
.social-icons a {
    font-size: 20px;
    transition: color 0.3s;
}

/* Эффект при наведении на соц.иконки */
.social-icons a:hover {
    color: #fff;
}

/* Кнопки соц.сетей */
.social_but {
    background-color: #CD5888;
    padding: 10px;
    border-radius: 15px;
    transition: background-color 0.3s;
}

.social_but:hover {
    background-color: rgb(179, 74, 117);
}

/* Эффект наведения на секции */
.section_hover {
    text-align: center;
    border-bottom: 2px solid transparent;
    transition: border-color 0.3s ease-in-out, color 0.3s;
}

.section_hover:hover {
    border-bottom: 2px solid #20262E;
    color: #20262E;
}

/* Адаптивные стили для мобильных устройств */
@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        align-items: center;
    }
    .footer-section {
        width: 100%;
        align-items: center;
        text-align: center;
    }
    .social-icons {
        justify-content: center;
        margin-top: 15px;
    }
}
</style>

<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h3>Контакты</h3>
            <p>Адрес: г. Город, ул. Улица, д. 123</p>
            <p>Телефон: +7 123 456 78 90</p>
            <p>Email: info@vasibase.ru</p>
        </div>
        
        <div class="footer-section">
            <h3>Полезные ссылки</h3>
            <a href="index.php" class="section_hover">О Магазине</a>
            <a href="catalog.php" class="section_hover">Каталог</a>
            <a href="reviews.php" class="section_hover">Отзывы</a>
            <a href="contacts.php" class="section_hover">Контакты</a>
        </div>
        
        <div class="footer-section">
            <h3>Мы в соцсетях</h3>
            <div class="social-icons">
                <a href="#" class="social_but">Facebook</a>
                <a href="#" class="social_but">Instagram</a>
                <a href="#" class="social_but">VK</a>
            </div>
        </div>
    </div>
</footer>