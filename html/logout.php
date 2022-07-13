<?php
	$config = parse_ini_file("/etc/nowgallery.conf");

	unset($_COOKIE['loginCreds']);
	setcookie('loginCreds', null, -1, '/');
	header('Location: index.php');
?>
