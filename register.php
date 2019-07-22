<?php
    include 'nav-bar.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Register</h2>
                <form action="registration.php" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="user" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required/>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button> 
                </form>
                <br>
            </div>
        </div>
    </div>
</div>
<?php 
    include 'footer.php';
?>