<?php

	$config = parse_ini_file("/etc/nowgallery.conf");

	function getExifDate($i) {
		global $config;
		$d = $i->getImageProperty("exif:DateTime");
		if ($d != null && $d != "") {
			$year=substr($d, 0, 4);
			$month=substr($d, 5, 2);
			$day=substr($d, 8, 2);
			$prefix=$year."-".$month."-".$day."-";
		} else {
			$prefix="0000-00-00-";
		}
		return $prefix;
	}

	function mkThumb($imagePath, $outputPath, $filename, $width, $height) {
		global $config;
		$i = new \Imagick(realpath($imagePath));
		$i->cropThumbnailImage($width, $height);
		$prefix = getExifDate($i);
		$finalOutput = $outputPath . "/" . $prefix . $filename;
		$i->setCompressionQuality(65);
		$i->writeImage($finalOutput);
		echo "Made Thumb: " . $finalOutput . "\n";
	}

	function mkMid($imagePath, $outputPath, $filename, $width, $height) {
		global $config;
		$i = new \Imagick(realpath($imagePath));
		$i->scaleImage($width, $height, true);
		$prefix = getExifDate($i);
		$finalOutput = $outputPath . "/" . $prefix . $filename;
		$i->writeImage($finalOutput);
		echo "Made Mid: " . $finalOutput . "\n";
	}

	function rsearch($folder, $pattern) {
		global $config;
		$dir = new RecursiveDirectoryIterator($folder);
		$ite = new RecursiveIteratorIterator($dir);
		$files = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
		$fileList = array();
		foreach($files as $file) {
			$fileList[] = $file[0];
		}
		return $fileList;
	}

	function makeImages($files) {
		global $config;
		$total = sizeof($files);
		$count = 0;
		foreach ($files as &$file) {
			$count++;
			echo "Processing (".$count."/".$total.")\n";
			$fullfolder = pathinfo($file, PATHINFO_DIRNAME);
			$folder = explode('/' , $fullfolder);
			$album = end($folder);
			$filename = basename($file);
			$thumbfilename = preg_replace("/".preg_replace("/\//", "\\\/", $config["systemsourceimages"])."\//", $config["systemwebimages"]."/thumb/", $file, 1);
			$midfilename = preg_replace("/".preg_replace("/\//", "\\\/", $config["systemsourceimages"])."\//", $config["systemwebimages"]."/mid/", $file, 1);
			$thumbpath = dirname($thumbfilename);
			$midpath = dirname($midfilename);
			#echo "Processing File: " . $file . "\n";
			#echo "  Album: " . $album . "\n";
			#echo "  Filename: " . $filename . "\n";
			#echo "  Thumb Filename: " . $thumbfilename . "\n";
			#echo "  Mid Filename: " . $midfilename . "\n";
			#echo "  Thumb Path: " . $thumbpath . "\n";
			#echo "  Mid Path: " . $midpath . "\n";
			if (!file_exists($thumbpath))
			    mkdir($thumbpath, 0777, true);
			if (!file_exists($midpath))
			    mkdir($midpath, 0777, true);
			$list = glob($thumbpath."/*-*-*-".$filename);
			if (sizeof($list) == 0) {
				mkThumb($file, $thumbpath, $filename, 100, 100);
				mkMid($file, $midpath, $filename, 600, 600);
			}
		}
	}

	function checkForRemovals($files, $webfiles) {
		global $config;
		$total = sizeof($webfiles);
		$count = 0;
		foreach ($webfiles as &$webfile) {
			$count++;
			echo "Checking for removal (".$count."/".$total.")\n";
			$webfilecompare = preg_replace("/".preg_replace("/\//", "\\\/", $config["systemwebimages"])."\/mid\//", "", $webfile, 1);
			$webdir = dirname($webfilecompare);
			$webfilename = basename($webfilecompare);
			$webfilename = substr($webfilename, 11);
			$webfilecompare = $webdir."/".$webfilename;
			$found = false;
			foreach ($files as &$file) {
				$filecompare = preg_replace("/".preg_replace("/\//", "\\\/", $config["systemsourceimages"])."\//", "", $file, 1);
				if ($filecompare == $webfilecompare) {
					$found = true;
					break;
				}
			}
			if (!$found) {
				echo "Removing: " . $webfilecompare . "\n";
				$thumbfilename = preg_replace("/".preg_replace("/\//", "\\\/", $config["systemwebimages"])."\/mid\//", $config["systemwebimages"]."/thumb/", $webfile, 1);
				unlink($thumbfilename);
				unlink($webfile);
			}
		}
	}

	$webfiles = rsearch($config["systemwebimages"]."/mid","/^.*\.(jpg|gif|png|JPG|GIF|PNG)$/");
	$files = rsearch($config["systemsourceimages"],"/^.*\.(jpg|gif|png|JPG|GIF|PNG)$/");
	makeImages($files);
	checkForRemovals($files, $webfiles);

?>
