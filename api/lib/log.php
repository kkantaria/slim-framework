<?php 
use Lib\Database;
class Log extends Database
{
	private $token;
	private $log_data;
	function __construct()
	{
		parent::__construct();
		$sess=new Session();
		$this->log_data=new stdClass();
		$this->log_data->log_type="NOT SET";
		$this->log_data->route_name=get_route()."/".get_route("name");
		$this->log_data->log_text="NOT SET";
		$this->log_data->file_log_text="NOT SET";
		$this->log_data->user_id=myempty($sess->getMulti("user_data","user_id"));
	}
	function basic_log_insert($data)
	{
		$this->log_data->log_text=json_encode($data);
		$this->log_data->file_log_text=json_encode($_FILES);
		$this->pdo_insert("log_table",$this->log_data);
	}	
}
?>