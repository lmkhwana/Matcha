<?php require 'header.php'; require 'required/functions.php'; Is_Not_Connected(); ?>

<?php 
	$uploadfile = "";
	if (!empty($_POST))
	{

		if ($_FILES['profile_picture']['error'] > 0)
			Display_flash('danger', "Error : Problem while uploading.", "profile_photo.php");

		if ($_FILES['profile_picture']['size'] > intval($_POST['MAX_FILE_SIZE']))
			Display_flash('danger', "Error : File too big.", "profile_photo.php");

		$valid_ext = array('png', 'png');

		$ext = strtolower(substr(strrchr($_FILES['profile_picture']['name'], '.'), 1));
		echo $ext;
		if (!(in_array($ext, $valid_ext)))
			//Display_flash('danger', "Error : Invalid extension.", "profile_photo.php");

		require_once 'required/functions.php';
		require_once 'required/database.php';

		$uploaddir = 'img/user/' .$_SESSION['auth']->id;

		if (!is_dir($uploaddir))
			mkdir($uploaddir, 0777);

		$uploadfile = $uploaddir ."/" .basename($_FILES['profile_picture']['name']);

		if (file_exists($uploadfile))
			unlink($uploadfile);

		if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadfile)) {
		    $path = $uploadfile;
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data = file_get_contents($path);
			rename($uploadfile, "img/user/" .$_SESSION['auth']->id ."/profile.jpg");
			$req = $pdo->prepare('UPDATE users SET profile_img = ? WHERE id = ?');
			$req->execute(["img/user/" .$_SESSION['auth']->id ."/profile.jpg", $_SESSION['auth']->id]);
			$_SESSION['auth']->profile_img = "img/user/" .$_SESSION['auth']->id ."/profile.jpg";
		} else {
			Display_flash('danger', "Error : Problem while uploading.", "profile_photo.php");
		}

	}
?>


<div class="banner-home">
	<div class="login">
		<div style="position: relative; top: 15%; color: whitesmoke; z-index: 2;">
			<?php if(empty($_POST)) { ?>
					<center><h1>No file selected</h1></center>
						<center>
						<form class="form-group" method="POST" action="profile_photo.php" enctype="multipart/form-data">
						     <label for="icone">File (JPG | 5 Mo) :</label> 
						     <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
						     <input type="file" name="profile_picture" id="profile_picture" /><br><br>
						     <input class="btn-commenta" type="submit" name="submit" value="Upload" />
						</form><br>
						</center>
				<?php }else{ ?>
					<br><br>
					<center>
						<img src="<?php echo "img/user/" .$_SESSION['auth']->id ."/profile.jpg"; ?>" width="20%">
						<br><br>
						<a href="profile_photo.php"><input type="submit" class="btn btn-primary" value="Change"></a>
						<a href="profile.php"><input type="submit" class="btn btn-primary" value="Save"></a>
					</center>
				<?php } ?>
		</div>
	</div>
</div>