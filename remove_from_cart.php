<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    // Отримання та санітарна очистка ідентифікатора продукту для видалення
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);

    // Перевірка, чи ідентифікатор продукту є дійсним числом
    if (!filter_var($product_id, FILTER_VALIDATE_INT)) {
        // Якщо невірний ідентифікатор продукту, перенаправте на сторінку покупця
        header("Location: buyer_dashboard.php");
        exit();
    }

    // Видалення ідентифікатора продукту з сесії корзини
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Пошук індексу продукту у сесії корзини
        $index = array_search($product_id, $_SESSION['cart']);

        // Видалення продукту з корзини
        if ($index !== false) {
            unset($_SESSION['cart'][$index]);
        }
    }

    // Повернення на сторінку покупця
    header("Location: buyer_dashboard.php");
    exit();
} else {
    // Якщо дані неправильні, перенаправте на сторінку покупця
    header("Location: buyer_dashboard.php");
    exit();
}
?>
