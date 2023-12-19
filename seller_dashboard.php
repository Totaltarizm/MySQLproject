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
    }
} else {
    echo "Немає даних про продукти";
}

// Закриття з'єднання
$conn->close();
?>

<!-- Додайте кнопки "Додати", "Видалити", "Редагувати" -->
<button onclick="location.href='<?php echo htmlspecialchars('add_product.php'); ?>'">Додати продукт</button>
<button onclick="location.href='<?php echo htmlspecialchars('delete_product.php'); ?>'">Видалити продукт</button>
<button onclick="location.href='<?php echo htmlspecialchars('edit_product.php'); ?>'">Редагувати продукт</button>

<!-- Кнопка "Вийти" -->
<button onclick="location.href='<?php echo htmlspecialchars('login_register.php'); ?>'">Вийти</button>

</body>
</html>
