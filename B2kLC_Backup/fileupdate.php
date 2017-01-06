<?php include('top.php');?>
<style>
#datepicker{ margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }
select{ margin-bottom:0px; width:165px; padding: .2em; text-align:left; }
</style>

</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
   	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
          <form name="empdata" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter the File details</h2></center>
          	<?php
          	$fileno=$_GET['fno'];
			$result=mysql_query("SELECT `Date`,`File_No`,`Hospital`,`File_Type`,`File_min`,`Upstatus`,`Linecount`,`Upload_to`,`Editedby` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `File_No`='$fileno'");
			while($row=mysql_fetch_array($result))
			{
			?>
          <table cellpadding="5" align="center" cellspacing="10">
          <tr>
          <td>Date</td>
          <td>:</td>
          <td>
		  <input type="text" id="datepicker" title="Select the Date" name="date5" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
          </td>
          </tr>
          
          <tr>
          <td>Old File No</td>
          <td>:</td>
          <td><input type="text" name="f_no_old" id="f_no_old" class="text ui-widget-content ui-corner-all" size="10" value="<?php echo htmlentities($row['File_No']);?>"  readonly="readonly" /></td>
          </tr>
          
          <tr>
          <td>New File No</td>
          <td>:</td>
          <td><input type="text" name="f_no" id="f_no" size="10" class="text ui-widget-content ui-corner-all" value="<?php echo htmlentities($row['File_No']);?>"/></td>
          </tr>
          
          <tr>
          <td>Hospital</td>
          <td>:</td>
          <td><select name="f_hos" id="f_hos" class="text ui-widget-content ui-corner-all">
                <option selected="selected" value="<? echo $row['Hospital'];?>"><? echo htmlentities($row['Hospital']);?></option>
                 <?php
                    $sql=mysql_query("select `Hospital_name` from `hospitals` order by `Hospital_name`");
                    while($row1=mysql_fetch_array($sql))
                    {
						$hsp=$row1['Hospital_name'];
						if($hsp!=$row['Hospital'])
						{
							echo '<option value="'.htmlentities($hsp).'">'.htmlentities($hsp).'</option>';
						}
                    }
                    ?>
          </select></td>
          </tr>
          
          <tr>
          <td>File Type</td>
          <td>:</td>
          <td><select name="f_type" id="f_type" class="text ui-widget-content ui-corner-all">
                <option selected="selected" value="<? echo $row['File_Type'];?>"><?php echo htmlentities($row['File_Type']); ?></option>
               <?php
			   $hsp=$row['File_Type'];
			   	if($hsp=="Edit")
				{
					echo '<option value="Blank">Blank</option>';
				}
				else
				{
					echo '<option value="Edit">Edit</option>';
				}
               ?>
          </select></td>
          </tr>
          
          <tr>
          <td>File Mins</td>
          <td>:</td>
          <td><input type="text" name="f_min" id="f_min" size="6" class="text ui-widget-content ui-corner-all" value="<?php echo htmlentities($row['File_min']);?>"  /></td>
          </tr>
          
          <tr>
          <td>Upload Status</td>
          <td>:</td>
            <?
				if($row['Upstatus']!='No DUP')
				{
					$nature=explode("DUP / ",$row['Upstatus']);
			  		$val=$nature[1];
					$val_s="DUP/".$val;
				}
				else
				{
					$val=$row['Upstatus'];
					$val_s=$row['Upstatus'];
				}
			  ?>
          <td>
              <select name="f_upstatus" id="f_upstatus" class="text ui-widget-content ui-corner-all" >
            
                  <option selected="selected" value="<? echo htmlentities($val);?>"><? echo htmlentities($val_s);?></option>
                  <?php
				  	if($row['Upstatus']!='No DUP')
					{
				    	echo '<option value="No DUP">No DUP</option>';
					}
                    $sql=mysql_query("select `Nature` from `jobnature` order by `Nature` ");	
                    while($row2=mysql_fetch_array($sql))
                    {
                        $nat=$row2['Nature'];
						if($val!=$row2['Nature'])
                        	echo '<option value="'.htmlentities($nat).'">DUP/'.htmlentities($nat).'</option>';
                    }
                    echo '<option value="DUP/ADT">DUP/ADT</option>';
                    ?>
              </select>
          </td>
          </tr>
          
          
          
          <tr>
          <td>Linecount</td>
          <td>:</td>
          <td><input type="text" name="f_lc" id="f_lc" size="8" class="text ui-widget-content ui-corner-all" value="<? echo htmlentities($row['Linecount']); ?>"  />
          <input type="hidden" name="f_ed_by" id="f_ed_by" size="8" class="text ui-widget-content ui-corner-all" value="<? echo htmlentities($row['Editedby']);?>"  /></td>
          </tr>
         
          <?php
		  /*if($row['Editedby']!='Not yet Edited')
		  {
			echo "<tr>
			<td>Edited by</td>
			<td>:</td>
			<td>
			<select name=\"f_ed_by\" title=\"Edited By\" id=\"f_ed_by\" >
			<option selected=\"selected\" value=\"".$row['Editedby']."\">".$row['Editedby']."</option>
			<option value=\"Not yet Edited\">Not yet Edited</option>
			</select>
			</td>
			</tr>";
			}*/
		  ?>
          
          <?php
		  if($row['Upload_to']!='Not yet Edited')
		  {
			echo "<tr>
			<td>Upload To</td>
			<td>:</td>
			<td>
			<select name=\"f_up_to\" title=\"uploadto\" id=\"f_up_to\" class=\"text ui-widget-content ui-corner-all\" >
			<option selected=\"selected\" value=\"-1\">".$row['Upload_to']."</option>
			<option value=\"Not yet Edited\">Not yet Edited</option>
			<option value=\"Hospital/Customer\">Hospital / Customer</option>
			<option value=\"IDS/QA_Checkpoint\">IDS / QA Checkpoint</option>
			<option value=\"Third_level\">Third Level </option>
			</select>
			</td>
			</tr>";
		  }
		  else
		  {
		  	echo "<input type=\"hidden\" name=\"f_up_to\" id=\"f_up_to\" size=\"20\" value=\"".$row['Upload_to']."\"/>";
		  }

		  ?>
          
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
          <tr><td><input type="submit" value="Submit" name="sub" style=" height:30px; width:75px;"  /></td></tr>
          </table>
          	<?php
				}
			?>
          </form>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    <?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php
