<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:left; }
</style>
<script type="text/javascript" language="javascript">
<?php 
$sql=mysql_query("select * from `attn_list` order by `Name`");
while($row1=mysql_fetch_array($sql))
{
Print"				
    function enableTextBox".$row1['No']."() {
        if (document.getElementById(\"double".$row1['No']."\").checked == true)
            document.getElementById(\"a_comm1".$row1['No']."\").style.display = '';
        else
            document.getElementById(\"a_comm1".$row1['No']."\").style.display='none';
    }
	";
}
?>
function check(thisform)
{
<?
$sql=mysql_query("select * from `attn_list` order by `Name`");
while($at_row=mysql_fetch_array($sql))
{
	echo "var don".$at_row['No']." = document.getElementsByName('status".$at_row['No']."');
	var count".$at_row['No']."=0;
	for(var i=0;i<don".$at_row['No'].".length;i++)
	{
			if(!don".$at_row['No']."[i].checked)
		{
			count".$at_row['No']."=count".$at_row['No']."+1;
		}
	}
	if(count".$at_row['No']."==4)
	{
		dhtmlx.alert({title:\"Warning!!!\", text:\"Please specify attendance for ".$at_row['Name']." \"});
		return false;
	}
	";
}
?>
thisform.submit();
}
function hide()
{
	<?php
	$sql=mysql_query("select * from `attn_list` order by `Name`");
	while($row2=mysql_fetch_array($sql))
	{
		Print"document.getElementById(\"a_comm1".$row2['No']."\").style.display = 'none';";
	}
	?>
}

</script>

</head>
<body onLoad="hide()"> 
<div id="outer_wrapper">
  <div id="wrapper">
   	<?php 
	include('main_top.php');
	?>
          <div id="main"><br>
          	<?php
			Print "<center>";
			Print "<form name=\"empatt\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\" method=\"post\">";
			?>
          	<center><table align="center" cellpadding="1" cellspacing="10"><tr><td class="bold">Today Attendance</td><td>:</td><td style="padding-bottom:0px;">
			<input type="text" id="datepicker" title="Select the Date" name="date5" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
            </td></tr></table><br></center>
                 
			<?php
				$a=1;
				$sql=mysql_query("select * from `attn_list` order by `Name`");
				Print "<div style=\"width: 800px; height: auto; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table border=\"1\" width=\"800\" cellspacing=\"0\" class=\"text ui-widget-content ui-corner-all tab\" cellpadding=\"0\">";
				$c=1;
				Print"<th>No</th><th>Name</th><th>Full / Half / Half</th><th>Double Pay</th><th>Comments</th>";
				while($row=mysql_fetch_array($sql))
				{
					Print "<tr class=\"tr".$a."\">";
					Print"<td style=\"text-align:center; width:60px;\">".$c."</td>";
					Print"<td style=\"text-align:center; width:180px;\">".$row['Name']." (".$row['No'].")</td>";
					Print"<td style=\"text-align:left; width:180px;\" >
					  <input type=\"radio\" name=\"status".$row['No']."\" id=\"status".$row['No']."\" value=\"Full\" onclick=\"highlight_row(this, 'LightBlue');\">Full Day&nbsp;&nbsp;
					  <input type=\"radio\" name=\"status".$row['No']."\" id=\"status".$row['No']."\" value=\"Night\" onclick=\"highlight_row(this, 'LightBlue');\">Night Shift<br>
					  <input type=\"radio\" name=\"status".$row['No']."\" id=\"status".$row['No']."\" value=\"Half\" onclick=\"highlight_row(this, 'LightBlue');\">Half Day&nbsp;&nbsp;
					  <input type=\"radio\" name=\"status".$row['No']."\" id=\"status".$row['No']."\" value=\"Leave\" onclick=\"highlight_row(this, 'LightBlue');\">Leave<br>
					  </td>";
					Print"<td style=\"text-align:left; width:120px;\"><input type=\"radio\" name=\"double".$row['No']."[]\" id=\"double".$row['No']."\" value=\"YES\" onChange=\"enableTextBox".$row['No']."()\">&nbsp;YES&nbsp;&nbsp;<input type=\"radio\" name=\"double".$row['No']."[]\" id=\"double".$row['No']."\" checked=\"true\" value=\"NO\" onChange=\"enableTextBox".$row['No']."()\">&nbsp;NO</td>";
					Print"<td id=\"a_comm1".$row['No']."\" style=\"text-align:center; width:248px;\"><textarea name=\"a_comm".$row['No']."\" title=\"a_comm".$row['No']."\" id=\"a_comm".$row['No']."\" cols=\"27\" rows=\"2\" class=\"text ui-widget-content ui-corner-all button\" onFocus=\"clearText(this)\" onBlur=\"clearText(this)\">No Double Pay</textarea></td></tr>";
					$c=$c+1;
					if($a==1)
					{
						$a=0;
					}
					else
					{
						$a=1;
					}
				}
				Print "</table>";
				Print "</div>";
				Print "<table width=\"700\">";
				Print "<tr align=\"center\"><td><input type=\"button\" value=\"Submit\" name=\"sub\" onclick=\"check(this.form)\" style=\"height:30px; width:150px;\"/></td><td><input type=\"reset\" value=\"Reset\" name=\"res\" style=\"height:30px; width:150px;\"/></td></tr>";
				Print "</table>";
				Print "</form>";
				Print "</center>";
            ?>
          </div> <!-- end of main -->
    <div id="main_bottom"></div>
    <?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php
if(isset($_POST['date5']))
{
	include('dbconfig.php');
	$s_flag='';
	$f_flag='';
	$query=mysql_query("select * from `attn_list` order by `Name`");
	while($row=mysql_fetch_array($query))
	{
		$double=$_POST['double'.$row['No']];
		for($i=0;$i<sizeof($double);$i++)
		{
		$dday=mysql_real_escape_string($_POST['double'.$row['No']][$i]);
		}
		$no=$row['No'];
		$name=$row['Name'];
		$date=mysql_real_escape_string($_POST['date5']);
		$att=$_POST['status'.$row['No']];
		
		$status=mysql_real_escape_string($_POST['status'.$row['No']]);
		
		$comm=mysql_real_escape_string($_POST['a_comm'.$row['No']]);
		$extrahrs="0";
		$check=mysql_query("SELECT * from `attendance` WHERE `Date`='$date' AND `No`='$no'");
		$count=mysql_num_rows($check);
		if($count==0)
		{
			$sql=mysql_query("INSERT INTO `attendance` VALUES ('NULL','$date','$no','$name','$status','$dday','$comm','$extrahrs')");
			if($sql)
			{
				$s_flag=$s_flag+1;
			}
		}
		else
		{
				$f_flag=$f_flag+1;
		
		}
	}
	if($s_flag!=0)
	{
		$comment=$loginas." has added Attendanec Details into the Database";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
				title:\"Success !!!\",
				ok:\"Ok\",
				text:\"".$s_flag." Attendance details added Successfully\",
				callback:function(){
				setTimeout(function(){ window.location = \"atten1.php\";}, 0);
				}
			});
			
			</script>";
	}
	if($f_flag!=0)
	{
		echo "<script> dhtmlx.alert({
							title:\"Opps !!!\",
							ok:\"Ok\",
							text:\"".$f_flag." Attendance details already added Please verify\",
							callback:function(){
							setTimeout(function(){ window.location = \"atten1.php\";}, 0);
							}
						});
						
						</script>";
	}
}
mysql_close($con);
?>
</body>
<script src="js/element.js"></script>
</html>
