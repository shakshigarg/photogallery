<?php
require_once('database.php');
require_once('database_object.php');
class comments extends database_object{
    protected static $table_name="comments";
    protected static $table_fields=array('id','photograph_id','created','author','body');
    public $photograph_id;
    public $id;
    public $created;
    public $author;
    public $body;
    
    public static function make($photo_id,$author="annonymous",$body="") 
    {
        if(!empty($photo_id)&&!empty($author)&&!empty($body))
        {
            $comment=new comments();
            $comment->photograph_id=$photo_id;
            $comment->author=$author;
            $comment->body=$body;
            $comment->created=strftime("%y-%m-%d %H:%M:%S",time());
            return $comment;
        }
        else
        {
            return false;
        }
    }
	public static function get_result_of_query($query="")
	{
		global $db;
		$result=$db->query($query);
		$obj_arr=array();
		while($arr=$db->fetch_array($result))
		{
			$obj_arr[]=self::instantiate($arr);
			
		}
		return $obj_arr;
	}

   //to get the full name of user

	// public function full_name()
	// {
	// 	//echo "hiiii".$this->first_name;
	// 	return $this->first_name." ".$this->last_name;
	// }




	//to convert a array record in obkject having all those attributes

    private static function instantiate($record)
    {
    	$obj=new self;
    	foreach($record as $attribute=>$value)
    	{
            if($obj->has_attribute($attribute))
            {
            	
            	$obj->$attribute=$value;
            }
            
    	}
    	return $obj;
    }


    //to check of the object has a property same asthe attribute

    private function has_attribute($att)
    {
    	$obj_vars=get_object_vars($this);
    	return array_key_exists($att, $obj_vars);

    }


    //funtion to check if user exits or not

    // public static function authenticate($username="",$password="")
    // {
    // 	global $db;
    // 	$username=$db->mysql_prep($username);
    // 	$password=$db->mysql_prep($password);
    // 	$query="select * from users where username='$username' and password='$password'";
    // 	$res=self::get_result_of_query($query);
    //     return (!empty($res)?array_shift($res):false);
    // }


    protected function attributes()
    {
        global $database;
       $attributes=array();
       foreach(self::$table_fields as $att)
        {
            if(property_exists($this, $att))
            {
                $attributes[$att]=$this->$att;
            }

        }
        return $attributes;
    }

    protected function up_attributes()
    {
        global $database;
       $attributes=$this->attributes();
       //print_r($attributes);
       $up_att=array();
       foreach($attributes as $key=>$field)
        {
            $up_att[]="{$key}='{$field}'";

        }
        //echo "helloo";
        //print_r($up_att);
        return $up_att;
    }

    public function create()
    {
    	global $db;
    	// $username=$db->mysql_prep($this->username);
    	// $pass=$db->mysql_prep($this->password);
    	// $f_name=$db->mysql_prep($this->first_name);
    	// $l_name=$db->mysql_prep($this->last_name);
        $query="insert into ".self::$table_name."(".join(',',array_keys($this->attributes())).") ";
        $query.="values('";
        $query.=join("','",array_values($this->attributes()));
        $query.="')";
        //echo $query;
        if($db->query($query))
        {
        	$this->id=$db->insert_id();
        	echo "successfully inserted data";
            return true;
        }
        else
        {
            return false;
        	die("query failed");
        }

    	    }
  public function update()
    {
    	global $db;
        $query="update ".self::$table_name." set ";
        $query.=join(',',$this->up_attributes());
        $query.=" where id=$this->id";
        echo $query;
        
        if($db->affected_rows($db->query($query))==1)
        {
        	echo "success";
        }
        else
        {
        	echo "cannot update";
        }

    	    }

public function delete()
    {
    	global $db;
    	$id=$db->mysql_prep($this->id);
    	// $username=$db->mysql_prep($this->username);
    	// $pass=$db->mysql_prep($this->password);
    	// $f_name=$db->mysql_prep($this->first_name);
    	// $l_name=$db->mysql_prep($this->last_name);
        $query="delete from ".self::$table_name;
        $query.=" where id=$id";
        //echo $query;
        
        if($db->affected_rows($db->query($query))==1)
        {
        	//echo "success";
            return true;
        }
        else
        {
        	//echo "cannot update";
            return false;
        }

      }
         


         //to delete the photo as well as unupload it

            public function destroy()
            {
                if($this->delete())
                {

                    if(!unlink($this->upload_dir."/".$this->filename))
                        {echo $this->upload_dir."/".$this->filename;}
                    $_SESSION['message']="FILE DELETED SUCCESSFULLY";
                    return true;
                }
                else
                {
                    $_SESSION['message']="SOME ERROR IN DURING DELETING FROM DATABASE";
                    return false;
                }
            } 
         //method overwritten above
    	 public function save()
    	 {
    	 	return isset($this->id)?$this->update():$this->create();
    	}
    }
?>