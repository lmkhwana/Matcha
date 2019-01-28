<?php
	
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	require '../required/functions.php';
	Is_Not_Connected();

	if (empty($_POST))
		Display_flash('danger', "Error : You cannot acces this page.", '../index.php');

	$name = $_POST['name'];
	$gender = $_POST['gender'];
	$orientation = $_POST['orientation'];
	$bio = $_POST['bio'];
	$i1 = $_POST['i1'];
	$i2 = $_POST['i2'];
	$i3 = $_POST['i3'];
	$age = $_POST['age'];

	if (empty($name) || !preg_match('/^[a-zA-Z ]+$/', $name) || strlen($name) > 20)
		Display_flash('danger', "Error : Invalid name.", "../profile_editor_action.php");

	if (empty($gender))
		Display_flash('danger', "Error : Invalid gender.", "../profile_editor_action.php");

	if (empty($orientation))
		Display_flash('danger', "Error : Invalid orientation.", "../profile_editor_action.php");

	if (empty($bio) || !preg_match('/^[a-zA-Z 0-9.,!?"]+$/', $bio) || strlen($bio) > 255)
		Display_flash('danger', "Error : Invalid bio.", "../profile_editor_action.php");

	if (empty($i1) || !preg_match('/^[a-zA-Z0-9]+$/', $i1) || strlen($i1) > 20)
		Display_flash('danger', "Error : Invalid interest 1.", "../profile_editor_action.php");
		
	if (empty($i2) || !preg_match('/^[a-zA-Z0-9]+$/', $i2) || strlen($i2) > 20)
		Display_flash('danger', "Error : Invalid interest 2.", "../profile_editor_action.php");
	
	if (empty($i3) || !preg_match('/^[a-zA-Z0-9]+$/', $i3) || strlen($i3) > 20)
		Display_flash('danger', "Error : Invalid interest 3.", "../profile_editor_action.php");

	if (empty($age))
		Display_flash('danger', "Error : Please indicate your age.", "/profile_editor_action.php");

	require '../required/database.php';
	$req = $pdo->prepare('UPDATE users SET name = ?, age = ?, gender = ?, orientation = ?, bio = ?, i1 = ?, i2 = ?, i3 = ? WHERE id = ?');
	$req->execute([$name, $age, $gender, $orientation, $bio, $i1, $i2, $i3, $_SESSION['auth']->id]);
	$_SESSION['auth']->name = $name;
	$_SESSION['auth']->age = $age;
	$_SESSION['auth']->gender = $gender;
	$_SESSION['auth']->orientation = $orientation;
	$_SESSION['auth']->bio = $bio;
	$_SESSION['auth']->i1 = $i1;
	$_SESSION['auth']->i2 = $i2;
	$_SESSION['auth']->i3 = $i3;
	Display_flash('success', "Success : Account modified.", "../profile.php");
