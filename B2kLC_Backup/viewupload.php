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
    <div id="main">
        <h2>IDSIL / PJO File Details </h2>
        <div id="file_box">
          		<center>
                <form name="file_ser" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="text" value="Enter a file no to search" name="fileno" size="10" id="searchfield" title="searchfield" onFocus="clearText(this)" onBlur="clearText(this)" />
                  	<input type="submit" name="Searchid" value="Search" alt="Search" id="Searchid" title="Search" onClick="show();" />
                </form>
                </center>
            </div><br>
        <form name="sub" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table align="center" width="900" cellpadding="1" cellspacing="0" style="padding-left:20px;">
        <tr align="center"><td colspan="9" class="result1" align="center" style="text-align:center; font-size:13px;">Choose the Date to See the uploaded Files<br><br></td></tr>
            <tr align="left">
                <td class="bold">From<td>:</td></td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date1'])) { echo $_POST['date1']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">To</td><td>:</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date2'])) { echo $_POST['date2']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td> 
                <td class="bold">Shift</td>
                 <td>:</td>
                 <td><select name="Shift" id="Shift" class="text ui-widget-content ui-corner-all">
                 	<?
					if(isset($_POST['Shift']))
					{	
						$Shift_show=$_POST['Shift'];
						if($Shift_show!='-1')
						{
							echo "<option value=\"-1\">--Show All--</option>";
							if($Shift_show=="Day")
							{
								echo "<option selected=\"selected\" value=".$Shift_show.">".$Shift_show."</option>";
								echo "<option value=\"Night\">Night</option>";
							}
							else
							{
								echo "<option selected=\"selected\" value=".$Shift_show.">".$Shift_show."</option>";
								echo "<option value=\"Day\">Day</option>";
							}
						}
						else
						{
							echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
							echo "<option value=\"Day\">Day</option>";
							echo "<option value=\"Night\">Night</option>";
						}
					}
					else
					{
						echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
						echo "<option value=\"Day\">Day</option>";
						echo "<option value=\"Night\">Night</option>";
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
                    <?
					$client_show='';
					if(isset($_POST['client']))
					{	
						$client_show=$_POST['client'];
						if($client_show!='-1')
						{
							echo "<option selected=\"selected\" value=".$client_show.">".$client_show."</option>";
							echo "<option value=\"-1\">--Select All--</option>";
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
					$sql=mysql_query("select `Client_name` from `client` order by `Client_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $des=$row['Client_name'];
					if($des!=$client_show)
					{
                    	echo '<option value="'.$des.'">'.$des.'</option>';
					}
                    }
                    ?>
            	</select></td>
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
					$sql=mysql_query("select `Hospital_name` from `hospitals` order by `Hospital_name` ");
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
                    $sql=mysql_query("select `username` from `id_details` order by `username` ");
                    while($row=mysql_fetch_array($sql))
                    {
                    $p_id=$row['username'];
					if($plat_id_show!=$p_id)
					{
                    	echo '<option value="'.$p_id.'">'.$p_id.'</option>';
					}
                    }
                    ?>
                    </select>
                </td>
          	</tr>
            <tr>
                 <td class="bold">Choose Team</td>
                 <td>:</td>
                 <td>
                     <select name="vendor" id="vendor" class="text ui-widget-content ui-corner-all">
                        <option selected="selected" value="-1">--Show All--</option>
                        <?php
                        $sql=mysql_query("select `Vendor_name` from `vendor` order by `Vendor_name`");
                        while($row=mysql_fetch_array($sql))
                        {
                        $vend=$row['Vendor_name'];
                        echo '<option value="'.$vend.'">'.$vend.'</option>';
                        }
                        ?>
                	</select>
                </td>
                <td class="bold">MLS Name</td>
                 <td>:</td>
                 <td>
                    <select name="a_id" id="a_id" class="text ui-widget-content ui-corner-all">
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
					$sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='MLS' OR `Emp_desig`='HT-MLS' or `Emp_desig`='EDITOR' or `Emp_desig`='HT-EDITOR' order by `Emp_name`");
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
							if($type_show=="Blank")
							{	
								echo "<option value=\"Edit\">Edit</option>";
							}
							else
							{
								echo "<option value=\"Blank\">Blank</option>";
							}
						}
						else
						{
							echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
							echo "<option value=\"Blank\">Blank</option>";
							echo "<option value=\"Edit\">Edit</option>";
						}
					}
					else
					{
						echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
						echo "<option value=\"Blank\">Blank</option>";
						echo "<option value=\"Edit\">Edit</option>";
					}
					?>
                    </select>
                 </td>
          	</tr>
            <tr align="center">
                <td colspan="9">
                <br><input type="submit" name="search"  value="Search" onClick="show()" style="height:30px; width:100px;"/>
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
	$result=mysql_query("SELECT * FROM `file_details` WHERE `File_No` LIKE '%$f_no%'");
	$shared=mysql_query("SELECT * FROM `shared_files` WHERE `File_no`='$f_no'");
	$ser="Search Results for file no contains ".$f_no;
}
elseif(isset($_POST['date1'],$_POST['date2'],$_POST['a_id'],$_POST['hos'],$_POST['type'],$_POST['vendor'],$_POST['client'],$_POST['Shift']))
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
	
	$query="SELECT * FROM `file_details` FORCE INDEX (`File_No`) WHERE `Date` BETWEEN '$s_date' AND '$e_date'";
	$sh_query="SELECT * FROM `shared_files` FORCE INDEX (`File_No`)  WHERE `Date` BETWEEN '$s_date' AND '$e_date'";
	
	if($id!=-1)//if id is set
	{
		$query=$query." AND `Uploadedby`='$id'";
		$sh_query=$sh_query." AND `Uploadedby`='$id'";
		$ser="Search Results for ".$id;
	}
	
	if($hos!=-1)//if hospital is set
	{
		$query=$query." AND `Hospital`='$hos'";
		$sh_query=$sh_query." AND `Hospital`='$hos'";
		$ser="Search Results for ".$hos;
	}
	
	if($typ!=-1)//if file type is set
	{
		$query=$query." AND `File_Type`='$typ'";
		$sh_query=$sh_query." AND `File_type`='$typ'";
		$ser="Search Results for ".$typ;
	}
	if($vendor!=-1)//if file type is set
	{
		$query=$query." AND `Vendor`='$vendor'";
		$sh_query=$sh_query." AND `Vendor`='$vendor'";
		$ser="Search Results for ".$vendor;
	}
	if($client!=-1)//if file type is set
	{
		$query=$query." AND `Client`='$client'";
		$sh_query=$sh_query." AND `Client`='$client'";
		$ser="Search Results for ".$client;
	}
	
	if($shift!=-1)//if file type is set
	{
		$query=$query." AND `Shift`='$shift'";
		$sh_query=0;
		$ser="Search Results for ".$shift;
	}
	if($platform_id!=-1)//if file type is set
	{
		$query=$query." AND `Platform_id`='$platform_id'";
		$sh_query=0;
		$ser="Search Results for ".$platform_id;
	}
	$result=mysql_query($query);
	$shared=mysql_query($sh_query);
}

