<?php
require_once("../../includes/database.php");
require_once("../../includes/user.php");
require_once("../../includes/session.php");
require_once("../../includes/function.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }
require_once("../layout/admin_header.php");
?>
<?php
	// 	  $user=new user();
 //  $user->username="sakshi ji";
 //  $user->password="saki@123";
 // $user->first_name="sakshi";
 //  $user->last_name="ji";
 //  $user->create();

      //       $user=user::get_result_of_query("select * from users where id=4");
      // //echo  $user[0]->username;
      //    if($user)
      //       {$users=array_shift($user);
      //                $users->password="saaaaaa";
      //                $users->save();}
      //                else
      //                {
      //                	echo "no user of spacified id";
      //                }
  $user=user::get_result_of_query("select * from users where id=7");
           //echo  $user[0]->username;
           if($user)
           {$users=array_shift($user);
                  
                    $users->delete();}
                    else
                    {
                    	echo "no user of spacified id";
                    }
		?>
		</div>
		
        <?php require_once("../layout/footer.php");?>