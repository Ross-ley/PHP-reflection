<?php
use PHPMailer\PHPMailer\Exception;
use Symfony\Component\CssSelector\Parser\Handler\StringHandler;
session_start();

include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if ($_POST['table'] == 1) {
        $table = 'animelike';
    } else {
        $table = 'mangalike';
    }
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $usernameAM = $_SESSION['username'];
    try {
        $sql_anime = "SELECT * FROM $table WHERE username = ? AND id = $id";
        $query = $pdo->prepare($sql_anime);
        $query->bindParam(1, $usernameAM);
        $query->execute();
        $aniLi = $query->fetch(PDO::FETCH_ASSOC);
        if ($aniLi) {
            try {
                $sql_anime = "DELETE FROM $table WHERE id = $id  AND username = ?";
                $query = $pdo->prepare($sql_anime);
                $query->bindParam(1, $usernameAM); 
                $query->execute();
            } catch (Exception $e ) {
                echo "This update wasn't successful";
            };
        } else {
            try {
                $sql_anime = "INSERT INTO $table (username, id) VALUES ( ? , ?)";
                $query = $pdo->prepare($sql_anime);
                $query->bindParam(1, $usernameAM, PDO::PARAM_STR);
                $query->bindParam(2, $id, PDO::PARAM_STR);
                $query->execute();
            } catch (Exception $e ) {
                echo "This insert wasn't successful";
            };
        }
    } catch(Exception $e){
        echo "Sorry this could not be completed";
    }
}