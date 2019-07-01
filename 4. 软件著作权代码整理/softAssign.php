<?php
/*
* 面向过程编程真的乱得一塌糊涂
* Rytia 2019.07.01
*/


echo "=======================================================\n";
echo "\tSoftware Assignment Code Document Generator\n";
echo "=======================================================\n";
echo "\n";

echo "\nPlease input the code directory: ";
$dir= trim(fgets(STDIN));

echo "\nRecursive or not? [y/n]: ";
$rec = trim(fgets(STDIN)) == "y" ? true : false;



function getCode($dir, $rec) {
	$file=scandir($dir);
	$output = "";

	foreach ($file as $key => $value) {
		if ($value=='.'||$value=='..'||$value=='.md'||$value=='softAssign.php') {
			continue;
		}
		if ($rec === true && is_dir($dir."/".$value)) {
			$output .= getCode($dir."/".$value, $rec);
		}
		if (strpos($value, ".php")) {

			$codeFile = file_get_contents($dir."/".$value);
			$output .= deleteBlockAnnotation(deleteLineAnnotation(deleteEmptyLine($codeFile)));
	
		}
		
	}
	return deleteEmptyLine($output);
}

function deleteEmptyLine($code){
	$codeArray = explode("\n", $code);	//分割为数组，每行为一个数组元素
	$codeArray = array_filter($codeArray);		//去除数组中的空元素
	return implode("\n", $codeArray);	//用换行符连结数组为字符串
}

function deleteLineAnnotation($code){
	$output = "";
	$codeArray = explode("\n", $code);
	foreach ($codeArray as $line => $str) {
		$flag = strpos($str, '//');
		if ($flag !== false) { 
			$output .= "\n".($flag == 0) ? "" : substr($str, 0, $flag);
		} else {
			$output .= "\n".$str;
		}
	}
	return $output;
}

function deleteBlockAnnotation($code){
	$output = "";
	$codeArray = explode("\n", $code);
	$lineCount = count($codeArray);
	global $i;
	$i = 0;
	while($i < $lineCount) {
		$flag1 = strpos($codeArray[$i], '/*');
		if ($flag1 !== false) { 
			for ($j = $i; $j < $lineCount; $j++) { 
				$flag2 = strpos($codeArray[$j], '*/');
				if ($flag2 !== false) {
					$i = $j+1;
					break;
				}
			}
		} else {
			$output .= "\n".$codeArray[$i];
			$i+=1;
		}

	}
	return $output;
}


if(file_put_contents($dir."\output.txt", getCode($dir, $rec))){
	echo "\nSuccess: ",$dir,"\\output.txt ", filesize($dir."/output.txt")." \n\n";
}

