<?php
	require("../include/common.php");

	$config = parse_ini_file("/etc/nowgallery.conf");

	$albums = array();
	$output = array();

	$files = rsearch("/".$config["webimages"]."/thumb","/^.*\.(jpg|gif|png|JPG|GIF|PNG)$/");
	$count = 0;
	foreach ($files as &$file) {
		$fullfolder = pathinfo($file, PATHINFO_DIRNAME);
		$folder = explode('/' , $fullfolder);
		$album = end($folder);
		if (!in_array($album, $albums)) {
			$object = (object) [
				'id' => $count,
				'album' => $album,
				'cover' => $file,
				'albumpath' => urlencode($fullfolder)
			];
			array_push($albums, $album);
			array_push($output, $object);
			$count++;
		}
	}

	$ret = json_encode($output);
	echo $ret;
?>
