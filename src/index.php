<?php

// 接続テスト
try {
    $pdo = new PDO('mysql:host=mysql;dbname=sample', 'root', 'mlrtpd');
    $sql = 'SELECT * FROM Bugs';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
} catch(PDOException $e) {
    echo('Connection failed:'.$e->getMessage());
    die();
}

print_r($result);
