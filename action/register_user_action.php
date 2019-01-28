<?php
	
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	require '../required/functions.php';
	Is_Connected();

	if (empty($_POST) || isset($_SESSION['auth']))
		Display_flash('danger', "Error : You cannot acces this page.", '../index.php');

	$username = $_POST['username'];
	$email = $_POST['email'];
	$psw = $_POST['password'];
	$pswr = $_POST['passwordr'];

	//verif username
	if (empty($username) || !preg_match('/^[a-zA-Z0-9]+$/', $username) || strlen($username) > 20)
		Display_flash('danger', "Error : Invalid username.", "../register.php");

	//verif passwords
	if ($psw !== $pswr || strlen($psw) > 20)
		Display_flash('danger', "Error : Invalid password", "../register.php");

	//Is user or mail
	require_once '../required/database.php';
	$req = $pdo->prepare('SELECT username FROM users WHERE username = ?');
	$req->execute([$username]);
	$usernameExi = $req->fetch();

	if ($usernameExi)
		Display_flash('danger', "Error : Username already taken.", "../register.php");

	$req = $pdo->prepare('SELECT mail FROM users WHERE mail = ?');
	$req->execute([$email]);
	$emailExi = $req->fetch();

	if ($emailExi)
		Display_flash('danger', "Error : Email already taken.", "../register.php");

	//register the user
	$password = password_hash($psw, PASSWORD_BCRYPT);
	$req = $pdo->prepare('INSERT INTO users SET username = ?, mail = ?, password = ?');
	
	if ($req->execute([$username, $email, $password]))
		Display_flash('success', "Success : Account created, please login.", "../login.php");
	else
		Display_flash('danger', "Error : Can't register user.", "../register.php");


?>