<?php
	require("../include/common.php");

	if ($config["username"] == "" || (isset($_COOKIE['loginCredentials']) && !empty($_COOKIE['loginCredentials']))) {

		$searchpath = $_GET["p"];
		$recursive = $_GET["r"];
		$query = "/".$config["webimages"]."/";
		if (substr($searchpath, 0, strlen($query)) === $query) {

			$output = array();
			$files = array();
			if ($recursive)
				$files = rsearch($searchpath,"/^.*\.(jpg|gif|png|JPG|GIF|PNG)$/");
			else
				$files = array_filter(glob($searchpath.'/*.jpg'));
			$count = 0;
			foreach ($files as &$file) {
				$filename = basename($file);
				$displayname = $filename;
				$year=(int)substr($filename, 0, 4);
				$month=(int)substr($filename, 5, 2);
				$filetype=substr($filename, 10, 3);
				if ($filetype == "-V-") {
					$filetype = "video";
					$displayname = substr($displayname, 13);
				} else {
					$filetype = "image";
					$displayname = substr($displayname, 11);
				}
				$displayname = substr($displayname, 0, -4);
				$displaymonth = "";
				switch ($month) {
					case 1:
						$displaymonth = "January";
						break;
					case 2:
						$displaymonth = "February";
						break;
					case 3:
						$displaymonth = "March";
						break;
					case 4:
						$displaymonth = "April";
						break;
					case 5:
						$displaymonth = "May";
						break;
					case 6:
						$displaymonth = "June";
						break;
					case 7:
						$displaymonth = "July";
						break;
					case 8:
						$displaymonth = "August";
						break;
					case 9:
						$displaymonth = "September";
						break;
					case 10:
						$displaymonth = "October";
						break;
					case 11:
						$displaymonth = "November";
						break;
					case 12:
						$displaymonth = "December";
						break;
				}
				$src = preg_replace("/\/".$config["webimages"]."\/thumb\//", "", $file, 1);
				$object = (object) [
					'id' => $count,
					'src' => $src,
					'name' => $displayname,
					'month' => $displaymonth,
					'year' => $year,
					'type' => $filetype,
					'loaded' => 0
				];
				array_push($output, $object);
				$count++;
			}
		}

		if (isset($_GET['d']) && $_GET['d'] == 1) {
			$dirs = array_filter(glob($searchpath.'/*'), 'is_dir');
			foreach($dirs as &$dir) {
				$object = (object) [
					'id' => $count,
					'src' => $dir,
					'name' => basename($dir),
					'month' => "",
					'year' => "",
					'type' => "dir",
					'loaded' => 0
				];
				array_push($output, $object);
				$count++;
			}
		}

		$ret = json_encode($output);
		echo $ret;
	}
?>
