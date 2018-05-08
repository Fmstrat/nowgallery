<?php
	$config = parse_ini_file("/etc/nowgallery.conf");

	unset($_COOKIE['loginCredentials']);
	setcookie('loginCredentials', null, -1, '/');
	header('Location: index.php');
?>
