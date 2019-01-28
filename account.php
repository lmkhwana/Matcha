<?php require 'header.php'; require 'required/functions.php'; Is_Not_Connected(); ?>

<div class="banner-home">
	<div class="login">
    	<div class="container" style="position: relative; top: 10%; color: whitesmoke; z-index: 2;">
    		<form action="action/edit_account_action.php" method="POST">
				<div class="form-group">
		            <label for="username" style="font-family: Gabriola; font-style: italic; font-size: 2vw; color:black">Change username :</label>
		            <input type="text" class="form-control" name="username" value="<?php echo $_SESSION['auth']->username ?>" required>
		            <center><input type="submit" class="btn btn-info btn-block" name="subusername" value="Update"></center>
		        </div>
		    </form>
		    <form action="action/edit_account_action.php" method="POST">
		        <div class="form-group">
		            <label for="mail" style="font-family: Gabriola; font-style: italic; font-size: 2vw; color:black">Change mail :</label>
		            <input type="text" class="form-control" name="mail" value="<?php echo $_SESSION['auth']->mail ?>" required>
		            <center><input type="submit" class="btn btn-info btn-block" name="submail" value="Update"></center>
		        </div>
		    </form>
		    <form action="action/edit_account_action.php" method="POST">
		        <div class="form-group">
		            <label for="psw" style="font-family: Gabriola; font-style: italic; font-size: 2vw; color:black">Change password :</label>
		            <input type="password" class="form-control" name="psw" value="" required><br>
		            <label for="psw" style="font-family: Gabriola; font-style: italic; font-size: 2vw; color:black">Confirm password :</label>
		            <input type="password" class="form-control" name="pswr" value="" required>
		            <center><input type="submit" class="btn btn-info btn-block" name="subpsw" value="Update"></center>
		        </div>
		    </form>
    	</div>
    </div>
</div>