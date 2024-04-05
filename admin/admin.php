<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
   
    header('Location: login.php');
    exit;
}


$inactive = 1800; 
if (isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
     
        session_destroy();
        header('Location: login.php');
        exit;
    }
}
$_SESSION['timeout'] = time();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
  
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
        }

        header .user-info {
            text-align: right;
        }

        header a {
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #fff;
            border-radius: 5px;
        }

        header a:hover {
            background-color: #fff;
            color: #333;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .container {
            padding: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Admin Page</h1>
        <div class="user-info">
            <span>Welcome, <?php echo $_SESSION['username']; ?>!</span>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </header>
    <div class="container">
        <h2>Admin Page Content</h2>
        <p>This is the admin page content.</p>
    </div>
    <footer>
        &copy; 2024 Ecom pfe. All rights reserved.
    </footer>
</body>
</html>
