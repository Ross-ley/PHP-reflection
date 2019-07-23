<?php
    session_start();
    
    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }

?>

<?php include 'header.php'; ?>
    <div class="nav-bar ">
        <div class="active">
            <a href="logout.php">Log Out</a>
        </div>
        
    </div>
    <div class="container">
        <h1>
            Welcome  <?PHP echo $_SESSION['username']; ?>  
        </h1>
        <div>
            <p>this is the context for the page</p>
        </div>
        <a href="reset_password.php">Reset password</a>
    </div>
<?php include 'footer.php'; ?>