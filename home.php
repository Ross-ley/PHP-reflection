<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }
?>

<?php include 'header.php'; ?>
    <div class="container">
    <a href="logout.php">Log Out</a>
        <h1>
            Welcome  <?PHP echo $_SESSION['username']; ?>  
        </h1>
    </div>
<?php include 'footer.php'; ?>