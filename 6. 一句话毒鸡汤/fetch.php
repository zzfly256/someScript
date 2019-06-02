<?php
$url = "http://www.**.**/";

for ($k=0; $k < 50; $k++) { 
	$current = array_unique(array_filter(file("fun.txt")));
	$result = [];
	
	for ($i=0; $i < 100; $i++) { 
		$data = file_get_contents($url);
		$sentence = trim(explode('</span>', explode('<span id="sentence" style="font-size: 2rem;">', $data)[1])[0]);
	
		if (!in_array($sentence, $result) && !in_array($sentence."\n", $current)) {
			$result[] = $sentence;
			echo $k." - ",count($result),". ",$sentence, "\n";
		}
	}
	
	file_put_contents("fun.txt", implode("\n",$result)."\n", FILE_APPEND);
}
	

$current = array_unique(array_filter(file("fun.txt")));
file_put_contents("fun.txt", implode("",$current));