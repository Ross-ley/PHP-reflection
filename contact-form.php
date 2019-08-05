<?php 
use PHPMailer\PHPMailer\PHPMailer;
require 'vender/phpmailer/src/PHPMailer.php';
require 'vender/phpmailer/src/Exception.php';
require 'vender/phpmailer/src/SMTP.php';


if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING));
  $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
  $details = trim(filter_input(INPUT_POST, "details", FILTER_SANITIZE_SPECIAL_CHARS));
  
  if($name == "" || $email == ""){
    $error_message = "Please fill in the required fields: Name and Email.";
  }
  
  if(!isset($error_message) && $_POST["address"] != ""){
    $error_message = "Bad form input";
  }

  if(!isset($error_message) && !PHPMailer::validateAddress($email)){
    $error_message = "Invalid Email Address";
  }
  
  if(!isset($error_message)){
    $email_body = "";
    $email_body .= "Name " . $name . "\n";
    $email_body .= "Email " . $email . "\n";
    $email_body .= "\n\nSuggested Item\n\n";
    $email_body .= "Details: " . $details . "\n";
    
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 2;
    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6
    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;
    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "ross.ley1997@gmail.com";
    //Password to use for SMTP authentication
    $mail->Password = "ymajhddydqylcifz";
    //It's important not to use the submitter's address as the from address as it's forgery,
    //which will cause your messages to fail SPF checks.
    //Use an address in your own domain as the from address, put the submitter's address in a reply-to

    $mail->setFrom( $email, $name);
    $mail->addReplyTo($email, $name);
    $mail->addAddress($email, 'Ross-ley Bunn');
    $mail->Subject = "Bug fix suggestions from " . $name; //title of email that comes through
    $mail->Body = $email_body;
    if ($mail->send()) {
      header("location:contact-form.php?status=thanks");
      exit;
    }
      $error_message = "Mailer Error: " . $mail->ErrorInfo;
  }
};

// echo isLogedIn();

include("inc/nav-bar.php");
?>
<div class="third">
  <div class="container">
    <div class="section page">
      <div class="wrapper">
          <h1>Get in Contact</h1>
          <?php if(isset($_GET["status"]) && $_GET["status"] == "thanks")
              {
                  echo "<p>Thanks for the email!</p>";
              } else { 
                  if(isset($error_message)){
                  echo '<p class="message">' . $error_message . '</p>';
                  } else {
                  echo '<p>If you think there is something wrong or you need help, let me know!</p>';
                  }
      ?>
          <form method="post" action="contact-form.php">
              <table class="table">
                  <tr class="flexy">
                  <th><label for="name">Name (required)</label></th>
                  <td><input type="text" id="name" name="name"  value="<?php if(isset($name)) echo $name; ?>"/></td>
                  </tr>
                  <tr class="flexy">
                  <th><label for="email">Email (required)</label></th>
                  <td><input type="text" id="email" name="email" value="<?php if(isset($email)) echo $email; ?>"/></td>
                  </tr>
                  <tr class="flexy">
                  <th><label for="name">Details</label></th>
                  <td><textarea name="details" id="details" ><?php if(isset($details)) echo htmlspecialchars($_POST['details']); ?></textarea></td>
                  </tr>
                  <tr style="display:none">
                  <th><label for="address">Address</label></th>
                  <td><input type="text" id="address" name="address" />
                      <p>Please leave this field blank</p>
                  </td>
                  </tr>
              </table>
              <button type="submit" value="Send" class="btn contact-btn">Send</button>
          </form>
          <?php } ?>
        </div>
      </div>
    </div>
</div>


<?php include("inc/footer.php"); ?>