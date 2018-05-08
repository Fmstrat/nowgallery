<?php
	require("../include/common.php");

	$config = parse_ini_file("/etc/nowgallery.conf");

	$searchpath = $_GET["p"];
	$query = "/".$config["webimages"]."/";
	if (substr($searchpath, 0, strlen($query)) === $query) {

		$output = array();
		$files = rsearch($searchpath,"/^.*\.(jpg|gif|png|JPG|GIF|PNG)$/");
		$count = 0;
		foreach ($files as &$file) {
			$filename = basename($file);
			$year=(int)substr($filename, 0, 4);
                        $month=(int)substr($filename, 5, 2);
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
			$displayname = substr($filename, 11);
			$src = preg_replace("/\/".$config["webimages"]."\/thumb\//", "", $file, 1);
			$object = (object) [
				'id' => $count,
				'src' => $src,
				'name' => $displayname,
				'month' => $displaymonth,
				'year' => $year,
				'loaded' => 0
			];
			array_push($output, $object);
			$count++;
		}
	}

	$ret = json_encode($output);
	echo $ret;
?>
