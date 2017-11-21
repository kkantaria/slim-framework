<?php 
namespace Lib;
use Lib\Session;
class UsersSystem extends Database
{
	private $session;
	private $users;
	function __construct()
	{
		parent::__construct();
		$this->session=new Session();
	}
	function check_access_token($token)
	{
		if(empty(trim($token)))
			return false;
		$client=$this->session->getMulti("clients","client_id");
		$str="select u.* from access_token as at JOIN users as u ON at.user_id=u.user_id where access_token='".$token."' and client_id=$client";
		$res=$this->query($str);
		if($res->rowCount())
		{
			$this->users=$data=$res->fetch();
			$this->session->set("users",$data);
			return true;
		}
		return false;
	}	
	function genrate_access_token($user_id,$device_token)
	{
		$token="";
		do
		{	
			$token=genrate_random_access_token($user_id);
			$count=$this->pdo_count("access_token","access_token='".$token."'","access_token");
		}while($count>0);
		$client=$this->session->getMulti("clients","client_id");
		$data=array(
			"client_id"=>$client,
			"access_token"=>$token,
			"device_token"=>$device_token
			);
		$user=$this->pdo_select("access_token","user_id=".$user_id." and device_token='".$device_token."'",array("access_token_id,device_token"),1);
		$is_update=0;
		if($user['status'])
		{
			$this->pdo_update("access_token",$data,"access_token_id=".$user['data']['access_token_id']);
		}else
		{
			$data['user_id']=$user_id;
			$this->pdo_insert("access_token",$data);
		}
		return $token;
	}
	function genrate_forgot_token($user_id)
	{
		$token="";
		do
		{	
			$token=genrate_random_access_token($user_id);
			$count=$this->pdo_count("users","forgot_token='".$token."'","forgot_token");
		}while($count>0);
		$this->pdo_update("users",array("forgot_token"=>$token,"forgot_passwprd_token_time"=>cdt()),"user_id=".$user_id);
		return $token;
	}
	function genrate_verify_token($user_id)
	{
		$token="";
		do
		{	
			$token=genrate_random_access_token("verify_token");
			$count=$this->pdo_count("users","verify_token='".$token."'","verify_token");
		}while($count>0);
		$this->pdo_update("users",array("verify_token"=>$token,"verify_token_time"=>cdt()),"user_id=".$user_id);
		return $token;
	}
	function check_email($email)
	{
		$res = $this->pdo_select('users',"email='".$email."'",array("*"),1);
		if($res['status'])
		{
			return $res['data']['user_id'];
		}else
		{
			return false;
		}
	}
}
?>