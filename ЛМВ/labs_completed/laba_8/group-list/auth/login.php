<?php
    if ($_POST) {
        require('../data/declare-users.php');
        $found = false;
        foreach ($data['users'] as $user) {
            if ($user['name'] == $_POST['username']) {
                $found = true;
                break;
            }
        }
        if ($found) {
            if ($user['pwd'] == $_POST['password']) {
                session_start();
                $_SESSION['user'] = $user['name'];
                header('Location: ../index.php');
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../css/login-style.css">
</head>
<body>
    <form method="post">
        <p>
            <input  type="text" name="username" placeholder="username">
        </p>
        <p>
            <input type="password" name="password" placeholder="password">
        </p>
        <p>
            <input type="submit" value="login">
        </p>
    </form>
</body>
</html>