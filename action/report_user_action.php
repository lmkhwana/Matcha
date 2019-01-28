<?php
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	require '../required/functions.php';
	Is_Not_Connected();
	
	if (empty($_POST))
		Display_flash('danger', "Invalid action.", "/matcha/index.php");

	require '../required/database.php';
	$req = $pdo->query("UPDATE users SET reported = 1 WHERE id =" .intval($_POST['id']));
	Display_flash('info', "User reported.", "/matcha/index.php");
