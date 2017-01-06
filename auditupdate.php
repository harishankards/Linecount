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
          <form name="empdata" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Enter the File details</h2></center>
          	<?php
          	$fileno=$_GET['fno'];
			$result=mysql_query("SELECT `Date`,`File_no`,`Hospital`,`Linecount` FROM `audit_files` FORCE INDEX (`File_no`)  WHERE `File_no`='$fileno'");
			while($row=mysql_fetch_array($result))
			{
			?>
          <table cellpadding="5" align="center" cellspacing="10">
          <tr>
          <td>Date</td>
          <td>:</td>
          <td>
		  <input type="text" id="datepicker" title="Select the Date" name="date5" value="<?php echo $row['Date'];?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
          </td>
          </tr>
          
          <tr>
          <td>Old File No</td>
          <td>:</td>
          <td><input type="text" name="f_no_old" id="f_no_old" size="10" value="<?php echo htmlentities($row['File_no']);?>"  readonly="readonly" /></td>
          </tr>
          
          <tr>
          <td>New File No</td>
          <td>:</td>
          <td><input type="text" name="f_no" id="f_no" size="10" value="<?php echo htmlentities($row['File_no']);?>"/></td>
          </tr>
          
          <tr>
          <td>Hospital</td>
          <td>:</td>
          <td><select name="f_hos" id="f_hos">
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
          <td>Linecount</td>
          <td>:</td>
          <td><input type="text" name="f_lc" id="f_lc" size="8" value="<? echo htmlentities($row['Linecount']);?>"  />
          <input type="hidden" name="f_ed_by" id="f_ed_by" size="8" value="<? echo htmlentities($row['Editedby']);?>"  /></td>
          </tr>
         
          
          
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
          <tr><td><input type="submit" value="Submit" name="sub" class="button" /></td><td><input type="reset" value="Reset" name="res" class="button" height="27" width="100" /></td></tr>
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
	$lc=mysql_real_escape_string($_POST['f_lc']);
	$client=mysql_query("SELECT `Client` FROM `hospitals` WHERE `Hospital_name`='$hospital'");
	while($crow=mysql_fetch_array($client))
	{
		$clinet_name=$crow['Client'];
	}
	$sql=mysql_query("UPDATE `audit_files` SET  `Date`='$date',`Client`='$clinet_name',`Hospital`='$hospital',`File_no`='$no',`Linecount`='$lc' where `File_no`='$old_no'");
	if($sql)
	{
		$comment=$loginas." has updated a Audit file Details [".$old_no."]";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> alert('File details updated Successfully');</script>";
		echo "<script> setTimeout(function(){ window.location = \"viewauditfile.php\";}, 0);</script>";
	}
	else
	{
		echo "<script> alert('File details not added Successfully');</script>";
		echo "<script> setTimeout(function(){ window.location = \"viewauditfile.php\";}, 0);</script>";
	}
}
mysql_close($con);
?>
</body>
<script src="js/element.js"></script>
</html>
