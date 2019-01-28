<?php require 'header.php'; require 'required/functions.php'; Is_Not_Connected(); ?>

<div class="login">
    <div class="container" style="position: relative; top: 15%; height: 80%; color: whitesmoke; z-index: 2; overflow-y: scroll;">
    	<?php
    	if (!empty($_POST) && isset($_POST['search']))
    	{
    		require 'required/database.php';
    		
    		if ($_POST['selectedfilter'] === "l")
    		{
    			$ulati = floatval($_SESSION['auth']->lati);
    			$ulongi = floatval($_SESSION['auth']->longi);
    			$req = $pdo->query("SELECT * FROM users WHERE name LIKE '%" .addslashes($_POST['search']) ."%' AND reported = 0 ORDER BY ((lati-$ulati)*(lati-$ulati)) + ((longi - $ulongi)*(longi - $ulongi)) ASC");
    		}
    		else if ($_POST['selectedfilter'] === "a")
    		{
    			?>
    			<center>
			    	<form method="POST">
			    		<input type="submit" name="btnage" value="18-25" class="btn btn-primary">
			    		<input type="submit" name="btnage" value="25-35" class="btn btn-primary">
			    		<input type="submit" name="btnage" value="35+" class="btn btn-primary">
			    		<input type="text" name="search" value="<?php echo $_POST['search']; ?>" style="width: 0; height: 0; border: 0">
			    		<input type="text" name="selectedfilter" value="<?php echo $_POST['selectedfilter']; ?>" style="width: 0; height: 0; border: 0">
			    	</form>
			    	<br>
		    	</center>
		    	<?php
		    	if (isset($_POST['btnage']) && $_POST['btnage'] === "18-25")
		    		$req = $pdo->query("SELECT * FROM users WHERE reported = 0 AND age >= 18 && age <= 25 AND name LIKE '%" .addslashes($_POST['search']) ."%'");
		    	else if (isset($_POST['btnage']) && $_POST['btnage'] === "25-35")
		    		$req = $pdo->query("SELECT * FROM users WHERE reported = 0 AND age >= 25 && age <= 35 AND name LIKE '%" .addslashes($_POST['search']) ."%'");
		    	else if (isset($_POST['btnage']) && $_POST['btnage'] === "35+")
		    		$req = $pdo->query("SELECT * FROM users WHERE reported = 0 AND age >= 35 AND name LIKE '%" .addslashes($_POST['search']) ."%'");
		    	else
		    		$req = $pdo->query("SELECT * FROM users WHERE reported = 0 AND name LIKE '%" .addslashes($_POST['search']) ."%'");	
    		}
    		else if ($_POST['selectedfilter'] === "p")
    		{
    			?>
    			<center>
			    	<form method="POST">
			    		<input type="submit" name="btnpop" value="0-100" class="btn btn-primary">
			    		<input type="submit" name="btnpop" value="100-200" class="btn btn-primary">
			    		<input type="submit" name="btnpop" value="200+" class="btn btn-primary">
			    		<input type="text" name="search" value="<?php echo $_POST['search']; ?>" style="width: 0; height: 0; border: 0">
			    		<input type="text" name="selectedfilter" value="<?php echo $_POST['selectedfilter']; ?>" style="width: 0; height: 0; border: 0">
			    	</form>
			    	<br>
		    	</center>
		    	<?php
		    	if (isset($_POST['btnpop']) && $_POST['btnpop'] === "0-100")
		    		$req = $pdo->query("SELECT * FROM users WHERE reported = 0 AND popscore >= 0 && popscore <= 100 AND name LIKE '%" .addslashes($_POST['search']) ."%'");
		    	else if (isset($_POST['btnpop']) && $_POST['btnpop'] === "100-200")
		    		$req = $pdo->query("SELECT * FROM users WHERE reported = 0 AND popscore >= 100 && popscore <= 200 AND  name LIKE '%" .addslashes($_POST['search']) ."%'");
		    	else if (isset($_POST['btnpop']) && $_POST['btnpop'] === "200+")
		    		$req = $pdo->query("SELECT * FROM users WHERE reported = 0 AND popscore >= 200 AND name LIKE '%" .addslashes($_POST['search']) ."%'");
		    	else
		    		$req = $pdo->query("SELECT * FROM users WHERE reported = 0 AND name LIKE '%" .addslashes($_POST['search']) ."%'");	
    		}
    		else if ($_POST['selectedfilter'] === "i")
    		{
		    	if (!isset($_POST['btninterest']))
		    	{
		    		$req = $pdo->query("SELECT * FROM users WHERE reported = 0 AND i1 LIKE '%" .addslashes($_POST['search']) ."%' OR i2 LIKE '%" .addslashes($_POST['search']) ."%' OR i3 LIKE '%" .addslashes($_POST['search']) ."%'");
		    	}
    		}
			$res = $req->fetchall();

			foreach ($res as $key) {
				$req = $pdo->prepare('SELECT * FROM users WHERE name = ?');
				$req->execute([$key->name]);
				$currentUser = $req->fetch();

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
				<?php if (!$blocked) { ?>
				<a href="view_profile.php?id=<?php echo $currentUser->id; ?>"  style="color: whitesmoke">
		    		<div class="profile-box">
			    		<h1 class="profile-box-h1"><?php echo $currentUser->name; ?> - <span><?php echo $currentUser->age; ?></span></h1>
			    		<h2 class="profile-box-h2"><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo $local; ?></h2>
			    		<h2 class="profile-box-h2-pts" style="color: yellow;"><i class="fa fa-star" aria-hidden="true"></i><?php echo $currentUser->popscore; ?></h2>
			    		<img src="<?php echo $currentUser->profile_img; ?>" height="80%">
			    	</div>
			    	<br>
		    	</a><?php
		    }
			}
    	}
    	?>
    </div>
</div>
</div>