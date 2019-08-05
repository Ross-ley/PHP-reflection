<div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="<?php echo '../index.php';?>">Home</a>
  <?php
			if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
	?>
    <a href="<?php echo 'user.php';?>"><?php echo $_SESSION['username'];?></a>
  <?php
  } else {
  ?>
    <a href="<?php echo '../login.php';?>">Login</a>
  <?php
  }
  ?>
  <a href="<?php echo 'register.php';?>">Register</a>
  <a href="<?php echo '../contact-form.php';?>">Contact Us</a>
</div>