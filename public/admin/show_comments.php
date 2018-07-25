<?php
require_once("../../includes/database.php");
require_once("../../includes/user.php");
require_once("../../includes/session.php");
require_once("../../includes/function.php");
require_once("../../includes/photograph.php");
require_once("../../includes/comment.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>

		
		<?php
		if(isset($_GET['id'])){
	$result=photograph::get_result_of_query("select * from photographs where id={$_GET['id']}");
	$photo=array_shift($result);
	if(!$photo)
	{
	   $_SESSION['message']="cannot locate image";
	   //redirect_to("index.php");
	}}
	?>
	<?php 
if(isset($_GET['comment_id']))
{
	if(empty($_GET['comment_id']))
	{
		$_SESSION['message']="NO ID FOUND";
	}
	else
	{
		$comment_ar=comments::get_result_of_query("select * from comments where id={$_GET['comment_id']}");
		$comment=array_shift($comment_ar);
		if($comment&&$comment->delete())
		{
			$_SESSION['message']="COMMENT DELETED SUCCESSFULLY";
		}
		else
		{
			$_SESSION['message']="SOME ERROR OCCURED";
			//echo $_SESSION['message'];
		}
	}
}

	$comments=$photo->coments();

	?>
		<?php require_once("../layout/admin_header.php");?>
		<a href="http://localhost/pproject_2/photogallery/public/admin/list_photos.php">&laquo;BACK</a>
		<br>
		<br>
		<br>
		<div style="margin-left: 20px; float: left; padding-right: 50px">
			<center><img src="<?php echo $photo->get_path()."/".$photo->filename?>" width=850em height=500em />
			<p style="font-size: 20px; font-weight: bold; font-family: Comic Sans MS;"><?php echo $photo->caption;?></p></center><br><br>
		</div>
		<div id="comments" >
	<h3 style="color: #1A446C; border: 2px solid #1A446C; padding: 10px; margin-right:10px;margin-top:  10px;margin-bottom:  10px; display: inline-block;"><strong>ALL COMMENTS</strong></h3>
	<?php foreach ($comments as $comment) {?>

		<div class="comment" style="margin-bottom: 2em">
			<div class="author" style="font-weight: bold;">
				<?php echo htmlentities($comment->author);?> wrote:
			</div>
			<div class="body" style="font-family:verdana;">
				<?php echo strip_tags($comment->body,'<strong><em><p>')?>!!
			</div>
<div class="meta-info" style="font-size: 0.8em;">
	<?php echo datetime_to_text($comment->created); ?>
</div>
<div class="actions" style="font-size: 0.8em;">
	<a href="show_comments.php?id=<?php echo $photo->id?>&comment_id=<?php echo $comment->id?>">Delete comment</a>
	
</div>
		</div>
	<?php }?>
	<?php if(empty($comments)){
		echo "NO COMMENTS";
	}?>
	
</div>
		
		</div>
		
    <?php require_once("../layout/admin_footer.php");?>