<?php include('top.php');?>
</head>
<body> 

<div id="outer_wrapper">

  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
    
    <table width="900">
    <tr>
    <td>
    <?php
	$cc=1;
	$cr=0;
	$query="SELECT * FROM `vendor` order by `Vendor_name`";
	$client=mysql_query($query);
	$sendquery=$query;
	echo "<h4><center>Team Details</center></h4>";
	Print "<center><div style=\"width: 900px; height: 400px; border: 0px groove #3b3a3a; overflow: auto;\">";
	echo "<table width=\"900\" border=\"1\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\" cellpadding=\"3\" cellspacing=\"0\">";
	echo "<th align=\"center\" >option</th><th>Team Name</th><th>Address</th><th>Telephone</th><th>Contact Person</th><th>Mobile 01</th><th>Mobile 02</th><th>Mobile 03</th><th>Primary Mail ID</th><th>Secondary Mail ID</th>";
	while($vnrow=mysql_fetch_array($client))
	{
		echo "<tr aling=\"center\" class=\"tr".$cr."\">";
		echo "<td align=\"center\">
				<table width=\"55\"><tr align=\"center\"><td style=\"border:0px;\"><img src=\"menu/notes.png\" title=\"Edit Team details\" height=\"20\" width=\"20\"  style=\"cursor:pointer;\" onclick=\"updatefile('".$vnrow['S.No']."');\"></td></tr></table>
				</td> "; 
		echo "<td width=\"150\">".$vnrow['Vendor_name']."</td>";
		echo "<td width=\"100\">".$vnrow['Address']."</td>";
		echo "<td width=\"170\">".$vnrow['Office_no']."</td>";
		echo "<td>".$vnrow['Contact_person']."</td>";
		echo "<td>".$vnrow['Ph_no_1']."</td>";
		echo "<td>".$vnrow['Ph_no_2']."</td>";
		echo "<td>".$vnrow['Ph_no_3']."</td>";
		echo "<td>".$vnrow['Mail_1']."</td>";
		echo "<td>".$vnrow['Mail_2']."</td>";
		echo "</tr>";
		$cc=$cc+1;
		if($cr==1)
		{
			$cr=0;
		}
		else
		{
			$cr=1;
		}
	}
	echo "</table>";
	Print "</div></center>";
	echo "<br><center><strong>***The output of the Excel is based on your selection Criteria***</strong></center>";
	Print "<br><br><center><form name=\"xl\" method=\"post\" action=\"toexcel.php\">";
	Print "<input type=\"hidden\" Value=\"$sendquery\" name=\"query\" id=\"query\" />";
	Print "<input type=\"hidden\" Value=\"Team Details\" name=\"rep_name\" id=\"name\" />";
	Print "<input type=\"submit\" value=\"Get Team details as Excel\" name=\"Filedetails\"/>";
	Print "</form></center></td></tr></table>";
	echo "<script type=\"text/javascript\" language=\"javascript\">
				function updatefile(sno)
				{
					var fno=sno;
					if (confirm('Are you sure ? You want to update ?'))
					{
						window.location = \"updatevendor.php?sno=\"+fno;
					}
					else
					{
						return false;
					}
				}
			</script>";
	?>
    </td>
    </tr>
    </table>
   
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>
