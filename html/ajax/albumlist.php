<?php
	require("../include/common.php");

	if ($config["username"] == "" || (isset($_COOKIE['loginCredentials']) && !empty($_COOKIE['loginCredentials']))) {

		$albums = array();
		$output = array();

		$isvid = false;

		$files = rsearch("/".$config["webimages"]."/thumb","/^.*\.(jpg|gif|png|JPG|GIF|PNG)$/");
		$count = 0;
		foreach ($files as &$file) {
			$fullfolder = pathinfo($file, PATHINFO_DIRNAME);
			$folder = explode('/' , $fullfolder);
			$album = end($folder);
			$filename = basename($file);
			if (!in_array($album, $albums)) {
				$isvid = false;
				$object = (object) [
					'id' => $count,
					'album' => $album,
					'cover' => $file,
					'albumpath' => urlencode($fullfolder)
				];
				if (substr($filename, 10, 3) == "-V-")
					$isvid = true;
				array_push($albums, $album);
				array_push($output, $object);
				$count++;
			} elseif ($isvid == true) {
				if (substr($filename, 10, 3) != "-V-") {
					$object = (object) [
						'id' => $count,
						'album' => $album,
						'cover' => $file,
						'albumpath' => urlencode($fullfolder)
					];
					$output[sizeof($output)-1] = $object;
					$isvid = false;
				}
			}
		}

		$ret = json_encode($output);
		echo $ret;
	}
?>
