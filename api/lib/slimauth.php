<?php 
use Lib\Database;
use Lib\UsersSystem as Users;
use Lib\Session as Session;
class Slimauth extends Database
{
	function __construct()
	{
		parent::__construct();
	}	
	function checkAuth($request)
	{

		$login_array=array("login","register","forgotPassword","socialLogin");
		$this->checkClient($request);
		$token=$request->getHeaderLine("token");
		$user=new Users;
		if(!$user->check_access_token($token))
		{
			if(!in_array(get_route("name"),$login_array))
			{
				if(AUTH_ENABLE)
					_json(TIMEOUT,"Your token is expired please login");
			}
		}
	}
	function checkClient($request)
	{
		$client_key=$request->getHeaderLine("clientkey");
		$client_secret=$request->getHeaderLine("clientsecret");
		//pre($client_key,1);
		//p/re($client_secret);
		$res=$this->pdo_select("def_clients","client_key='".$client_key."' and client_secret='".$client_secret."'",array("*"),1);
		$client_id="";
		//pre($res);
		if($res['status']==1)
		{
			$sess=new Session();	
			$sess->set("clients",$res['data']);
		}else
		{
			if(AUTH_ENABLE)
				_json(TIMEOUT,"Your API call is not valid");
		}
		return ;
	}
}
?>