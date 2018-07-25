<?php
require_once("../../includes/database.php");
require_once("../../includes/user.php");
require_once("../../includes/session.php");
require_once("../../includes/function.php");

require_once("../layout/admin_header.php");
?>

		<!-- <h2>Menu</h2>
		<a href="logfile.php">view log file</a>
		<p>
		<a href="list_photos.php">
		LIST ALL PICS</a></p> -->
		<div id="page">
        <h2>WELCOME TO ADMIN AREA</h2>
        <table cellpadding="30em">
          <tr>
            <td>
              <a href="logfile.php"><img src="log.jpg" height="150em" width="150em"></a>
              <p>
              <a href="logfile.php"><b><center>VIEW LOG FILE</center></b></a></p>
            </td>
            <td>
              <a href="list_photos.php"><img src="all_pic.jpg" height="150em" width="150em"></a>
              <p>
              <a href="list_photos.php"><b><center>LIST ALL PHOTOS</center></b></a></p>
            </td>
            <td>
              <a href="logout.php?logout=1"><img src="logout.jpg" height="150em" width="150em"></a>
              <p>
              <a href="logout.php?logout=1"><b><center>LOGOUT</center></b></a></p>
            </td>
          </tr>
          
        </table>


      </div>

		</div>
		
        <?php require_once("../layout/footer.php");?>