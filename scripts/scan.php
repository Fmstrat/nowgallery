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
			$prefix="2000-01-01-";
		}
		return $prefix;
	}

	function autoRotateImage($image) {
		$orientation = $image->getImageOrientation();
		switch($orientation) {
			case imagick::ORIENTATION_BOTTOMRIGHT:
				$image->rotateimage("#000", 180); // rotate 180 degrees
				break;
			case imagick::ORIENTATION_RIGHTTOP:
				$image->rotateimage("#000", 90); // rotate 90 degrees CW
				break;
			case imagick::ORIENTATION_LEFTBOTTOM:
				$image->rotateimage("#000", -90); // rotate 90 degrees CCW
				break;
		}
		$image->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
	} 

	function mkImage($sourceImage, $thumbPath, $midPath, $filename) {
		global $config;
		if (filesize($sourceImage) > 0) {
			$i = new \Imagick(realpath($sourceImage));
			autoRotateImage($i);
			$prefix = getExifDate($i);
			$thumbfile = $thumbPath."/".$prefix.$filename;
			$midfile = $midPath."/".$prefix.$filename;
			if (!file_exists($midfile)) {
				$i->scaleImage(600, 600, true);
				$i->writeImage($midfile);
				echo "Made Mid: " . $midfile . "\n";
			}
			if (!file_exists($thumbfile)) {
				$i->cropThumbnailImage(100, 100);
				$i->setCompressionQuality(65);
				$i->writeImage($thumbfile);
				echo "Made Thumb: " . $thumbfile . "\n";
			}
		}
	}

	function mkVideo($videoPath, $thumbPath, $midPath, $filename, $width, $height) {
		global $config;
		$cmd = $config["ffmpeg"].' -i "'.$videoPath.'" 2>&1';
		$curdir = dirname(__FILE__);
		exec($cmd, $output, $retval);
		if (isset($output)) {
			$prefix = "2000-01-01-V-";
			foreach ($output as &$o) {
				if (strpos($o, "creation_time") !== false && strlen($o) >= 32) {
					$prefix = substr($o, 22, 10).'-V-';
					break;
				}
			}
			$tmpOutput = $thumbPath . "/TMP-" . $prefix . $filename . ".jpg";
			$cmd = $config["ffmpeg"].' -i "'.$videoPath.'" -deinterlace -an -ss 1 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg "'.$tmpOutput.'" 2>&1';
			exec($cmd, $output, $retval);
			if (file_exists($tmpOutput) && filesize($tmpOutput) > 0) {
				$i = new \Imagick(realpath($tmpOutput));
				$i->cropThumbnailImage($width, $height);
				$finalOutput = $thumbPath . "/" . $prefix . $filename . ".jpg";
				$i->setCompressionQuality(65);
				// Add play button which is 73x63
				$t = floor((100-63)/2);
				$l = floor((100-73)/2);
				$v = new \Imagick(realpath($curdir."/play.png"));
				$i->compositeImage($v, Imagick::COMPOSITE_DEFAULT, $l, $t);
				$i->writeImage($finalOutput);
				unlink($tmpOutput);
				echo "Made Thumb: " . $finalOutput . "\n";
			} else {
				if (file_exists($tmpOutput))
					unlink($tmpOutput);
				$i = new \Imagick(realpath($curdir."/image.png"));
				$i->cropThumbnailImage($width, $height);
				$finalOutput = $thumbPath . "/" . $prefix . $filename . ".jpg";
				$i->setCompressionQuality(65);
				// Add play button which is 73x63
				$t = floor((100-63)/2);
				$l = floor((100-73)/2);
				$v = new \Imagick(realpath($curdir."/play.png"));
				$i->compositeImage($v, Imagick::COMPOSITE_DEFAULT, $l, $t);
				$i->writeImage($finalOutput);
				echo "Made Thumb: " . $finalOutput . "\n";
			}
			$finalOutput = $midPath . "/" . $prefix . $filename . ".mp4";
			if (!file_exists($finalOutput)) {
				echo "Rendering mp4 video...\n";
				$cmd = $config["ffmpeg"].' -i "'.$videoPath.'" -acodec aac -strict experimental -ac 2 -ab 128k -vcodec libx264 -preset slow -f mp4 -crf 36 "'.$finalOutput.'" 2>&1';
				exec($cmd, $output, $retval);
				echo "Made video: " . $finalOutput . "\n";
			}
		}
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

	function checkIgnore($file) {
		global $config;
		if (isset($config["ignore"])) {
			foreach ($config["ignore"] as &$i) {
				if (strpos($file, $i) !== false) {
					return true;
				}
			}
		}
		return false;
	}

	function makeImages($files) {
		global $config;
		$total = sizeof($files);
		$count = 0;
		foreach ($files as &$file) {
			$count++;
			echo "Processing image (".$count."/".$total.")\n";
			$filename = basename($file);
			if ($filename[0] != '.' && !checkIgnore($file)) {
				$fullfolder = pathinfo($file, PATHINFO_DIRNAME);
				$folder = explode('/' , $fullfolder);
				$album = end($folder);
				$outputpath = preg_replace("/".preg_replace("/\//", "\\\/", $config["systemsourceimages"])."\//", "", $fullfolder, 1);
				$filename = $filename.".jpg";
				$thumbpath = $config['systemwebimages']."/thumb/".$outputpath;
				$midpath = $config['systemwebimages']."/mid/".$outputpath;
				#echo "Processing File: " . $file . "\n";
				#echo "  Album: " . $album . "\n";
				#echo "  Outputpath: " . $outputpath . "\n";
				#echo "  Filename: " . $filename . "\n";
				if (!file_exists($thumbpath))
				    mkdir($thumbpath, 0777, true);
				if (!file_exists($midpath))
				    mkdir($midpath, 0777, true);
				$list = glob($thumbpath."/*-*-*-".$filename);
				if (sizeof($list) == 0) {
					mkImage($file, $thumbpath, $midpath, $filename);
				}
			}
		}
	}

	function checkForRemovals($files, $webfiles, $type) {
		global $config;
		$total = sizeof($webfiles);
		$count = 0;
		foreach ($webfiles as &$webfile) {
			$count++;
			echo "Checking for ".$type." removal (".$count."/".$total.")\n";
			$webfilecompare = preg_replace("/".preg_replace("/\//", "\\\/", $config["systemwebimages"])."\/mid\//", "", $webfile, 1);
			$webdir = dirname($webfilecompare);
			$webfilename = basename($webfilecompare);
			if ($type == "image") {
				$webfilename = substr($webfilename, 11);
			} else {
				$webfilename = substr($webfilename, 13);
			}
			$webfilename = substr($webfilename, 0, -4);
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
				echo "Removing ".$type.": " . $webfilecompare . "\n";
				$thumbfilename = preg_replace("/".preg_replace("/\//", "\\\/", $config["systemwebimages"])."\/mid\//", $config["systemwebimages"]."/thumb/", $webfile, 1);
				unlink($thumbfilename);
				unlink($webfile);
			}
		}
	}

	function makeVideos($files) {
		global $config;
		$total = sizeof($files);
		$count = 0;
		foreach ($files as &$file) {
			$count++;
			echo "Processing video (".$count."/".$total.")\n";
			$filename = basename($file);
			if ($filename[0] != '.' && !checkIgnore($file)) {
				$fullfolder = pathinfo($file, PATHINFO_DIRNAME);
				$folder = explode('/' , $fullfolder);
				$album = end($folder);
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
				$list = glob($thumbpath."/2*-*-*-V-".$filename.".jpg");
				if (sizeof($list) == 0) {
					mkVideo($file, $thumbpath, $midpath, $filename, 100, 100);
				}
			}
		}
	}

	if (!file_exists($config["systemwebimages"]."/thumb"))
	    mkdir($config["systemwebimages"]."/thumb", 0777, true);
	if (!file_exists($config["systemwebimages"]."/mid"))
	    mkdir($config["systemwebimages"]."/mid", 0777, true);

	// Handle Images
	$webfiles = rsearch($config["systemwebimages"]."/mid","/^.*\.(jpg|gif|png|JPG|GIF|PNG)$/");
	$files = rsearch($config["systemsourceimages"],"/^.*\.(jpg|gif|png|JPG|GIF|PNG)$/");
	makeImages($files);
	checkForRemovals($files, $webfiles, "image");

	// Handle Videos
	$webfiles = rsearch($config["systemwebimages"]."/mid","/^.*\.(webm|mkv|flv|vob|ogv|ogg|drc|gifv|mng|avi|mov|qt|wmv|yuv|rm|rmvb|asf|amv|mp4|m4p|m4v|mpg|mp2|mpeg|mpe|mpv|mpeg|m2v|m4v|svi|3gp|3g2|mxf|roq|nsv|f4v|f4p|f4a|f4b|WEBM|MKV|FLV|VOB|OGV|OGG|DRC|GIFV|MNG|AVI|MOV|QT|WMV|YUV|RM|RMVB|ASF|AMV|MP4|M4P|M4V|MPG|MP2|MPEG|MPE|MPV|MPEG|M2V|M4V|SVI|3GP|3G2|MXF|ROQ|NSV|F4V|F4P|F4A|F4B)$/");
	$files = rsearch($config["systemsourceimages"],"/^.*\.(webm|mkv|flv|vob|ogv|ogg|drc|gifv|mng|avi|mov|qt|wmv|yuv|rm|rmvb|asf|amv|mp4|m4p|m4v|mpg|mp2|mpeg|mpe|mpv|mpeg|m2v|m4v|svi|3gp|3g2|mxf|roq|nsv|f4v|f4p|f4a|f4b|WEBM|MKV|FLV|VOB|OGV|OGG|DRC|GIFV|MNG|AVI|MOV|QT|WMV|YUV|RM|RMVB|ASF|AMV|MP4|M4P|M4V|MPG|MP2|MPEG|MPE|MPV|MPEG|M2V|M4V|SVI|3GP|3G2|MXF|ROQ|NSV|F4V|F4P|F4A|F4B)$/");
	makeVideos($files);
	checkForRemovals($files, $webfiles, "video");

?>
