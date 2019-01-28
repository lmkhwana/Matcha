<?php
	
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	require '../required/functions.php';
	Is_Not_Connected();

	if (empty($_POST))
		Display_flash('danger', "Error : You cannot acces this page.", '../index.php');

	if (isset($_POST['subusername']))
	{
		if (empty($_POST['username']))
			Display_flash('danger', "Empty username.", "../account.php");

		if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) || strlen($_POST['username']) > 20)
			Display_flash('danger', "Error : Invalid username. a-zA-Z0-9 < 20 char", "../account.php");

		require '../required/database.php';

		$req = $pdo->prepare("SELECT * FROM users WHERE username = ?");
		$req->execute([$_POST['username']]);
		$exi = $req->fetch();

		if ($exi)
			Display_flash('danger', "Username already taken.", "/account.php");


		$req = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
		$req->execute([$_POST['username'], $_SESSION['auth']->id]);
		$_SESSION['auth']->username = $_POST['username'];
		Display_flash('success', "Username modified.", "/account.php");
	}

	if (isset($_POST['mail']))
	{
		if (empty($_POST['mail']))
			Display_flash('danger', "Empty username.", "../account.php");

		require '../required/database.php';

		$req = $pdo->prepare("SELECT * FROM users WHERE mail = ?");
		$req->execute([$_POST['mail']]);
		$exi = $req->fetch();

		if ($exi)
			Display_flash('danger', "Mail already taken.", "/account.php");


		$req = $pdo->prepare("UPDATE users SET mail = ? WHERE id = ?");
		$req->execute([$_POST['mail'], $_SESSION['auth']->id]);
		$_SESSION['auth']->mail = $_POST['mail'];
		Display_flash('success', "Mail modified.", "/account.php");

	}

	if (isset($_POST['subpsw']))
	{
		if ($_POST['psw'] !== $_POST['pswr'] || strlen($_POST['psw']) > 20)
			Display_flash('danger', "Error : Invalid password", "../account.php");

		require_once '../required/database.php';

		$password = password_hash($_POST['psw'], PASSWORD_BCRYPT);
		$req = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
		$req->execute([$password, $_SESSION['auth']->id]);
		Display_flash('success', "Password modified.", "/account.php");
	}

?>