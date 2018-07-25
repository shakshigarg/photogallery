<?php
require_once("../includes/database.php");
require_once("../includes/user.php");
require_once("../includes/session.php");
require_once("../includes/function.php");
require_once("../includes/photograph.php");
require_once("../includes/comment.php");
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
	if(isset($_POST['submit']))
	{
		$author=trim($_POST['author']);
		$body=trim($_POST['body']);
		if(!empty($author)&&!empty($body))
		{
			$comment=comments::make($photo->id,$author,$body);
			if($comment&&$comment->save())
			{
				
					redirect_to("photo.php?id={$photo->id}");
				
			}
			else
			{
				$_SESSION['message']="cannot make the comment ,,something really unauspicious";
			}
		}
		else
			{
				$_SESSION['message']="author or body cannot be blank";
			}
	}
	else
	{
		$author="";
		$body="";
	}

	$comments=$photo->coments();

	?>
		<?php require_once("layout/header.php");?>
		<a href="index.php">&laquo;BACK</a>
		<br>
		<br>
		<br>
		<div style="margin-left: 20px; float: left; padding-right: 50px">
			<center><img src="<?php echo $photo->public_img_path."/".$photo->filename?>" width=850em height=500em />
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
		</div>
	<?php }?>
	<?php if(empty($comments)){
		echo "NO COMMENTS";
	}?>
	
</div>
		<h3 style="color: #1A446C; border: 2px solid #1A446C; padding: 10px; margin-right:10px;margin-top:  10px;margin-bottom:  15px; display: inline-block;"><strong>ADD NEW COMMENT</strong></h3>
      <div id="comment-form">

		<?php if(isset($_SESSION['message']))
			{echo $_SESSION['message'];
			unset($_SESSION['message']);
		}
		?>
		<form action="photo.php?id=<?php echo $photo->id ; ?>" method="post">
			<table>
				<tr>
					<td>YOUR NAME: </td>
					<td><input type="text" name="author" value="<?php echo $author ?>"></td>
				</tr>
				<tr>
					<td>COMMENT: </td>
					<td><textarea name="body" cols="40" rows="8"><?php echo $body?></textarea></td>
				</tr>
				<tr>
				<td>&nbsp</td>
				<td><input type="submit" name="submit" value="COMMENT"></td></tr>
			</table>
		</form>
		
		</div>
		</div>
		
    <?php require_once("layout/footer.php");?>