include('dbconfig.php');
if(isset($_POST['f_no'],$_POST['f_no_old']))
{
	$no=mysql_real_escape_string($_POST['f_no']);
	$old_no=mysql_real_escape_string($_POST['f_no_old']);
	$hospital=mysql_real_escape_string($_POST['f_hos']);
	$date=mysql_real_escape_string($_POST['date5']);
	$type=mysql_real_escape_string($_POST['f_type']);
	$min=mysql_real_escape_string($_POST['f_min']);
	$status=mysql_real_escape_string($_POST['f_upstatus']);
	$lc=mysql_real_escape_string($_POST['f_lc']);
	$editedby=mysql_real_escape_string($_POST['f_ed_by']);
	$upload_to=mysql_real_escape_string($_POST['f_up_to']);
	$f_dup=$status;
	$client=mysql_query("SELECT `Client` FROM `hospitals` WHERE `Hospital_name`='$hospital'");
	while($crow=mysql_fetch_array($client))
	{
		$clinet_name=$crow['Client'];
	}
	if($f_dup=="No DUP")
	{
		if($editedby=="DUP / 0" || $editedby=="DUP / 1" || $editedby=="DUP / 2" || $editedby=="DUP / 3" || $editedby=="DUP/ADT")
		{
			$editedby="Not yet Edited";
			$thirdlevel='Not yet Edited';
			$thirdeditor='Not yet Edited';
			$upload_to='Not yet Edited';
			$accuracy='100';
			$upstatus="No DUP";
		}
		else
		{
			$editedby="Not yet Edited";
			$thirdlevel='Not yet Edited';
			$thirdeditor='Not yet Edited';
			$upload_to='Not yet Edited';
			$accuracy='100';
			$upstatus="No DUP";
		}
	}
	elseif($f_dup=="DUP/ADT")
	{
		if($editedby=="DUP / 0" || $editedby=="DUP / 1" || $editedby=="DUP / 2" || $editedby=="DUP / 3" || $editedby=="DUP/ADT")
		{
			$editedby="Not yet Edited";
			$upstatus="DUP/ADT";
			$accuracy='';
			$thirdlevel='Not yet Edited';
			$thirdeditor='Not yet Edited';
			$upload_to='Not yet Edited';
		}
		else
		{
			$editedby="Not yet Edited";
			$upstatus="DUP/ADT";
			$accuracy='';
			$thirdlevel='Not yet Edited';
			$thirdeditor='Not yet Edited';
			$upload_to='Not yet Edited';
		}
	}
	else
	{
		$hosp=mysql_query("SELECT `Job_nature`,`Client` FROM `hospitals` WHERE `Hospital_name`='$hospital'");
		while($hrow=mysql_fetch_array($hosp))
		{
			if($f_dup<=$hrow['Job_nature'])
			{
				$editedby="DUP / ".$f_dup;
				$upstatus="DUP / ".$f_dup;
				$thirdlevel="DUP / ".$f_dup;
				$thirdeditor="DUP / ".$f_dup;
				$accuracy='98';
				$upload_to="Hospital/Cusotmer";
			}
			else
			{
				$editedby="Not yet Edited";
				$upstatus="DUP / ".$f_dup;
				$accuracy='';
				$thirdlevel='Not yet Edited';
				$thirdeditor='Not yet Edited';
				$upload_to='Not yet Edited';
			}
		}
	}
	$sql=mysql_query("UPDATE `file_details` SET  `Date`='$date',`Client`='$clinet_name',`Hospital`='$hospital',`File_No`='$no',`File_Type`='$type',`File_min`='$min',`Linecount`='$lc',`Upstatus`='$upstatus',`Upload_to`='$upload_to',`Editedby`='$editedby',`Third_level`='$thirdlevel',`Third_Editor`='$thirdeditor' where `File_No`='$old_no'");
	if($sql)
	{
		echo "<script> alert('Employee details updated Successfully');</script>";
		echo "<script> setTimeout(function(){ window.location = \"viewupload.php\";}, 0);</script>";
	}
	else
	{
		echo "<script> alert('Employee details not added Successfully');</script>";
		echo "<script> setTimeout(function(){ window.location = \"viewupload.php\";}, 0);</script>";
	}
}
mysql_close($con);
?>
</body>
<script src="js/element.js"></script>
</html>
