<?php include('satop.php');?>
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
    <div id="main" style="height:300px;"><br>
    	<h2>Current Employee Status</h2>
        <table width="900" align="center" border="1" class="tab">
        <?php
		$mls_count=0;
		$editor_count=0;
		$htmls_count=0;
		$htedtr_count=0;
		$upstatus=mysql_query("SELECT `Emp_desig` FROM `employee` WHERE `Log_status`='YES' order by `Emp_no`");
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
        $mlsstatus=mysql_query("SELECT `Emp_name` FROM `employee` WHERE `Emp_desig`='MLS' AND `Log_status`='YES' order by `Emp_no`");
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
        $edtstatus=mysql_query("SELECT `Emp_name` FROM `employee` WHERE `Emp_desig`='EDITOR' AND `Log_status`='YES' order by `Emp_no`");
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
        $htmlsstatus=mysql_query("SELECT `Emp_name` FROM `employee` WHERE `Emp_desig`='HT-MLS' AND `Log_status`='YES' order by `Emp_no`");
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
        $htstatus=mysql_query("SELECT `Emp_name` FROM `employee` WHERE `Emp_desig`='HT-EDITOR' AND `Log_status`='YES' order by `Emp_no`");
		$htcount=mysql_num_rows($htstatus);
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
        </div>
         <div id="main" style="height:450px;"><br>
    	<h2>Non compliant Employees (<?php  echo date("d-m-Y", time() - 60 * 60 * 24);?>)</h2>
        <table width="900" align="center" border="1" class="tab">
        
		<th>Inhouse MLS </th><th>Inhouse Editors</th><th>HT-MLS</th><th>HT-Editors</th>
        <tr align="center">
        <td width="205">
        <div style="width:200px; height:200px; overflow:auto; color:#000000;">
        <?php 
        $mlsstatus=mysql_query("SELECT `Emp_name`,`Emp_No` FROM `employee` WHERE `Emp_desig`='MLS' order by `Emp_no`");
		$mlscount=mysql_num_rows($mlsstatus);
		$mls_cnt=0;
		if($mlscount!=0)
		{	
			while($mlsrow=mysql_fetch_array($mlsstatus))
			{
				$mls_count=0;
				$name=$mlsrow['Emp_name']."-".$mlsrow['Emp_No'];
				$date=date("Y-m-d", time() - 60 * 60 * 24);
				$mls_upload=mysql_query("SELECT `File_No` FROM `file_details` WHERE `Uploadedby`='$name' AND `Date`='$date'");
				$mls_count=mysql_num_rows($mls_upload);
				if($mls_count<5)
				{
					$res=$name." (".$mls_count.")";
					echo htmlentities($res)."<br>";
					$res='';
					$mls_cnt=$mls_cnt+1;
				}
				
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
        <div style="width:200px; height:200px; overflow:auto; color:#000000;">
        <?php 
        $edtstatus=mysql_query("SELECT `Emp_name`,`Emp_No` FROM `employee` WHERE `Emp_desig`='EDITOR' order by `Emp_no`");
		$edtcount=mysql_num_rows($edtstatus);
		$ed_cnt=0;
		if($edtcount!=0)
		{	
			while($edtrow=mysql_fetch_array($edtstatus))
			{
				$ed_count=0;
				$ed_dupcount=0;
				$tot=0;
				$nam=$edtrow['Emp_name'];
				$name=$edtrow['Emp_name']."-".$edtrow['Emp_No'];
				$date=date("Y-m-d", time() - 60 * 60 * 24);
				$ed_upload=mysql_query("SELECT `File_No` FROM `file_details` WHERE `Editedby`='$name' AND `Date`='$date'");
				$ed_count=mysql_num_rows($ed_upload);
				$ed_dupupload=mysql_query("SELECT `File_No` FROM `file_details` WHERE `Uploadedby`='$name' AND `Date`='$date'");
				$ed_dupcount=mysql_num_rows($ed_dupupload);
				$tot=$ed_count+$ed_dupcount;
				if($tot<5)
				{
					$res=$nam." ED(".$ed_count.") / DUP(".$ed_dupcount.")";
					echo htmlentities($res)."<br>";
					$res='';
					$ed_cnt=$ed_cnt+1;
				}
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
        <div style="width:200px; height:200px; overflow:auto; color:#000000;">
        <?php 
        $htmlsstatus=mysql_query("SELECT `Emp_name`,`Emp_No` FROM `employee` WHERE `Emp_desig`='HT-MLS' order by `Emp_no`");
		$htmlscount=mysql_num_rows($htmlsstatus);
		$htmls_cnt=0;
		if($htmlscount!=0)
		{	
			while($htmlsrow=mysql_fetch_array($htmlsstatus))
			{
				$htmls_count=0;
				$name=$htmlsrow['Emp_name']."-".$htmlsrow['Emp_No'];
				$date=date("Y-m-d", time() - 60 * 60 * 24);
				$htmls_upload=mysql_query("SELECT `File_No` FROM `file_details` WHERE `Uploadedby`='$name' AND `Date`='$date'");
				$htmls_count=mysql_num_rows($htmls_upload);
				if($htmls_count<5)
				{
					$res=$name." (".$htmls_count.")";
					echo htmlentities($res)."<br>";
					$res='';
					$htmls_cnt=$htmls_cnt+1;
				}
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
        <div style="width:200px; height:200px; overflow:auto; color:#000000;">
        <?php 
        $htstatus=mysql_query("SELECT `Emp_name`,`Emp_No` FROM `employee` WHERE `Emp_desig`='HT-EDITOR' order by `Emp_no`");
		$htcount=mysql_num_rows($htstatus);
		$hted_cnt=0;
		if($htcount!=0)
		{	
			
			while($htrow=mysql_fetch_array($htstatus))
			{
				$hted_count=0;
				$hted_dupcount=0;
				$tot=0;
				$nam=$htrow['Emp_name'];
				$name=$htrow['Emp_name']."-".$htrow['Emp_No'];
				$date=date("Y-m-d", time() - 60 * 60 * 24);
				$hted_upload=mysql_query("SELECT `File_No` FROM `file_details` WHERE `Editedby`='$name' AND `Date`='$date'");
				$hted_count=mysql_num_rows($hted_upload);
				$hted_dupupload=mysql_query("SELECT `File_No` FROM `file_details` WHERE `Uploadedby`='$name' AND `Date`='$date'");
				$hted_dupcount=mysql_num_rows($hted_dupupload);
				$tot=$hted_count+$hted_dupcount;
				if($tot<5)
				{
					$res=$nam." ED(".$hted_count.") / DUP(".$hted_dupcount.")";
					echo htmlentities($res)."<br>";
					$res='';
					$hted_cnt=$hted_cnt+1;
				}
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
        <tr><td><b>Total = <?php echo $mls_cnt;?></b></td><td><b>Total = <?php echo $ed_cnt;?></b></td><td><b>Total = <?php echo $htmls_cnt;?></b></td><td><b>Total = <?php echo $hted_cnt;?></b></td></tr>
        </table>
        </div>
        <div class="cleaner"></div>
        <div class="cleaner"></div>
        </center>
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>