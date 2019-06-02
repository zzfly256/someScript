<?php
$soffice = 'D:\Software\LibreOffice\LibreOfficePortable\App\libreoffice\program\soffice';
$from = isset($argv[1]) ? explode(',', $argv[1]) : ["ppt"];
$to = "pdf";
$outdir = getcwd()."\pdf";

echo "Convert ".implode(",", $from)." to PDF\n";

function getFiles($path = __DIR__) {
	$result = [];
	$files = scandir($path);

	foreach ($files as $file) {
		if ($file != "." AND $file !=".." AND is_dir($file)) {
			$result = array_merge($result, getFiles($file));
		} 
		else if($file != "." AND $file !="..") {
			$realpath =  realpath($path)."\\".$file;
			array_push($result, $realpath);
		}
	}

	return $result;
}

$files = getFiles(getcwd());


foreach ($files as $file) {
	$name = explode(".", $file);
	if (count($name) > 1 AND in_array($name[count($name)-1], $from) ) {

		echo "Processing \t", $file,"\n";
		
		$output = str_replace(getcwd(), $outdir, $file);
		$exec = $soffice.' --invisible --convert-to '.$to.' "'.$file.'" --outdir '.dirname($output);

		system($exec);
	}
}
