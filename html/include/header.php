<?php

	$config = parse_ini_file("/etc/nowgallery.conf");

?> <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="format-detection" content="telephone=no" />
		<meta name="msapplication-tap-highlight" content="no" />
		<!-- WARNING: for iOS 7, remove the width=device-width and height=device-height attributes. See https://issues.apache.org/jira/browse/CB-4323 -->
		<!-- Removed for font sizes: target-densitydpi=device-dpi -->
		<!-- <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height" /> -->
		<meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-title" content="Gallery">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<link rel="apple-touch-icon" href="images/icon.png">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" type="text/css" href="css/slide.css" />
		<title>Gallery</title>
		<link rel="icon" type="image/png" href="images/icon.png">
		<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/jquery.touchSwipe.min.js"></script>
		<script type="text/javascript">
			var webimages = "<?php echo $config["webimages"]; ?>";
			var sourceimages = "<?php echo $config["sourceimages"]; ?>";
			<?php
				if ($config["username"] == "" || (isset($_COOKIE['loginCredentials']) && !empty($_COOKIE['loginCredentials']))) {
					echo "var loggedIn = true;\n";
					echo "var loggedInUsername = '".$config["username"]."';\n";
				} else {
					echo "var loggedIn = false;\n";
					echo "var loggedInUsername = '';\n";
				}
				if (isset($_GET['login']) && $_GET['login'] == "failed") {
					echo "var loginFailed = true;\n";
				} else {
					echo "var loginFailed = false;\n";
				}
			?>
		</script>
		<script type="text/javascript" src="js/script.js"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	</head>
	<body>
