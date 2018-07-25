<?php

require_once("config.php");

class MySqlDatabase{

	private $conn;
    public $last_query;


    //to open the connection
	public function open_conn()
	{
		$this->conn=mysqli_connect(DB_SERVER,DB_USER,DB_PASS);
		if(!$this->conn)
		{
			die("database conn failed ".mysqli_error($this->conn));
		}
		else
		{
			$db_select=mysqli_select_db($this->conn,DB_NAME);
			if(!$db_select)
			{
				die("database selection failed ".mysqli_error($this->conn));
			}
		}

	}


    //to run the my sql query '$query'

    public function query($query)
    {
    	$this->last_query=$query;
    	$result=mysqli_query($this->conn,$query);
    	$this->confirm_query($result);
    	return $result;
    }

    //to confirm if query run successfully

    private function confirm_query($res)
    {
    	if(!$res)
    	{
    		$output="query failed  ".mysqli_error($this->conn);
    		$output.=$this->last_query;
    		die($output);
    	}
    }


    //to prepare the vaue to be inserted in database

    public function mysql_prep($val)
    {
       if($val)
       {
       	$value=mysqli_real_escape_string($this->conn,$val);
       	return $value;
       }
       return $val;
    }

    //to convert the result of a query in array

    public function fetch_array($res)
    {
      return mysqli_fetch_array($res);
    }



    //to count no of returned by query

    public function num_rows($res)
    {
    	return mysqli_num_rows($res);
    }

    public function insert_id()
    {
    	//get last id insert over the current db conn

    	return mysqli_insert_id($this->conn);
    }


    //to get the no of rws effected
    public function affected_rows()
    {
    	return mysqli_affected_rows($this->conn);
    }

    //to close the db conn
	public function close_conn()
	{
		if(isset($this->conn))
		{
			mysqli_close($this->conn);
			unset($this->conn);
		}
	} 
   


   //constructor 
	function __construct()
     {
     	$this->open_conn();
     }
}

$db=new MySqlDatabase();
?>