<?php 
class Notification
{
	private $google_notification_key;
	private $ios_dev_pemfile_path;
	private $ios_pro_pemfile_path;
	private $ios_pro_pem_password;
	private $ios_dev_pem_password;
	private $notification_type;
	private $device_token;
	function __construct($data,$device_token)
	{
		$this->google_notification_key=$data['google_notification_key'];
		$this->ios_dev_pemfile_path=$data['ios_dev_pemfile_path'];
		$this->ios_pro_pemfile_path=$data['ios_pro_pemfile_path'];
		$this->ios_pro_pem_password=$data['ios_pro_pem_password'];
		$this->ios_dev_pem_password=$data['ios_dev_pem_password'];
		$this->notification_type=$data['notification_type'];
		$this->device_token=$device_token;
		//pre($this);
	}
	function set_device_token($device_token)
	{
		$this->device_token=$device_token;
	}	
	function gcm_for_ios($message,$gcmRegIds)
	{	
		
		$send_data = array(
			'aps' => array(
					'status_code'=>$message['status_code'],
					'alert'=>$message['message'],
					'sound' => 'default',
					'notification_type'=>$message['notification_type'],
					'mutable-content'=> $message['mute'],
				),
			'my-attachment'=>$message['attacthment'],
			);
		if(!empty($message['data']))
		{
			$send_data['aps']['data']=$message['data'];
		}
		$data = array();
		if(count($gcmRegIds)>0)
		{
			    $ctx = stream_context_create();
                if(MODE=='production')
                {
                	$passphrase = $this->ios_pro_pem_password;
                	stream_context_set_option($ctx, 'ssl', 'local_cert', $this->ios_pro_pemfile_path);	
                	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
                	$url="ssl://gateway.push.apple.com:2195";
                }
            	else
	            {	
	            	$passphrase = "";
	            	stream_context_set_option($ctx, 'ssl', 'local_cert', $this->ios_dev_pemfile_path);	
	            	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	            	$url="ssl://gateway.sandbox.push.apple.com:2195";
	            }	
			foreach ($gcmRegIds as $key => $value) 
			{
                $fp = stream_socket_client($url, $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
    			$payload = json_encode($send_data);
                try
                {
                	$msg = chr(0) . @pack('n', 32) . @pack('H*', $value['push_id']) . @pack('n', strlen($payload)) . $payload;	
                }catch(Exception $e)
                {

                }
                $result = fwrite($fp, $msg, strlen($msg));
                fclose($fp);
			}
			return $result;
		}		
	}
	function gcm_for_android($message,$data,$title="Default")
	{		
			$msg =  array(
				"aps"=>array(
					'status_code'=> $message['status_code'],
					'message' => $message['message'],
					'sound' => 'default',
					'notification_type'=>$message['notification_type'],
					'data'=>!empty($message['data'])?$message['data']:array()
					)
				);
			$fcmsg = array
                (
                'title' => $title,
                'body' => $msg,
            );
              $fields = array(
			         'registration_ids' => $data,
			         'data' => $fcmsg
			        );
			    $url = 'https://fcm.googleapis.com/fcm/send';
			   	$headers = array
				(
					'Authorization: key=' .$this->google_notification_key,
					'Content-Type: application/json'
				);
			   $ch = curl_init();
			   curl_setopt($ch, CURLOPT_URL, $url);
			   curl_setopt($ch, CURLOPT_POST, true);
			   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			   curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
			   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			   $result = curl_exec($ch);   
			   $e=curl_error($ch);
			   curl_close($ch);
			  return $result;
	}
	function send_notification($payload)
	{
		$title=myempty(@$payload['extra']['title']);
		$mute=myempty(@$payload['extra']['mute']);
		$attacthment=myempty(@$payload['extra']['attacthment']); 
		$send_data = array(
			'status_code'=>200,
			'message'=>@$payload['message'],
			'sound' => 'default',
			'notification_type'=>@$payload['type'],
			"mute"=>$mute,
			"attacthment"=>$attacthment,
			"data"=>myempty(@$payload['data'],"array"),
			);
		$ios=array();
		$and=array();
		foreach($this->device_token as $key=>$value)
		{
			if(strtolower($value['type'])=="android")
				array_push($and,$value['device_token']);
			else if(strtolower($value['type'])=="ios")
				array_push($ios,array("push_id"=>$value['device_token']));
		}
		if(count($and)>0)
		{
			$and1= $this->gcm_for_android($send_data,$and,$title);
		}
		if(count($ios)>0)
		{
			$ios= $this->gcm_for_ios($send_data,$ios,$title);
		}	
		return true;
	}
}
?>