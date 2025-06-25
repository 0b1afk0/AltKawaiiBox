<?php
session_start();
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

/* Общие стили для форм поиска и фильтрации */
.search-form, .filter_div {
    margin: 20px 40px;
    width: 500px;
}
@media (max-width: 768px) {
    .search-form, .filter_div {
        width: 90%;
        margin: 20px auto;
        padding: 0 10px;
    }
}

/* Flex контейнеры для поиска и фильтра */
.search_flex, .filter_flex {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap; /* добавлено для мобильных */
}
@media (max-width: 768px) {
    .search_flex, .filter_flex {
        flex-direction: column;
        align-items: stretch;
    }
}

/* Поля ввода и селекторы */
.search-input, .select_filter {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    flex-grow: 1;
    width: 100%;
}
@media (max-width: 768px) {
    .search-input, .select_filter {
        font-size: 14px;
    }
}

/* Кнопки поиска и фильтра */
.search_btn, .filter_btn {
    background-color: #CD5888;
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    white-space: nowrap;
}
.search_btn:hover, .filter_btn:hover {
    transition: 0.3s;
    background-color: #913175;
}
@media (max-width: 768px) {
    .search_btn, .filter_btn {
        width: 100%;
        padding: 12px;
        margin-top: 10px;
    }
}

/* Категории */
.categories_flex {
    display: flex;
    gap: 30px;
    justify-content: center;
    padding: 50px;
    flex-wrap: wrap;
}
@media (max-width: 768px) {
    .categories_flex {
        padding: 20px;
        gap: 20px;
    }
}

.category_but {
    background-color: #CD5888;
    padding: 14px 70px;
    border-radius: 15px;
    font-size: 1.3em;
    cursor: pointer;
    transition: background-color 0.3s;
}
@media (max-width: 768px) {
    .category_but {
        padding: 14px 20px;
        font-size: 1em;
        margin: 10px 0;
        width: 100%;
        text-align: center;
    }
}
.category_but:hover {
    background-color: #913175;
}

/* Карточки продуктов */
.product_card {
    width: 300px;
    height: 470px;
    flex: 0 0 300px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    border: solid #CD5888 5px;
    border-radius: 30px;
    padding: 36px;
    box-sizing: border-box;
    overflow: visible;
    background-position: center;
    transition: border 0.3s, background-image 0.3s;
}
@media (max-width: 768px) {
    .product_card {
        width: 90%;
        height: auto;
        padding: 20px;
    }
}

.product_card:hover {
    cursor: pointer;
    border: solid rgba(205, 88, 137, 0) 5px; 
    background-image: url('img/Rectangle 6 (1).png');
    background-size: 105%;
    background-repeat: no-repeat;
    background-position: center;
}

/* Изображения продукта */
.product_image img, .catalog_image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}
@media (max-width: 768px) {
    .product_image {
        width: 100%;
        height: auto;
        padding: 20px 0;
    }
}

/* Информация о продукте */
.product_info {
    width: 100%;
    height: 140px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 10px 0;
}
@media (max-width: 768px) {
    .product_info {
        height: auto;
        padding: 10px;
    }
}

.product_title {
    margin: 10px 0;
    font-size: 16px;
    line-height: 1.2em;
    height: 2.4em;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-box-orient: vertical;
}
@media (max-width: 768px) {
    .product_title {
        font-size: 14px;
        height: auto;
    }
}

.product_price {
    font-size: 200%;
    font-weight: 600;
    color: #CD5888;
}
@media (max-width: 768px) {
    .product_price {
        font-size: 150%;
    }
}

/* Кнопка продукта */
.product_button {
    background: #CD5888;
    color: white;
    padding: 15px 30px;
    border-radius: 15px;
    border: none;
    margin-top: auto;
    cursor: pointer;
    transition: background 0.3s;
}
.product_button:hover {
    background-color: #913175;
}
@media (max-width: 768px) {
    .product_button {
        width: 100%;
        padding: 12px;
        font-size: 14px;
        margin-top: 10px;
    }
}

/* Блок каталога */
.catalog_image {
    background-color: #D9D9D9;
    padding: 32px 12px;
    border-radius: 20px;
    width: 250px;
    height: 170px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    filter: blur(5px);
}
@media (max-width: 768px) {
    .catalog_image {
        width: 100%;
        height: auto;
        padding: 20px 0;
    }
}

/* Кнопки каталога */
.btn_catalog {
    background: #CD5888;
    color: white;
    padding: 15px 30px;
    border-radius: 15px;
    border: none;
    margin-top: 180px;
    cursor: pointer;
    transition: background 0.3s;
}
@media (max-width: 768px) {
    .btn_catalog {
        width: 100%;
        padding: 12px;
        font-size: 14px;
        margin-top: 20px;
    }
}
.btn_catalog:hover {
    background-color: #913175;
}

/* Контейнер для кнопок каталога */
.btn_container_catalog {
    text-align: center;
    margin-top: 180px;
}
@media (max-width: 768px) {
    .btn_container_catalog {
        margin-top: 20px;
    }
}

/* Галерея продуктов */
.products_index {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 73px;
}
@media (max-width: 768px) {
    .products_index {
        gap: 20px;
        justify-content: center;
        padding: 20px;
    }
}
    </style>
</head>
<body>
<?php
include 'connect.php';
?>

