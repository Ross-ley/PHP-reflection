<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

?>

<?php include('header.php'); ?>
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
        <a href="reset-password.php">Reset password</a>
    </div>
<?php include('footer.php'); ?>