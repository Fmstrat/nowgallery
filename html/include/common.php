<?php
	$config = parse_ini_file("/etc/nowgallery.conf");
	ini_set("memory_limit",$config["memory_limit"]);

	class ExampleSortedIterator extends SplHeap {
		public function __construct(Iterator $iterator) {
			foreach ($iterator as $item) {
				$this->insert($item);
			}
		}
		public function compare($a,$b) {
			return strcmp($a->getRealpath(), $b->getRealpath());
		}
	}

	function rsearch($folder, $pattern) {
		$dir = new RecursiveDirectoryIterator($folder);
		$ite = new RecursiveIteratorIterator($dir);
		$ste = new ExampleSortedIterator($ite);
		$files = new RegexIterator($ste, $pattern, RegexIterator::GET_MATCH);
		$fileList = array();
		foreach($files as $file) {
			$fileList[] = $file[0];
		}
		return $fileList;
	}

?>
