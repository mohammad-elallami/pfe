<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $servername = $_POST['servername'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dbname = $_POST['dbname'];

    
    $conn = new mysqli($servername, $username, $password);

   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

 
    $query = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($query) === TRUE) {
        echo "Database '$dbname' created successfully.<br>";
    } else {
        echo "Error creating database: " . $conn->error;
    }

 
    $conn->select_db($dbname);

   
    $tables = array(
        'product' => "CREATE TABLE IF NOT EXISTS product (
                        product_id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(255) NOT NULL,
                        photolink VARCHAR(255),
                        price DECIMAL(10, 2),
                        ram VARCHAR(50),
                        rom VARCHAR(50),
                        description TEXT
                    )",
        'client' => "CREATE TABLE IF NOT EXISTS client (
                        client_id INT AUTO_INCREMENT PRIMARY KEY,
                        fullname VARCHAR(255) NOT NULL,
                        address VARCHAR(255),
                        city VARCHAR(100),
                        sold DECIMAL(10, 2),
                    )",
        'order' => "CREATE TABLE IF NOT EXISTS orders (
                        order_id INT AUTO_INCREMENT PRIMARY KEY,
                        client_id INT,
                        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (client_id) REFERENCES client(client_id)
                    )",
        'ordersproducts' => "CREATE TABLE IF NOT EXISTS ordersproducts (
                                id INT AUTO_INCREMENT PRIMARY KEY,
                                productid INT,
                                quantity INT,
                                FOREIGN KEY (productid) REFERENCES product(product_id)
                            )"
    );

 
    foreach ($tables as $table => $sql) {
        if ($conn->query($sql) === TRUE) {
            echo "Table '$table' created successfully.<br>";
        } else {
            echo "Error creating table '$table': " . $conn->error;
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Database</title>
</head>
<body>
    <h2>Create Database</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="servername">Server Name:</label>
        <input type="text" id="servername" name="servername" required><br><br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="dbname">Database Name:</label>
        <input type="text" id="dbname" name="dbname" required><br><br>
        <button type="submit">Create Database</button>
    </form>
</body>
</html>
