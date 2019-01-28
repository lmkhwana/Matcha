<?php require '../header.php'; require '../required/functions.php'; Is_Not_Connected(); ?>

<?php
    if ($_SESSION['auth']->name === "Unknown" || $_SESSION['auth']->age == 0 || $_SESSION['auth']->profile_img === "img/profile.jpg")
        Display_flash('info', "Please set your profile first.", "/matcha/index.php");
?>
<div class="login">
    <div class="container" style="position: relative; top: 15%; height: 80%; color: whitesmoke; z-index: 2; overflow-y: scroll;">
    	<center>
	    	<form method="POST" action="">
	    		<input type="submit" name="btnage" value="18-25" class="btn btn-primary">
	    		<input type="submit" name="btnage" value="25-35" class="btn btn-primary">
	    		<input type="submit" name="btnage" value="35+" class="btn btn-primary">
	    	</form>
	    	<br>
    	</center>
    	<?php
    	if (empty($_POST))
    	{
    		require '../required/database.php';
    		$ulati = floatval($_SESSION['auth']->lati);
    		$ulongi = floatval($_SESSION['auth']->longi);
    		if ($_SESSION['auth']->orientation !== "M" && $_SESSION['auth']->orientation !== "F")
    		{
    			$req = $pdo->query("SELECT * FROM users WHERE reported = 0 AND (i1 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i3 ."%' 
    			OR i2 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i3 ."%' 
    			OR i3 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i3 ."%')
    			ORDER BY ((lati-$ulati)*(lati-$ulati)) + ((longi - $ulongi)*(longi - $ulongi)) ASC, popscore DESC");	
    		}
    		else
    		{
    			$req = $pdo->prepare("SELECT * FROM users WHERE gender = ? AND reported = 0  
    			AND (i1 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i3 ."%' 
    			OR i2 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i3 ."%' 
    			OR i3 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i3 ."%')
    			ORDER BY ((lati-$ulati)*(lati-$ulati)) + ((longi - $ulongi)*(longi - $ulongi)) ASC, popscore DESC");
    			$req->execute([$_SESSION['auth']->orientation]);
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
    	}
    	else
    	{
    		require '../required/database.php';
    		$ulati = floatval($_SESSION['auth']->lati);
    		$ulongi = floatval($_SESSION['auth']->longi);

    		if ($_POST['btnage'] === "18-25")
    		{
    			if ($_SESSION['auth']->orientation !== "M" && $_SESSION['auth']->orientation !== "F")
	    		{
	    			$req = $pdo->query("SELECT * FROM users WHERE age >= 18 AND age <= 25 AND reported = 0 AND (i1 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i3 ."%' 
	    			OR i2 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i3 ."%' 
	    			OR i3 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i3 ."%')
	    			ORDER BY ((lati-$ulati)*(lati-$ulati)) + ((longi - $ulongi)*(longi - $ulongi)) ASC, popscore DESC");	
	    		}
	    		else
	    		{
	    			$req = $pdo->prepare("SELECT * FROM users WHERE age >= 18 AND age <= 25 AND gender = ? AND reported = 0  
	    			AND (i1 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i3 ."%' 
	    			OR i2 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i3 ."%' 
	    			OR i3 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i3 ."%')
	    			ORDER BY ((lati-$ulati)*(lati-$ulati)) + ((longi - $ulongi)*(longi - $ulongi)) ASC, popscore DESC");
	    			$req->execute([$_SESSION['auth']->orientation]);
	    		}
    		}
    		else if ($_POST['btnage'] === "25-35")
    		{
    			if ($_SESSION['auth']->orientation !== "M" && $_SESSION['auth']->orientation !== "F")
	    		{
	    			$req = $pdo->query("SELECT * FROM users WHERE age >= 25 AND age <= 35 AND reported = 0 AND (i1 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i3 ."%' 
	    			OR i2 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i3 ."%' 
	    			OR i3 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i3 ."%')
	    			ORDER BY ((lati-$ulati)*(lati-$ulati)) + ((longi - $ulongi)*(longi - $ulongi)) ASC, popscore DESC");	
	    		}
	    		else
	    		{
	    			$req = $pdo->prepare("SELECT * FROM users WHERE age >= 25 AND age <= 35 AND gender = ? AND reported = 0  
	    			AND (i1 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i3 ."%' 
	    			OR i2 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i3 ."%' 
	    			OR i3 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i3 ."%')
	    			ORDER BY ((lati-$ulati)*(lati-$ulati)) + ((longi - $ulongi)*(longi - $ulongi)) ASC, popscore DESC");
	    			$req->execute([$_SESSION['auth']->orientation]);
	    		}
    		}
    		else if ($_POST['btnage'] === "35+")
    		{
    			if ($_SESSION['auth']->orientation !== "M" && $_SESSION['auth']->orientation !== "F")
	    		{
	    			$req = $pdo->query("SELECT * FROM users WHERE age >= 35 AND reported = 0 AND (i1 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i3 ."%' 
	    			OR i2 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i3 ."%' 
	    			OR i3 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i3 ."%')
	    			ORDER BY ((lati-$ulati)*(lati-$ulati)) + ((longi - $ulongi)*(longi - $ulongi)) ASC, popscore DESC");	
	    		}
	    		else
	    		{
	    			$req = $pdo->prepare("SELECT * FROM users WHERE age >= 35 AND gender = ? AND reported = 0  
	    			AND (i1 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i1 LIKE '%" .$_SESSION['auth']->i3 ."%' 
	    			OR i2 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i2 LIKE '%" .$_SESSION['auth']->i3 ."%' 
	    			OR i3 LIKE '%" .$_SESSION['auth']->i1 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i2 ."%' OR i3 LIKE '%" .$_SESSION['auth']->i3 ."%')
	    			ORDER BY ((lati-$ulati)*(lati-$ulati)) + ((longi - $ulongi)*(longi - $ulongi)) ASC, popscore DESC");
	    			$req->execute([$_SESSION['auth']->orientation]);
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
    	}
    	?>
    </div>
</div>
</div>