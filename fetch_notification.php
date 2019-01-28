<?php if (session_status() == PHP_SESSION_NONE) { session_start(); }  ?>
<?php require 'required/functions.php'; ?>
<?php

	if (!isset($_POST['view']) || empty($_POST['view']))
		Display_flash('danger', "Invalid action.", "/matcha/index.php");
	require 'required/database.php';
    $req = $pdo->prepare('SELECT * FROM notifications WHERE receiver = ? ORDER BY id DESC LIMIT 5');
    $req->execute([intval($_SESSION['auth']->id)]);
    $res = $req->fetchall();
    
	$output = '';
	
	if ($req->rowCount() == 0)
		$output .= '<li>No notifications</li>';

	foreach ($res as $key) {

		$req = $pdo->prepare("SELECT name FROM users WHERE id = ?");
		$req->execute([$key->emitter]);
		$name = $req->fetch()->name;

		$output .= '
		  <li style="border-bottom: 1px solid black;">
		  <strong>'.$name .'</strong><br />
		  <small><em>'.$key->text.'</em></small>
		  </li>';
	}

	$req = $pdo->prepare("SELECT * FROM notifications WHERE seen = 0 AND receiver = ?");
	$req->execute([$_SESSION['auth']->id]);
	$count = $req->rowCount();

	$data = [
	    "notification" => $output,
	    "unseen_notification" => $count,
	];

	if ($_POST['view'] === "seen")
	{
		$req = $pdo->prepare("UPDATE notifications SET seen = 1 WHERE seen = 0 AND receiver = ?");
		$req->execute([$_SESSION['auth']->id]);
	}

	if (isset($_SESSION['auth']->id))
	{
		$req = $pdo->prepare("UPDATE users SET lastonline = NOW() WHERE id = ?");
		$req->execute([$_SESSION['auth']->id]);
		$_SESSION['auth']->lastonline = date("Y-m-d H:i:s");
	}

	echo json_encode($data);
?>