<?php
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	require '../required/functions.php';
	Is_Not_Connected();

	if (empty($_POST))
		Display_flash('danger', "Invalid action.", "/matcha/index.php");

	require '../required/database.php';

	$req = $pdo->prepare("INSERT INTO blocked SET blocker = ?, blocked = ?");
	if($req->execute([$_SESSION['auth']->id, $_POST['id']]))
		Display_flash('info', "User blocked.", "/matcha/index.php");