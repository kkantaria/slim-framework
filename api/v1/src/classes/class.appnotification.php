<?php 
class Appnotification extends Base
{
	private $notification;
	private $payload;
	private $device_token;
	function __construct()
	{
		$data['google_notification_key']=GOOGLE_KEY;
		$data['ios_dev_pemfile_path']=IOS_DEV_PEMFILE_PATH;
		$data['ios_pro_pemfile_path']=IOS_PRO_PEMFILE_PATH;
		$data['ios_dev_pem_password']=IOS_DEV_PEM_PASSWORD;
		$data['ios_pro_pem_password']=IOS_PRO_PEM_PASSWORD;
		$this->device_token=$this->device_token=array(
			array(
				"type"=>"ios",
				"device_token"=>"test"
				),
			array(
				"type"=>"android",
				"device_token"=>"test1"
				)
			);	
		$this->payload=array(
			"message"=>"This is my testing",
			"type"=>"default",
			"data"=>array(),
			"extra"=>array(
					array(
						"title"=>"test",
						"mute"=>1,
						"attacthment"=>"",
					)
				),
			);
		parent::__construct();
		$this->notification=new Notification($data,$this->device_token);
	}
/*
	Notification : User Request Accept in sub communty
*/	
	function ntNotificationDeno()
	{
		$message="testing notification";
		$this->payload=array(
			"message"=>$message,
			"type"=>"test-notification",
			"data"=>array(),
			"extra"=>array(
					array(
						"title"=>"Knitd",
						"mute"=>1,
						"attacthment"=>"",
					)
				),
			);
		$this->send();	
	}		
/*
	COMMAN PART
	-------------------------------------------------------------------------------------	
	Send All type notification to specific user
*/
	function sendAll()
	{
		$this->test();
	}
/*
	Testing notification
*/		
	function test()
	{
		$this->notification->send_notification($this->payload);
	}
/*
	Set user device token to send notification
*/	
	function set_user_device_token($user_id)
	{
		$data=array();
		$query="SELECT at.device_token,df.type from users as u JOIN access_token as at ON u.user_id=at.user_id JOIN def_clients as df ON at.client_id=df.client_id WHERE u.user_id in($user_id)";
		$res=$this->query($query)->fetchAll();
		$this->notification->set_device_token($this->device_token=$res);
	}
/*
	Send push notification
*/	
	function send()
	{
		$this->notification->send_notification($this->payload);
	}
}
?>