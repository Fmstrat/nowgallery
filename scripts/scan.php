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

	function mkVideo($videoPath, $thumbPath, $midPath, $filename, $width, $height) {
		global $config;
		$cmd = $config["ffmpeg"].' -i "'.$videoPath.'" 2>&1';
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
				$v = new \Imagick(realpath("/scripts/play.png"));
				$i->compositeImage($v, Imagick::COMPOSITE_DEFAULT, $l, $t);
				$i->writeImage($finalOutput);
				unlink($tmpOutput);
				echo "Made Thumb: " . $finalOutput . "\n";
			} else {
				if (file_exists($tmpOutput))
					unlink($tmpOutput);
				$i = new \Imagick(realpath("/scripts/image.png"));
				$i->cropThumbnailImage($width, $height);
				$finalOutput = $thumbPath . "/" . $prefix . $filename . ".jpg";
				$i->setCompressionQuality(65);
				// Add play button which is 73x63
				$t = floor((100-63)/2);
				$l = floor((100-73)/2);
				$v = new \Imagick(realpath("/scripts/play.png"));
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
			echo "Processing image (".$count."/".$total.")\n";
			$fullfolder = pathinfo($file, PATHINFO_DIRNAME);
			$folder = explode('/' , $fullfolder);
			$album = end($folder);
			$filename = basename($file);
			$thumbfilename = preg_replace("/".preg_replace("/\//", "\\\/", $config["systemsourceimages"])."\//", $config["systemwebimages"]."/thumb/", $file, 1);
			$midfilename = preg_replace("/".preg_replace("/\//", "\\\/", $config["systemsourceimages"])."\//", $config["systemwebimages"]."/mid/", $file, 1);
			$thumbpath = dirname($thumbfilename);
			$midpath = dirname($midfilename);
			$filename = $filename.".jpg";
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
				echo "Removing".$type." : " . $webfilecompare . "\n";
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
			$list = glob($thumbpath."/2*-*-*-V-".$filename.".jpg");
			if (sizeof($list) == 0) {
				mkVideo($file, $thumbpath, $midpath, $filename, 100, 100);
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
