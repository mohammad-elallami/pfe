<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    if(isset($_POST['logout'])) {
      
        $_SESSION = array();

        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

       
        session_destroy();
    } else {
       
        $username = $_POST['username'];
        $password = $_POST['password'];

      
        if ($username === 'admin' && $password === 'password') {
          
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
           
            header('Location: admin.php');
            exit;
        } else {
          
            header('Location: login.php?error=1');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php
    
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo '<p style="color: red;">Invalid username or password.</p>';
    }
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        echo '<p style="color: green;">You are already logged in as ' . $_SESSION['username'] . '.</p>';
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo '<button type="submit" name="logout">Logout</button>';
        echo '</form>';
    } else {
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo '<label for="username">Username:</label>';
        echo '<input type="text" id="username" name="username" required><br><br>';
        echo '<label for="password">Password:</label>';
        echo '<input type="password" id="password" name="password" required><br><br>';
        echo '<button type="submit">Login</button>';
        echo '</form>';
    }
    ?>
</body>
</html>
