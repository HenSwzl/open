##允许单个域名访问

###在文件头加入：
	header('Access-Control-Allow-Origin:http://client.runoob.com');

##允许多个域名访问
	$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';

	//加入指定访问的域名
	$allow_origin = array(  
	    'http://client1.runoob.com',  
	    'http://client2.runoob.com'  
	);  
	  
	if(in_array($origin, $allow_origin)){  
	    header('Access-Control-Allow-Origin:'.$origin);       
	}

##允许所有域名访问
	header('Access-Control-Allow-Origin:*');