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

// Реєстрація
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Перевірка паролів
    if ($password == $confirm_password) {
        // Хешування паролю
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Підготовлений запит для додавання користувача до бази даних
        $stmt = $conn->prepare("INSERT INTO users (Name, Email, Password, role_ID) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            echo "Реєстрація пройшла успішно.";
        } else {
            echo "Помилка при реєстрації: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Паролі не співпадають.";
    }
}

// Вхід
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];

    // Підготовлений запит для пошуку користувача в базі даних
    $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Перевірка паролю
        if (password_verify($password, $row['Password'])) {
            // Вхід відбувся успішно
            $role = $row['role_ID'];
            if ($role == 1) {
                header("Location: seller_dashboard.php"); // Перенаправлення на сторінку продавця
            } elseif ($role == 2) {
                header("Location: buyer_dashboard.php"); // Перенаправлення на сторінку покупця
            } else {
                echo "Невідомий тип користувача.";
            }
        } else {
            echo "Невірний пароль.";
        }
    } else {
        echo "Користувача з таким email не знайдено.";
    }

    $stmt->close();
}

// Закриття з'єднання
$conn->close();

// Функція для санітарної очистки введених даних
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід/Реєстрація</title>
</head>
<body>

<h1>Вхід</h1>
<form action="" method="post">
    <!-- Поля для входу -->
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>
    <label for="password">Пароль:</label>
    <input type="password" name="password" required><br>
    <input type="submit" name="login" value="Увійти">
</form>

<h1>Реєстрація</h1>
<form action="" method="post">
    <!-- Поля для реєстрації -->
    <label for="name">Ім'я:</label>
    <input type="text" name="name" required><br>
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>
    <label for="password">Пароль:</label>
    <input type="password" name="password" required><br>
    <label for="confirm_password">Підтвердження паролю:</label>
    <input type="password" name="confirm_password" required><br>
    <label for="role">Тип акаунта:</label>
    <select name="role" required>
        <option value="1">Продавець</option>
        <option value="2">Покупець</option>
    </select><br>
    <input type="submit" name="register" value="Зареєструватися">
</form>

</body>
</html>
