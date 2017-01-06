<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
</script>

</head>
<body onLoad="test()"> 

<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>


    <div id="main" style="height:450px;"><br>
    	<h2>Employee Status</h2>
        <table width="900" align="center" border="1" class="tab">
        <?php
		$mls_count=0;
		$editor_count=0;
		$htmls_count=0;
		$htedtr_count=0;
		$upstatus=mysql_query("SELECT * FROM `employee` WHERE `Log_status`='YES' order by `Emp_no`");
		$upcount=mysql_num_rows($upstatus);
		if($upcount!=0)
		{
			while($uprow=mysql_fetch_array($upstatus))
			{
				if($uprow['Emp_desig']=="MLS")
				{
					$mls_count=$mls_count+1;
				}
				if($uprow['Emp_desig']=="EDITOR")
				{
					$editor_count=$editor_count+1;
				}
				if($uprow['Emp_desig']=="HT-MLS")
				{
					$htmls_count=$htmls_count+1;
				}
				if($uprow['Emp_desig']=="HT-EDITOR")
				{
					$htedtr_count=$htedtr_count+1;
				}
			}
		}
		?>
        <th>No. of MLS (<?php echo htmlentities($mls_count);?>)</th><th>No. of Editors (<?php echo htmlentities($editor_count); ?>)</th><th>No. of HT-MLS (<?php echo htmlentities($htmls_count);?>)</th><th>No. of HT-Editors (<?php echo htmlentities($htedtr_count); ?>)</th>
        <tr align="center">
        <td width="205">
        <div style="width:200px; height:100px; overflow:auto; color:#000000;">
        <?php 
        $mlsstatus=mysql_query("SELECT * FROM `employee` WHERE `Emp_desig`='MLS' AND `Log_status`='YES' order by `Emp_no`");
		$mlscount=mysql_num_rows($mlsstatus);
		if($mlscount!=0)
		{	
			while($mlsrow=mysql_fetch_array($mlsstatus))
			{
				echo htmlentities($mlsrow['Emp_name'])."<br>";
			}
		}
		else
		{
			echo " MLS have not logged yet";
		}
		?>
        </div>
        </td>
        <td>
        <div style="width:200px; height:100px; overflow:auto; color:#000000;">
        <?php 
        $edtstatus=mysql_query("SELECT * FROM `employee` WHERE `Emp_desig`='EDITOR' AND `Log_status`='YES' order by `Emp_no`");
		$edtcount=mysql_num_rows($edtstatus);
		if($edtcount!=0)
		{	
			while($edtrow=mysql_fetch_array($edtstatus))
			{
				echo htmlentities($edtrow['Emp_name'])."<br>";
			}
		}
		else
		{
			echo " Editors have not logged yet";
		}
		?>
        </div>
        </td>
        <td>
        <div style="width:200px; height:100px; overflow:auto; color:#000000;">
        <?php 
        $htmlsstatus=mysql_query("SELECT * FROM `employee` WHERE `Emp_desig`='HT-MLS' AND `Log_status`='YES' order by `Emp_no`");
		$htmlscount=mysql_num_rows($htmlsstatus);
		if($htmlscount!=0)
		{	
			while($htmlsrow=mysql_fetch_array($htmlsstatus))
			{
				echo htmlentities($htmlsrow['Emp_name'])."<br>";
			}
		}
		else
		{
			echo " HT-MLS have not logged yet";
		}
		?>
        </div>
        </td>
        <td>
        <div style="width:200px; height:100px; overflow:auto; color:#000000;">
        <?php 
        $htstatus=mysql_query("SELECT * FROM `employee` WHERE `Emp_desig`='HT-EDITOR' AND `Log_status`='YES' order by `Emp_no`");
		$htcount=mysql_num_rows($htstatus);
		/*$no=mysql_num_fields($htstatus);
		for($i=0;$i<$no;$i++)
		{
			echo mysql_field_name($htstatus,$i	);
		}*/
		if($htcount!=0)
		{	
			
			while($htrow=mysql_fetch_array($htstatus))
			{
				echo htmlentities($htrow['Emp_name'])."<br>";
			}
		}
		else
		{
			echo " HT-Editors have not logged yet";
		}
		?>
        </div>
        </td>
        </tr>
        </table>
        <div class="cleaner"></div>
        <div class="cleaner"></div>
        </center>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>
