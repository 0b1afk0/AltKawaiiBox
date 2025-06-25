<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'connect.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
} else {
    $message = '';
}

if (isset($_GET['delete_product'])) {
    $id = intval($_GET['delete_product']);
    error_log("Attempting to delete product ID: $id");
    
    try {
        $connect->begin_transaction();
        
        $check = $connect->prepare("SELECT id FROM products WHERE id = ?");
        $check->bind_param("i", $id);
        $check->execute();
        $check->store_result();
        
        if ($check->num_rows > 0) {
            $connect->query("DELETE FROM reviews WHERE product_id = $id");
            
            $stmt = $connect->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                $_SESSION['message'] = "Товар успешно удалён!";
                error_log("Product ID $id deleted successfully");
            } else {
                $_SESSION['message'] = "Ошибка при удалении товара.";
            }
            $stmt->close();
        } else {
            $_SESSION['message'] = "Товар с ID $id не найден.";
        }
        $check->close();
        
        $connect->commit();
        
    } catch (Exception $e) {
        $connect->rollback();
        
        if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
            $_SESSION['message'] = "Ошибка: Невозможно удалить товар, так как он связан с другими данными. Сначала удалите связанные элементы.";
        } else {
            $_SESSION['message'] = "Ошибка: " . $e->getMessage();
        }
        
        error_log("Error deleting product: " . $e->getMessage());
    }
    
    header("Location: admin_panel.php");
    exit();
}

try {
    $result = $connect->query("DESCRIBE products");
    $columns = [];
    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }

    if (!in_array('price', $columns)) {
        $connect->query("ALTER TABLE products ADD COLUMN price DECIMAL(10,2) NOT NULL DEFAULT 0.00");
    }

    if (!in_array('description', $columns)) {
        $connect->query("ALTER TABLE products ADD COLUMN description TEXT");
    }
} catch (Exception $e) {
    die("Ошибка при проверке структуры таблицы: " . $e->getMessage());
}

if (isset($_POST['add_product'])) {
    $name = trim($_POST['product_name']);
    $img = trim($_POST['product_img']);
    $price = trim($_POST['product_price']);
    $description = trim($_POST['product_description']);
    $category_id = intval($_POST['product_category']);
    $anime = trim($_POST['product_anime']);

    $allowed_anime = ['jojo', 'alien', 'juju', 'oshi', 'arcane'];
    if (!in_array($anime, $allowed_anime)) {
        $message = "Выберите корректное аниме из списка!";
    } elseif ($name && $img && $price !== '' && $description && $category_id) {
        try {
            $stmt = $connect->prepare("INSERT INTO products (name, img, price, description, category_id, anime) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsis", $name, $img, $price, $description, $category_id, $anime);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                $message = "Товар успешно добавлен!";
            } else {
                $message = "Ошибка при добавлении товара.";
            }
            $stmt->close();
        } catch (Exception $e) {
            $message = "Ошибка: " . $e->getMessage();
        }
    } else {
        $message = "Пожалуйста, заполните все поля!";
    }
}

if (isset($_GET['delete_review'])) {
    $id = intval($_GET['delete_review']);
    try {
        $stmt = $connect->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Отзыв успешно удалён!";
        } else {
            $_SESSION['message'] = "Отзыв с таким ID не найден.";
        }
        $stmt->close();
        
        header("Location: admin_panel.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['message'] = "Ошибка при удалении отзыва: " . $e->getMessage();
        header("Location: admin_panel.php");
        exit();
    }
}

try {
    $users = $connect->query("SELECT * FROM users");
    $products = $connect->query("SELECT * FROM products");
    $reviews = $connect->query(
        "SELECT r.*, u.user_name, u.last_name, p.name AS product_name
                FROM reviews r
                JOIN users u ON r.user_id = u.id
                JOIN products p ON r.product_id = p.id
                ORDER BY r.created_at DESC"
    );
    
    if ($users === false || $products === false || $reviews === false) {
        throw new Exception("Ошибка выполнения запроса: " . $connect->error);
    }
} catch (Exception $e) {
    die("Ошибка при получении данных: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель - AltKawaiiBox</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
      body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background-color: #20262E;
    color: #E9E8E8;
}

/* Основной контейнер */
.container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 0 20px;
}

