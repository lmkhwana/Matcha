<?php 
	if (session_status() == PHP_SESSION_NONE) { session_start(); }
	require '../required/functions.php';
	Is_Not_Connected();
	unset($_SESSION['auth']); 
	unset($_SESSION['username']);
	header('Location: ../index.php');
	exit();
?>