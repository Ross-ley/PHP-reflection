<?php
include 'nav-bar.php';
?>
<div class="third">
    <div class="container">
        <div class="row">
            <div>
                <h2>Contact us</h2>
                <div class="flexy">
                    <form action="">
                        <label for="">Name</label>
                        <input type="text" style="width:45%;">
                        <label for="">Email</label>
                        <input type="text" style="width:45%;">
                        <label for="">Reasion for contact</label>
                        <input type="text" style="width:100%;">
                        <label for="">Message</label>
                        <textarea style="width:100%; min-height:10rem;" maxlength="1000"></textarea>
                    </form>
                <!--
                <form name="contactform" method="post" action="send_form_email.php">
                    <table>
                    <tr>
                    <td valign="top">
                    <label for="first_name">First Name *</label>
                    </td>
                    <td valign="top">
                    <input  type="text" name="first_name" maxlength="50" size="50">
                    </td>
                    </tr>
                    <tr>
                    <td valign="top"">
                    <label for="last_name">Last Name *</label>
                    </td>
                    <td valign="top">
                    <input  type="text" name="last_name" maxlength="50" size="50">
                    </td>
                    </tr>
                    <tr>
                    <td valign="top">
                    <label for="email">Email Address *</label>
                    </td>
                    <td valign="top">
                    <input  type="text" name="email" maxlength="80" size="50">
                    </td>
                    </tr>
                    <tr>
                    <td valign="top">
                    <label for="telephone">Telephone Number</label>
                    </td>
                    <td valign="top">
                    <input  type="text" name="telephone" maxlength="30" size="50">
                    </td>
                    </tr>
                    <tr>
                    <td valign="top">
                    <label for="comments">Comments *</label>
                    </td>
                    <td valign="top">
                    <textarea  name="comments" maxlength="1000" cols="52" rows="6"></textarea>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="2" style="text-align:center">
                    <input type="submit" value="Submit">  
                    </td>
                    </tr>
                    </table>
                    </form>
                    <form name="contactform" method="post" action="send_form_email.php">
                        -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>