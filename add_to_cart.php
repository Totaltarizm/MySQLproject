<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    // Отримання ідентифікатора продукту, який додається до корзини
    $product_id = sanitize_input($_POST['product_id']);

    // Додавання ідентифікатора продукту до сесії корзини
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    array_push($_SESSION['cart'], $product_id);

    // Повернення на сторінку покупця
    header("Location: buyer_dashboard.php");
    exit();
} else {
    // Якщо дані неправильні, перенаправте на сторінку покупця
    header("Location: buyer_dashboard.php");
    exit();
}

// Функція для санітарної очистки введених даних
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
