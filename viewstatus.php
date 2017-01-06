<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}

function highlight_row(the_element, checkedcolor) {
if(the_element.parentNode.parentNode.style.backgroundColor != checkedcolor) {
the_element.parentNode.parentNode.style.backgroundColor = checkedcolor;
} 
else {
the_element.parentNode.parentNode.style.backgroundColor = '';
}
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
          		<form name="show" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <center><table><tr><td>Choose the Date</td><td><?php
                  $myCalendar = new tc_calendar("date5", true, false);
                  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
                  $myCalendar->setDate(date('d'), date('m'), date('Y'));
                  $myCalendar->setPath("calendar/");
                  $myCalendar->setYearInterval(2012, 2030);
                  $myCalendar->dateAllow('2012-01-01', '2030-12-31');
                  $myCalendar->setDateFormat('j F Y');
                  $myCalendar->autoSubmit(true, "show");
                  $myCalendar->setAlignment('left', 'bottom');
                  $myCalendar->writeScript();
                  ?></td></tr></table></center><br>
				</form>            
			<?php
			if(isset($_POST['date5']))
			{
				$date=$_POST['date5'];
				$result = mysql_query("select * from `file_status` WHERE `Date`='$date'");
			}
			else
			{
				$date=date('Y-m-d');
				$result = mysql_query("select * from `file_status` WHERE `Date`='$date'");
			}
			$count=mysql_num_rows($result);
			if($count>0)
			{
				Print "<center><form name=\"contact\" method=\"post\" action=\"#\">"; 
				Print "<div style=\"width: 900px; height: 500px; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table border=\"0\" cellpadding=\"3\" width=\"700\"  align=\"center\" class=\"tab\"  bgcolor=\"#dbdedf\">";
				Print "<th>S.No</th><th>Date</th><th>Client</th><th>Opening Count</th><th>Client Jobs</th><th>B2K Jobs</th>";
				Print "<tbody>";
				$c=1;
				$r=1;
				while($row=mysql_fetch_array($result))
				{	
					Print "<tr class=\"tr".$c."\" align=\"center\" >";
					Print "<td>".$r . "</td> ";
					Print "<td>".$row['Date'] . "</td> ";
					Print "<td>".$row['Client'] . "</td> ";
					Print "<td> ".$row['Open'] . " </td>";
					Print "<td> ".$row['Close'] . " </td>";
					Print "<td> ".$row['B2k_status'] . " </td>";
					Print "</tr>";
					if($c==1)
					{
						$c=0;
					}
					else
					{
						$c=1;
					}
					$r=$r+1;
				}
				Print "</tbody>";
				Print "</table>";
				Print "</div>";
				
			}
			else
			{
				echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
			}
			?>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>
