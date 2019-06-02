<?php 
function ping_loss($host,$count){
	exec("ping $host -c $count",$output,$result);
	if($result==0)
	{
		$time = explode("=", trim($output[$count+4]));
		$time = explode("/", trim($time[1]));
		$time = explode(".",trim($time[1]));
		return $time[0]."ms";
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
	$lost = ping_loss($_GET['host'],$count);
	echo $lost;
}


?>