<div class="search-form">
    <p class="filter_title"><b>Что ищем?</b></p>
    <form method="get" action="?page=catalog" class="search_flex">
        <input type="hidden" name="page" value="catalog">
        <input type="text" class="search-input" name="search" placeholder="Поиск по названию" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <input type="submit" class="search_btn" value="Поиск">
    </form>
</div>

<div class="filter_div">
    <p class="filter_title"><b>Сортировка</b></p>
    <form method="get" action="?page=catalog" class="filter_flex">
        <input type="hidden" name="page" value="catalog">
        <?php if (!empty($_GET['search'])): ?>
            <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search']) ?>">
        <?php endif; ?>
        <?php if (!empty($_GET['category'])): ?>
            <input type="hidden" name="category" value="<?= htmlspecialchars($_GET['category']) ?>">
        <?php endif; ?>
        <?php if (!empty($_GET['anime'])): ?>
            <input type="hidden" name="anime" value="<?= htmlspecialchars($_GET['anime']) ?>">
        <?php endif; ?>
        
        <select class="select_filter" name="sort">
            <option value="">Сбросить по умолчанию</option>
            <option value="price_asc" <?= ($_GET['sort'] ?? '') == 'price_asc' ? 'selected' : '' ?>>Сначала дешёвые</option>
            <option value="price_desc" <?= ($_GET['sort'] ?? '') == 'price_desc' ? 'selected' : '' ?>>Сначала дорогие</option>
            <option value="name_asc" <?= ($_GET['sort'] ?? '') == 'name_asc' ? 'selected' : '' ?>>От А до Я</option>
            <option value="name_desc" <?= ($_GET['sort'] ?? '') == 'name_desc' ? 'selected' : '' ?>>От Я до А</option>
        </select>
        <input type="submit" class="filter_btn" value="Применить">
    </form>
</div>

<div class="filter_div">
    <p class="filter_title"><b>Аниме</b></p>
    <form method="get" action="?page=catalog" class="filter_flex">
        <input type="hidden" name="page" value="catalog">
        <?php if (!empty($_GET['search'])): ?>
            <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search']) ?>">
        <?php endif; ?>
        <?php if (!empty($_GET['category'])): ?>
            <input type="hidden" name="category" value="<?= htmlspecialchars($_GET['category']) ?>">
        <?php endif; ?>
        <?php if (!empty($_GET['sort'])): ?>
            <input type="hidden" name="sort" value="<?= htmlspecialchars($_GET['sort']) ?>">
        <?php endif; ?>
        
        <select class="select_filter" name="anime">
            <option value="">Сбросить по умолчанию</option>
            <option value="arcane" <?= ($_GET['anime'] ?? '') == 'arcane' ? 'selected' : '' ?>>Arcane</option>
            <option value="alien" <?= ($_GET['anime'] ?? '') == 'alien' ? 'selected' : '' ?>>Alien Stage</option>
            <option value="oshi" <?= ($_GET['anime'] ?? '') == 'oshi' ? 'selected' : '' ?>>Oshi no Ko</option>
            <option value="juju" <?= ($_GET['anime'] ?? '') == 'juju' ? 'selected' : '' ?>>Jujutsu Kaisen</option>
            <option value="jojo" <?= ($_GET['anime'] ?? '') == 'jojo' ? 'selected' : '' ?>>JoJo's Bizarre Adventure</option>
        </select>
        <input type="submit" class="filter_btn" value="Применить">
    </form>
</div>

<div class="categories_flex">
    <?php
    $categories = $connect->query("SELECT * FROM categories");
    while($cat = $categories->fetch_assoc()): 
        $active = isset($_GET['category']) && $_GET['category'] == $cat['id'] ? 'active' : '';
    ?>
        <a href="?page=catalog&category=<?= $cat['id'] ?>" class="category_but <?= $active ?>">
            <?= htmlspecialchars($cat['category_name']) ?>
        </a>
    <?php endwhile; ?>
</div>

<div class="products_index">
    <?php
    $sql = "SELECT * FROM products WHERE 1=1";
    
    if (!empty($_GET['category'])) {
        $category_id = (int)$_GET['category'];
        $sql .= " AND category_id = $category_id";
    }
    
    if (!empty($_GET['search'])) {
        $search = $connect->real_escape_string($_GET['search']);
        $sql .= " AND name LIKE '%$search%'";
    }
    
    if (!empty($_GET['anime'])) {
        $anime = $connect->real_escape_string($_GET['anime']);
        $sql .= " AND anime = '$anime'";
    }
    
    if (!empty($_GET['sort'])) {
        switch ($_GET['sort']) {
            case 'price_asc': $sql .= " ORDER BY price ASC"; break;
            case 'price_desc': $sql .= " ORDER BY price DESC"; break;
            case 'name_asc': $sql .= " ORDER BY name ASC"; break;
            case 'name_desc': $sql .= " ORDER BY name DESC"; break;
        }
    }
    
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()): ?>
            <div class="product_card">
                <div class="product_image" onclick="location.href='product.php?id=<?= $row['id'] ?>'">
                    <img src="<?= $row['img'] ?>">
                </div>
                <div class="product_info">
                    <h3 class="product_title"><?= htmlspecialchars($row['name']) ?></h3>
                    <div class="product_price"><?= number_format($row['price'], 0, '', ' ') ?> ₽</div>
                </div>
<a href="cart.php?add=<?= $row['id'] ?>" class="product_button">Добавить в корзину</a>
            </div>
        <?php endwhile;
    } else {
        echo '<div class="no-products">Товары не найдены</div>';
    }
    ?>
</div>

<?php include 'footer.php'; ?>