/* Заголовки */
h1 {
    text-align: center;
    font-size: 2.5em;
    color: #CD5888;
}

h2 {
    margin-top: 40px;
    font-size: 2em;
    color: #CD5888;
}

/* Форма */
form {
    margin-top: 20px;
}

/* Поля формы */
input[type=text], input[type=number], textarea, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 4px;
    border: 1px solid #ccc;
    background-color: #333;
    color: #fff;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* Кнопки */
button {
    padding: 10px 20px;
    background-color: #CD5888;
    border: none;
    border-radius: 4px;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #a0456e;
}

/* Таблица */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #333;
}

th, td {
    padding: 12px;
    border: 1px solid #444;
    text-align: left;
    font-family: 'Poppins', sans-serif;
}

/* Заголовки таблицы */
th {
    background-color: #CD5888;
    color: white;
}

/* Чередование строк */
tr:nth-child(even) {
    background-color: #3a3a3a;
}

/* Изображения */
img {
    max-width: 100px;
    height: auto;
}

/* Кнопка-ссылка */
.btn {
    display: inline-block;
    padding: 6px 12px;
    background-color: #c0392b;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn:hover {
    background-color: #8e2e1e;
}

/* Сообщение */
.message {
    padding: 10px;
    margin: 10px 0;
    border-radius: 4px;
    background-color: #CD5888;
    color: white;
}

/* Адаптивность для мобильных устройств */
@media (max-width: 768px) {
    /* Уменьшаем размеры заголовков */
    h1 {
        font-size: 2em;
    }

    h2 {
        font-size: 1.5em;
    }

    /* Поля формы и кнопки */
    input[type=text], input[type=number], textarea, select {
        font-size: 14px;
    }

    button {
        width: 100%;
        font-size: 1em;
    }

    /* Таблица и изображения */
    table {
        font-size: 14px;
    }

    img {
        max-width: 80px;
    }
}
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="container">
        <h1>Админ-панель</h1>

        <?php if (!empty($message)): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <h2>Добавить товар</h2>
        <form method="post" action="">
            <label>Название товара</label>
            <input type="text" name="product_name" required>

            <label>Ссылка на изображение</label>
            <input type="text" name="product_img" required>

            <label>Цена</label>
            <input type="number" step="0.01" name="product_price" required>

            <label>Описание</label>
            <textarea name="product_description" rows="4" required></textarea>

            <label>Категория</label>
            <select name="product_category" required>
                <option value="1">Фигурки</option>
                <option value="2">Еда</option>
                <option value="3">Плакаты</option>
                <option value="4">Наклейки</option>
                <option value="5">Манга</option>
                <option value="6">Мерч</option>
                <option value="7">Канцелярия</option>
            </select>

            <label>Аниме</label>
            <select name="product_anime" required>
                <option value="">-- Выберите аниме --</option>
                <option value="jojo">JoJo</option>
                <option value="alien">Alien</option>
                <option value="juju">Juju</option>
                <option value="oshi">Oshi</option>
                <option value="arcane">Arcane</option>
            </select>

            <button type="submit" name="add_product">Добавить</button>
        </form>
        <h2>Список товаров</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Изображение</th>
                    <th>Цена</th>
                    <th>Описание</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $products->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['id']) ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><img src="<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>"></td>
                        <td><?= number_format($product['price'], 2, '.', '') ?> ₽</td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                        <td>
                            <a class="btn" href="?delete_product=<?= $product['id'] ?>" onclick="return confirm('Удалить этот товар?')">Удалить</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Отзывы</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Автор</th>
                    <th>Продукт</th>
                    <th>Отзыв</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($review = $reviews->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($review['id']) ?></td>
                        <td><?= htmlspecialchars($review['user_name'] . ' ' . $review['last_name']) ?></td>
                        <td><?= htmlspecialchars($review['product_name']) ?></td>
                        <td><?= htmlspecialchars($review['text']) ?></td>
                        <td><?= date('d.m.Y H:i', strtotime($review['created_at'])) ?></td>
                        <td>
                            <a class="btn" href="?delete_review=<?= $review['id'] ?>" onclick="return confirm('Удалить этот отзыв?')">Удалить</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2>Пользователи</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Email</th>
                    <th>Роль</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['user_name']) ?></td>
                        <td><?= htmlspecialchars($user['last_name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>