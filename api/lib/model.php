<?php 
namespace Lib;
abstract class Model extends Database
{
	private $table;
	function __construct($table)
	{
		parent::__construct();
		$this->table=$table;
	}
	protected function save($data=array(),$where=array(),$is_update_flag=0)
	{
		if(empty($where))
		{
			return $this->pdo_insert($this->table,$data);
		}else
		{
			return $this->pdo_update($this->table,$data);
		}
	}

}
?>