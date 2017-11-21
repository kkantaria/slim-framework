<?php 
namespace Lib;
use \PDO;
class Database
{
	private $conn;
	function __construct()
	{
		global $DB;
		$this->conn=$DB;
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->conn->query("SET SESSION group_concat_max_len = 100000000");
	}
	function pdo_insert($table_name,$bind)
	{
		try
		{
			$key=array();
			foreach($bind as $k=>$v)
				array_push($key,$k);

			$query= $this->conn->prepare("insert into $table_name(".implode(",",$key).") values (:".implode(",:",$key).")");
			
			foreach($bind as $k=>&$v)
					$query->bindParam(":".$k,$v);

			$query->execute();
			
			return $this->conn->lastInsertId();		
		}
		catch(PDOException $p)
		{
			if(MODE=="production")
				return false;
			else
				pre($p);
		}
	}

	function pdo_update($table,$bind,$where,$flag=0)
	{
		try
		{
			$key=array();$where_key=array();
			foreach($bind as $k=>$v)
				array_push($key,$k."=:".$k);

			$query= $this->conn->prepare("update $table set ".implode(",",$key) ." where ".$where);
			foreach($bind as $k=>&$v)
				$query->bindParam(":".$k,$v);
				
			if(!$flag==1)
			{
				return $query->execute();		
			}
			else
			{
				$query->execute();
				return $query->rowCount(); 		
			}
		}
		catch(PDOException $p)
		{
			if(MODE=="production")
				return false;
			else
				pre($p);
		}
	}

	function pdo_delete($table,$where,$flag=0)
	{
		try
		{
			$query= $this->conn->prepare("delete from $table where ".$where);
			if(!$flag==1)
			{
				return $query->execute();		
			}
			else
			{
				$query->execute();
				return $query->rowCount(); 		
			}
		}
		catch(PDOException $p)
		{
			if(MODE=="production")
				return false;
			else
				pre($p);
		}
		
	}

	function pdo_select($table,$where=" 1 ",$field=array("*"),$flag=0)
	{
		try
		{
			$query="select ".implode(",",$field)." from $table ";
			if($where!="")
				$query .=" where $where ";
			$result = $this->conn->prepare($query);
			$result->execute();
			if($flag==1)
			{
				$data['status']=$result->rowCount();
				$data['data']=$result->fetch(PDO::FETCH_ASSOC);
			}
			else
			{
				$data['status']=$result->rowCount();
				$data['data']=$result->fetchAll(PDO::FETCH_ASSOC);
			}	
		}
		catch(PDOException $p)
		{
			if(MODE=="production")
			{
				$data['status']=false;
				$data['data']=array();
			}	
			else
				pre($p);
		}
		return $data;
	}

	function query($query)
	{
        try
		{
	       $query= $this->conn->prepare($query);
		   $query->execute();
		   return $query;
		}
	    catch(PDOException $p)
		{
			if(MODE=="production")
			{
				$data['status']=false;
				$data['data']=array();
				return $data;
			}	
			else
				pre($p);
		}
	}

	function pdo_count($table,$where,$field,$group_by="")
	{
		if($group_by!="")
			$group_by="group by ".$group_by;
		$query="select count(".$field.") as total from $table ";
		if($where!="")
		 	$query .=" where $where ";
		$query= $this->conn->prepare($query.$group_by);
	    $query->execute();
		return intval($query->fetch()['total']);
	}

	function set_transaction()
	{
		$this->conn->beginTransaction();
	}
	
	function save_transaction()
	{
		$this->conn->commit();
	//	$this->conn = null;
	}
	
	function rollback_transaction()
	{
		try
		{
			$this->conn->rollBack();
			//$this->conn = null;
		}
		catch(PDOException $p)
		{
			$data['status'] = false;
			$data['message'] = "Database Error";
			$data['error'] = $p->getMessage();
		}
	}
}
?>