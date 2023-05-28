<?php

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$statement = $pdo->prepare('DELETE FROM users WHERE id = 2');
$statement->execute();