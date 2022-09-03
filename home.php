<?php
session_start();
require './db.php';
if (!isset($_SESSION['username']) || !isset($_SESSION['cafe_name'])) header('Location: ./login.php');
if ($_SESSION['privilage'] == 'waiter') {
    $stmt = $db->prepare('SELECT * FROM contract WHERE contrat_username=?');
    $stmt->execute([$_SESSION['username']]);
    $contrat = $stmt->fetch(PDO::FETCH_OBJ);
    $status_contat = $contrat->contrat_status;
}

if ($_SESSION['privilage'] == 'owner') {
    $stmt = $db->prepare('SELECT * FROM contract WHERE contrat_cafe=? AND contrat_status=?');
    $stmt->execute([$_SESSION['cafe_name'], 'ko']);
    $contrats_ko = $stmt->fetchAll(PDO::FETCH_OBJ);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/styles/home.css">
    <link rel="stylesheet" href="./assets/styles/home-waiter.css">
    <link rel="stylesheet" href="./assets/styles/home-owner.css">
    <title><?= $_SESSION['cafe_name'] . ' - ' . $_SESSION['username'] ?></title>
</head>

<body>
    <?php include('./components/home-header.php') ?>
    <?php if ($_SESSION['privilage'] == 'owner') : ?>
        <div class="owner-container">
            <?php include('./components/home-owner-nav.php') ?>
            <?php include('./components/home-owner-approve.php') ?>
        </div>
    <?php endif;
    if ($_SESSION['privilage'] == 'waiter') : ?>
        <div class="waiter-container">
            <?php if ($status_contat == 'ko') : ?>
                <div class="status-ko">
                    Your account is being approved by the owner of <?= $_SESSION['cafe_name'] ?>.
                </div>
            <?php elseif ($status_contat == 'ok') : ?>

            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>

</html>