<?php
if (!isset($_SESSION['username']) || !isset($_SESSION['cafe_name'])) header('Location: ./login.php');
?>
<div class="owner-nav">
    <div><a href="./home.php?oa=approve">Approve (<?= (isset($contrats_ko)) ? count($contrats_ko) : '0' ?>)</a></div>
</div>