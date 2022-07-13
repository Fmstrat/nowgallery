<?php
	$config = parse_ini_file("/etc/nowgallery.conf");

	if ($_POST['username'] == $config['username'] && password_verify($_POST['password'], base64_decode($config['password']))) {
		setcookie("loginCreds", $config['username'], time() + (1 * 365 * 24 * 60 * 60)); // Expiring after 365 days
		header('Location: index.php');
	} else {
		header('Location: index.php?login=failed');
	}
?>
