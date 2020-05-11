<?php
$fp = fopen('www.travoplus.cn.log', 'r');

// 101.132.69.5 - - [07/Dec/2019:06:05:28 +0800] "GET / HTTP/1.1" 200 985 "-" "Mozilla/5.0 (iPhone; CPU iPhone OS 8_0_2 like Mac OS X)"

$time_map = [];

while (!feof($fp)) {
    preg_match('/([^ ]*) ([^ ]*) ([^ ]*) (\[.*\]) (\".*?\") (-|[0-9]*) (-|[0-9]*) (\".*?\") (\".*?\")/', fgets($fp), $matches);

    if (isset($time_map[$matches[4]])) {
        $time_map[$matches[4]] += 1;
    } else {
        $time_map[$matches[4]] = 1;
    }
}



asort($time_map);

var_dump($time_map);