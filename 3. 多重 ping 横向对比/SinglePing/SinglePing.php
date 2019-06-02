<?php
	/*
		SinglePing
		Author: Rytia
		Blog: www.zzfly.net
	*/
	ob_end_clean();
	ob_implicit_flush(true);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>腾讯云 广州二区 Ping</title>
	<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap-theme.css" rel="stylesheet">
	<style>
		body{
			padding:0 10%;
			background: #f1f1f1;
		}
		#main{
			padding: 1rem;
			background: #fff;
		}
		code {
		    background: #eee;
		    padding: 0.2rem;
		    color: #bc1c1c;
		    margin-left: 10px;
		}
		hr{
			border: 1px solid #eee;
    		border-top: 0px;
    		margin: 16px 0;
		}
		pre{
			overflow: auto;
		}
		input{
			padding-left:7px;
		}
		@media (max-width: 767px){
		body{
		    padding: 0px;
		}
		}
	</style>
</head>
<body>
	<div id="main">
		<?php
		
		if (isset($_GET['host'])) {
			$host = $_GET['host'];
		
			$origin = json_decode(file_get_contents("http://x64.men/get/?ip=".$host));
			echo $origin->country." ".$origin->province." ".$origin->city." ".$origin->isp;
			echo "<code>".$origin->ip."</code>";

			echo "<hr>";
			
			echo "<pre>";
			if(isset($_GET['count'])){
				$count = $_GET['count'];
			}
			else{
				$count = 5;
			}
			for ($i=0; $i < $count ; $i++) { 
				exec("ping $host -n 1",$output,$status);
				echo $output[2].'<br>';
			}
			echo "</pre>";
		}else{
			?>
		<form action="" method="get">
			<input type="text" name="host" placeholder="IP / 域名" >
			<input type="text" name="count" placeholder="次数，默认 5 " value="5">
			<input type="submit" value="Ping">
		</form>

			<?php
		}
		?>
	</div>
</body>
</html>

