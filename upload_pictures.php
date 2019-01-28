<?php require 'header.php'; require 'required/functions.php'; Is_Not_Connected(); ?>

<?php 
	$uploadfile = "";
	require_once 'required/functions.php';
	if (!empty($_POST))
	{

		if ($_FILES['picture_1']['error'] > 0 || $_FILES['picture_2']['error'] > 0 || $_FILES['picture_3']['error'] > 0 || $_FILES['picture_4']['error'] > 0)
			Display_flash('danger', "Error : Problem while uploading.", "profile_photo.php");

		if ($_FILES['picture_1']['size'] > intval($_POST['MAX_FILE_SIZE']) || $_FILES['picture_2']['size'] > intval($_POST['MAX_FILE_SIZE']) || $_FILES['picture_3']['size'] > intval($_POST['MAX_FILE_SIZE']) || $_FILES['picture_4']['size'] > intval($_POST['MAX_FILE_SIZE']))
			Display_flash('danger', "Error : File too big.", "upload_pictures.php");

		$extensions_valides = array('jpg', 'png');

		if (check_valid_ex('picture_1') || check_valid_ex('picture_2') || check_valid_ex('picture_3') || check_valid_ex('picture_4'))
			Display_flash('danger', "Error : Invalid extension.", "upload_pictures.php");


		$uploaddir = 'img/user/' .$_SESSION['auth']->id;

		if (!is_dir($uploaddir))
			mkdir($uploaddir, 0777);

		$uploadfile1 = $uploaddir ."/" .basename($_FILES['picture_1']['name']);
		$uploadfile2 = $uploaddir ."/" .basename($_FILES['picture_2']['name']);
		$uploadfile3 = $uploaddir ."/" .basename($_FILES['picture_3']['name']);
		$uploadfile4 = $uploaddir ."/" .basename($_FILES['picture_4']['name']);

		if (file_exists($uploadfile1))
			unlink($uploadfile1);
		else if (file_exists($uploadfile2))
			unlink($uploadfile2);
		else if (file_exists($uploadfile3))
			unlink($uploadfile3);
		else if (file_exists($uploadfile4))
			unlink($uploadfile4);

		function upload($uploadfile, $name)
		{
			$path = $uploadfile;
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data = file_get_contents($path);
			rename($uploadfile, "img/user/" .$_SESSION['auth']->id ."/" .$name);
			$req = $pdo->prepare('INSERT INTO images (username, path) VALUES(":username", "path")');
			$req->bindParam(':username', $_SESSION['auth']->id, PDO::PARAM_STR);
			$req->bindParam(':path', "img/user/" .$_SESSION['auth']->id ."/".$name, PDO::PARAM_STR);
			$req->execute();
			$_SESSION['auth']->picture_1 = "img/user/" .$_SESSION['auth']->id ."/".$name;
		}

		if (move_uploaded_file($_FILES['picture_1']['tmp_name'], $uploadfile) && move_uploaded_file($_FILES['picture_2']['tmp_name'], $uploadfile2) && move_uploaded_file($_FILES['picture_3']['tmp_name'], $uploadfile3) && move_uploaded_file($_FILES['picture_4']['tmp_name'], $uploadfile4)) {
			upload($uploadfile1, "picture_1");
			upload($uploadfile2, "picture_2");
			upload($uploadfile3, "picture_3");
			upload($uploadfile4, "picture_4");
			
		} else {
			Display_flash('danger', "Error : Problem while uploading.", "upload_pictures.php");
		}

	}
?>


<div class="banner-home">
	<div class="login">
		<div style="position: relative; top: 15%; color: whitesmoke; z-index: 2;">
			<?php if(empty($_POST)) { ?>
					<center><h1 style="color:black;">No file selected</h1></center>
						<center>
						<form class="form-group" method="POST" action="upload_pictures.php" enctype="multipart/form-data">
						     <label for="icone" style="color:black;">File (JPG | PNG) :</label> 
						     <input type="hidden" name="MAX_FILE_SIZE" value="5242880" /> <br>
							 <input type="file" name="picture_1" id="profile_picture" /><br>
							 <input type="file" name="picture_2" id="profile_picture" /><br>
							 <input type="file" name="picture_3" id="profile_picture" /><br>
							 <input type="file" name="picture_4" id="profile_picture" /><br><br>
							 
						     <input class="btn-commenta" type="submit" name="submit" value="Upload" />
						</form><br>
						</center>
				<?php }else{ ?>
					<br><br>
					<center>
						<img src="<?php echo "img/user/" .$_SESSION['auth']->id ."/profile.jpg"; ?>" width="20%">
						<img src="<?php echo "img/user/" .$_SESSION['auth']->id ."/profile.jpg"; ?>" width="20%">
						<img src="<?php echo "img/user/" .$_SESSION['auth']->id ."/profile.jpg"; ?>" width="20%">
						<img src="<?php echo "img/user/" .$_SESSION['auth']->id ."/profile.jpg"; ?>" width="20%">
						<br><br>
						<a href="profile_photo.php"><input type="submit" class="btn btn-primary" value="Change"></a>
						<a href="profile.php"><input type="submit" class="btn btn-primary" value="Save"></a>
					</center>
				<?php } ?>
		</div>
	</div>
</div>