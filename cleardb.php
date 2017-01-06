<?php
session_start();
require_once('calendar/classes/tc_calendar.php');
if(!isset($_SESSION['CODE']))
{ 
header("location:index.php"); 
}
else 
header( 'Content-Type: text/html; charset=utf-8' );
include('dbconfig.php');
include('include_dir.php');
include('global.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>B2k Medical Transcription</title>
<meta name="keywords" content="B2k Medical Transcription Linecount" />
<meta name="description" content="B2k Medical Transcription Linecount" />
<link rel="shortcut icon" href="images/shortcut.png" size="32*32" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="calendar/calendar.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.js" language="javascript"></script>
<script type="text/javascript" src="js/copy.js"></script>
<script type="text/javascript" src="js/RCPCode.js"></script>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(document.getElementById('searchfield1').value==='-1')
	{
		alert('Please select a table to Clear');
		return false;
	}
	thisform.submit();
}


</script>

</head>
<body> 

          <center>
          <table width="600">
          <tr align="center">
            <td>
            <div id="search_drop">
          		<center>
                <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <select name="searchfield1" id="searchfield1" >
                    <option selected="selected" value="-1">--Select Table--</option>
                    <?php 
					$showtablequery = "SHOW TABLES FROM `b2k_database`";
 					$showtablequery_result	= mysql_query($showtablequery);
					$count=mysql_num_rows($showtablequery_result);
					$i=0;
					while($showtablerow = mysql_fetch_array($showtablequery_result))
					{
						echo '<option value="'.htmlentities($showtablerow[0]).'">'.htmlentities($showtablerow[0]).'</option>';
					}
					?>
                    </select>
                  	<input type="button" name="Searchdes" width="" value="CLEAR" alt="Search" id="Searchdes" title="Clear Table" onClick="check(this.form)" />
                </form>
                	
                </center>
            </div>
            </td>
            </tr>
            </table>
            <br>
			<br>
			<br>
	        <div id="alert">
                Please do not touch the following tables,<br>
                1.admin<br>
                2.file_detaisls<br>
                3.shared_files<br>
                4.audit_files<br>
                5.attendance<br>
                6.client<br>
                7.vendor<br>
                8.designation<br>
                9.employee<br>
                10.id_details<br>
                11.hospitals<br>
                12.platforms<br>
            </div>
            </center>
            <br /><br />
          <?php
		  	$r=1;
			if(isset($_POST['searchfield1']))
			{
				$des=mysql_real_escape_string($_POST['searchfield1']);
				if($des!='admin' && $des!='client' && $des!='designation' && $des!='employee'  && $des!='file_details' && $des!=' file_status' && $des!='hospitals' && $des!='id_details' && $des!=' jobnature' && $des!='main_balance' && $des!='platform' && $des!='shared_files' && $des!='training' && $des!='vendor' && $des!='attendance'  )
				{
					$result=mysql_query("TRUNCATE `$des`");
					if($result)
					{
						echo "<script> alert('Table Cleared Successfully'); </script>";
					}
				}
				else
				{
					echo "<script> alert('Access Denied ! ! !'); </script>";
				}
				
			}
			mysql_close($con);			
			?>  
</body>
<script src="js/element.js"></script>
</html>
