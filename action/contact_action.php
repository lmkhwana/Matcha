<?php

if (!file_exists('required/database.php'))
	header('Location: ../index.php');

if (session_status() == PHP_SESSION_NONE) { session_start(); }
	Is_Not_Connected();

	require 'required/database.php';

	$req = $pdo->prepare("SELECT * FROM matches WHERE A = ? OR B = ?");
	$req->execute([$_SESSION['auth']->id, $_SESSION['auth']->id]);
	$res = $req->fetchall();

	foreach ($res as $currentuser) {
		if ($currentuser->A === $_SESSION['auth']->id)
			$req = $pdo->query("SELECT * FROM users WHERE reported = 0 AND id =" .$currentuser->B);
		else
			$req = $pdo->query("SELECT * FROM users WHERE reported = 0 AND id =" .$currentuser->A);
		$user = $req->fetch();

		if ($user)
		{
			if (!Is_blocked($_SESSION['auth']->id, $user->id))
			echo "<form method='POST'><button class='contact' name='id' value='" .$user->id ."'><div>" .$user->name ."</div></button></form>";	
		}
	}
?>