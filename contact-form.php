<?php
// use PHPMailer\PHPMailer\PHPMailer;
// require 'vender/phpmailer/src/PHPMailer.php';
// require 'vender/phpmailer/src/Exception.php';
// require 'vender/phpmailer/src/SMTP.php';

// if($_SERVER["REQUEST_METHOD"] == "POST") {
//   $name = trim(filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING));
//   $email = trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL));
// //   $category = trim(filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRING));
// //   $title = trim(filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING));
// //   $format = trim(filter_input(INPUT_POST, "format", FILTER_SANITIZE_STRING));
// //   $genre = trim(filter_input(INPUT_POST, "genre", FILTER_SANITIZE_STRING));
// //   $year = trim(filter_input(INPUT_POST, "year", FILTER_SANITIZE_NUMBER_INT));
// //   $details = trim(filter_input(INPUT_POST, "details", FILTER_SANITIZE_SPECIAL_CHARS));
  
//   if($name == "" || $email == "" || $category == "" || $title == "" ){
//     $error_message = "Please fill in the required fields: Name, Email, Category and Title.";
//   }
  
//   if(!isset($error_message) && $_POST["address"] != ""){
//     $error_message = "Bad form input";
//   }

//   if(!isset($error_message) && !PHPMailer::validateAddress($email)){
//     $error_message = "Invalid Email Address";
//   }
  
//   if(!isset($error_message)){
//     $email_body = "";
//     $email_body .= "Name " . $name . "\n";
//     $email_body .= "Email " . $email . "\n";
//     // $email_body .= "\n\nSuggested Item\n\n";
//     // $email_body .= "Category: " . $category . "\n";
//     // $email_body .= "Title: " . $title . "\n";
//     // $email_body .= "Format: " . $format . "\n";
//     // $email_body .= "Genre: " . $genre . "\n";
//     // $email_body .= "Year: " . $year . "\n";
//     // $email_body .= "Details: " . $details . "\n";
    
//     $mail = new PHPMailer;
//     //Tell PHPMailer to use SMTP
//     $mail->isSMTP();
//     //Enable SMTP debugging
//     // 0 = off (for production use)
//     // 1 = client messages
//     // 2 = client and server messages
//     $mail->SMTPDebug = 2;
//     //Set the hostname of the mail server
//     $mail->Host = 'smtp.gmail.com';
//     // use
//     // $mail->Host = gethostbyname('smtp.gmail.com');
//     // if your network does not support SMTP over IPv6
//     //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
//     $mail->Port = 587;
//     //Set the encryption system to use - ssl (deprecated) or tls
//     $mail->SMTPSecure = 'tls';
//     //Whether to use SMTP authentication
//     $mail->SMTPAuth = true;
//     //Username to use for SMTP authentication - use full email address for gmail
//     $mail->Username = "ross.ley1997@gmail.com";
//     //Password to use for SMTP authentication
//     $mail->Password = "ymajhddydqylcifz";
//     //It's important not to use the submitter's address as the from address as it's forgery,
//     //which will cause your messages to fail SPF checks.
//     //Use an address in your own domain as the from address, put the submitter's address in a reply-to
//     $mail->setFrom('ross.ley1997@gmail.com', $name);
//     $mail->addReplyTo($email, $name);
//     $mail->addAddress('ross.ley1997@gmail.com', 'Ross-ley Bunn');
//     $mail->Subject = 'Library suggestion from ' . $name;
//     $mail->Body = $email_body;
//     if ($mail->send()) {
//       header("location:suggest.php?status=thanks");
//       exit;
//     }
//       $error_message = "Mailer Error: " . $mail->ErrorInfo;
//   }
// };



include 'nav-bar.php';
?>
<div class="third">
    <div class="container">

        <!-- <div class="row">
        <h1>Contact Us</h1>
            <div class="col-xl-8 offset-xl-2 py-5">
                <form id="contact-form" method="post" action="contact-mail.php" role="form">
                    <div class="messages"></div>
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_name">Firstname *</label>
                                    <input id="form_name" type="text" name="name" class="form-control" placeholder="Please enter your firstname *" required="required" data-error="Firstname is required.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_lastname">Lastname *</label>
                                    <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Please enter your lastname *" required="required" data-error="Lastname is required.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_email">Email *</label>
                                    <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email *" required="required" data-error="Valid email is required.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_message">Message *</label>
                                    <textarea id="form_message" name="message" class="form-control" placeholder="Message for me *" rows="4" required="required" data-error="Please, leave us a message."></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-success btn-send" value="Send message">
                            </div>
                        </div>
                        <div class="row">
                        </div>
                    </div>
                </form>
            </div>
        </div> -->

        <!-- <form action="contact.php" method="post">
  <div class="elem-group">
    <label for="name">Your Name</label>
    <input type="text" id="name" name="visitor_name" placeholder="John Doe" pattern=[A-Z\sa-z]{3,20} required>
  </div>
  <div class="elem-group">
    <label for="email">Your E-mail</label>
    <input type="email" id="email" name="visitor_email" placeholder="john.doe@email.com" required>
  </div>
  <div class="elem-group">
    <label for="department-selection">Choose Concerned Department</label>
    <select id="department-selection" name="concerned_department" required>
        <option value="">Select a Department</option>
        <option value="billing">Billing</option>
        <option value="marketing">Marketing</option>
        <option value="technical support">Technical Support</option>
    </select>
  </div>
  <div class="elem-group">
    <label for="title">Reason For Contacting Us</label>
    <input type="text" id="title" name="email_title" required placeholder="Unable to Reset my Password" pattern=[A-Za-z0-9\s]{8,60}>
  </div>
  <div class="elem-group">
    <label for="message">Write your message</label>
    <textarea id="message" name="visitor_message" placeholder="Say whatever you want." required></textarea>
  </div>
  <button type="submit">Send Message</button>
</form>
    </div>
</div> -->

<form action="mail.php" method="POST">
<p>Name</p> <input type="text" name="name">
<p>Email</p> <input type="text" name="email">
<p>Phone</p> <input type="text" name="phone">

<p>Request Phone Call:</p>
Yes:<input type="checkbox" value="Yes" name="call"><br />
No:<input type="checkbox" value="No" name="call"><br />

<p>Website</p> <input type="text" name="website">

<p>Priority</p>
<select name="priority" size="1">
<option value="Low">Low</option>
<option value="Normal">Normal</option>
<option value="High">High</option>
<option value="Emergency">Emergency</option>
</select>
<br />

<p>Type</p>
<select name="type" size="1">
<option value="update">Website Update</option>
<option value="change">Information Change</option>
<option value="addition">Information Addition</option>
<option value="new">New Products</option>
</select>
<br />

<p>Message</p><textarea name="message" rows="6" cols="25"></textarea><br />
<input type="submit" value="Send"><input type="reset" value="Clear">
</form>
<?php
include 'footer.php';
?>