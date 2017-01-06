<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
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
           <?php
			$result = mysql_query("SELECT * FROM `notes` ORDER BY Date");
			$count=mysql_num_rows($result);
			if($count>0)
			{
				Print "<center><form name=\"notes\" method=\"POST\" action=\"".$_SERVER['PHP_SELF']."\">"; 
				Print "<label>Stored Information in database</label>";
				Print "<div style=\"width: 900px; height: 500px; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table border=\"0\" cellpadding=\"3\" width=\"700\"  align=\"center\" class=\"tab\"  bgcolor=\"#dbdedf\">";
				Print "<th>Select</th><th>S.No</th><th>Date</th><th>Message</th>";
				Print "<tbody>";
				$c=1;
				$r=1;
				while($row=mysql_fetch_array($result))
				{	
					Print "<tr class=\"tr".$c."\" align=\"center\" >";
					Print "<td align=\"center\" ><input type=\"checkbox\" name=\"notice[]\" value=\"".htmlentities($row['S.No'])."\" onclick=\"confirmifo();\"></td> ";
					Print "<td>".$r . "</td> ";
					Print "<td>".$row['Date'] . "</td> ";
					Print "<td>".$row['Note'] . "</td> ";
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
				Print "</div></form>";
				Print "<script type=\"text/javascript\" language=\"javascript\">
						function confirmifo()
						{
							if (confirm('Are you sure ? You want to delete this Information	?'))
							{
								notes.submit();
							}
							else
							{
								return false;
							}
						}
						</script>";
			}
			else
			{
				echo "<br /><br /><br /><br /><br /><h1><center>Sorry No record found !!!</center></h1><br /><br /><br /><br /><br /><br />";
			}
				
			$result = mysql_query("SELECT * FROM `quotes`");
			$count=mysql_num_rows($result);
			if($count>0)
			{
				$a=1;
				Print "<center><form name=\"quotes\" method=\"POST\" action=\"".$_SERVER['PHP_SELF']."\">"; 
				Print "<label>Stored Quotes in database</label>";
				Print "<div style=\"width: 900px; height: 500px; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table border=\"0\" cellpadding=\"3\" width=\"700\"  align=\"center\" class=\"tab\"  bgcolor=\"#dbdedf\">";
				Print "<th>Select</th><th>S.No</th><th>Quotes</th><th>Said By</th>";
				Print "<tbody>";
				$c=1;
				while($row=mysql_fetch_array($result))
				{	
					Print "<tr class=\"tr".$c."\" align=\"center\" >";
					Print "<td align=\"center\" ><input type=\"checkbox\" name=\"quotes[]\" value=\"".htmlentities($row['S.No'])."\" onclick=\"confirmquotes();\"></td> ";
					Print "<td>".$a . "</td> ";
					Print "<td>".$row['Quotes'] . "</td> ";
					Print "<td>".$row['By'] . "</td> ";
					Print "</tr>";
					if($c==1)
					{
						$c=0;
					}
					else
					{
						$c=1;
					}
					$a=$a+1;
				}
				Print "</tbody>";
				Print "</table>";
				Print "</div></form>";
				Print "<script type=\"text/javascript\" language=\"javascript\">
						function confirmquotes()
						{
							if (confirm('Are you sure ? You want to delete this Quotes ?'))
							{
								quotes.submit();
							}
							else
							{
								return false;
							}
						}
						</script>";
				
			}
			else
			{
				echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
			}
			if(!(isset($_POST['quotes']))=="0")
			{		
			$myArray=$_POST['quotes'];
				foreach($myArray as $key => $value)
				{	$value=mysql_real_escape_string($value);	
					$del=mysql_query("DELETE FROM `quotes` WHERE `S.No`='$value'");
					if($del)
					{
						echo "<script> alert('Quotes deleted successfully !!!');</script>";
						echo "<script> setTimeout(function(){ window.location = \"viewchat.php\";}, 0);</script>";
					}
					else
					{
						echo "<script> alert('Please choose the data !!!');</script>";
					}
				}
			}
			if(!(isset($_POST['notice']))=="0")
			{		
			$myArray=$_POST['notice'];
				foreach($myArray as $key => $value)
				{	$value=mysql_real_escape_string($value);	
					$del=mysql_query("DELETE FROM `notes` WHERE `S.No`='$value'");
					if($del)
					{
						echo "<script> alert('Information deleted successfully !!!');</script>";
						echo "<script> setTimeout(function(){ window.location = \"viewchat.php\";}, 0);</script>";
					}
					else
					{
						echo "<script> alert('Please choose the data !!!');</script>";
					}
				}
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
