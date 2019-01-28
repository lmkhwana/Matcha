<?php require 'header.php'; require 'required/functions.php'; Is_Connected(); ?>
<div class="login" >
    <div class="container" style="position: relative; top: 15%; color: whitesmoke; z-index: 2;">
        <center><h1 style="font-family: Gabriola; font-style: italic; font-size: 4vw; color:black;">Login</h1></center>
        <form action="action/login_user_action.php" method="POST">
            <div class="form-group">
            <center><label for="username" style="font-family: Gabriola;color:black; font-style: italic; font-size: 2vw">Username :</label> </center>
                <center><input type="text" class="form-control" style="background: transparent; border: 4px solid black;width:50%;";  name="username" id="username" required></center>
            </div>
            <div class="form-group">
            <center><label for="psw" style="font-family: Gabriola;color:black; font-style: italic; font-size: 2vw">Password :</label><center>
                <center><input type="password" class="form-control" style="background: transparent; border: 4px solid black;width:50%; " name="password" id="psw" required></center>
            </div>
            <div class="form-group" style="position: relative;left: 5%;">
                <center><input type="submit" class="btn btn-info" name="btn" value="Login"> <a href="reset.php" style="color: whitesmoke">Forgot password ?</a></center>
            </div>
        </form>
    </div>
 
</div>