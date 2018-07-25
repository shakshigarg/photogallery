<?php
require_once("../../includes/database.php");
require_once("../../includes/user.php");
require_once("../../includes/session.php");
require_once("../../includes/function.php");
require_once("../../includes/photograph.php");
require_once("../../includes/comment.php");
require_once("../../includes/pagination.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }

?>

<?php

if(isset($_GET['id']))
{
	if(empty($_GET['id']))
	{
		$_SESSION['message']="NO ID FOUND";
	}
	else
	{
		$photo_ar=photograph::get_result_of_query("select * from photographs where id={$_GET['id']}");
		$photo=array_shift($photo_ar);
		if($photo&&$photo->destroy())
		{
			$_SESSION['message']="PHOTO DELETED SUCCESSFULLY";
		}
		else
		{
			$_SESSION['message']="SOME ERROR OCCURED";
			//echo $_SESSION['message'];
		}
	}
}

?>

<?php

//current page no

if(isset($_GET['pageno']))
{
	$page=(int)$_GET['pageno'];
}
else
{
	$page=1;
}

//records per page

$per_page=3;

//total count

$total_count=photograph::count_all();

//find all pics

$pagination=new pagination($page,$per_page,$total_count);

?>



<?php
require_once("../layout/admin_header.php");
?>

<h2 style="color: #1A446C;  padding: 10px; margin-right:10px;margin-top:  10px;margin-bottom:  10px; display: inline-block;"><strong>UPLOADED PHOTOGRAPHS</strong></h2><br><br>
<h4><?php
if(isset($_SESSION['message'])) {echo $_SESSION['message'];
unset($_SESSION['message']);}
?></h4>
<table id="customers">
	<tr>
		<th>
			<h3>IMAGE</h3>
		</th>
		<th>
			<h3>FILENAME</h3>
		</th>
		<th>
			<h3>CAPTION</h3>
		</th>
		<th>
			<h3>SIZE</h3>
		</th>
		<th>
			<h3>TYPE</h3>
		</th>
		<th>
			<h3>COMMENTS</h3>
		</th>
		<th>
			&nbsp;
		</th>
	</th>
	<?php
	$query="select * from photographs ";
		$query.="limit {$pagination->per_page} ";
		$query.="offset {$pagination->offset()}";
	$result=photograph::get_result_of_query($query);
	foreach ($result as $key => $photo) {?>
	<tr>
		<td><img src="<?php echo $photo->get_path()."/".$photo->filename?>" width=250 height=150></td>
		<td><?php echo $photo->filename ?></td>
		<td><?php echo $photo->caption ?></td>
		<td><?php echo $photo->size ?></td>
		<td><?php echo $photo->type ?></td>
		<td><a href="show_comments.php?id=<?php echo $photo->id ?>"><?php echo count($photo->coments()) ?></a></td>
		<td><a href="list_photos.php?id=<?php echo $photo->id ?>">DELETE</a></td>
	</tr>
		
	<?php }?>
</table>
<br>
<br>
<br>
<a href="photo_upload.php">UPLOAD NEW PHOTO</a><br><br>

<center>
	<b>
<div id="pagination" style="clear:both; position: center;">
		<?php
		if($pagination->total_count_pages()>1)
		{
		if($pagination->has_previous_page())
		{?>
			<a class="page" href="list_photos.php?pageno=<?php echo $pagination->previous_page()?>">&laquo; PREVIOUS</a>
		<?php }

        for($i=1;$i<=$pagination->total_count_pages();$i++)
        {
        	if($i==$page)
        	{
        		echo "<span class=\"selected\">&nbsp;{$i}&nbsp;</span>";
        	}
        	else
        	{?>
        		&nbsp;
                <a class="page" href="list_photos.php?pageno=<?php echo $i?>"><?php echo $i ?></a>
                &nbsp;
        	<?php }
        }

		if($pagination->has_next_page())
		{?>
			<a class="page" href="list_photos.php?pageno=<?php echo $pagination->next_page()?>">NEXT &raquo;</a>
			<?php }}?>
	</div>
		</center>
</b>
		
		</div>
        <?php require_once("../layout/footer.php");?>