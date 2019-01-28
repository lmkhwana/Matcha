<?php require require '../header.php'; require '../required/functions.php'; Is_Not_Connected(); ?>

<?php
    if ($_SESSION['auth']->name === "Unknown" || $_SESSION['auth']->age == 0 || $_SESSION['auth']->profile_img === "img/profile.jpg")
        Display_flash('info', "Please set your profile first.", "/matcha/index.php");
?>
<script>
        $(document).ready(function(){ 
        	$("#seed_one").autocomplete({source: "/action/tags_action.php"}); 
        	$("#seed_two").autocomplete({source: "/action/tags_action.php"}); 
        });
</script>

<div class="login">
    <div class="container" style="position: relative; top: 15%; height: 80%; color: whitesmoke; z-index: 2; overflow-y: scroll;">
    	<center>
    		<form method="POST">
    			<label style="font-family: Gabriola; font-style: italic; font-size: 2vw;">Interest : </label><br>
		        	<p style="color: black!important">
			        	<input minlength="2" type="text" id="seed_one" name="i1" value="">
			        	<input minlength="2" type="text" id="seed_two" name="i2" value="">
		        		<input type="submit" class="btn btn-primary" name="submit" value="Validate">
		        	</p>
    		</form>
	    	<br>
    	</center>
    	<?php
    		require '../required/database.php';
    		if ($_SESSION['auth']->orientation === "M" || $_SESSION['auth']->orientation === "F")
    		{
	    		if (!empty($_POST))
	    		{
	    			$req = $pdo->prepare("SELECT * FROM users WHERE gender = ? AND (i1 = ? OR i1 = ? OR i2 = ? OR i2 = ? OR i3 = ? OR i3 = ?) AND reported = 0");
	    			$req->execute([$_SESSION['auth']->orientation, $_POST['i1'], $_POST['i2'], $_POST['i1'], $_POST['i2'], $_POST['i1'], $_POST['i2']]);
	    		}
	    		else
	    		{
	    			$req = $pdo->prepare("SELECT * FROM users WHERE gender = ? AND reported = 0");
	    			$req->execute([$_SESSION['auth']->orientation]);
	    		}	
	    	}
	    	else{
	    		if (!empty($_POST))
	    		{
	    			$req = $pdo->prepare("SELECT * FROM users WHERE (i1 = ? OR i1 = ? OR i2 = ? OR i2 = ? OR i3 = ? OR i3 = ?) AND reported = 0");
	    			$req->execute([$_POST['i1'], $_POST['i2'], $_POST['i1'], $_POST['i2'], $_POST['i1'], $_POST['i2']]);
	    		}
	    		else
	    		{
	    			$req = $pdo->query("SELECT * FROM users WHERE reported = 0");
	    		}		
	    	}
			$res = $req->fetchall();
			foreach ($res as $currentUser) {
				$number = get_Distance($currentUser->lati, $currentUser->longi);
				$number = number_format($number, 2, ',', ' ');
				if ($number < 1.00)
					$local = "In your city";
				else
					$local = $number ." km away.";
				$blocked = 0;
				if (Is_blocked($_SESSION['auth']->id, $currentUser->id))
                    $blocked = 1;
				?>
				<?php if ($_SESSION['auth']->id != $currentUser->id && !$blocked && ($currentUser->orientation === $_SESSION['auth']->gender || $currentUser->orientation === "M-F")){ ?>
				<a href="view_profile.php?id=<?php echo $currentUser->id; ?>"  style="color: whitesmoke;">
		    		<div class="profile-box">
			    		<h1 class="profile-box-h1"><?php echo $currentUser->name; ?> - <span><?php echo $currentUser->age; ?></span></h1>
			    		<h2 class="profile-box-h2"><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo $local; ?></h2>
			    		<h2 class="profile-box-h2-pts" style="color: yellow;"><i class="fa fa-star" aria-hidden="true"></i><?php echo $currentUser->popscore; ?></h2>
			    		<img src="<?php echo $currentUser->profile_img; ?>" height="80%">
			    	</div>
			    	<br>
		    	</a>
		    	<?php } ?>
		    	<?php
			}
    	?>
    </div>
</div>
</div>