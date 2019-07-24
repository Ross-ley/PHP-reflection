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

    // sending the data to the database



    $name = $_POST['user'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $s = "SELECT * FROM usertable WHERE name ='$name'";

 

    $num = $pdo->query($s);


    if ($num->fetch()) {
        echo " Username Already Taken";
    } else {
        $reg = " INSERT INTO usertable(name , password) VALUES ('$name' , '$hash')";
        $tim = $pdo->prepare($reg);
        $tim->execute();
        echo " Registration Successful";
    }

    header('location:login.php');

?>