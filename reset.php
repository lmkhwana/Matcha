<?php require 'header.php'; require 'required/functions.php'; Is_Connected(); ?>
<div class="content">
      <div class="container">

      	<center><h1>Reset password</h1></center>
      	<form action="action/reset_user_action.php" method="POST">
	      	<div>
	      		<input class="form-control" type="text" name="username" placeholder="Username..." required>
	      	</div>
	      	<br>
	      	<center><button class="btn btn-primary" type="submit">Reset</button></center>
	    </form>
      </div>
    </div>
  </body>
</html>