<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=gestion_cafe', 'root', '');
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}
