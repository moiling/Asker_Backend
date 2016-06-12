<?php
$pdoDsn = 'mysql:host=localhost;dbname=asker';
$pdoUser = 'moi';
$pdoPassword = 'moi';

try {
    $pdo = new PDO($pdoDsn, $pdoUser, $pdoPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES UTF8');
} catch (PDOException $e) {
    echo $e->getMessage();
}