<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>B2k Medical Transcription</title>
<meta name="keywords" content="B2klinecount, B2k Medical Transcription , Erode" />
<meta name="description" content="B2klinecount, B2k Medical Transcription, Erode" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/shortcut.png" size="32*32" />
<link rel="stylesheet" type="text/css" href="codebase/themes/message_growl_dark.css">
<link rel="stylesheet" href="js/jquery/themes/redmond/jquery-ui-1.10.1.custom.css"/>
<style>
input.text{ margin-bottom:0px; width:150px; padding: .2em; text-align:left; background:#edf3fb; }
select, option{ margin-bottom:0px; width:155px; padding: .2em; text-align:left; background:#edf3fb;}
input.button1 { margin-bottom:0px; width:75px; padding: .2em; text-align:center; cursor:pointer;  }
#username{text-transform:uppercase;}
body { font-size:13px;}
</style>
</head>
<body>
<?php include_once("analyticstracking.php") ?>
<div id="outer_wrapper">
  <div id="wrapper">
    <div id="header">
        <div id="site_title">
            <center>
                <img src="images/b2ktitle.png" class="magnify"  alt="B2k Medical Transcription" height="116" width="250" />
            </center>
        </div> <!-- end of site_title -->
    </div> <!-- end of header -->
    <div id="banner">
        <div class="cleaner"></div>
    </div>
    <div id="menu01" style="margin-top:-15px;">
           <ul>
                <p style="font: bold 25px Arial, Helvetica, sans-serif; text-align:center; color:#FFF;">Medical Transcription Center</p>
          </ul>    	
    </div> <!-- end of menu -->
    <div id="main_top"></div>
    	  <?php 
		  $undercons=0;
		  if($undercons==1)
		  {
		  ?>
          <div id="main">
			<center><img src="images/website_under_construction.jpg" height="333" width="490" /></center>
            <br />
          </div>
          <?
		  }
		  else
          {
		  ?>
          <div id="main" style="height:230px; ">
                <form action="check_login.php" method="post">
                        <table  cellpadding="2"  width="300" cellspacing="2" align="center">
                        <tr>
                        <td >Client</td>
                        <td>:</td>
                        <td>
                        <select name="client" id="client" class="text ui-widget-content ui-corner-all">
                             <?php 
							 if(isSet($_COOKIE['cook_client'])) 
							 { 
							 	$dec_client = base64_decode ($_COOKIE['cook_client']);
							 	echo "<option selected=\"selected\" value=\"".$dec_client."\">".$dec_client."</option>"; 
							 }
							 else
							 { 
							    echo "<option selected=\"selected\" value=\"-1\">--Choose--</option>"; 
							 }
							 ?>
                            <option value="Escription">E-Scription</option>
                            <option value="IDSIL">IDSIL / PJO</option>
                        </select>
                        </td>
                        </tr>
                        <tr>
                        <td >Login as</td>
                        <td>:</td>
                        <td>
                        <select name="log_as" id="log_as" class="text ui-widget-content ui-corner-all">
                            <?php 
							if(isSet($_COOKIE['cook_loginas'])) 
							{ 
								$dec_loginas = base64_decode ($_COOKIE['cook_loginas']);
								echo "<option selected=\"selected\" value=\"".$dec_loginas."\">".$dec_loginas."</option>"; 							} 
							else 
							{ 
								echo "<option selected=\"selected\" value=\"-1\">--Choose--</option>"; 
							}
							?>
                            <option value="Admin">Admin</option>
                            <option value="Vendoradmin">Branch Admin</option>
                            <option value="Superadmin">Super Admin</option>
                            <option value="MT">MLS / MT</option>
                            <option value="QC">Editor / QC</option>
                        </select>
                        </td>
                        </tr>
                        <tr>
                        <td >Username</td>
                        <td>:</td>
                        <td>
                        <input type="text" name="username" id="username" size="16" maxlength="35" onfocus="clearText(this)" onblur="clearText(this)" class="text ui-widget-content ui-corner-all" value="<?php if(isSet($_COOKIE['cook_username'])) { $dec_user = base64_decode ($_COOKIE['cook_username']); echo $dec_user; }?>" />
                        </td>
                        </tr>
                        <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td>
                        <input type="password" name="pass" id="pass" size="16" maxlength="35"  onfocus="clearText(this)" onblur="clearText(this)" class="text ui-widget-content ui-corner-all" value="<?php if(isSet($_COOKIE['cook_password'])) { $dec_pass = base64_decode ($_COOKIE['cook_password']); echo $dec_pass; }?>" />
                        </td>
                        </tr>
                        <tr>
                        <td>Remember Me</td>
                        <td>:</td>
                        <td>
                        <input type="checkbox" name="autologin" value="1">
                        </td>
                        </tr>
                        </table>
                        <table cellpadding="5" cellspacing="10" style="padding-left:40px;" align="center">
                        <tr><td><input type="button" value="Login" name="sub" onclick="check(this.form)" class="button1" /></td><td><input type="reset" value="Reset" name="res" class="button1"/></td></tr>
                        </table>
                </form>
         </div> 
         <?
		 }
		 ?>
<div id="main_bottom">
  <center><p>Please use <strong>Mozilla Firefox or Google Chrome</strong> for better performance. For any clarification <a href="watchvideos/index.php" title="Watch tutorial to train yourself">Watch Tutorial</a></p></center></div>        
<div id="footer">
<center>
       Copyright © 2012 <a href="http://www.b2klinecount.com" target="_blank">B2K Medical Transcription</a><br /><table><tr><td>Developed by</td><td><img src="images/praveen.png" height="31" width="180" /></td></tr></table>
</center>
</div>
</div>	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<script src="js/jquery/jquery-1.8.3.js"></script>
<script src="js/jquery/ui/jquery-ui.custom.js"></script>
<script src="js/browser.js" language="javascript"></script>
<script type="text/javascript" src='codebase/message.js'></script>
<script>
    $(function() {
        $( document ).tooltip({
            track: true
        });
    });
    </script>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
function show()
{
	setTimeout("dhtmlx.message('Authenticating...')", 0);
	setTimeout("dhtmlx.message('Redirecting...')", 1500);
}
</script>
<script type="text/javascript">
function check(thisform)
{
	if(document.getElementById('client').value==='-1')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Client"});
		return false;
	}
	if(document.getElementById('log_as').value==='-1')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Login as"});
		return false;
	}
	
	if(document.getElementById('username').value==='Username')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter your Login Username "});
		return false;
	}
	if(document.getElementById('pass').value==='password')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter your Login password "});
		return false;
	}
	
	thisform.submit();
	show();
	dhtmlx.message("Logging in Please Wait...");	
}
</script>
<?php
if(isset($_GET['msg']))
{
	if($_GET['msg']=="Invalid User")
	{
		echo "<script> dhtmlx.alert({
				title:\"Login Error !!!\",
				ok:\"Ok\",
				text:\"Pleae Enter the valid username and password\"
			});
			</script>";
		//echo "<embed src=\"sounds/popup.wav\" autostart=\"true\" width=\"0\" height=\"0\" id=\"sound1\" enablejavascript=\"true\">";

	}
}
elseif(isset($_GET['msg1']))
{
	if($_GET['msg1']=="Blocked")
	{
		echo "<script> dhtmlx.alert({
				title:\"Warning !!!\",
				ok:\"Ok\",
				text:\"Your ID is blocked, Contact Administrator\"
			});
			</script>";
	}
}
elseif(isset($_GET['msg2']))
{
	if($_GET['msg2']=="loggedout")
	{
		echo "<script> dhtmlx.alert({
				title:\"\",
				ok:\"Ok\",
				text:\"You have successfully logged out\"
			});
			</script>";
	}
}
elseif(isset($_GET['msg3']))
{
	if($_GET['msg3']=="loggedout")
	{
		echo "<script> dhtmlx.alert({
				title:\"Warning !!!\",
				ok:\"Ok\",
				text:\"Your Session Expired please Log in again\"
			});
			
			</script>";
	}
}
elseif(isset($_GET['msg4']))
{
	if($_GET['msg4']=="NotAllowed")
	{
		echo "<script> dhtmlx.alert({
				title:\"Warning !!!\",
				ok:\"Ok\",
				text:\"You must Login to see this Page\"
			});
			
			</script>";
	}
}
elseif(isset($_GET['msg5']))
{
	$msg=$_GET['msg5'];
	if(isset($_SESSION['EMP_NAME_ID']))
	{
		if($msg=="Timeout")
		{
			$user=$_SESSION['EMP_NAME_ID'];
			include('dbconfig.php');
			$up_status="UPDATE `employee` SET `Log_status`='NO' WHERE `Emp_no`='$user'";
			$upstatus=mysqli_query($dbC,$up_status);
		}
	}
	else
	{
		echo "<script> dhtmlx.alert({
				title:\"Warning !!!\",
				ok:\"Ok\",
				text:\"".$msg."\"
			});
			</script>";
	}
}
else
{
	/*echo "<script> dhtmlx.alert({
				title:\"Hello\",
				ok:\"Ok\",
				text:\"Welcome to B2k. Have a nice day\"
			});
			
			</script>";*/
}

?>
<script language="JavaScript">
<!--
if ((screen.width>=1280) && (screen.height>=768))
{
}
else
{
	  dhtmlx.alert({title:"Warning!!!", text:"Please change the screen resolution to \" 1280 * 768 \" or higher for Best Viewing Experience (optional)"});
}
//-->
</script>
<?
session_unset();
session_destroy();
?>
</body>
</html>