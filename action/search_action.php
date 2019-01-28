<?php 
	require '../required/database.php';
	if (isset($_GET['term']))
	{
		$req = $pdo->query("SELECT name FROM users WHERE reported = 0 AND name LIKE '%" .addslashes($_GET['term']) ."%' LIMIT 10");
		$res = $req->fetchall();

		foreach ($res as $key) {
			$tab[] = $key->name;
		}
		print json_encode($tab);
	}
?>