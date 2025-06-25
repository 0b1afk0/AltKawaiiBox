<?php
require_once 'connect.php';
session_start();
$user_id = $_SESSION['user_id'] ?? null;
if ($user_id === null) {
    header("Location: login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['Id_products'] ?? ''; 
    $quantity = 1; 
    if (empty($product_id)) {
        echo "Ошибка: Не указан ID продукта.";
        exit;
    }
    $query = "INSERT INTO cart (user_id, product_id, quantity) 
              VALUES (?, ?, ?)
              ON DUPLICATE KEY UPDATE quantity = quantity + ?"; 
    $stmt = $connect->prepare($query);
    if ($stmt === false) {
        die("Ошибка подготовки запроса: " . $connect->error);
    }
    $stmt->bind_param("iiii", $user_id, $product_id, $quantity, $quantity);
    
    if ($stmt->execute()) {
        header("Location: cart.php"); 
        exit;
    } else {
        echo "Ошибка добавления в корзину: " . $stmt->error;
    }
}
