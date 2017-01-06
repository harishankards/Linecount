<?php include('mlstop.php');?>
</head>
<body> 
<div id="outer_wrapper">

  <div id="wrapper">
    
   <?php 
	include('main_top.php');
	?>
    <div id="main"><br>
			<?php
			
				$date=date('Y-m-d');
				$result = mysql_query("select * from `file_status` WHERE `Date`='$date'");
			$count=mysql_num_rows($result);
			if($count>0)
			{
				
				Print "<center><form name=\"contact\" method=\"post\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\">"; 
				Print "<p><h4>Today file status</h4></p>";
				Print "<div style=\"width: 900px; height: 500px; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table border=\"0\" cellpadding=\"3\" width=\"700\"  align=\"center\" class=\"tab\"  bgcolor=\"#dbdedf\">";
				Print "<th>S.No</th><th>Date</th><th>Client</th><th>Opening Count</th><th>Current Status</th><th>B2k Sataus</th>";
				Print "<tbody>";
				$c=1;
				$r=1;
				while($row=mysql_fetch_array($result))
				{	
					Print "<tr class=\"tr".$c."\" align=\"center\" >";
					Print "<td>".htmlentities($r) . "</td> ";
					Print "<td>".htmlentities($row['Date']) . "</td> ";
					Print "<td>".htmlentities($row['Client']) . "</td> ";
					Print "<td> ".htmlentities($row['Open']) . " </td>";
					Print "<td> ".htmlentities($row['Close']) . " </td>";
					Print "<td> ".htmlentities($row['B2k_status']) . " </td>";
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
			mysql_close($con);
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
