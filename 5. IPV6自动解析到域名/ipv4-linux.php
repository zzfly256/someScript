<?php

$domain 		=	"x64.men";
$sub_domain 	=	"seele";
$record_type 	= 	"A";
$token 			= 	"*****************";

error_reporting(0);

/**
 * POST 请求
 * @param  [string] $url      请求链接
 * @param  [array] $post_data 携带的参数
 * @return [array] $result    返回获取的内容
 */
function send_post($url,$post_data) {

      $postdata = http_build_query($post_data);
      $options = array(
            'http' => array(
                'method' => 'POST',//注意要大写
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata
            ),
            "ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
   		 	),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
}

echo "动态 IPv4 域名自动解析\n\n";

while(true){
	// 得到域名记录
	
	$post_data = array(
	    'login_token' => $token,
	    'format' => 'json',
	    'domain' => $domain,
	    'sub_domain' => $sub_domain,
	    'record_type' => $record_type,
	    'offset' => '0',
	    'length' => '3'
	);
	
	$domain_record = json_decode( send_post('https://dnsapi.cn/Record.List',$post_data) );
	
	if(is_array($domain_record->records)){
		$dnspod_ipv6_config = $domain_record->records[0]->value;
	} else {
		echo "解析为空\n";
		$dnspod_ipv6_config = false;
	}
	
	
	
	
	$local_ipv6_config = "";
	exec("ifconfig enp0s31f6",$ipconfig_result);
	
	foreach ($ipconfig_result as $value) {
		if(stripos($value, "inet ") == 8){
			$local_ipv6_config = trim(explode(" ", $value)[9]);
		}


	}

	
	
	
	if ($local_ipv6_config != $dnspod_ipv6_config) {
		
	
		if($dnspod_ipv6_config){
			echo "域名解析:\t",$dnspod_ipv6_config,"\n";
			// 删除解析
			$post_data = array(
			    'login_token' => $token,
			    'format' => 'json',
			    'domain' => $domain,
			   	'record_id' => $domain_record->records[0]->id
			);
		
			$domain_result = json_decode( send_post('https://dnsapi.cn/Record.Remove',$post_data) );
			if ($domain_result->status->code == "1") {
				echo "删除解析成功\n";
			} else {
				echo "删除解析出错\n";
				var_dump($domain_result->status->message);
			}
		}
		
		echo "本地地址:\t",$local_ipv6_config,"\n";
		echo "检查时间:\t",date("Y-m-d H:i:s"),"\n";
	
		// 添加解析
		$post_data = array(
		    'login_token' => $token,
		    'format' => 'json',
		    'domain' => $domain,
		    'sub_domain' => $sub_domain,
		    'record_type' => $record_type,
		    'record_line' => '默认',
		    'value' => $local_ipv6_config
		);
		$domain_result = json_decode( send_post('https://dnsapi.cn/Record.Create',$post_data) );
		if ($domain_result->status->code == "1") {
			echo "添加解析成功\n";
		} else {
			echo "添加解析出错\n";
			var_dump($domain_result->status->message);
		}
	
	} else {
		echo "解析正常:\t",date("Y-m-d H:i:s"),"\n";
	}
	
	// sleep("5");
	break;

}