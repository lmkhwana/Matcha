<?php require 'header.php'; require 'required/functions.php'; Is_Not_Connected(); ?>

<div class="banner-home"><br><br><br>
    <center><a href="profile_editor_action.php"><input class="btn btn-info" type="submit" name="Edit" value="Edit Profile" style="position: absolute; z-index: 9999999999999; left: 0"></a>
                <a href="profile_photo.php"><input class="btn btn-info" type="submit" name="EditPhoto" value="Edit Photo" style="position: absolute; z-index: 9999999999999; left: 110px"></a></center>
    <div class="left-container">
        <div class="MainPhoto">
            <img src="<?php echo $_SESSION['auth']->profile_img; ?>" width="100%" title="profile_img" alt="profile_img">
        </div>
    </div>
    <div class="middle-container">
        <h1 class="text-primary">Profile of <?php echo $_SESSION['auth']->name ." - " . Age . $_SESSION['auth']->age; ?>
            <span style="font-size: 2vw; color: yellow"><?php echo $_SESSION['auth']->popscore; ?></span> 😎
        </h1>
        <div class="infos-container">
            <?php if ($_SESSION['auth']->gender === "M") { ?>
                <h4><span class="text-primary">Gender :</span> <span style="color: royalblue;"><?php echo $_SESSION['auth']->gender; ?></span></h4>
            <?php }else{ ?>
                <h4><span class="text-primary">Gender :</span> <span style="color: fuchsia;"><?php echo $_SESSION['auth']->gender; ?></span></h4>
            <?php } ?>
            <br>
            <?php if ($_SESSION['auth']->orientation === "F") { ?>
                <h4><span class="text-primary">Interested in :</span> <span style="color: fuchsia;"><?php echo $_SESSION['auth']->orientation; ?></span></h4>
            <?php }else{ ?>
                <h4><span class="text-primary">Interested in :</span> <span style="color: royalblue;"><?php echo $_SESSION['auth']->orientation; ?></span></h4>
            <?php } ?>
            <br>
            <h4><span class="text-primary">Bio :</span></h4>
            <textarea class="form-control"><?php echo $_SESSION['auth']->bio ?></textarea>
            <br>
            <h4><span class="text-primary">Interests :</span> <span class="htag">#</span><span><?php echo $_SESSION['auth']->i1; ?></span>
                <span class="text-primary">#</span><span><?php echo $_SESSION['auth']->i2; ?></span>
                <span class="text-primary">#</span><span><?php echo $_SESSION['auth']->i3; ?></span></h4>
        </div>
        <div class="MainPhoto2">
            <img src="<?php echo $_SESSION['auth']->profile_img1; ?>" width="20%" title="profile_img" alt="profile_img">
            <img src="<?php echo $_SESSION['auth']->profile_img1; ?>" width="20%" title="profile_img" alt="profile_img">
            <img src="<?php echo $_SESSION['auth']->profile_img1; ?>" width="20%" title="profile_img" alt="profile_img">
            <img src="<?php echo $_SESSION['auth']->profile_img1; ?>" width="20%" title="profile_img" alt="profile_img"> <br> <br>
            <div class="col text-center">
            <a href="upload_pictures.php"><input class="btn btn-primary" type="submit" name="EditPhoto" value="Edit Photo"></a>
            </div>
        </div>
        
    </div>
   
</div>