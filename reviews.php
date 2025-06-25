<?php
ob_start();
session_start();
require_once 'header.php';
include 'connect.php';

$reviews_sql = "SELECT 
    r.id,
    r.product_id,
    r.user_id,
    r.rating,
    r.text AS comment,
    r.created_at,
    u.user_name AS name,
    u.last_name AS lastname,
    u.avatar AS avatar,
    p.name AS product_name,
    p.img AS product_img
FROM reviews r
JOIN users u ON r.user_id = u.id
JOIN products p ON r.product_id = p.id
ORDER BY r.created_at DESC";
$reviews_result = $connect->query($reviews_sql);
?>



<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отзывы - AltKawaiiBox</title>
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

/* Контейнер отзывов */
.reviews_container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 0 20px;
}

/* Заголовок страницы */
.page_title {
    font-size: 2.5em;
    color: #CD5888;
    margin-bottom: 30px;
    text-align: center;
}

/* Отзыв */
.review_item {
    background: #2C3440;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
    display: flex;
    gap: 30px;
    flex-wrap: wrap; /* добавляем перенос для мобильных */
}

/* Изображение продукта */
.review_product_image {
    width: 200px;
    height: 200px;
    background-color: #D9D9D9;
    border-radius: 15px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    cursor: pointer;
}

/* Изображение внутри блока */
.review_product_image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

/* Контент отзыва */
.review_content {
    flex-grow: 1;
}

/* Заголовки внутри отзыва */
.review_header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    align-items: center;
    flex-wrap: wrap; /* добавляем перенос */
}

.user{
    display: flex;
    gap: 10px;
    align-items: center;
}

/* Название продукта */
.product_name {
    font-size: 1.5em;
    color: #CD5888;
    margin-bottom: 5px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}

/* Эффект при наведении */
.product_name:hover {
    text-decoration: underline;
}

/* Автор отзыва */
.review_author {
    font-weight: bold;
    color: #CD5888;
}

/* Дата отзыва */
.review_date {
    color: #8D8D8D;
    font-size: 0.9em;
}

/* Рейтинг */
.review_rating {
    color: #FFD700;
    margin: 10px 0;
    font-size: 1.2em;
}

/* Текст отзыва */
.review_text {
    line-height: 1.5;
    font-size: 1.1em;
}

/* Сообщение о отсутствии отзывов */
.no_reviews {
    color: #8D8D8D;
    font-style: italic;
    text-align: center;
    font-size: 1.2em;
    padding: 50px 0;
}

/* Ссылки внутри отзывов */
.product_link {
    text-decoration: none;
    color: inherit;
}

.avatar-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    background-color: #fff;
    border: 1px solid #CD5888;
}

.avatar-placeholder{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: inline-block;
    background-color: #CD5888;
    border: 1px solid #CD5888;
    background-image: url('placeholder.svg'); /* сюда вставим SVG ниже */
    background-size: 60%;
    background-repeat: no-repeat;
    background-position: center;
}

/* Медиазапрос для мобильных устройств */
@media (max-width: 768px) {
    .review_item {
        flex-direction: column;
        align-items: center;
    }
    .review_product_image {
        width: 100%;
        max-width: 300px;
        height: auto;
    }
    .review_header {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .product_name {
        font-size: 1.3em;
    }
    .review_rating {
        font-size: 1em;
    }
    .review_text {
        font-size: 1em;
    }
}
    </style>
</head>
<body>
    <div class="reviews_container">
        <h1 class="page_title">Отзывы покупателей</h1>
        
        <?php if ($reviews_result->num_rows > 0): ?>
            <?php while ($review = $reviews_result->fetch_assoc()): ?>
                <div class="review_item">
                    <a href="product.php?id=<?= $review['product_id'] ?>" class="product_link">
                        <div class="review_product_image">
                            <img src="<?= htmlspecialchars($review['product_img']) ?>" alt="<?= htmlspecialchars($review['product_name']) ?>">
                        </div>
                    </a>
                    <div class="review_content">
                        <a href="product.php?id=<?= $review['product_id'] ?>" class="product_link">
                            <div class="product_name"><?= htmlspecialchars($review['product_name']) ?></div>
                        </a>
                        <div class="review_header">
                            <div class="user">
                                <?php if (!empty($_SESSION['user']['avatar']) && file_exists(__DIR__ . '/../localhost/avatars/' . $_SESSION['user']['avatar'])): ?>
                                    <img src="<?php echo '../avatars/' . htmlspecialchars($_SESSION['user']['avatar']); ?>" alt="Аватар" class="avatar-img">
                                <?php else: ?>
                                    <div class="avatar-placeholder"></div>
                                <?php endif; ?>
                                <span class="review_author"><?= htmlspecialchars($review['name'] . ' ' . $review['lastname']) ?></span>
                            </div>
                            <span class="review_date"><?= date('d.m.Y', strtotime($review['created_at'])) ?></span>
                        </div>
                        <div class="review_rating">
                            <?= str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) ?>
                        </div>
                        <div class="review_text">
                            <?= nl2br(htmlspecialchars($review['comment'])) ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no_reviews">Пока нет отзывов о товарах. Будьте первым!</p>
        <?php endif; ?>
    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>
<?php ob_end_flush(); ?>