<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['cafe_name'])) header('Location: ./login.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_SESSION['cafe_name'] . ' - ' . $_SESSION['username'] ?></title>
</head>

<body>
    <?php if ($_SESSION['privilage'] == 'owner') : ?>
<a href="./logout.php">Logout</a>
    <?php endif;
    if ($_SESSION['privilage'] == 'waiter') : ?>
<a href="./logout.php">Logout</a>
    <?php endif; ?>
</body>

</html>