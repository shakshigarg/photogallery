<?php
require_once("../includes/database.php");
require_once("../includes/user.php");
require_once("../includes/session.php");
require_once("../includes/function.php");
require_once("../includes/photograph.php");
require_once("../includes/pagination.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }
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

$per_page=10;

//total count

$total_count=photograph::count_all();

//find all pics

$pagination=new pagination($page,$per_page,$total_count);

?>

<?php
require_once("layout/header.php");
?>

		<h2 style="color: #1A446C; border: 2px solid #1A446C; margin: 10px; padding: 10px; display: inline-block;"><strong>ALL PHOTOS</strong></h2><br><br>
		<?php
		$query="select * from photographs ";
		$query.="limit {$pagination->per_page} ";
		$query.="offset {$pagination->offset()}";
	$result=photograph::get_result_of_query($query);
	foreach ($result as $key => $photo) {?>
	     <div style="float: left; margin-left: 20px;">
		<a href="photo.php?id=<?php echo $photo->id?>"><img src="<?php echo $photo->public_img_path."/".$photo->filename?>" style="padding-top: 15px; padding-left: 15px; padding-right: 15px;" width=250 height=150 ></a>
		<br>
		<center><p style="font-size: 15px; font-family: Comic Sans MS;"><?php echo $photo->caption; ?></p></center>
		
</div>
		
	<?php }?>

<center>
	<b>
<div id="pagination" style="clear:both; position: center;"><br>
     <br>
	<br>
	<br>
		<?php
		if($pagination->total_count_pages()>1)
		{
		if($pagination->has_previous_page())
		{?>
			<a class="page" href="index.php?pageno=<?php echo $pagination->previous_page()?>">&laquo; PREVIOUS</a>
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
                <a class="page" href="index.php?pageno=<?php echo $i?>"><?php echo $i ?></a>
                &nbsp;
        	<?php }
        }

		if($pagination->has_next_page())
		{?>
			<a class="page" href="index.php?pageno=<?php echo $pagination->next_page()?>">NEXT &raquo;</a>
			<?php }}?>
	</div>
		</center>
</b>
</div>
		
    <?php require_once("layout/footer.php");?>