<?php 

	$user_type = $_COOKIE['type'];
	unset($_COOKIE['type']);
	unset($_COOKIE['userid']);
	$res = setcookie('type', '', time() - (86400 * 30), '/');
	$res = setcookie('userid', '', time() - (86400 * 30), '/');

	header("Location: " . $user_type . "/login.php");

?>