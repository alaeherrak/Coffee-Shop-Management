<?php
session_start();
require './db.php';
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!empty($username) && !empty($password)) {
        $stmt = $db->prepare('SELECT * FROM users WHERE username=? AND password=?');
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if ($user) {
            $_SESSION['username'] = $user->username;
            $_SESSION['privilage'] = $user->privilage;
            switch ($user->privilage) {
                case 'owner':
                    $stmt = $db->prepare('SELECT * FROM cafe WHERE owner=?');
                    $stmt->execute([$user->username]);
                    $cafe = $stmt->fetch(PDO::FETCH_OBJ);
                    $_SESSION['cafe_name'] = $cafe->cafe_name;
                    break;
                case 'waiter':
                    $stmt = $db->prepare('SELECT * FROM contract WHERE contrat_username=?');
                    $stmt->execute([$user->username]);
                    $cafe = $stmt->fetch(PDO::FETCH_OBJ);
                    $_SESSION['cafe_name'] = $cafe->contrat_cafe;
                    break;
            }
            header('Location: ./home.php');
        } else {
            $error = 'Incorrect username or password.';
        }
    } else {
        $error = 'All fields must be filled.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/styles/login-signup.css">
    <link rel="stylesheet" href="./assets/styles/login.css">
    <title>Gestion Cafe - Log In</title>
</head>

<body>
    <?php include('./components/login-signup-header.php') ?>
    <div class="section">
        <div class="container">
            <div class="forms">
                <div>
                    <div class="form">
                        <form action="" method="post">
                            <div class="form-container">
                                <label for="username">Username</label>
                                <input type="text" name="username" autocomplete="off" />
                                <label for="password">Password</label>
                                <input type="password" name="password" autocomplete="off" />
                                <input type="submit" value="Log In" name="login" />
                                <div class="error">
                                    <?= (isset($error)) ? $error : '' ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>