<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список продуктів</title>
</head>
<body>

<h1>Список продуктів</h1>

<?php
// Підключення до бази даних
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carshop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка з'єднання
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL-запит для вибору продуктів
$sql = "SELECT * FROM part";
$result = $conn->query($sql);

// Перевірка результатів запиту
if ($result->num_rows > 0) {
    // Вивід даних кожного продукту
    while($row = $result->fetch_assoc()) {
        echo "<p>Назва: " . htmlspecialchars($row["Name"]). " - Ціна: " . htmlspecialchars($row["Price"]). "</p>";

        // Додана кнопка "Додати в корзину" для кожного продукту
        echo '<form action="add_to_cart.php" method="post">';
        echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($row["ID"]) . '">';
        echo '<input type="submit" value="Додати в корзину">';
        echo '</form>';
    }
} else {
    echo "Немає даних про продукти";
}

// Кнопка для перегляду корзини
echo '<button onclick="location.href=\'view_cart.php\'">Переглянути корзину</button>';
?>

<!-- Кнопка "Вийти" -->
<button onclick="location.href='<?php echo htmlspecialchars('login_register.php'); ?>'">Вийти</button>

</body>
</html>
