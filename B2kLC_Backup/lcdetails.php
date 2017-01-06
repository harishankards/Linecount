<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
select{ margin-bottom:0px; width:180px; padding: .2em; text-align:left;}
</style>

</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
        <h2>InHouse Linecount Details </h2>
        <form name="sub" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <center><p class="result">Choose the Date to See MLS Line count details</p></center>
        
        <table align="center" width="400" cellpadding="2">
            <tr align="left">
                <td class="bold">From<td>:</td></td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date1'])) { echo $_POST['date1']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/>
                </td>
                <td class="bold">To</td><td>:</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date2'])) { echo $_POST['date2']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/>
                </td> 
                
        	</tr>
           <tr align="center">
                <td colspan="6">
                <input type="submit" value="Search" name="search" id="search" style="height:30px; width:75px;" >
                </td>
            </tr>
        </table>
	</form>
    <br><br>

<?php

if(isset($_POST['date1'],$_POST['date2']))
{
	$final_blank_lines=0;
	$final_edit_lines=0;
	$final_total_lines=0;
	$final_dupblank_lines=0;
	$final_dupedit_lines=0;
	$final_proof_lines=0;
	$final_proof_total=0;
	$final_edt_dup_total=0;
	$s_date=$_POST['date1'];
	$e_date=$_POST['date2'];
	$query="select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='MLS' order by `Emp_no`";
	$e_query="select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='EDITOR' order by `Emp_no`";
	echo "<center><label class=\"result1\"> Line Count details from $s_date to $e_date</label></center>";
	$a=1;
	$col=1;
	//For MLS
	echo" <h2>InHouse MLS Linecount </h2>";
	echo "<div style=\"width:900px; height: auto; border: 0px groove #3b3a3a; overflow: auto;\">";
	echo "<table class=\"text ui-widget-content ui-corner-all tab\" width=\"900\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\">";
	echo "<th>S.No.</th><th>Name</th><th>Blank</th><th>Edit</th><th>DUP Blank</th><th>Dup Edit</th><th>Total LineCount</th><th>Proofing</th><th>Proofing / DUP</th><th>Proofing Total</th><th>Final Total</th><th>Double pay </th>";
	$sql=mysql_query($query);
	while($row1=mysql_fetch_array($sql))
	{
		$no=$row1['Emp_no'];
		$e_name=$row1['Emp_name'];
		$name=$e_name."-".$no;
		$no=mysql_real_escape_string($no);
		$name=mysql_real_escape_string($name);
		$final_mls_total=0;
		$final_mls_p_total=0;
		$final_mls_f_total=0;
		
		$flag=0;
		if($flag==0)
		{
			$doublepay=0;
			$mls_query=mysql_query("SELECT `Double_pay` FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$no'");
			$mls_count=mysql_num_rows($mls_query);
			if($mls_count!=0)
			{
				while($mlsrow=mysql_fetch_array($mls_query))
				{	
					if($mlsrow['Double_pay']=="YES")
					{
						$doublepay=$doublepay+1;
						$flag=1;
					}
				}
			}
		}
		$cl_query="SELECT `Client_name` FROM `client`";
		
		$cl_result=mysql_query($cl_query);
		
		$cl_count=mysql_num_rows($cl_result);
		
		if($cl_count!=0)
		{
			while($clrow=mysql_fetch_array($cl_result))
			{				
				$cl_name=mysql_real_escape_string($clrow['Client_name']);
				$blanklines=0;
				$editlines=0;
				$dup_blank=0;
				$dup_edit=0;
				$prooflines=0;
				$proofduplines=0;
				$sh_dupb_line=0;
				$sh_dupe_line=0;
				$sh_blank_line=0;
				$sh_edit_line=0;
				$sh_pr_lc=0;
				$sh_pr_duplc=0;
				$total_lc=0;
				//$doublepay=0;
				$up_query="SELECT `Upstatus`,`File_Type`,`Linecount` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name' AND `Client`='$cl_name'";
				
				$up_result=mysql_query($up_query);
				
				$up_count=mysql_num_rows($up_result);
				
				// MLS Uploaded Files
				if($up_count!=0)
				{	
					while($uprow=mysql_fetch_array($up_result))
					{				
							if($uprow['Upstatus']!="No DUP")// IF DUP
							{	
								if($uprow['File_Type']=="Edit")
								{	
									$dup_edit=$dup_edit+$uprow['Linecount'];
								}
								if($uprow['File_Type']=="Blank")
								{	
									$dup_blank=$dup_blank+$uprow['Linecount'];
								}
							}
							else
							{
								if($uprow['File_Type']=="Edit") // IF NO DUP
								{	
									
									$editlines=$editlines+$uprow['Linecount'];
								}
								if($uprow['File_Type']=="Blank")
								{	
									$blanklines=$blanklines+$uprow['Linecount'];
								}
								
							}
							
							//$total_lc=$total_lc+$uprow['Linecount'];
					}
				}
				
				//For Shared Files
				$shared=mysql_query("SELECT `Upstatus`,`File_type`,`Linecount` FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name' AND `Client`='$cl_name'");
				$sh_count=mysql_num_rows($shared);
				if($sh_count!=0)
				{
					while($shrow=mysql_fetch_array($shared))
					{	
							if($shrow['Upstatus']!="No DUP")// IF DUP
							{
								if($shrow['File_type']=="Edit")
								{
									$sh_dupe_line=$sh_dupe_line+$shrow['Linecount'];
								}
								if($shrow['File_type']=="Blank")
								{
									$sh_dupb_line=$sh_dupb_line+$shrow['Linecount'];
								}
							}
							else
							{
								if($shrow['File_type']=="Edit")
								{
									$sh_edit_line=$sh_edit_line+$shrow['Linecount'];
								}
								if($shrow['File_type']=="Blank")
								{
									$sh_blank_line=$sh_blank_line+$shrow['Linecount'];
								}
							}
					}
				}
				
				//For Proofing files
				$pr_query="SELECT `Linecount`,`Upstatus`,`Shared`,`File_No` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Proofed by`='$name' AND `Client`='$cl_name'";
				$pr_result=mysql_query($pr_query);
				$pr_count=mysql_num_rows($pr_result);
				if($pr_count!=0)
				{	
					while($prrow=mysql_fetch_array($pr_result))
					{				
						if($prrow['Upstatus']!="No DUP")
						{	
							if($prrow['Shared']=="YES")
							{
								$f_no=$prrow['File_No'];
								$shared=mysql_query("SELECT `Linecount` FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `File_no`='$f_no' AND `Client`='$cl_name'");
								while($shrow_dup_p=mysql_fetch_array($shared))
								{
									$sh_pr_duplc=$sh_pr_duplc+$shrow_dup_p['Linecount'];
									//echo $sh_pr_duplc;
								}
							}
							else
							{
								$proofduplines=$proofduplines+$prrow['Linecount'];
							}
						}
						else
						{
							if($prrow['Shared']=="YES")
							{
								$f_no=$prrow['File_No'];
								$shared=mysql_query("SELECT `Linecount` FROM `shared_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `File_no`='$f_no' AND `Client`='$cl_name'");
								while($shrow_p=mysql_fetch_array($shared))
								{
									$sh_pr_lc=$sh_pr_lc+$shrow_p['Linecount'];
								}
							}
							else
							{
								$prooflines=$prooflines+$prrow['Linecount'];
							}
						}
					}
				}
				$blanklines=$blanklines+$sh_blank_line;
				$blanklines=round($blanklines,$round_value);
				$editlines=$editlines + $sh_edit_line;
				$editlines=round($editlines,$round_value);
				$dup_blank=$dup_blank + $sh_dupb_line;
				$dup_blank=round($dup_blank,$round_value);
				$dup_edit=$dup_edit + $sh_dupe_line;
				$dup_edit=round($dup_edit,$round_value);
				$total_lc=$blanklines + $editlines+$dup_blank+$dup_edit;
				$total_lc=round($total_lc,$round_value);
				$prooflines=$prooflines + $sh_pr_lc;
				$prooflines=round($prooflines,$round_value);
				$proofduplines=$proofduplines + $sh_pr_duplc;
				$proofduplines=round($proofduplines,$round_value);
				$proof_total=$prooflines + $proofduplines;
				$proof_total=round($proof_total,$round_value);
				$final=$total_lc + $proof_total;
				$final=round($final,$round_value);
				$final_proof_lines=$final_proof_lines + $proof_total;
				$final_dupblank_lines=$final_dupblank_lines + $dup_blank;
				$final_dupedit_lines=$final_dupedit_lines + $dup_edit;
				$final_blank_lines=$final_blank_lines + $blanklines;
				$final_edit_lines=$final_edit_lines + $editlines;
				
				if(($up_count!=0) || ($pr_count!=0) || ($sh_count!=0))
				{
					if($flag==1)
					{
						$double=$doublepay;
						$flag=0;
					}				
					else
					{
						$double='';
					}
					echo "<tr class=\"tr".$col."\"><td>$a</td><td style=\"text-align:left; padding-left:5px;\">$name ($cl_name)</td><td>$blanklines</td><td>$editlines</td><td>$dup_blank</td><td>$dup_edit</td><td>$total_lc</td><td>$prooflines</td><td>$proofduplines</td><td>$proof_total</td><td>$final</td><td>$double</td></tr>";
					$a=$a+1;
					if($col==0)
					{
						$col=1;
					}
					else
					{
						$col=0;
					}
				}
				$final_mls_total=$final_mls_total+$total_lc;
				$final_mls_p_total=$final_mls_p_total+$proof_total;
			}
		}
		$final_mls_f_total=$final_mls_f_total+$final_mls_total+$final_mls_p_total;
		if(($up_count!=0) || ($pr_count!=0) || ($sh_count!=0))
		{
			//print("<tr><td></td> <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td> <td>Total + Proofing </td><td>$final_mls_f_total</td></tr>");
		}
		
	}
	echo "</table><br>";
	//For Editors
	echo "<h2>InHouse Editor</h2>";
	echo "<table class=\"text ui-widget-content ui-corner-all tab\" border=\"1\" align=\"center\" width=\"900\" cellspacing=\"0\" cellpadding=\"0\"> ";
	echo "<th>S.No</th><th>Name</th><th>Second Level Editing</th><th>Third Level Editing </th><th>DUP Lines </th><th> Missing Files </th><th> Auditing </th><th> Total </th><th> Double pay </th>";
	$c=1;
	$col1=0;
	$e_sql=mysql_query($e_query);
	while($erow=mysql_fetch_array($e_sql))
	{
		$no=$erow['Emp_no'];
		$e_name=$erow['Emp_name'];
		$name=$e_name."-".$no;
		$flag=0;
		if($flag==0)
		{
			$doublepay=0;
			$edt_query=mysql_query("SELECT `Double_pay` FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$no'");
			$edt_count=mysql_num_rows($edt_query);
			if($edt_count!=0)
			{
				while($edtrow=mysql_fetch_array($edt_query))
				{	
					if($edtrow['Double_pay']=="YES")
					{
						$doublepay=$doublepay+1;
						$flag=1;
					}
				}
			}
		}
		
		$cl_query="SELECT `Client_name` FROM `client`";
		
		$cl_result=mysql_query($cl_query);
		
		$cl_count=mysql_num_rows($cl_result);
		
		if($cl_count!=0)
		{
			while($clrow=mysql_fetch_array($cl_result))
			{	
							
				$cl_name=$clrow['Client_name'];
				$edtr_lines=0;
				$th_edtr_lines=0;
				$audit_lines=0;
				$missing_lines=0;
				$total_editor_lines=0;
				$edtr_dup_lines=0;	
				//For Edited Lines
				$ed_query=mysql_query("SELECT `Linecount` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Editedby`='$name' AND `Client`='$cl_name'");
				$ed_count=mysql_num_rows($ed_query);
				if($ed_count!=0)
				{
					while($edrow=mysql_fetch_array($ed_query))
					{		
						$edtr_lines=$edtr_lines + $edrow['Linecount'];
					}
					
				}
				
				//For Third Level
				$th_query=mysql_query("SELECT `Linecount` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Third_Editor`='$name' AND `Client`='$cl_name'");
				$th_count=mysql_num_rows($th_query);
				if($th_count!=0)
				{
					while($throw=mysql_fetch_array($th_query))
					{		
						$th_edtr_lines=$th_edtr_lines + $throw['Linecount'];
					}
				}		
				
				//For Missing Files
				$mis_query=mysql_query("SELECT `Linecount` FROM `missing_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Edit_by`='$name' AND `Client`='$cl_name'");
				$mis_count=mysql_num_rows($mis_query);
				if($mis_count!=0)
				{
					while($mis_row=mysql_fetch_array($mis_query))
					{		
						$missing_lines=$missing_lines + $mis_row['Linecount'];
					}
				}	
				
				//For Auditing Files
				$au_query=mysql_query("SELECT `Linecount` FROM `audit_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Audit_by`='$name' AND `Client`='$cl_name'");
				$au_count=mysql_num_rows($au_query);
				if($au_count!=0)
				{
					while($aurow=mysql_fetch_array($au_query))
					{		
						$audit_lines=$audit_lines + $aurow['Linecount'];
					}
				}	
				
				
				//For DUP Lines
				$dup_query=mysql_query("SELECT `Linecount` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$name' AND `Client`='$cl_name'");
				$dup_count=mysql_num_rows($dup_query);
				if($dup_count!=0)
				{
					while($duprow=mysql_fetch_array($dup_query))
					{		
						$edtr_dup_lines=$edtr_dup_lines + $duprow['Linecount'];
					}
					
				}	
				$final_edt_dup_total=$final_edt_dup_total+$edtr_dup_lines;
				//final total
				$total_editor_lines=$edtr_lines+$missing_lines+$audit_lines+$th_edtr_lines + $edtr_dup_lines;
				
				if(($ed_count!=0) || ($th_count!=0) || ($au_count!=0) || ($dup_count!=0))	
				{
					if($flag==1)
					{
						$double=$doublepay;
						$flag=0;
					}				
					else
					{
						$double='';
					}
					print("<tr class=\"tr".$col1."\"><td>$c</td><td style=\"text-align:left; padding-left:5px;\"> $name ($cl_name) </td><td>$edtr_lines </td><td> $th_edtr_lines </td><td> $edtr_dup_lines </td><td> $missing_lines </td><td> $audit_lines </td><td> $total_editor_lines </td><td> $double</td></tr>");
					$c=$c+1;
					if($col1==0)
					{
						$col1=1;
					}
					else
					{
						$col1=0;
					}
				}			
			}
		}
		
	}
	echo "</table></div><br>";
		
	$final_total_lines=$final_blank_lines+$final_edit_lines+$final_dupblank_lines+$final_dupedit_lines+$final_edt_dup_total;
	$final_proof_total=$final_total_lines+$final_proof_lines;
	echo "<h2>Over all</h2>";
	echo "<table border=\"1\" class=\"text ui-widget-content ui-corner-all tab\" width=\"500\" align=\"center\" cellspacing=\"0\" cellpadding=\"0\">";
	echo "<th>Particulars</th><th>Linecount</th>";
	echo "<tr class=\"tr0\"><td style=\"text-align:left; padding-left:5px;\">Total No. of DUP Blank lines </td><td> $final_dupblank_lines</td></tr>";
	echo "<tr class=\"tr1\"><td style=\"text-align:left; padding-left:5px;\">Total No. of DUP Edit lines </td><td> $final_dupedit_lines</td></tr>";
	echo "<tr class=\"tr0\"><td style=\"text-align:left; padding-left:5px;\">Total No. of Blank lines </td><td> $final_blank_lines</td></tr>";
	echo "<tr class=\"tr1\"><td style=\"text-align:left; padding-left:5px;\">Total No. of Edit lines </td><td> $final_edit_lines</td></tr>";
	echo "<tr class=\"tr0\"><td style=\"text-align:left; padding-left:5px;\">Total No. of DUP lines by Editor </td><td> $final_edt_dup_total</td></tr>";
	echo "<tr class=\"tr1\"><td style=\"text-align:left; padding-left:5px;\">Total No. of lines </td><td> $final_total_lines</td></tr>";
	//echo "<tr><td>Total No. of Proofed lines </td><td> $final_proof_lines</td></tr>";
	//echo "<tr><td>Final total + Proofing </td><td> $final_proof_total</td></tr>";
	echo "</table>";
	Print "<table align=\"center\">";
	Print "<tr><td>";
	Print "<center><form name=\"xl\" method=\"post\" action=\"mlsxl-new.php\">";
	Print "<input type=\"hidden\" value=$s_date name=\"start\" id=\"start\" />";
	Print "<input type=\"hidden\" value=$e_date name=\"end\" id=\"end\" />";
	Print "<input type=\"submit\" value=\"Export to Excel\" name=\"inhouse\"/>";
	Print "</form></center></td></tr></table>";
	Print "<table align=\"center\">";
	Print "<tr><td>";
	Print "<center><form name=\"xl\" method=\"post\" action=\"periodicreport.php\">";
	Print "<input type=\"hidden\" value=$s_date name=\"start\" id=\"start\" />";
	Print "<input type=\"hidden\" value=$e_date name=\"end\" id=\"end\" />";
	Print "<input type=\"submit\" value=\"Get Report\" name=\"inhouse\"/>";
	Print "</form></center></td></tr></table>";
}
mysql_close($con);
?>
        <br />
        <br />
        <br />
        <br />
        <br />
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>