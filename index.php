<?php require 'header.php'; ?>

<div class="container" style="margin-top: 25px;">

    <div class="jumbotron mt-25" >
        <h1 class="display-4 text-center">Welcome To Matcha</h1>
        <p class="lead text-center">Because Love too can be centralized.</p>
        <hr class="my-4">
        <?php if (!isset($_SESSION['username'])){
            echo '<p class="text-center">Click register now and go find your ideal partner</p> <div class="col text-center">
            <a class="btn btn-primary btn-lg center" href="register.php" role="button">Register</a>
        </div>';
        }  
              else
                echo '<p class="text-center">Update your profile and click on your recommandations.</p>';
        ?>
        
       
    </div>

</div>