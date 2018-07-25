<?php
class session{
	public $user_id;
	private $logged_in;


//constructor to start the session

	 function __construct()
	 {
	 	session_start();
	 	$this->check_logged_in();
	 }

//to get the value of logged_in
	public function is_logged_in()
	{
        return $this->logged_in;
	}


	//to check if any user logged in or not

	public function check_logged_in()
	{
		if(isset($_SESSION['user_id']))
		{
			$this->user_id=$_SESSION['user_id'];
			$this->logged_in=true;
		}
		else
		{
			unset($this->user_id);
			$this->logged_in=false;
		}
	}

	//when we find that the user can log in

	public function login($user)
	{
		if($user)
		{
			$this->user_id=$_SESSION['user_id']=$user->id;
			$_SESSION['username']=$user->username;
			$this->logged_in=true;
		}
	}



	//when we want to logout a user whosoever logged in

	public function logout()
	{
		unset($_SESSION['user_id']);
		unset($this->user_id);
		$this->logged_in=false;
	}
}
$session=new session();
?>