<?php

error_reporting(E_ALL);
error_reporting(-1);

// making the object
$host = "localhost";
$db = "userregistration";
$user = "root";
$pass = "";

$dsn = "mysql:host=$host;dbname=$db";
$attributes = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];
try {
    $pdo = new PDO($dsn, $user, $pass, $attributes);
} catch (PDOException $e) {
    echo "<pre>Cannot connect to Database";
    echo $e->getMessage();
    echo "</pre>";
    exit;
}
