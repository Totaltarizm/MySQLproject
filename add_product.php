<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати продукт</title>
</head>
<body>

<h1>Додати продукт</h1>

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
    $name = sanitizeInput($_POST["name"]);
    $type = sanitizeInput($_POST["type"]);
    $warranty = sanitizeInput($_POST["warranty"]);
    $price = sanitizeInput($_POST["price"]);
    $date = sanitizeInput($_POST["date"]);
    $manufacturerID = sanitizeInput($_POST["manufacturer"]);

    // SQL-запит для додавання нового продукту
    $sql = "INSERT INTO part (Name, Type, Warranty_period, Price, Date_of_manufacture, manufacturer_ID) 
            VALUES ('$name', '$type', '$warranty', '$price', '$date', '$manufacturerID')";

    if ($conn->query($sql) === TRUE) {
        echo "Продукт успішно додано!";
        header("Location: seller_dashboard.php"); // Перенаправлення на головну сторінку після додавання
        exit();
    } else {
        echo "Помилка: " . $sql . "<br>" . $conn->error;
    }
}

// Отримання списку виробників для вибору
$manufacturerSql = "SELECT * FROM manufacturer";
$manufacturerResult = $conn->query($manufacturerSql);
?>

<!-- Форма для додавання продукту -->
<form action="" method="post">
    Назва: <input type="text" name="name" required><br>
    Тип: <input type="text" name="type" required><br>
    Гарантійний термін: <input type="number" name="warranty" required><br>
    Ціна: <input type="number" name="price" required><br>
    Дата виготовлення: <input type="date" name="date" required><br>
    Виробник:
    <select name="manufacturer">
        <?php
        while ($manufacturer = $manufacturerResult->fetch_assoc()) {
            echo "<option value='" . $manufacturer['ID'] . "'>" . $manufacturer['Manufacturer_Name'] . "</option>";
        }
        ?>
    </select><br>
    <input type="submit" value="Додати продукт">
</form>

<?php
// Закриття з'єднання
$conn->close();

// Функція для санітарної очистки введених даних
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

</body>
</html>
