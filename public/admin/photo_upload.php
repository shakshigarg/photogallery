<?php
require_once("../../includes/database.php");
require_once("../../includes/user.php");
require_once("../../includes/session.php");
require_once("../../includes/function.php");
require_once("../../includes/photograph.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }

?>

<?php
  $max_file_size=1048576;
?>
<?php
$message="";
if(isset($_POST['upload']))
{
  $photo=new photograph();
  $photo->caption=htmlentities($_POST['caption']);
  $photo->attach_file($_FILES['file_upload']);
  if($photo->save())
  {
    $_SESSION['message']="photo uploaded successfully";
    redirect_to("list_photos.php");
  }
  else
  {
    $_SESSION['message']=join('<br>',$photo->error);
    redirect_to("list_photos.php");
  }
}
  ?>


  <?php
require_once("../layout/admin_header.php");
?>
<?php 
echo $message;?>
<form action="photo_upload.php" enctype="multipart/form-data" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
<p><input type="file" name="file_upload"/></p>
<p>CAPTION  :  <input type="text" name="caption"/></p>

<input type="submit" name="upload" value="upload"/> 
</form>


<br>
<br>
<a href="list_photos.php">SHOW ALL UPLOADED FILES</a>
		</div>
		
        <?php require_once("../layout/footer.php");?>