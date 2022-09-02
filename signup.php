<?php
session_start();
require './db.php';
$stmt = $db->prepare('SELECT * FROM cafe');
$stmt->execute();
$cafes = $stmt->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['signupO'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $cafeName = $_POST['cafeName'];
    $password = $_POST['password'];
    $passwordR = $_POST['passwordR'];
    if (!empty($fullname) && !empty($username) && !empty($cafeName) && !empty($password) && !empty($passwordR)) {
        if ($password == $passwordR) {
            $stmt = $db->prepare('SELECT * FROM users WHERE username=?');
            $stmt->execute([$username]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if (!$result) {
                $stmt = $db->prepare('SELECT * FROM cafe WHERE cafe_name=?');
                $stmt->execute([$cafeName]);
                $result = $stmt->fetch(PDO::FETCH_OBJ);
                if (!$result) {
                    $stmt = $db->prepare('INSERT INTO users (username, password, privilage, fullname) VALUES (?,?,?,?)');
                    $flag =  $stmt->execute([$username, $password, 'owner', $fullname]);
                    if ($flag) {
                        $stmt = $db->prepare('INSERT INTO cafe (owner, cafe_name) VALUES (?,?)');
                        $flag =  $stmt->execute([$username, $cafeName]);
                        if ($flag) {
                            //traitement ici
                        } else {
                            $error = 'An error has occured.';
                        }
                    } else {
                        $error = 'An error has occured.';
                    }
                } else {
                    $error = 'Cafe name already taken.';
                }
            } else {
                $error = 'Username already taken.';
            }
        } else {
            $error = "Passwords don't match.";
        }
    } else {
        $error = 'All fields must be filled.';
    }
}

if (isset($_POST['signupW'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $cafeName = $_POST['cafeName'];
    $password = $_POST['password'];
    $passwordR = $_POST['passwordR'];
    if (!empty($fullname) && !empty($username) && !empty($cafeName) && !empty($password) && !empty($passwordR)) {
        if ($password == $passwordR) {
            $stmt = $db->prepare('SELECT * FROM users WHERE username=?');
            $stmt->execute([$username]);
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            if (!$result) {
                $stmt = $db->prepare('INSERT INTO users (username, password, privilage, fullname) VALUES (?,?,?,?)');
                $flag =  $stmt->execute([$username, $password, 'waiter', $fullname]);
                if ($flag) {
                    $stmt = $db->prepare('INSERT INTO contract (contrat_username, contrat_cafe, contrat_status) VALUES (?,?,?)');
                    $flag =  $stmt->execute([$username, $cafeName, 'ko']);
                    if ($flag) {
                        //traitement ici
                    } else {
                        $errorW = 'An error has occured.';
                    }
                } else {
                    $errorW = 'An error has occured.';
                }
            } else {
                $errorW = 'Username already taken.';
            }
        } else {
            $errorW = "Passwords don't match.";
        }
    } else {
        $errorW = 'All fields must be filled.';
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
    <link rel="stylesheet" href="./assets/styles/signup.css">
    <script src="./assets/scripts/signup.js" defer></script>
    <title>Gestion Cafe - Sign Up</title>
</head>

<body>
    <?php include('./components/login-signup-header.php') ?>
    <div class="section">
        <div class="container">
            <div class="toggle">
                <button class="current" id="b1" onclick="CafeOwner()">Cafe owner</button>
                <button id="b2" onclick="Waiter()">Waiter</button>
            </div>
            <div class="forms">
                <div class="owner-form" id="owner-form">
                    <div class="form">
                        <form action="" method="post">
                            <div class="form-container">
                                <label for="fullname">Full name</label>
                                <input type="text" name="fullname" autocomplete="off" />
                                <label for="username">Username</label>
                                <input type="text" name="username" autocomplete="off" />
                                <label for="cafeName">Cafe name</label>
                                <input type="text" name="cafeName" autocomplete="off" />
                                <label for="password">Password</label>
                                <input type="password" name="password" autocomplete="off" />
                                <label for="passwordR">Password repeat</label>
                                <input type="password" name="passwordR" autocomplete="off" />
                                <input type="submit" value="Sign up" name="signupO" />
                                <div class="error">
                                    <?= (isset($error)) ? $error : '' ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="waiter-form" id="waiter-form" style="display: none;">
                    <div class="form">
                        <form action="" method="post">
                            <div class="form-container">
                                <label for="fullname">Full name</label>
                                <input type="text" name="fullname" autocomplete="off" />
                                <label for="username">Username</label>
                                <input type="text" name="username" autocomplete="off" />
                                <label for="cafeName">Cafe name</label>
                                <select name="cafeName">
                                    <?php foreach ($cafes as $cafe) : ?>
                                        <option value="<?= $cafe->cafe_name ?>"><?= $cafe->cafe_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="password">Password</label>
                                <input type="password" name="password" autocomplete="off" />
                                <label for="passwordR">Password repeat</label>
                                <input type="password" name="passwordR" autocomplete="off" />
                                <input type="submit" value="Sign up" name="signupW" />
                                <div class="error">
                                    <?= (isset($errorW)) ? $errorW : '' ?>
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