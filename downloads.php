<?php
session_start();
if(isset($_SESSION['Admin']))
{ 
	header( 'Content-Type: text/html; charset=utf-8' );
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
}
elseif(isset($_SESSION['MLS']))
{ 
	header( 'Content-Type: text/html; charset=utf-8' );
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
}
elseif(isset($_SESSION['EDITOR']))
{ 
	header( 'Content-Type: text/html; charset=utf-8' );
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
}
elseif(isset($_SESSION['ES-MLS']))
{ 
	header( 'Content-Type: text/html; charset=utf-8' );
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
}
elseif(isset($_SESSION['ES-EDITOR']))
{ 
	header( 'Content-Type: text/html; charset=utf-8' );
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
}

else
{ 
	header("location:index.php"); 
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
</head>
<body> 

<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main" style="height:450px;"><br>
    	<h2>Download files here</h2>
       <?php
		$upstatus=mysql_query("SELECT * FROM `admin_uploads` order by `Date`");
		$upcount=mysql_num_rows($upstatus);
		$r=0;
		if($upcount!=0)
		{	
				 if ($handle = opendir($admin_dir)) {
				   while (false !== ($file = readdir($handle)))
					  {
						  if ($file != "." && $file != "..")
							{
								//$thelist .= '<a href="'.$file.'">'.$file.'</a>';
								//echo '<a href="'.$admin_local.$file.'">'.$file.'</a><br>';
							}
					   }
				 // closedir($handle);
				  }
			echo "<table border=\"1\" width=\"750\" align=\"center\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\" cellpadding=\"3\" cellspacing=\"0\">";
			echo "<tr class=\"ui-widget-header\"><th>S.No</th><th>Date</th><th>File Name</th><th>File Size</th><th>File Type</th></tr>";
			$a=1;
			while($uprow=mysql_fetch_array($upstatus))
			{
				echo "<tr align=\"center\" class=tr".$r.">";
				echo"<td>".$a."</td>";
				echo"<td>".$uprow['Date']."</td>";
				echo"<td>".$uprow['File_name']."</td>";
				echo"<td>".$uprow['File_size']."</td>";
				echo "<td><a href=\"$admin_local".$uprow['File_name']."\"><img src=\"menu/pick.png\" height=\"20\" width=\"20\" /></a></td>";
				echo "</tr>";
				$a=$a+1;
				if($r==0)
				{
					$r=1;
				}
				else
				{
					$r=0;
				}
			}
			echo "</table>";
			
		}
		else
		{
			echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
		}
		?>
        <div class="cleaner"></div>
        <div class="cleaner"></div>
        </center>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
