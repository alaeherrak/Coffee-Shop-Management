<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['cafe_name']) || (isset($_SESSION['privilage']) && $_SESSION['privilage'] != 'owner')) header('Location: ./login.php');
if (!isset($_GET['approve']) || !isset($_GET['id'])) header('Location: ./home.php');
if ($_GET['approve'] == 'ok' || $_GET['approve'] == 'no') {
    require './db.php';
    if ($_GET['approve'] == 'ok') {
        $stmt = $db->prepare('UPDATE contract SET contrat_status=? WHERE id_contrat=?');
        $stmt->execute(['ok', $_GET['id']]);
    }
    if ($_GET['approve'] == 'no') {
        $stmt = $db->prepare('UPDATE contract SET contrat_status=? WHERE id_contrat=?');
        $stmt->execute(['no', $_GET['id']]);
    }
    if ($_SESSION['privilage'] == 'owner') header('Location: ./home.php?oa=approve');
    else header('Location: ./home.php');
}