else
{	
	$dat=date('Y-m-d');
	echo "<center><table><tr><td class=\"result1\">Details of files uploaded by the mls on ".$dat."</td></tr></table></center>";
	$query="SELECT * FROM `file_details`  WHERE `Date` ='$dat' order by `Time_up_mls`";
	$result=mysql_query($query);
	$shared=mysql_query("SELECT * FROM `shared_files`  WHERE `Date` ='$dat'");
	$ser='';
}
$sendquery=$query;

if($result)
{	
	echo "<center><label class=\"result1\">".$ser."</label></b><br>";
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
			echo "<div id=\"detail\" style=\"width:900px; height: 300px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		else
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 400px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		
		echo "<table border=\"1\" cellpadding=\"2\"  cellspacing=\"0\" width=\"900\" align=\"center\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\">";
		echo "<tr class=\"ui-widget-header\"><th >Options<th>S.No.</th><th>Date</th><th>Shift</th><th>Team</th><th>Client</th><th>Hospital</th><th>Platform ID</th><th>File No</th><th>Voice No</th><th>File Type</th><th>File Mins</th><th>LineCount</th><th>Upload type</th><th>Shared</th><th>Uploaded By</th><th>Proofed By</th><th>Edited By</th><th>III - Level</th><th>III - Level Editor</th><th>Uploaded To</th><th>Uptime_MLS</th><th>Pick_time_Editor</th><th>Uptime_Editor</th><th>Pick_time_3rd Editor</th><th>Uptime_3rd_Editor</th><th>Accuracy ( % )</th><th>Comments</th></tr>";
		
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			//echo "<td align=\"center\" ><input type=\"checkbox\" name=\"file_no_del[]\" value=\"".$row['File_No']."\" onclick=\"highlight_row(this, 'LightBlue');\"></td> "; 
			echo "<td align=\"center\">
				<table><tr><td style=\"border:0px;\"><img src=\"menu/notes.png\" title=\"Edit file details\" height=\"20\" width=\"20\"  style=\"cursor:pointer;\" onclick=\"update('".$row['File_No']."');\"></td><td style=\"border:0px;\"><img src=\"menu/button-cross_sticker.png\" height=\"20\" width=\"20\" title=\"Delete file details\" style=\"cursor:pointer;\" onclick=\"deletefile('".$row['File_No']."');\"></td></tr></table>
				</td> "; 
			echo "<td>".htmlentities($c)."</td>";
			echo "<td>".htmlentities($row['Date'])."</td>";
			echo "<td>".htmlentities($row['Shift'])."</td>";
			echo "<td>".htmlentities($row['Vendor'])."</td>";
			echo "<td>".htmlentities($row['Client'])."</td>";
			echo "<td>".htmlentities($row['Hospital'])."</td>";
			echo "<td>".htmlentities($row['Platform_id'])."</td>";
			echo "<td>".htmlentities($row['File_No'])."</td>";
			echo "<td>".htmlentities($row['Voice_No'])."</td>";
			echo "<td>".htmlentities($row['File_Type'])."</td>";
			if($row['File_Type']=="Edit")
			{	
				$editlines=$editlines+$row['Linecount'];
			}
			if($row['File_Type']=="Blank")
			{	
				$blanklines=$blanklines+$row['Linecount'];
			}
			echo "<td>".htmlentities($row['File_min'])."</td>";
			echo "<td>".htmlentities($row['Linecount'])."</td>";
			echo "<td>".htmlentities($row['Upstatus'])."</td>";
			echo "<td>".htmlentities($row['Shared'])."</td>";
			
			$lc=$lc+$row['Linecount'];
			
			echo "<td>".htmlentities($row['Uploadedby'])."</td>";
			echo "<td>".htmlentities($row['Proofed by'])."</td>";
			echo "<td>".htmlentities($row['Editedby'])."</td>";
			echo "<td>".htmlentities($row['Third_level'])."</td>";
			echo "<td>".htmlentities($row['Third_Editor'])."</td>";
			echo "<td>".htmlentities($row['Upload_to'])."</td>";
			echo "<td>".htmlentities($row['Time_up_mls'])."</td>";
			echo "<td>".htmlentities($row['pick_time_edtr'])."</td>";
			echo "<td>".htmlentities($row['Time_up_edit'])."</td>";
			echo "<td>".htmlentities($row['pick_time_III_level'])."</td>";
			echo "<td>".htmlentities($row['uptime_III_level'])."</td>";
			echo "<td>".htmlentities($row['Accuracy'])."</td>";
			echo "<td>".htmlentities($row['Comments'])."</td>";
			
			//echo "<td>".$row['File_location']."</td>";
			
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
		echo "<script type=\"text/javascript\" language=\"javascript\">
				function update(file_no)
				{
					var fno=file_no;
					if (confirm('Are you sure ? You want to update this '+fno+'?'))
					{
						window.location = \"fileupdate.php?fno=\"+fno;
					}
					else
					{
						return false;
					}
				}
				function deletefile(file_no)
				{
					var fno=file_no;
					if (confirm('Are you sure ? You want to delete this '+fno+'?'))
					{
						window.location = \"viewupload.php?file_no_del=\"+fno;
					}
					else
					{
						return false;
					}
				}
				</script>";
		echo "<center><table>";
		echo "<tr class=\"result1\"><td>Total No. of. File</td><td>:</td><td>".htmlentities($count)."</td></tr><br>";
		echo "<tr class=\"result1\"><td>Total No. of. Edit lines</td><td>:</td><td>".htmlentities($editlines)."</td></tr>";
		echo "<tr class=\"result1\"><td>Total No. of. Blank lines</td><td>:</td><td>".htmlentities($blanklines)."</td></tr>";
		echo "<tr class=\"result1\"><td>Total No. of. lines</td><td>:</td><td>".htmlentities($lc)."</td></tr>";
		echo "</table></center>";
		echo "<br><strong>***The output of the Excel is based on your selection Criteria***</strong>";
		Print "<br><br><center><form name=\"xl\" method=\"post\" action=\"filereport.php\">";
		Print "<input type=\"hidden\" Value=\"$sendquery\" name=\"query\" id=\"query\" />";
		Print "<input type=\"submit\" value=\"Get File details as Excel\" name=\"Filedetails\"/>";
		Print "</form></center></td></tr></table>";
	}
	else
	{
		echo "<br /><h1><center>Sorry No Record Found !!!</center></h1><br />";
	
	}
}
if($shared)
{

	$editlines=0;
	$blanklines=0;
	$lc1=0; 	

	//echo "<center><label class=\"result1\">Please donot consider this linecount. This is only for information.</label></b><br><br>";
	$count=mysql_num_rows($shared);
	if($count!=0)
	{	
		echo "<center><label class=\"result1\">".$ser." shared files</label></b><br><br>";
		if($count<20)
		{
			echo "<div id=\"share_detail\" style=\"width:900px; height: 150px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		else
		{
			echo "<div id=\"share_detail\" style=\"width:900px; height: 350px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		echo "<table border=\"1\" cellpadding=\"2\"  cellspacing=\"0\" width=\"900\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\">";
		echo "<th>S.No.</th><th>Date</th><th>Client</th><th>File No</th><th>File Type</th><th>Linecount</th><th>Uploaded By</th></tr>";
		
		while($row=mysql_fetch_array($shared))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".htmlentities($c)."</td>";
			echo "<td>".htmlentities($row['Date'])."</td>";
			echo "<td>".htmlentities($row['Client'])."</td>";
			echo "<td>".htmlentities($row['File_no'])."</td>";
			echo "<td>".htmlentities($row['File_type'])."</td>";
			
			if($row['File_type']=="Edit")
			{	
				$editlines=$editlines+$row['Linecount'];
			}
			if($row['File_type']=="Blank")
			{	
				$blanklines=$blanklines+$row['Linecount'];
			}
			
			echo "<td>".htmlentities($row['Linecount'])."</td>";
					
			$lc1=$lc1+$row['Linecount'];
			
			echo "<td>".htmlentities($row['Uploadedby'])."</td>";
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
		echo "<table>";
		echo "<tr class=\"result1\"><td>Total No. of. File</td><td>:</td><td>".htmlentities($count)."</td></tr><br>";
		echo "<tr class=\"result1\"><td>Total No. of. Edit lines</td><td>:</td><td>".htmlentities($editlines)."</td></tr>";
		echo "<tr class=\"result1\"><td>Total No. of. Blank lines</td><td>:</td><td>".htmlentities($blanklines)."</td></tr>";
		echo "<tr class=\"result1\"><td>Total No. of. Lines</td><td>:</td><td>".htmlentities($lc1)."</td></tr>";
		echo "</table></center>";
	}
}
?>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
    <?php
	if(isset($_GET['file_no_del']))
	{		
		$value=$_GET['file_no_del'];
		$del=mysql_query("DELETE FROM `file_details`  WHERE `File_No`='$value'");
		$del_shared=mysql_query("DELETE FROM `shared_files`  WHERE `File_no`='$value'");
		if($del)
		{
			$comment=$loginas." has Deleted the details of the file ".$value.".";
			$fp = fopen($log_dir.$loginas.".txt", "a+");
			fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
			fclose($fp);
			echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Details of the File ".$value."  is deleted successfully !!!\",
					callback:function(){
					setTimeout(function(){ window.location = \"viewupload.php\";}, 0);
					}
				});
				</script>";
			
		}
	}
	?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>