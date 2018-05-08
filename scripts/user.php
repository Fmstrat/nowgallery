<?php

	$config = parse_ini_file("/etc/nowgallery.conf");

	echo "Username: ";
	$handle = fopen ("php://stdin","r");
	$username = fgets($handle);
	$username = trim(preg_replace('/\s+/', ' ', $username));
	if($username == '') {
		echo "ABORTING!\n";
		exit;
	}
	echo "\n";

	echo "Password: ";
	$handle = fopen ("php://stdin","r");
	$password = fgets($handle);
	$password = trim(preg_replace('/\s+/', ' ', $password));
	if($password == '') {
		echo "ABORTING!\n";
		exit;
	}
	echo "\n";
	
	echo "Confirm password: ";
	$handle = fopen ("php://stdin","r");
	$confirm_password = fgets($handle);
	$confirm_password = trim(preg_replace('/\s+/', ' ', $confirm_password));
	if($confirm_password == '') {
		echo "ABORTING!\n";
		exit;
	}
	echo "\n";

	if ($password != $confirm_password) {
		echo "Passwords do not match.\n";
		exit;
	}

	$hash = password_hash($password, PASSWORD_DEFAULT);

	$contents = file_get_contents("/etc/nowgallery.conf");
	$contents = preg_replace('/username\s?=\s?".*"/', 'username = "'.$username.'"', $contents);
	$contents = preg_replace('/password\s?=\s?".*"/', 'password = "'.base64_encode($hash).'"', $contents);

	$fh = fopen("/etc/nowgallery.conf", "w");
	fwrite($fh, $contents);

	echo "Password set for $username\n";

?>
