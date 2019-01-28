<?php
	require '../required/functions.php';
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
		Is_Not_Connected();

	if (empty($_POST))
		Display_flash('danger', "Invalid action.", "/matcha/index.php");

	require '../required/database.php';

	if ($_POST['id'] !== 0)
	{
		$req = $pdo->prepare("SELECT * FROM messages WHERE sender = ? AND receiver = ? OR receiver = ? AND sender = ? ORDER BY id DESC");
		$req->execute([$_SESSION['auth']->id, $_POST['id'], $_SESSION['auth']->id, $_POST['id']]);
		$res = $req->fetchall();

		foreach ($res as $message) {
			if ($message->sender === $_SESSION['auth']->id)
				echo '<div class="me">' .$message->text ."</div>";
			else
				echo '<div class="other">' .$message->text ."</div>";
		}	
	}
	else
	{
		echo '<div class="me">Choose contact.</div>';
	}
	
