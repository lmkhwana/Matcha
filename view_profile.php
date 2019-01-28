<?php require 'header.php'; require 'required/functions.php'; Is_Not_Connected(); ?>

<?php
        if (empty($_GET))
            Display_flash('danger', "Error : Invalid values.", "/matcha/index.php");
         if (!isset($_GET['id']))
            Display_flash('danger', "Error : Invalid values.", "/matcha/index.php");
         if (!is_numeric($_GET['id']))
            Display_flash('danger', "Error : Invalid values.", "/matcha/index.php");

        require 'required/database.php';
        $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $req->execute([intval($_GET['id'])]);

        if (!$userinfo = $req->fetch())
            Display_flash('danger', "Invalid user.", "/matcha/index.php");

        if (Is_blocked($_SESSION['auth']->id, $userinfo->id))
            Display_flash('danger', "You've blocked this user.", "/matcha/index.php");

        if ($userinfo->id != $_SESSION['auth']->id)
        {
            if ($userinfo->reported)
                Display_flash('danger', "Can't acces reported user info.", "/matcha/index.php");
            $req = $pdo->query('UPDATE users SET popscore = popscore + 1 WHERE id =' .intval($userinfo->id));

            if (!Is_blocked($userinfo->id, $_SESSION['auth']->id))
                $req = $pdo->prepare("INSERT INTO notifications SET emitter = ?, receiver = ?, text = ?");

            $req->execute([$_SESSION['auth']->id, $userinfo->id,"visited your profile."]);
        }

        $req = $pdo->prepare("SELECT * FROM likes WHERE emitter = ? AND receiver = ?");
        $req->execute([$_SESSION['auth']->id, $userinfo->id]);

        $clike = 1;
        if ($req->rowCount() > 0)
            $clike = 0;

        $req = $pdo->prepare("SELECT * FROM likes WHERE receiver = ? AND emitter = ?");
        $req->execute([$_SESSION['auth']->id, $userinfo->id]);

        $likedu = 0;
        if ($req->rowCount() > 0)
            $likedu = 1;

        $to_time = strtotime(date("Y-m-d H:i:s"));
        $from_time = strtotime($userinfo->lastonline);
        $elapsed = round(abs($to_time - $from_time) / 60,2);


?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#btnlike").click(function(){
            $.ajax({
                url: 'action/like_action.php',
                type: 'POST',
                data: { like: <?php echo $userinfo->id; ?> },
                success: function(data) {
                    $("#btnlike").hide();
                }
            });
        });
        $("#btnunlike").click(function(){
            $.ajax({
                url: 'action/unlike_action.php',
                type: 'POST',
                data: { like: <?php echo $userinfo->id; ?> },
                success: function(data) {
                    location.reload();
                }
            });
        });
        $("#blockbtn").click(function(){
            $.ajax({
                url: 'action/block_action.php',
                type: 'POST',
                data: { id: <?php echo $userinfo->id; ?> },
                success: function(data) {
                    $("#blockbtn").hide();
                    document.location.href = '/index.php';
                }
            });
        });
        $("#reportbtn").click(function(){
            $.ajax({
                url: 'action/report_user_action.php',
                type: 'POST',
                data: { id: <?php echo $userinfo->id; ?> },
                success: function(data) {
                    $("#reportbtn").hide();
                }
            });
        });
});
</script>

<div class="banner-home">
    <div class="left-container">
        <div class="MainPhoto">
                <?php if ($userinfo->id != $_SESSION['auth']->id && $likedu && $clike && $userinfo->profile_img !== "img/profile.jpg") { ?>
                    <center><button id="btnlike" class="btn btn-primary like-btn" type="submit" name="like" value="<?php echo $userinfo->id; ?>">LIKE BACK</button></center>
                <?php } ?>

                <?php if ($userinfo->id != $_SESSION['auth']->id && $clike && !$likedu && $userinfo->profile_img !== "img/profile.jpg") { ?>
                    <center><button id="btnlike" class="btn btn-primary like-btn" type="submit" name="like" value="<?php echo $userinfo->id; ?>">LIKE</button></center>
                <?php } ?>

                <?php if ($userinfo->id != $_SESSION['auth']->id && !$clike && $userinfo->profile_img !== "img/profile.jpg") { ?>
                    <center><button id="btnunlike" class="btn btn-primary like-btn" type="submit" name="btnunlike" value="<?php echo $userinfo->id; ?>">UNLIKE</button></center>
                <?php } ?>
            <img src="<?php echo $userinfo->profile_img; ?>" width="100%" title="profile_img" alt="profile_img">
            <center>
            <?php if ($userinfo->id != $_SESSION['auth']->id) { ?>
                <button id="blockbtn" class="btn btn-primary block-btn" type="submit" name="blockbtn" value="<?php echo $userinfo->id; ?>">BLOCK</button>
                <button id="reportbtn" class="btn btn-primary report-btn" type="submit" name="reportbtn" value="<?php echo $userinfo->id; ?>">REPORT</button></center>
            <?php } ?>
            <?php if ($elapsed > 15){ ?>
                <small><em>Last online : <?php echo $userinfo->lastonline; ?></em></small>

            <?php }else{ ?>
                <small><em>Online</em></small>
            <?php } ?>
        </div>
    </div>
    <br><br><br>
    <div class="middle-container">
        <h1>Profile of <?php echo $userinfo->name ." - " .$userinfo->age; ?>
            <span style="font-size: 2vw; color: yellow"><i class="fa fa-star" aria-hidden="true"></i><?php echo $userinfo->popscore; ?></span>
        </h1>
        <div class="infos-container">
            <?php if ($userinfo->gender === "M") { ?>
                <h4><span class="class">Gender :</span> <span style="color: royalblue;"><?php echo $userinfo->gender; ?></span></h4>
            <?php }else{ ?>
                <h4><span class="class">Gender :</span> <span style="color: fuchsia;"><?php echo $userinfo->gender; ?></span></h4>
            <?php } ?>
            <br>
            <?php if ($userinfo->orientation === "F") { ?>
                <h4><span class="class">Interested by :</span> <span style="color: fuchsia;"><?php echo $userinfo->orientation; ?></span></h4>
            <?php }else{ ?>
                <h4><span class="class">Interested by :</span> <span style="color: royalblue;"><?php echo $userinfo->orientation; ?></span></h4>
            <?php } ?>
            <br>
            <h4><span class="class">Bio :</span></h4>
            <textarea class="form-control" disabled><?php echo $userinfo->bio ?></textarea>
            <br>
            <h4><span class="class">Interest :</span> <span class="htag">#</span><span><?php echo $userinfo->i1; ?></span>
                <span class="htag">#</span><span><?php echo $userinfo->i2; ?></span>
                <span class="htag">#</span><span><?php echo $userinfo->i3; ?></span></h4>

</div>
<div class="MainPhoto2">
                <img src="<?php echo $userinfo->profile_img1; ?>" width="20%" title="profile_img" alt="profile_img"> 
                <img src="<?php echo $userinfo->profile_img; ?>" width="20%" title="profile_img" alt="profile_img"> 
                <img src="<?php echo $userinfo->profile_img1; ?>" width="20%" title="profile_img" alt="profile_img"> 
                <img src="<?php echo $userinfo->profile_img; ?>" width="20%" title="profile_img" alt="profile_img"> 
            
        </div>