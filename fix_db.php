<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
$pdo->exec('DROP DATABASE IF EXISTS eleva_tech');
$pdo->exec('CREATE DATABASE eleva_tech');
echo "Database reset successfully.\n";
