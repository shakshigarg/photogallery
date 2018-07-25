<?php
require_once('database.php');
require_once('database_object.php');

class photograph extends database_object{
    protected static $table_name="photographs";
    protected static $table_fields=array('id','filename','type','size','caption');
    public $filename;
    public $id;
    public $type;
    public $size;
    public $caption;
    private $temp_path;
    protected $upload_dir="../images";
    public $error=array();
    public $public_img_path="images";
    public function get_path()
    {
        return $this->upload_dir;
    }

    public static function count_all()
    {
        global $db;
        $res=$db->query("select count(*) from photographs");
        $res=$db->fetch_array($res);
        return array_shift($res);
    }


    public function coments()
    {
        return comments::get_result_of_query("select * from comments where photograph_id={$this->id}");
    }
    protected $uploaded_errors=array(
                   UPLOAD_ERR_OK=>"NO ERRORS",
                   UPLOAD_ERR_INI_SIZE=>"LARGER THAN UPLODED MAX FILE SIZE",
                   UPLOAD_ERR_FORM_SIZE=>"LARGER THE MAX FILE SIZE",
                   UPLOAD_ERR_PARTIAL=>"PARTIAL FILE UPLOAD",
                   UPLOAD_ERR_NO_FILE=>"NO FILE",
                   UPLOAD_ERR_NO_TMP_DIR=>"NO TEMPRORY FILENAME",
                   UPLOAD_ERR_CANT_WRITE=>"CANT WRITE TO DISK",
                   UPLOAD_ERR_EXTENSION=>"FILE UPLOADED STOPPED BY EXTENSION");

    //fun that do following things
    //1.pass in $_FILE['uploaded_file']) as arg
    //2 perform error checking on form parameters
    //3.set objcet attributes to form parameters 
    //4.dont worry about saving data in database
    public function attach_file($file)
    {
        if(!$file||empty($file)||!is_array($file))
        {
            $this->error[]="no file uploaded";
        }
        else
        {
            if($file['error']!=0)
            {
                $this->error[]=$this->uploaded_errors[$file['error']];
                            }
            else
            {
                $this->temp_path=$file['tmp_name'];
                $this->type=$file['type'];
                $this->size=$file['size'];
                $this->filename=basename($file['name']);

            }
        }
    }


    //to upoad the files 

    public function save()
    {
        if(isset($this->id))
        {
            if(strlen($this->caption)>=255)
            {
                $this->error[]="caption can only be 255 chars long";
                return false;
            }
            else
            {
             $this->update();
             return true;
            }
        }
        else
        {
            //first check there must be no errors
            if(!empty($this->error))
            {
                return false;
            }
            //check caption not longer han 255 chars
            if(strlen($this->caption)>=255)
            {
                $this->error[]="caption can only be 255 chars long";
                return false;
            }
            //check if filename and temp_path not empty

            if(empty($this->filename)||empty($this->temp_path))
            {
                $this->error[]="file location not correct";
                return false;

            }
            if(file_exists($this->upload_dir."/".$this->filename))
            {
                $this->error[]="file already exists";
                return false;
            }
            if(move_uploaded_file($this->temp_path,$this->upload_dir."/".$this->filename))
             {
                if($this->create())
                {
                    unset($this->temp_path);
                    return true;
                }
                else
                {
                    $this->error[]="file cannot be uploaded may be due to locatin of finalupload foder unspecified";
                    return false;
                }
             }
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
    	// public function save()
    	// {
    	// 	return isset($this->id)?$this->update():$this->create();
    	}
?>