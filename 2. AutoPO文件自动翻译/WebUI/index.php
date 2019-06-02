<?php
//$input="zh_CN.po";
if(isset($_GET['do'])){
	$input=$_GET['do'];
	//echo $input;
	$name = explode('.', $input);
	$output = $name[0]."_AutoPO".".po";
	
	exec("php AutoPO $input>$output",$a,$status);
	if($status==0){
		echo '翻译完成：<a href="/'.$output.'">'.$output.'</a>';
		echo '<span id="result_text">';
		exec("type $output",$result_text,$a);
		foreach ($result_text as $key => $value) {
			echo $value."<br>";
		}
		echo '</span>';
	}
	else{
		echo "翻译失败：$output";
	}
}else{
	?>
	<!doctype html>
	<html>
	<head>
		<title>AutoPO WebUI</title>
		<style type="text/css">
			body{
				background: #f1f1f1;
			}
			#main{
				text-align: center;
				line-height: 2rem;
				width: 400px;
				padding:2rem;
				background: #ffffff;
				margin:100px auto;
				box-shadow: 2px 2px 10px #ddd;
			}
			#result_text{
				font-size: 75%;
    			background: #eee;
    			display: block;
    			padding: 0.3rem 1rem;
    			overflow: scroll;
    			height: 300px;
    			text-align: left;
    			margin-top: 15px;
    			line-height: 1.5rem;
    			color: #555;
			}
		</style>
	</head>
	<body>
	<div id="main">
	<?php
	exec("php AutoPO",$ver,$exist);
	if($exist==0)
	{
		echo "<h2>欢迎使用 AutoPO ".$ver[0]."</h2>";
		if(isset($_FILES["po"]))
		{
			$rand = date("ymd").rand(10000,99999);
			move_uploaded_file($_FILES["po"]["tmp_name"], "upload/".$rand."_".$_FILES["po"]["name"]);
			$input="upload/".$rand."_".$_FILES["po"]["name"];
			echo "正在翻译：".$_FILES["po"]["name"];
			?>
			<div id="result"></div>
			</div>
			<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
			<script type="text/javascript">
				$("#result").load("?do=<?php echo $input;?>");
			</script>
			<?php
		}
		else{
			?>
			请上传你的空白po文件
			<form action="" method="POST" enctype="multipart/form-data">
				<input type="file" name="po">
				<input type="submit">
			</form>
	
			<?php
		}
	
	}else{
		echo "启动失败，请确保 AutoPO 文件存在";
	}
	?>
	</body>
	</html>

<?php
}
?>