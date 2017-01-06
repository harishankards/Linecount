<?php include('dbconfig.php');?>
<h2>Non compliant Employees (<?php  echo date("d-m-Y", time() - 60 * 60 * 24);?>)</h2>
        <table width="800" border="1" align="center" class="ui-widget ui-widget-content ui-corner-all" cellpadding="3" cellspacing="0" style="font-size: 11px;">
		<tr class="ui-widget-header"><th>Inhouse MLS </th><th>Inhouse Editors</th><th>HT-MLS</th><th>HT-Editors</th></tr>
        <tr align="center">
        <td width="205" >
        <div style="width:170px; height:200px; overflow:auto; color:#000000;">
        <?php 
        $mlsstatus=mysql_query("SELECT `Emp_name`,`Emp_No` FROM `employee` WHERE `Emp_desig`='MLS'");
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
        <td >
        <div style="width:170px; height:200px; overflow:auto; color:#000000;">
        <?php 
        $edtstatus=mysql_query("SELECT `Emp_name`,`Emp_No` FROM `employee` WHERE `Emp_desig`='EDITOR'");
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
        <td >
        <div style="width:170px; height:200px; overflow:auto; color:#000000;">
        <?php 
        $htmlsstatus=mysql_query("SELECT `Emp_name`,`Emp_No` FROM `employee` WHERE `Emp_desig`='HT-MLS'");
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
        <td >
        <div style="width:170px; height:200px; overflow:auto; color:#000000;">
        <?php 
        $htstatus=mysql_query("SELECT `Emp_name`,`Emp_No` FROM `employee` WHERE `Emp_desig`='HT-EDITOR'");
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
        <tr><td ><b>Total = <?php echo $mls_cnt;?></b></td><td ><b>Total = <?php echo $ed_cnt;?></b></td><td ><b>Total = <?php echo $htmls_cnt;?></b></td><td ><b>Total = <?php echo $hted_cnt;?></b></td></tr>
        </table>