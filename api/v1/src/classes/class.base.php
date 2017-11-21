<?php 
Use Lib\Database;
Use Lib\Session;
class Base extends Database
{
	protected $session; 
	function __construct()
	{
		parent::__construct();
		$this->session=new Session();	
	}
	function send_email($to="",$subject="",$data=array())
	{
			
			include_once(MAIL_TEMPLATE_PATH."PHPMailer-master/PHPMailerAutoload.php");
			include_once(MAIL_TEMPLATE_PATH."mail.php");
			
			
	} 
	function get_user_id()
	{
		return $this->session->getMulti("users","user_id");
	}
}
?>