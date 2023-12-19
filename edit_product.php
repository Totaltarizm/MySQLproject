<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагувати продукт</title>
</head>
<body>

<h1>Редагувати продукт</h1>

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
    if (isset($_POST["edit_product"])) {
        $productID = $_POST["product_id"];
        $productName = sanitize_input($_POST["product_name"]);
        $productType = sanitize_input($_POST["product_type"]);
        $productWarranty = intval($_POST["product_warranty"]);
        $productPrice = floatval($_POST["product_price"]);
        $productDate = sanitize_input($_POST["product_date"]);
        $manufacturerID = intval($_POST["manufacturer_id"]);

        // SQL-запит для оновлення всіх полів продукту
        $sql = "UPDATE part SET Name='$productName', Type='$productType', Warranty_period=$productWarranty, Price=$productPrice, Date_of_manufacture='$productDate', manufacturer_ID=$manufacturerID WHERE ID=$productID";

        if ($conn->query($sql) === TRUE) {
            echo "Усі поля продукту успішно оновлено!";
            header("Location: seller_dashboard.php"); // Перенаправлення на головну сторінку після редагування
            exit();
        } else {
            echo "Помилка: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Функція для санітарної очистки введених даних
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!-- Форма для вибору та редагування продукту -->
<form action="" method="post">
    <select name="product_id">
        <?php
        $productSql = "SELECT * FROM part";
        $productResult = $conn->query($productSql);

        while ($product = $productResult->fetch_assoc()) {
            echo "<option value='" . $product['ID'] . "'>" . htmlspecialchars($product['Name']) . "</option>";
        }
        ?>
    </select>
    <br>
    Назва продукту: <input type="text" name="product_name"><br>
    Тип продукту: <input type="text" name="product_type"><br>
    Гарантійний термін: <input type="number" name="product_warranty"><br>
    Ціна продукту: <input type="number" step="0.01" name="product_price"><br>
    Дата виготовлення: <input type="date" name="product_date"><br>

    <!-- Випадаючий список для вибору виробника -->
    Виробник: 
    <select name="manufacturer_id">
        <?php
        $manufacturerSql = "SELECT * FROM manufacturer";
        $manufacturerResult = $conn->query($manufacturerSql);

        while ($manufacturer = $manufacturerResult->fetch_assoc()) {
            echo "<option value='" . $manufacturer['ID'] . "'>" . htmlspecialchars($manufacturer['Manufacturer_Name']) . "</option>";
        }
        ?>
    </select>
    <br>

    <input type="submit" name="edit_product" value="Оновити всі поля продукту">
</form>

<?php
// Закриття з'єднання
$conn->close();
?>

</body>
</html>
