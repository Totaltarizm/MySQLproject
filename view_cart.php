<?php
session_start();

// Вивід даних про продукти в корзині
echo "<h1>Корзина</h1>";

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Ваша база даних із продуктами
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "carshop";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Запит до бази даних для отримання продуктів з корзини
    $cart_product_ids = implode(',', array_map('intval', $_SESSION['cart']));
    $sql = "SELECT * FROM part WHERE ID IN ($cart_product_ids)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Вивід даних кожного продукту в корзині
        while ($row = $result->fetch_assoc()) {
            echo "<p>Назва: " . htmlspecialchars($row["Name"]) . " - Ціна: " . htmlspecialchars($row["Price"]) . "</p>";

            // Форма для видалення продукту з корзини
            echo '<form action="remove_from_cart.php" method="post">';
            echo '<input type="hidden" name="product_id" value="' . $row["ID"] . '">';
            echo '<input type="submit" value="Видалити">';
            echo '</form>';
        }
    } else {
        echo "Немає даних у корзині";
    }

    $conn->close();
} else {
    echo "Корзина порожня";
}

// Кнопка для повернення на сторінку покупця
echo '<form action="buyer_dashboard.php" method="post">';
echo '<input type="submit" value="Назад">';
echo '</form>';
?>
