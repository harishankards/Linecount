<?php
session_start();
if(isset($_SESSION['Admin']))
{ 
	$chatname=$_SESSION['Admin'];
	$loginas=$chatname;
	$token=$_SESSION['token'];
	$key=md5($loginas."_B2K");
}
elseif(isset($_SESSION['MLS']))
{ 
	$chatname=$_SESSION['MLS'];
	$loginas=$chatname;
	$token=$_SESSION['token'];
	$key=md5($loginas."_B2KIDSIL");
}
elseif(isset($_SESSION['EDITOR']))
{ 
	$chatname=$_SESSION['EDITOR'];
	$loginas=$chatname;
	$token=$_SESSION['token'];
	$key=md5($loginas."_B2KIDSIL");
}
elseif(isset($_SESSION['ES-MLS']))
{ 
	$chatname=$_SESSION['ES-MLS'];
	$loginas=$chatname;
	$token=$_SESSION['token'];
	$key=md5($loginas."_B2KES");
}
elseif(isset($_SESSION['ES-EDITOR']))
{ 
	$chatname=$_SESSION['ES-EDITOR'];
	$loginas=$chatname;
	$token=$_SESSION['token'];
	$key=md5($loginas."_B2KES");
}

if($token==$key)
{ 
	header( 'Content-Type: text/html; charset=utf-8' );
	include('include_dir.php');
	include('dbconfig.php');
	include('global.php'); 
}
else
{ 
	header("location:index.php"); 
}
$_SESSION['username']=$chatname;


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
<link rel="stylesheet" href="js/jquery/themes/redmond/jquery-ui.css" />
<script src="js/jquery-1.3.1.min.js" language="javascript"></script>
<script src="js/menu.js" language="javascript"></script>
<script src="js/jquery/jquery-1.8.3.js"></script>
<script src="js/jquery/jquery.bgiframe-2.1.2.js"></script>
<script src="js/jquery/jquery-ui.js"></script>
<script src="js/jquery/globaljq.js"></script>
<script src="js/jquery/textualizer.js"></script>
<script type="text/javascript" src='codebase/message.js'></script>
<script src="js/custom.js" type="text/javascript"></script>
<script type="text/javascript" src="js/ddimgtooltip.js"></script>
<script type="text/javascript">
function checkdes(thisform)
{
	if(thisform.searchfield1.value==="-1")
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Choose a Account"});
      return false;
    }
	thisform.submit();
	show();
}
</script>
</head>
<body> 

<div id="outer_wrapper">

  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
    <h2>Select the Account Name to see the details</h2>
    <div id="search_drop" style="margin-left:315px;">
    <center>
    
        <form name="account" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <select name="searchfield1" id="searchfield1" >
            <option selected="selected" value="-1">--Select Account--</option>
            <?php
            $sql=mysql_query("SELECT * FROM `acc_info` order by `Account_Name` ");
            while($row=mysql_fetch_array($sql))
            {
            $hsp=$row['Account_Name'];
            echo '<option value="'.htmlentities($hsp).'">'.htmlentities($hsp).'</option>';
            }
            ?>
            </select>&nbsp;&nbsp;
            <input type="button" name="Searchdes" value="Search" alt="Search" id="Searchdes" title="Search" onclick="checkdes(this.form);"  />
        </form>
    </center>
    </div>
    
    <?php
	if(isset($_POST['searchfield1']))
	{
		echo "<br><br><br><br><br><br>";
		$acc=$_POST['searchfield1'];
		$main_query=mysql_query("SELECT * FROM `acc_info` WHERE `Account_Name`='$acc' order by `Account_Name`");
		$count=mysql_num_rows($main_query);
		if($count!=0)
		{
			$no=mysql_num_fields($main_query);
			echo "<h4><center>General Instructions / Informattions of Account \"&nbsp;".$acc."&nbsp;\"</center></h4>";
			echo "<table align=\"center\" width=\"600\" border=\"0\" bordercolor=\"000\" cellpadding=\"15\" style=\"padding-left:0px\">";
			while($vnrow=mysql_fetch_array($main_query))
			{
				for($i=1;$i<$no;$i++)
				{
				$col=mysql_field_name($main_query,$i);
				echo "<tr><td class=\"tdleft\">".$col."</td><td class=\"tdmid\">:</td><td class=\"tdright\">".$vnrow[$i]."</td></tr>";
				} 
			}
			echo "</table>";
		}
		else
		{
			echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
		}
	}		
	?>
	<br>
    <br>
    <br>
    <br>
    <br>
    <br>
   
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
</body>
</html>
