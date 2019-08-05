<?php
    include('header.php');
?>
<div class="nav-bar">
  <a id="home" href="../index.php">Home</a>
  <?php 
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  ?>
  <a href="../login.php" id="login">Login</a>
  <?php
    } else {
  ?>
  <div class="active">
    <a href="logout.php">Log Out</a>
  </div>
  <?php
    }
  ?>
  <a href="../contact-form.php" id="contact">Contact Us</a>
  <button class="atom openbtn" onclick="openNav()">
    <div class="burger"></div>
    <div class="burger"></div>
    <div class="burger"></div>
</button>
</div>
<?php
  include('sidebar.php'); 
?>