<?php
ob_start();
session_start();
require_once 'header.php';
include 'connect.php';

$product_id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $rating = (int)$_POST['rating'];
    $comment = trim($_POST['comment']);
    $user_id = $_SESSION['user']['id'];

    if ($rating >= 1 && $rating <= 5 && !empty($comment)) {
$stmt = $connect->prepare("INSERT INTO reviews (product_id, user_id, rating, text, created_at) VALUES (?, ?, ?, ?, NOW())");
        
        $stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);
        
        if ($stmt->execute()) {
            header("Location: product.php?id=$product_id");
            ob_end_flush();
            exit();
        } 
    }
}


$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $connect->query($sql);

if ($result->num_rows === 0) {
    die("Товар не найден!");
}

$product = $result->fetch_assoc(); 

$reviews_sql = "SELECT 
    r.id,
    r.product_id,
    r.user_id,
    r.rating,
    r.text AS comment,
    r.created_at,
    u.user_name AS name,
    u.last_name AS lastname
FROM reviews r 
JOIN users u ON r.user_id = u.id 
WHERE r.product_id = $product_id 
ORDER BY r.created_at DESC";

$reviews_result = $connect->query($reviews_sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> - AltKawaiiBox</title>
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

/* Контейнер продукта */
.product_container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    display: flex;
    gap: 50px;
    flex-wrap: wrap;
}

/* Изображение продукта */
.product_image {
    flex: 1;
    background-color: #D9D9D9;
    padding: 30px;
    border-radius: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.product_image img {
    max-width: 100%;
    max-height: 500px;
    object-fit: contain;
}

/* Информация о продукте */
.product_info {
    flex: 1;
}

.product_title {
    font-size: 2.5em;
    margin-bottom: 20px;
    color: #CD5888;
}

.product_price {
    font-size: 2em;
    font-weight: bold;
    margin: 20px 0;
}

.product_description {
    font-size: 1.2em;
    line-height: 1.5;
    margin-bottom: 30px;
}

/* Кнопка добавить в корзину */
.add_to_cart {
    background: #CD5888;
    color: white;
    padding: 15px 30px;
    border: none;
    border-radius: 15px;
    font-size: 1.2em;
    cursor: pointer;
    transition: 0.3s;
    display: inline-block;
    margin-bottom: 30px;
}

.add_to_cart:hover {
    background: #913175;
}

/* Раздел отзывов */
.reviews_section {
    max-width: 1200px;
    margin: 0 auto 50px;
    padding: 0 20px;
}

.reviews_title {
    font-size: 2em;
    color: #CD5888;
    margin-bottom: 20px;
}

/* Форма добавления отзыва */
.review_form {
    background: #2C3440;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
}

.form_title {
    font-size: 1.5em;
    margin-bottom: 15px;
}

.review_textarea {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: none;
    background: #3E4A5A;
    color: #E9E8E8;
    margin-bottom: 15px;
    min-height: 100px;
    resize: vertical;
}

.submit_review {
    background: #CD5888;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.submit_review:hover {
    background: #913175;
}

/* Отзыв */
.review_item {
    background: #2C3440;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.review_header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.review_author {
    font-weight: bold;
    color: #CD5888;
}

.review_date {
    color: #8D8D8D;
    font-size: 0.9em;
}

.review_rating {
    color: #FFD700;
    margin-bottom: 10px;
}

.review_text {
    line-height: 1.5;
}

/* Сообщение о отсутствии отзывов */
.no_reviews {
    color: #8D8D8D;
    font-style: italic;
}

/* Блок для входа для добавления отзывов */
.login_to_review {
    background: #2C3440;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
    text-align: center;
}

.login_to_review a {
    color: #913175;
    text-decoration: underline;
}

/* Звездный рейтинг */
.rating-stars {
    display: inline-block;
    font-size: 0;
}

.stars-container {
    display: inline-block;
    direction: rtl; 
    unicode-bidi: bidi-override;
}

.stars-container input {
    display: none;
}

.stars-container label {
    font-size: 30px;
    color: #913175;
    cursor: pointer;
    display: inline-block;
    position: relative;
    padding: 0 2px;
}

.stars-container label:before {
    content: "★";
}

.stars-container input:checked ~ label:before,
.stars-container label:hover:before,
.stars-container label:hover ~ label:before {
    color: #CD5888;
}

.stars-container input:checked + label:before {
    color: #CD5888;
}

/* Медиазапросы для адаптивности */
@media (max-width: 768px) {
    .product_container {
        flex-direction: column;
        gap: 20px;
    }
    .product_image {
        padding: 20px;
    }
    .product_title {
        font-size: 2em;
    }
    .product_price {
        font-size: 1.5em;
    }
    .product_description {
        font-size: 1em;
    }
    .add_to_cart {
        width: 100%;
        font-size: 1em;
        padding: 12px 20px;
    }
    /* Отзывы и форма отзывов */
    .reviews_section {
        padding: 0 10px;
    }
    .reviews_title {
        font-size: 1.5em;
    }
    .review_item {
        padding: 15px;
    }
    .review_header {
        flex-direction: column;
        align-items: center;
    }
    .review_author, .review_date {
        font-size: 1em;
        margin-bottom: 5px;
    }
    /* Звездный рейтинг */
    .stars-container label {
        font-size: 24px;
    }
}
    </style>
</head>
<body>
    <div class="product_container">
        <div class="product_image">
            <img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>
        <div class="product_info">
            <h1 class="product_title"><?= htmlspecialchars($product['name']) ?></h1>
            <div class="product_price"><?= number_format($product['price'], 0, '', ' ') ?> ₽</div>
            <p class="product_description"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
<a href="cart.php?add=<?= $product['id'] ?>" class="add_to_cart">Добавить в корзину</a>
        </div>
    </div>

    <div class="reviews_section">
        <h2 class="reviews_title">Отзывы о товаре</h2>
        
        <?php if (isset($_SESSION['user'])): ?>
            <div class="review_form">
                <h3 class="form_title">Оставить отзыв</h3>
                <form method="POST" action="">
                    <div class="rating-stars">
                        <div class="stars-container">
                            <input type="radio" id="star5" name="rating" value="5">
                            <label for="star5" class="star"></label>
                            
                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4" class="star"></label>
                            
                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3" class="star"></label>
                            
                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2" class="star"></label>
                            
                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1" class="star"></label>
                        </div>
                    </div>
                    <textarea class="review_textarea" name="comment" placeholder="Ваш отзыв..." required></textarea>
                    <button type="submit" name="submit_review" class="submit_review">Отправить отзыв</button>
                </form>
            </div>
        <?php else: ?>
            <div class="login_to_review">
                <p>Чтобы оставить отзыв, пожалуйста, <a href="login.php">войдите</a> в свой аккаунт.</p>
            </div>
        <?php endif; ?>
        
        <?php if ($reviews_result->num_rows > 0): ?>
            <?php while ($review = $reviews_result->fetch_assoc()): ?>
                <div class="review_item">
                    <div class="review_header">
                        <span class="review_author"><?= htmlspecialchars($review['name'] . ' ' . $review['lastname']) ?></span>
                        <span class="review_date"><?= date('d.m.Y', strtotime($review['created_at'])) ?></span>
                    </div>
                    <div class="review_rating">
                        <?= str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) ?>
                    </div>
                    <div class="review_text">
                        <?= nl2br(htmlspecialchars($review['comment'])) ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no_reviews">Пока нет отзывов о этом товаре. Будьте первым!</p>
        <?php endif; ?>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>