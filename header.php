<?php 

session_start();
date_default_timezone_set( 'South Africa (GMT+2)' ); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Matcha</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <?php
    include "js/outocomp.js"
    
    ?>


</head>
<body>
     <nav class="navbar navbar-toggleable-md navbar-light bg-info" style ="z-index: 999; !important;">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="http://localhost:8080/matcha/index.php">Matcha</a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <?php if (isset($_SESSION['auth'])) { ?>
              <li class="nav-item active">
                <a class="nav-link" href="profile.php">Profile <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="chat.php">Chat <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="account.php">Update</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="recommanded.php">Recommended</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Search by
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="http://localhost:8080/matcha/filter/filter_by_age.php">Age</a>
                  <a class="dropdown-item" href="http://localhost:8080/matcha/filter/filter_by_local.php">Location</a>
                  <a class="dropdown-item" href="http://localhost:8080/matcha/filter/filter_by_popular.php">Popularity</a>
                  <a class="dropdown-item" href="http://localhost:8080/matcha/filter/filter_by_tags.php">Interest</a>
                </div>
                <li class="nav-item">
                  <a class="nav-link" href="action/logout_action.php">logout</a>
                </li>
                <li class="nav-item dropdown" style=" position: relative; top: 8px">
                  <a href="#" class="dropdown-toggle noti" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px; color: red"></span> <i class="fa fa-bell" aria-hidden="true" style="color: black;"></i></a>
                  <ul class="dropdown-menu notil"></ul>
                </li>
              </li>
            <?php }else{ ?>
              <li class="nav-item active">
                <a class="nav-link" href="login.php">Login <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
              </li>
            <?php } ?>
        </ul>
        <?php if (isset($_SESSION['auth'])) { ?>
        <form class="form-inline my-2 my-lg-0" action="search_action.php" method="POST">
          <select class="form-control" id="exampleSelect1" name="selectedfilter">
            <option value="l">Location</option>
            <option value="a">Age</option>
            <option value="p">Popu</option>
            <option value="i">Interest</option>
          </select>
          <input class="form-control mr-sm-2" type="text" placeholder="Search" name="search" id="search">
          <button class="btn btn-info my-2 my-sm-0" type="submit">Search</button>
        </form>
        <?php } ?>
      </div>
    </nav>
    
<?php require 'flash.php'; ?>