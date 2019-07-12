<?php
session_start();
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

// checking the database.

$name = $_POST['user'];
$password = $_POST['password'];


$s = "SELECT * FROM usertable where name ='$name'";


$num = $pdo->query($s);
$currentPass = $num->fetch(PDO::FETCH_ASSOC);
var_dump($currentPass);
if (password_verify($password, $currentPass['password'])){
    header('location:../../home.php');
    $_SESSION['username'] = $name;
} else  {
    header('location:../../login.php');
}

