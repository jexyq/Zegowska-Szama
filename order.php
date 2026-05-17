<?php
session_start();
require 'includes/db.php';

if(!isset($_SESSION['user_id'])){
    die("Brak dostępu");
}

$data = json_decode(file_get_contents("php://input"), true);

if(empty($data)){
    die("Koszyk pusty");
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    INSERT INTO orders (user_id, status)
    VALUES (?, 'oczekujace')
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$order_id = $stmt->insert_id;

$stmt->close();

foreach($data as $item){

    $product_id = $item['id'];
    $quantity = $item['quantity'];
    $price = $item['price'];

    $stmt = $conn->prepare("
        INSERT INTO order_items
        (order_id, product_id, quantity, price)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "iiid",
        $order_id,
        $product_id,
        $quantity,
        $price
    );

    $stmt->execute();

    $stmt->close();
}

echo "Zamówienie zostało złożone!";
?>