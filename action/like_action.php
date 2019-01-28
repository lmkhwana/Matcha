<?php
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	require '../required/functions.php';
	Is_Not_Connected();

	if (empty($_POST))
		Display_flash('danger', "Invalid action.", "/matcha/index.php");

	require '../required/database.php';

	$req = $pdo->prepare("INSERT INTO likes SET emitter = ?, receiver = ?");
	$req->execute([$_SESSION['auth']->id, $_POST['like']]);

	if (!Is_blocked($_POST['like'], $_SESSION['auth']->id))
	{
		$req = $pdo->prepare("INSERT INTO notifications SET emitter = ?, receiver = ?, text = ?");
		$req->execute([$_SESSION['auth']->id, $_POST['like'], "Liked your profile."]);
	}
	

	$newmatch = $pdo->prepare("SELECT * FROM likes WHERE emitter = ? AND receiver = ?");
	$newmatch->execute([$_POST['like'], $_SESSION['auth']->id]);

	if ($newmatch->rowCount() > 0)
	{
		$req = $pdo->prepare("INSERT INTO matches SET A = ?, B = ?");
		$req->execute([$_SESSION['auth']->id, $_POST['like']]);

		if (!Is_blocked($_POST['like'], $_SESSION['auth']->id))
		{
			$req = $pdo->prepare("INSERT INTO notifications SET emitter = ?, receiver = ?, text = ?");
			$req->execute([$_SESSION['auth']->id, $_POST['like'], "You have a new match."]);

			$req = $pdo->prepare("INSERT INTO notifications SET receiver = ?, emitter = ?, text = ?");
			$req->execute([$_SESSION['auth']->id, $_POST['like'], "You have a new match."]);
		}
	}