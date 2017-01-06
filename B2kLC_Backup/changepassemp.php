<?php
session_start();
if(isset($_SESSION['MLS']))
{ 
	header( 'Content-Type: text/html; charset=utf-8' );
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
	$chnge_name=$_SESSION['MLS'];
}
elseif(isset($_SESSION['EDITOR']))
{ 
	header( 'Content-Type: text/html; charset=utf-8' );
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
	$chnge_name=$_SESSION['EDITOR'];
}
elseif(isset($_SESSION['ES-MLS']))
{ 
	header( 'Content-Type: text/html; charset=utf-8' );
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
	$chnge_name=$_SESSION['ES-MLS'];
}
elseif(isset($_SESSION['ES-EDITOR']))
{ 
	header( 'Content-Type: text/html; charset=utf-8' );
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
	$chnge_name=$_SESSION['ES-EDITOR'];
}
else
{ 
	header("location:index.php?msg4=NotAllowed");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>B2k Medical Transcription</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="shortcut icon" href="images/shortcut.png" size="32*32" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/fisheye.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="css/menu.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="codebase/themes/message_growl_dark.css">
<link rel="stylesheet" href="js/jquery/themes/redmond/jquery-ui-1.10.1.custom.css"/>
<script type="text/javascript">
function check(thisform)
{
	if(document.getElementById('user').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter a Employee ID"});
		return false;
	}
	if(document.getElementById('c_pass').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter your Current password"});
		return false;
	}
	if(document.getElementById('n_pass').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter a new password"});
		return false;
	}
	if(document.getElementById('n_pass').value.length<8)
	{
		dhtmlx.alert({title:"Warning!!!", text:"Password must be atleast 8 Characters"});
		return false;
	}
	thisform.submit(thisform);
}
</script>
<style>
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }
</style>
</head>
<body> 

<div id="outer_wrapper">

  <div id="wrapper">
    
   	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
	<h2>Change Password</h2>
                    
          		<center>
                <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      			<table width="500" align="center" cellpadding="2" cellspacing="5" style="padding-left:50px;">
                <tr>
                <td>
                	Username
                </td>
                <td>:</td>
                <td>
                	<input type="text" name="user" id="user" size="28" value="<?php echo $chnge_name;?>" readonly="readonly" class="text ui-widget-content ui-corner-all">
                </td>
                </tr>
                
                <tr>
                <td>
                	Current Password
                </td>
                <td>:</td>
                <td>
                	<input type="password" name="c_pass" id="c_pass" size="28" value="" class="text ui-widget-content ui-corner-all">
                </td>
                </tr>
                
                <tr>
                <td>
                	New Password
                </td>
                <td>:</td>
                <td>
                	<input type="password" name="n_pass" id="n_pass" size="28" value="" class="text ui-widget-content ui-corner-all">
                </td>
                </tr>
                </table>
                

                <table width="500" align="center" cellpadding="2" cellspacing="5" style="padding-left:100px;">
                <tr><td><input type="button" value="Change" name="change" onClick="check(this.form)" ></td><td><input type="reset" value="Reset" name="reset"></td></tr>
                </table>
                </form>
                </center><br /><br />
          
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
    <?php
			if(isset($_POST['user'],$_POST['c_pass'],$_POST['n_pass']))
			{
				$username=mysql_real_escape_string($_POST['user']);
				$old=mysql_real_escape_string($_POST['c_pass']);
				$new=mysql_real_escape_string($_POST['n_pass']);
				//echo $new;
				if($old!=$new)
				{
					$result=mysql_query("UPDATE `employee` SET `Emp_pass`=SHA('$new'),`password`='$new' WHERE `Emp_pass`=SHA('$old') AND `Emp_no`='$username'");
					if($result)
					{
						echo "<script> dhtmlx.alert({title:\"Success !!!\", text:\"Password Changed Successfuly \"});</script>";
						$uploadby=$_SESSION['EMP_NAME_ID'];
						$fp = fopen($log_dir.$uploadby.".txt", "a+");
						$comment=$chnge_name." has Changed Password";
						fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
						fclose($fp);
					}
					else
					{
						echo "<script> dhtmlx.alert({title:\"Error !!!\", text:\"Password didnot Change Please try later \"});</script>";
					}
				}
				else	
				{
					echo "<script> dhtmlx.alert({title:\"Error !!!\", text:\"Old Password and New password are Same \"});</script>";
				}
				
			}
			?>  
  </div> 
	<!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
