<?php require 'header.php'; require 'required/functions.php'; Is_Connected(); ?>

<div class="login">
    <div class="container" style="position: relative; top: 10%; color: whitesmoke; z-index: 2;">
        <center><h1 style="font-size: 4vw; color: black;">Sign Up</h1></center>
        <form action="action/register_user_action.php" method="POST">
            <div class="form-group">
            <center><label for="username" style="font-size: 2vw; color:black;">Username :</label></center>
                <center><input type="text" class="form-control" name="username" style="background: transparent;border: 4px solid black;width:50%;" id="username" required></center>
            </div>
            <div class="form-group">
            <center><label for="Email" style="font-size: 2vw; color:black;">Email :</label></center>
                <center><input type="email" class="form-control" name="email"style="background: transparent; border: 4px solid black;width:50%; " id="Email" required></center>
            </div>
            <div class="form-group">
            <center><label for="psw" style="font-size: 2vw; color:black;">Password :</label></center>
                <center><input type="password" class="form-control" name="password"style="background: transparent;border: 4px solid black;width:50%; " id="psw" required></center>
            </div>
            <div class="form-group">
            <center><label for="pswr" style="font-size: 2vw; color:black;">Repeat Password :</label></center>
                <center><input type="password" class="form-control" name="passwordr" style="background: transparent; border: 4px solid black;width:50%; "id="pswr" required></center>
            </div>
            <div class="form-group">
                <center><input type="submit" class="btn btn-info" name="btn" value="Sign Up"></center>
            </div>
        </form>
    </div>    
</div>

