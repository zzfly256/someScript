<?php 
function ping_time($host,$count){
	exec("ping $host -n $count",$output,$result);
	if($result==0)
	{
		$time = explode("=", trim($output[$count+6]));
		$time = trim($time[3]);
		return $time;
	}
	else{
		return "lost";
	}
}

if(isset($_GET['host'])){
	if(isset($_GET['count'])){
		$count = $_GET['count'];
	}
	else{
		$count = 3;
	}
	$lost = ping_time($_GET['host'],$count);
	echo $lost;
}


?>