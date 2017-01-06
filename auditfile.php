<?php include('editortop.php');?>
<style>
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }
input.button { margin-bottom:0px; width:75px; padding: .2em; text-align:center; cursor:pointer; }
select { margin-bottom:0px; width:165px; padding: .2em; text-align:left; }
</style>
<script language="javascript" type="text/javascript">
function reload()
{
        setTimeout(function(){ window.location = "auditfile.php";}, 0);
}
function check(thisform)
{
	if(document.getElementById('f_hospital').value==='-1')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Client"});
		return false;
	}
	if(document.getElementById('fileup').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter a File No"});
		return false;
	}
	thisform.submit();
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
        <h2>Upload Audit Files Here </h2>
        <!--<center> <p style="color:#FF0000; font-size:14px;">If you are adding the Missing Files please donot add in the Audit. To add <a href="missingfiles.php">Click here</a></p></center>-->
        <center><p style="color:#0066CC; font-size:12px;">* * * Please Upload the Audit file details here * * *</p></center><br>
        <form name="Filesubmit" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" >
        <table align="center" width="750" cellspacing="5" style=" padding-left:170px;">
            <tr>
                <td>Select the Date</td><td>:</td>
                <td>
                    <input type="text" id="datepicker" title="Select the Date" name="date1" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
            </tr>
            
            <tr>
               	<td>Choose Hospital</td><td>:</td>
                <td>
                    <select name="f_hospital" id="f_hospital" class="text ui-widget-content ui-corner-all">
                    <?
					$hos_show='';
					if(isset($_SESSION['Hospital']))
					{	
						$hos_show=$_SESSION['Hospital'];
						if($hos_show!='-1')
						{
							echo "<option selected=\"selected\" value=\"".$hos_show."\">".$hos_show."</option>";
						}
						else
						{
							echo "<option selected=\"selected\" value=\"-1\">--Select Hospital--</option>";
						}
					}
					else
					{
						echo "<option selected=\"selected\" value=\"-1\">--Select Hospital--</option>";
					}
					$sql=mysql_query("select `Hospital_name` from `hospitals` order by `Hospital_name`");
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
            </tr>
            
            <tr>
                <td>File No</td><td>:</td>
                <td>
                	<input type="text" name="fileno" id="fileno" size="15" value="" class="text ui-widget-content ui-corner-all" onBlur="checkNum(this);" autocomplete="off">
                </td>
            </tr>
            
            <tr>
                <td>File's Character Count</td>
                <td>:</td>
                <td><input type="text" name="fileup" id="fileup" size="15" maxlength="5" class="text ui-widget-content ui-corner-all" onBlur="checkNum(this);" autocomplete="off"><a rel="imgtip[0]">&nbsp;&nbsp;To Know Click Here</a></td>
            </tr>
            
            <tr>
       </table>
       <br>
       
            <br>
            <center>
            	<input type="button" name="fsubmit" value="Submit" onClick="check(this.form)" />
            </center>
		</form>
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>		
    <?php include('footer.php');?>
    <?php
if(isset($_POST['fileup'],$_POST['fileno'],$_POST['date1'],$_POST['f_hospital']))
{
	$dat=mysql_real_escape_string(trim($_POST['date1'])); //date
	$f_hospital=mysql_real_escape_string($_POST['f_hospital']); // Hospital Name
	$_SESSION['Hospital']=$f_hospital;
	$f_no=mysql_real_escape_string($_POST['fileno']);
	$flag=1;
	if($flag==1)
	{
		$uploadby=$_SESSION['idsileditorname'];
		$client=mysql_query("SELECT * FROM `hospitals` WHERE `Hospital_name`='$f_hospital'");
		while($crow=mysql_fetch_array($client))
		{
			$f_client=$crow['Client'];
		}
		$uploadby=$_SESSION['idsileditorname'];
		$c_count=$_POST['fileup'];
		$size=$c_count/65;
		$linecount=round($size,$round_value);
		$today=$dat;
		$thirdlevel='';
		$thirdeditor='';
		$upload_to='';
		$Time_by_edit='';
		echo "<br><form name=\"up\" action=\"#\" method=\"post\">";
		echo "<table align=\"center\" border=\"1\">";
		echo "<th class=\"tr0\" width=\"300\">File Details</th>";
		echo "<tr class=\"tr2\"><td>";
		echo "<br><table callpadding=\"10\" cellspacing=\"5\">";
		echo "<tr><td>Client</td><td>:</td><td><strong>".htmlentities($f_client)."</strong></td></tr>";
		echo "<tr><td>Hospital</td><td>:</td><td><strong>".htmlentities($f_hospital)."</strong></td></tr>";
		echo "<tr><td>File No</td><td>:</td><td><strong>".htmlentities($f_no)."</strong></td></tr>";
		echo "<tr><td>Uploaded By</td><td>:</td><td><strong>".htmlentities($uploadby)."</strong></td></tr>";
		echo "<tr><td>Line Count</td><td>:</td><td><strong>".htmlentities($linecount)."</strong></td></tr>";
		echo "<tr><td>Uploaded Date and Time</td><td>:</td><td><strong>".htmlentities($datetime)."</strong></td></tr>";
		echo "</table><br></td></tr></table>";
		$uploadfile='';
		$upload=mysql_query("INSERT INTO `audit_files` VALUES ('NULL','$today','$f_no','$f_client','$f_hospital','$linecount','$uploadby','$datetime','$uploadfile')");
		
		if($upload)
			{
				$comment=$id." has added a Audit file ".$f_no." in IDSIL / PJO ";
				$fp = fopen($log_dir.$uploadby.".txt", "a+");
				fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
				fclose($fp);
				echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"File details added Successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"auditfile.php\";}, 0);
								}
							});
							</script>";
			}
			else
			{
				echo "<script> dhtmlx.alert({
								title:\"Error !!!\",
								ok:\"Ok\",
								text:\"File details Not added !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"auditfile.php\";}, 0);
								}
							});
							</script>";
			}
			echo "<br><center><input type=\"button\" value=\"OK\" onclick=\"reload()\"></center>";
			echo "</form>";
		}
	}

?>

</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
