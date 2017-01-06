<?php include('top.php');?>
</head>
<body onLoad="hide()"> 
<div id="outer_wrapper">
  <div id="wrapper">
   <?php 
	include('main_top.php');
	?>
          <div id="main"><br>
          	<?php
			Print "<form name=\"empatt\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\" method=\"post\">";
			?>
          	<table><tr><td>Choose Date : </td><td><?php
                  $myCalendar = new tc_calendar("date5", true, false);
                  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
                  $myCalendar->setDate(date('d'), date('m'), date('Y'));
                  $myCalendar->setPath("calendar/");
                  $myCalendar->setYearInterval(2012, 2030);
                  $myCalendar->dateAllow('2012-01-01', '2030-12-31');
                  $myCalendar->setDateFormat('j F Y');
                  //$myCalendar->autoSubmit(true, "form1");
                  $myCalendar->setAlignment('left', 'bottom');
                  $myCalendar->writeScript();
                  ?></td></tr></table><br><br>
          	<?php
				$a=1;
				$sql=mysql_query("select * from `hospitals` order by `No`");
				Print "<center><div style=\"width: 720px; height:550px; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table border=\"1\" width=\"700\" cellpadding=\"10\" >";
				$c=1;
				Print"<th>S.No</th><th>Hospital Name</th><th>No. of files</th>";
				while($row=mysql_fetch_array($sql))
				{
					Print "<tr align=\"center\">";
					Print"<td width=\"20px\">".$c."</td>";
					Print"<td align=\"left\">&nbsp;&nbsp;<b>".htmlentities($row['Hospital_name'])."</b> (".htmlentities($row['Client'])."--".htmlentities($row['Platform']).")</td>";
					Print"<td><input type=\"text\" name=\"hos_".htmlentities($row['Hospital_name'])."\" id=\"hos_".htmlentities($row['Hospital_name'])."\" title=\"hos_".htmlentities($row['Hospital_name'])."\" /></td>";
					$c=$c+1;
					if($a==1)
					{
						$a=0;
					}
					else
					{
						$a=1;
					}
				}
				Print "</table>";
				Print "</div>";
				Print "<table width=\"700\">";
				Print "<tr align=\"center\"><td><input type=\"submit\" value=\"Submit\" name=\"sub\" onclick=\"save()\" /></td><td><input type=\"reset\" value=\"Reset\" name=\"res\" /></td></tr>";
				Print "</table></center>";
				Print "</form>";
            ?>
          </div> <!-- end of main -->
    <div id="main_bottom"></div>
    <?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php
if(!empty($_POST['sub']))
{
	include('dbconfig.php');
	$query=mysql_query("select * from `hospitals` order by `No`");
	while($row=mysql_fetch_array($query))
	{
		$date=mysql_real_escape_string($_POST['date5']);
		$hos=mysql_real_escape_string($row['Hospital_name']);
		$files=mysql_real_escape_string($_POST['hos_'.$row['Hospital_name']]);
		$b2k=0;
		$check=mysql_query("SELECT * from `file_status` WHERE `Date`='$date' AND `Client`='$hos'");
		$count=mysql_num_rows($check);
		if($count==0)
		{
			$sql=mysql_query("INSERT INTO `file_status` VALUES ('NULL','$date','$hos','$files','$files','$b2k')");
		}
		else
		{
			echo "<script> alert('Entry Already added'); </script>";
		}
		
	}
}
mysql_close($con);
?>
</body>
<script src="js/element.js"></script>
</html>
