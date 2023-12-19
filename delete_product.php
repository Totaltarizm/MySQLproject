<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Видалити продукт</title>
</head>
<body>

<h1>Видалити продукт</h1>

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Обробка форми після відправлення
    if (isset($_POST["delete_product"])) {
        $productIDs = $_POST["product_ids"];

        // Перевірка, чи вибрано хоча б один продукт для видалення
        if (empty($productIDs)) {
            echo "Будь ласка, виберіть продукт(-и) для видалення.";
        } else {
            // SQL-запит для видалення обраних продуктів
            $sql = "DELETE FROM part WHERE ID IN (" . implode(",", $productIDs) . ")";

            if ($conn->query($sql) === TRUE) {
                echo "Продукти успішно видалено!";
                header("Location: seller_dashboard.php"); // Перенаправлення на головну сторінку після видалення
                exit();
            } else {
                echo "Помилка: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

// SQL-запит для отримання списку продуктів
$productSql = "SELECT * FROM part";
$productResult = $conn->query($productSql);
?>

<!-- Форма для вибору продуктів для видалення -->
<form action="" method="post">
    <?php
    while ($product = $productResult->fetch_assoc()) {
        echo "<input type='checkbox' name='product_ids[]' value='" . $product['ID'] . "'>";
        echo htmlspecialchars($product["Name"]) . " - Ціна: " . $product["Price"] . "<br>";
    }
    ?>
    <input type="submit" name="delete_product" value="Видалити обрані продукти">
</form>

<?php
// Закриття з'єднання
$conn->close();
?>

</body>
</html>
