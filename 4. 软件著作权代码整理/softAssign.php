<?php

echo "=======================================================\n";
echo "\tSoftware Assignment Code Document Generator\n";
echo "=======================================================\n";
echo "\n";
echo "\nPlease input the code directory: ";
$dir= trim(fgets(STDIN));
$file=scandir($dir);
$output = "";

foreach ($file as $key => $value) {
	if ($value=='.'||$value=='..'||$value=='.md'||$value=='softAssign.php' || is_dir($dir."/".$value)) {
		continue;
	}
	
	$codeFile = file_get_contents($dir."/".$value);
	$str = explode(PHP_EOL, $codeFile);	//分割为数组，每行为一个数组元素
	$str = array_filter($str);		//去除数组中的空元素
	$str = implode(PHP_EOL,$str);	//用换行符连结数组为字符串
	$output .= $str;
}

if(file_put_contents($dir."\output.txt", $output)){
	echo "\nSuccess: ",$dir,"\\output.txt","\n\n";
}

