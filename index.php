<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Головна сторінка</title>
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
        while ($row = $result->fetch_assoc()) {
            $productName = htmlspecialchars($row["Name"]);
            $productPrice = htmlspecialchars($row["Price"]);
            echo "<p>Назва: " . $productName . " - Ціна: " . $productPrice . "</p>";
        }
    } else {
        echo "Немає даних про продукти";
    }

    // Закриття з'єднання
    $conn->close();
    ?>

    <!-- Додайте кнопку "Вхід/Реєстрація" -->
    <a href="login_register.php">Вхід/Реєстрація</a>

</body>

</html>
