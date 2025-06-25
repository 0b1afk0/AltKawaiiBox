<?php
ob_start();
session_start();
require_once 'header.php';
include 'connect.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user']['id'];

// Добавление товара в корзину
if (isset($_GET['add']) && is_numeric($_GET['add'])) {
    $product_id = (int)$_GET['add'];
    
    // Проверяем, есть ли уже товар в корзине
    $check = $connect->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $check->bind_param("ii", $user_id, $product_id);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows > 0) {
        // Увеличиваем количество
        $stmt = $connect->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
    } else {
        // Добавляем новый товар
        $stmt = $connect->prepare("INSERT INTO cart (user_id, product_id) VALUES (?, ?)");
    }
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    header("Location: cart.php");
    exit();
}

// Удаление товара из корзины
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $product_id = (int)$_GET['remove'];
    $stmt = $connect->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    header("Location: cart.php");
    exit();
}

// Обновление количества товаров
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        $product_id = (int)$product_id;
        $quantity = (int)$quantity;
        
        if ($quantity > 0) {
            $stmt = $connect->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("iii", $quantity, $user_id, $product_id);
            $stmt->execute();
        } else {
            // Если количество 0 - удаляем товар
            $stmt = $connect->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
        }
    }
    header("Location: cart.php");
    exit();
}

// Получаем содержимое корзины
$cart_items = [];
$total = 0;

$stmt = $connect->prepare("
    SELECT p.id, p.name, p.price, p.img, c.quantity 
    FROM cart c 
    JOIN products p ON c.product_id = p.id 
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity'];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - AltKawaiiBox</title>
    <style>
              html, body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color:#20262E;
    color: #E9E8E8;
}

        .cart-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: #913175;
            border-radius: 10px;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #CD5888;
        }
        
        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 20px;
        }
        
        .cart-item-info {
            flex-grow: 1;
        }
        
        .cart-item-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .cart-item-price {
            color: #E9E8E8;
        }
        
        .cart-item-remove {
            color: #CD5888;
            text-decoration: none;
            font-weight: bold;
            margin-left: 15px;
        }
        
        .cart-quantity {
            width: 50px;
            padding: 5px;
            text-align: center;
            border-radius: 5px;
            border: 1px solid #CD5888;
            background-color: #20262E;
            color: #E9E8E8;
        }
        
        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        
        .cart-btn {
            background: #CD5888;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .cart-btn:hover {
            background: #913175;
        }
        
        .cart-total {
            text-align: right;
            font-size: 1.5em;
            margin-top: 20px;
        }
        
        .cart-empty {
            text-align: center;
            padding: 50px 0;
        }
        
        .update-btn {
            background-color: #CD5888;
        }
        
        .update-btn:hover {
            background-color: rgb(179, 74, 117);
        }
        
        .order-btn {
            background-color: #CD5888;
        }
        
        .order-btn:hover {
            background-color: rgb(179, 74, 117);
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h1>Ваша корзина</h1>
        
        <?php if (empty($cart_items)): ?>
            <div class="cart-empty">
                <p>Ваша корзина пуста</p>
                <a href="catalog.php" class="cart-btn">Перейти в каталог</a>
            </div>
        <?php else: ?>
            <form method="POST" action="cart.php">
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="cart-item-info">
                            <div class="cart-item-title"><?= htmlspecialchars($item['name']) ?></div>
                            <div class="cart-item-price">
                                <?= number_format($item['price'], 0, '', ' ') ?> ₽
                            </div>
                        </div>
                        <input type="number" name="quantity[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="cart-quantity">
                        <a href="cart.php?remove=<?= $item['id'] ?>" class="cart-item-remove">×</a>
                    </div>
                <?php endforeach; ?>
                
                <div class="cart-total">
                    Итого: <?= number_format($total, 0, '', ' ') ?> ₽
                </div>
                
                <div class="cart-actions">
                    <button type="submit" name="update_cart" class="cart-btn update-btn">Сохранить изменения</button>
                    <a href="#" class="cart-btn order-btn">Оформить заказ</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>