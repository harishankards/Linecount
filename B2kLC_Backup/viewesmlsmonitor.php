<?php include('monitortop.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
select{ margin-bottom:0px; width:180px; padding: .2em; text-align:left;}
</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
	<?php
    include('header.php');
    if(isset($_SESSION['Vendor_Admin']))
    { 
        include('ak_tecmenu.php');
        $vendor_name=$_SESSION['Vendor_Admin'];
    }
    ?>
<div id="main_top"><center><br><?php echo"<label id=\"welcome_note\">Welcome ".$vendor_name."</label>";?></center></div>
    <div id="main">
        <h2>Escription File Details </h2>
        <div id="file_box">
          		<center>
                <form name="file_ser" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="text" value="Enter a file no to search" name="fileno" size="10" id="searchfield" title="searchfield" onFocus="clearText(this)" onBlur="clearText(this)" />
                  	<input type="submit" name="Searchid" value="Search" alt="Search" id="Searchid" title="Search" onClick="show();" />
                </form>
                </center>
            </div><br>
        <form name="sub" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <center><p class="result1" style="text-align:center; font-size:13px;">Choose the Date to See the uploaded Files</p></center>
        <table align="center" width="950" cellpadding="1" cellspacing="0">
            <tr align="left">
                 <td class="bold">From<td>:</td></td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date1'])) { echo $_POST['date1']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">To</td><td>:</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date2'])) { echo $_POST['date2']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td> 
                <td class="bold"></td>
                 <td></td>
                 <td>
                     
                </td>
        	</tr>
            
        	<tr>
            	<td class="bold">Hospital</td>
                <td>:</td>
                <td>
                    <select name="hos" id="hos" class="text ui-widget-content ui-corner-all">
                   
					<?
					$hos_show='';
					if(isset($_POST['hos']))
					{	
						$hos_show=$_POST['hos'];
						if($hos_show!='-1')
						{
							echo "<option selected=\"selected\" value=\"".$hos_show."\">".$hos_show."</option>";
							echo "<option value=\"-1\">--Show All--</option>";
						}
						else
						{
							echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
						}
					}
					else
					{
						echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
					}
					$sql=mysql_query("select `Hospital_name` from `hospitals` WHERE `Client`='Nuance' order by `Hospital_name` ");
                    while($row=mysql_fetch_array($sql))
                    {
                    $hsp=$row['Hospital_name'];
					if($hsp!=$hos_show)
					{
						echo '<option value="'.$hsp.'">'.$hsp.'</option>';
					}
                    }
                    ?>
                    </select>
                 </td>
                 <td class="bold">MLS Name</td>
                 <td>:</td>
                 <td>
                    <select name="a_id" id="a_id" class="text ui-widget-content ui-corner-all" >
                    <?
					if(isset($_POST['a_id']))
					{	
						$a_id_show=$_POST['a_id'];
						if($a_id_show!='-1')
						{
							echo "<option selected=\"selected\" value=\"$a_id_show\">".$a_id_show."</option>";
							echo "<option value=\"-1\">--Show All--</option>";
						}
						else
						{
							echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
						}
					}
					else
					{
						echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
					}
					$sql=mysql_query("select `Emp_no`,`Emp_name` from `es_employee` WHERE `Emp_desig`='MLS' OR `Emp_desig`='HT-MLS' or `Emp_desig`='EDITOR' or `Emp_desig`='HT-EDITOR' order by `Emp_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $id=$row['Emp_no'];
                    $name=$row['Emp_name'];
                    echo '<option value="'.$id.'">'.$name.'</option>';
                    }
                    ?>
                    </select>
        		</td>
          	  	<td class="bold">File Type</td>
                <td>:</td>
                <td>
                    <select name="type" id="type" class="text ui-widget-content ui-corner-all">
                    <?
					if(isset($_POST['type']))
					{	
						$type_show=$_POST['type'];
						if($type_show!='-1')
						{
							echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
							echo "<option selected=\"selected\" value=".$type_show.">".$type_show."</option>";
							if($type_show=="Trans")
							{	
								echo "<option value=\"Edit\">Edit</option>";
							}
							else
							{
								echo "<option value=\"Trans\">Trans</option>";
							}
						}
						else
						{
							echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
							echo "<option value=\"Trans\">Trans</option>";
							echo "<option value=\"Edit\">Edit</option>";
						}
					}
					else
					{
						echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
						echo "<option value=\"Trans\">Trans</option>";
						echo "<option value=\"Edit\">Edit</option>";
					}
					?>
                    </select>
                 </td>
                
          	</tr>
            <tr>
            	<td class="bold">Client</td>
                <td>:</td>
                <td>
                <select name="client" id="client" class="text ui-widget-content ui-corner-all">
                    <option value="Nuance">Nuance</option>
            	</select></td>
                 <td class="bold">Shift</td>
                 <td>:</td>
                 <td><select name="Shift" id="Shift" class="text ui-widget-content ui-corner-all">
                 	<?
					if(isset($_POST['Shift']))
					{	
						$Shift_show=$_POST['Shift'];
						if($Shift_show!='-1')
						{
							echo "<option selected=\"selected\" value=".$Shift_show.">".$Shift_show."</option>";
							echo "<option value=\"-1\">--Select All--</option>";
						}
						else
						{
							echo "<option selected=\"selected\" value=\"-1\">--Show All--";
						}
					}
					else
					{
						echo "<option selected=\"selected\" value=\"-1\">--Show All--";
					}
					?>
                    <option value="Day">Day</option>
                    <option value="Night">Night</option>
                    </select></td>
                 <td class="bold">Platform ID</td>
                 <td>:</td>
                 <td> <select name="plat_id" id="plat_id" class="text ui-widget-content ui-corner-all">
                    <?
					$plat_id_show='';
					if(isset($_POST['plat_id']))
					{	
						$plat_id_show=$_POST['plat_id'];
						if($plat_id_show!='-1')
						{
							echo "<option selected=\"selected\" value=".$plat_id_show.">".$plat_id_show."</option>";
						}
						else
						{
							echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
						}
					}
					else
					{
						echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
					}
                    $sql=mysql_query("SELECT `User_ID` FROM `escript_id`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $p_id=$row['User_ID'];
					if($plat_id_show!=$p_id)
					{
                    	echo '<option value="'.$p_id.'">'.$p_id.'</option>';
					}
                    }
                    ?>
                    </select>
                    </td>
          	</tr>
            
        </table>    
           
        <table align="center" width="500" cellpadding="5">
            <tr align="center">
                <td>
                <a><input type="submit" name="search"  value="Search" onClick="show()" /></a>
                </td>
            </tr>
        </table>
        
	</form>
<?php
$c=1;
$lc=0;
$r=0;
$editlines=0;
$blanklines=0;
$query='';
$ser='Search Results';
if(isset($_POST['fileno']))
{
	$f_no=mysql_real_escape_string($_POST['fileno']);
	$result=mysql_query("SELECT * FROM `escript_filedetails` WHERE `File_No` LIKE '%$f_no%' AND `Vendor`='$vendor_name'");
	$ser="Search Results for file no contains ".$f_no;
}
elseif(isset($_POST['date1'],$_POST['date2'],$_POST['a_id'],$_POST['hos'],$_POST['type'],$_POST['client'],$_POST['Shift']))
{
	$s_date=mysql_real_escape_string($_POST['date1']);
	$e_date=mysql_real_escape_string($_POST['date2']);
	$shift=mysql_real_escape_string($_POST['Shift']);
	$id=mysql_real_escape_string($_POST['a_id']);
	$hos=mysql_real_escape_string($_POST['hos']);
	$typ=mysql_real_escape_string($_POST['type']);
	$client=mysql_real_escape_string($_POST['client']);
	$vendor=mysql_real_escape_string($_POST['vendor']);
	$platform_id=mysql_real_escape_string($_POST['plat_id']);
	
	if($id!=-1)
	{
		$id=getname($id);
	}
	
	$query="SELECT * FROM `escript_filedetails` FORCE INDEX (`File_No`) WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Vendor`='$vendor_name'";

	if($id!=-1)//if id is set
	{
		$query=$query." AND `MT`='$id'";
		$ser="Search Results for ".$id;
	}
	
	if($hos!=-1)//if hospital is set
	{
		$query=$query." AND `Hospital`='$hos'";
		$ser="Search Results for ".$hos;
	}
	
	if($typ!=-1)//if file type is set
	{
		$query=$query." AND `File_type`='$typ'";
		$ser="Search Results for ".$typ;
	}
	if($client!=-1)//if file type is set
	{
		$query=$query." AND `Client`='$client'";
		$ser="Search Results for ".$client;
	}
	
	if($shift!=-1)//if file type is set
	{
		$query=$query." AND `Shift`='$shift'";
		$ser="Search Results for ".$shift;
	}
	if($platform_id!=-1)//if file type is set
	{
		$query=$query." AND `Platform_ID`='$platform_id'";
		$ser="Search Results for ".$platform_id;
	}
	$result=mysql_query($query);
}

else
{	
	$dat=date('Y-m-d');
	echo "<center><table><tr><td class=\"result1\">Details of files uploaded by the mls on ".$dat."</td></tr></table></center><br>";
	$query="SELECT * FROM `escript_filedetails` WHERE `Date` ='$dat' AND `Vendor`='$vendor_name'";
	$result=mysql_query($query);
	$ser='';
}
$sendquery=$query;

if($result)
{	
	echo "<center><label class=\"result1\">".$ser."</label></b><br><br>";
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		echo "<table><tr align=\"center\">
                <td>
                <input type=\"checkbox\" value=\"show\" id=\"check\" name=\"check\"  onClick=\"call()\" >Show Linecount Only 
                </td>
            </tr></table>";
		//echo "<form name=\"file_delete\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">"; 
		if($count<20)
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 250px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		else
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 400px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		
		echo "<table border=\"1\" cellpadding=\"1\"  cellspacing=\"0\" align=\"center\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\">";
		echo "<tr class=\"ui-widget-header\"><th>S.No.</th><th>Date</th><th>Shift</th><th>Vendor</th><th>Client</th><th>Hospital</th><th>Platform ID</th><th>File No</th><th>File Type</th><th>LineCount</th><th>ID Status</th><th>MT Name</th><th>Pending Reason</th><th>MT Comment</th><th>QC ID</th><th>QC Name</th><th>QC Comment</th><th>Uploaded To</th><th>Uptime_MLS</th><th>Uptime_Editor</th></tr>";
		
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			//echo "<td align=\"center\" ><input type=\"checkbox\" name=\"file_no_del[]\" value=\"".$row['File_No']."\" onclick=\"highlight_row(this, 'LightBlue');\"></td> "; 
			echo "<td>".htmlentities($c)."</td>";
			echo "<td>".htmlentities($row['Date'])."</td>";
			echo "<td>".htmlentities($row['Shift'])."</td>";
			echo "<td>".htmlentities($row['Vendor'])."</td>";
			echo "<td>".htmlentities($row['Client'])."</td>";
			echo "<td>".htmlentities($row['Hospital'])."</td>";
			echo "<td>".htmlentities($row['Platform_ID'])."</td>";
			echo "<td>".htmlentities($row['File_No'])."</td>";
			echo "<td>".htmlentities($row['File_type'])."</td>";
			if($row['File_type']=="Edit")
			{	
				$editlines=$editlines+$row['Linecount'];
			}
			if($row['File_type']=="Trans")
			{	
				$blanklines=$blanklines+$row['Linecount'];
			}
			echo "<td>".htmlentities($row['Linecount'])."</td>";
			echo "<td>".htmlentities($row['DSP/NONDSP'])."</td>";
			
			$lc=$lc+$row['Linecount'];
			
			echo "<td>".htmlentities($row['MT'])."</td>";
			echo "<td>".htmlentities($row['Pending_Reason'])."</td>";
			echo "<td>".htmlentities($row['MT_Comment'])."</td>";
			echo "<td>".htmlentities($row['QC_Platform_ID'])."</td>";
			echo "<td>".htmlentities($row['QC'])."</td>";
			echo "<td>".htmlentities($row['QC_Comment'])."</td>";
			echo "<td>".htmlentities($row['Upload_to'])."</td>";
			echo "<td>".htmlentities($row['Time_by_mls'])."</td>";
			echo "<td>".htmlentities($row['Time_by_qc'])."</td>";
			echo "</tr>";
			$c=$c+1;
			if($r==0)
			{
				$r=1;
			}
			else
			{
				$r=0;
			}
		}
		echo "</table></div>";
		echo "<center><table>";
		echo "<tr class=\"result1\"><td>Total No. of. File</td><td>:</td><td>".htmlentities($count)."</td></tr><br>";
		echo "<tr class=\"result1\"><td>Total No. of. Edit lines</td><td>:</td><td>".htmlentities($editlines)."</td></tr>";
		echo "<tr class=\"result1\"><td>Total No. of. Blank lines</td><td>:</td><td>".htmlentities($blanklines)."</td></tr>";
		echo "<tr class=\"result1\"><td>Total No. of. lines</td><td>:</td><td>".htmlentities($lc)."</td></tr>";
		echo "</table></center>";
		echo "<br><strong>***The output of the Excel is based on your selection Criteria***</strong>";
		Print "<br><br><center><form name=\"xl\" method=\"post\" action=\"monitor-report.php\">";
		Print "<input type=\"hidden\" Value=\"$sendquery\" name=\"mls_query\" id=\"query\" />";
		Print "<input type=\"submit\" value=\"Get File details as Excel\" name=\"Filedetails\"/>";
		Print "</form></center></td></tr></table>";
	}
	else
	{
		echo "<br /><h1><center>Sorry No Record Found !!!</center></h1><br />";
	
	}
}
?>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>