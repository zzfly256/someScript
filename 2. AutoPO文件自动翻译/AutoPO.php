<?php
error_reporting(0);
function youdaoFree($text){
	$url="http://fanyi.youdao.com/openapi.do?keyfrom=Rytia-Blog&key=1066061878&type=data&doctype=json&version=1.1&q=";
	$request = $url.$text;
	//echo $request;
	$info = json_decode(file_get_contents($request));
	$info = $info->translation;
	return $info[0];
}

function youdaoPaid($text){
	$salt=rand(1000,9999);
	$key="08d227d614438e2c";
	$sign=md5($key.$text.$salt."1HyL6ywlemrTnMyPqN2lfbmriAFhHvHD");
	$url="http://openapi.youdao.com/api?q=".urlencode($text)."&from=EN&to=zh_CHS&appKey=".$key."&salt=".$salt."&sign=".$sign;
	//echo $url;
	$info = json_decode(file_get_contents($url));
	$info = $info->translation;
	return $info[0];
}

function translate_po($file,$fyi)
{
	$input = file_get_contents($file);
	$input_array = file($file);
	$count = count($input);
	
	// 输出头部
	echo 'msgid ""'."\n";
	echo 'msgstr ""'."\n";
	
	for($i=2;$i<count($input_array);$i++) {
		$value = $input_array[$i];
		// 跳过翻译字段
		$tmp = explode("msgstr", $value);
		if(count($tmp)>1):
			continue;
		endif;
		// 截取翻译原文
		$tmp = explode("msgid", $value);
		if(count($tmp)>1){
			$tmp = explode('"', $tmp[1]);
			if(empty($tmp[1]))
			{	
				// 长文本处理
				if($value=='msgid ""'."\n")
				{
					echo 'msgid ""'."\n";
	
					$longtext = [];
					$line_counter = 1;
					$next_line = $input_array[$i+$line_counter];
					//echo $next_line;
					//echo strpos($next_line, "msgstr");
					while(1)
					{
						echo $next_line;
						array_push($longtext,str_replace(array('"'),'',$next_line));
						$line_counter++;
						$next_line = $input_array[$i+$line_counter];
						$stop_condition = explode("msgstr", $next_line);
						// 长文本截取完毕，逐行处理
						if(count($stop_condition)>1)
						{
							$plural_test = explode("msgstr[0]", $next_line);
							if(count($plural_test)>1){
								echo 'msgstr[0] ""'."\n";
							}
							else{
								echo 'msgstr ""'."\n";
							}
							
							foreach ($longtext as $key => $value) {
								$value = str_replace("\n","",$value);
								echo '"';
								echo $fyi($value);
								echo '"'."\n";
							}
							$i+=$line_counter;
							break;
						}
					}
	
				}
	
			}
			else{
				echo 'msgid "';
				echo $tmp[1];
				echo '"'."\n";
				echo 'msgstr "';
				echo $fyi($tmp[1]);
				echo '"'."\n";
	
			}
		}
		else{
			echo $value;
		}
	
	}
	
}

translate_po("zh_CN.po",'youdaoFree');
?>