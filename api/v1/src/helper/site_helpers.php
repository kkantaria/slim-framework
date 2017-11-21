<?php
    function get_route($key="group")
    {
    	if(isset($_SERVER['REDIRECT_URL']))
		{
		    $url=$_SERVER['REDIRECT_URL'];    
		}else
		{
		    $url=$_SERVER['PHP_SELF'];
		}
		$sub="/".$GLOBALS['sub_folder'].$GLOBALS['api_version']."/";
		$url=str_replace($sub,"",$url);
		$tmp=explode("/",$url);
    	if($key=="name")
    		return @$tmp[1];
    	else
    		return $tmp[0];
    }
	function pre($data,$flag=0,$var=0)
	{
		echo "<pre>";
		$var==0?print_r($data):var_dump($data);
		if($flag==0)
			exit;
	}
	function not_valid($key)
	{
		_json(UNAUTH,$key." Not Valid");	
	}
	
	
	function activation_token($email)
	{
		return sha1(mt_rand(10000,99999).time().$email);
	}

	function ghv($key,$request)
	{
		$header = $request->getHeaders();
		return $header['HTTP_'.$key][0];
	}

	function is_blank($key,$array)
	{
		$empty = array();
		foreach($key as $k=>$v)
		{
			if(empty($array[$v]))
			{
				array_push($empty,$v);
			}
		} 
		if(count($empty)>0)
		{
			_json(UNAUTH,implode(",",$empty)." can not be null");	
		}
	}

	function is_my_empty($data)
	{
		$empty=array();
		foreach($data as $k=>$v)
		{
			if($v=="")
			{
				array_push($empty,$k);
			}	
		}
		if(count($empty)>0)
		{
			$result['status']=UNAUTH;
			$result['message']=implode(",",$empty)." can not be null";
			_json($result,UNAUTH);	
		}	
	}
	
	function _json($code,$message,$data=array())
	{
		@http_response_code($code);
		header("Content-Type: application/json");
		$result['status_code'] = $code;
		$result['message'] = $message;
		if($code==SUCCESS)
			$result['data'] = $data;
		echo json_encode($result);
		exit;
	}
	function os_valid($val)
	{
		if($val=="ios" || $val=="android")
		{
			return $val;
		}else
		{
			 _json(UNAUTH,"Os type not valid");
		}
	}
	function cdt($timezone="")
	{
		if($timezone!="")
		{
			date_default_timezone_set($timezone);		
		}
		return date("Y-m-d H:i:s");
	}
	function isJson($string) 
	{
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}
	function genrate_token($str="")
	{
		return sha1(microtime(true).mt_rand(10000,90000).$str);
	}
	function myempty($str,$flag="")
	{
		if($flag=="array")
		{
			return empty($str)?array():$str;
		}else 
		{
			if(is_int($str))
				return empty($str)?0:$str;
			else		
				return empty($str)?"":$str;
		}
	}
	function encrypt_password($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}
	function genrate_random_access_token($str="")
	{
		return  str_shuffle(md5($str).time().rand());
	}