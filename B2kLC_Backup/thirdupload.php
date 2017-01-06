<?php include('editortop.php');?>
<?php include('include_dir.php');?>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}

</script>
<script type="text/javascript" language="javascript">
function check(thisform)
{
	<?php
	$id=mysql_real_escape_string($_SESSION['EDITOR']);
	$name=getname($id);
	if(isset($_POST['serfile']))
	{
		$fileno=mysql_real_escape_string($_POST['serfile']);
		$result=mysql_query("SELECT * FROM `file_details` FORCE INDEX (`File_No`)  WHERE `File_No` LIKE '%$fileno%' AND `Third_Editor`='$name'");
	}
	elseif(isset($_POST['date1']))
	{
		$date=$_POST['date1'];
		$result=mysql_query("SELECT * FROM `file_details` FORCE INDEX (`File_No`) WHERE `Date` ='$date' AND `Third_Editor`='$name'");
	}
	else
	{	
		$dat=date('Y-m-d');
		$result=mysql_query("SELECT * FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Date` ='$dat' AND `Third_Editor`='$name'");
	}
	if($result) //if query ok
	{
		$count=mysql_num_rows($result);
		if($count!=0)// if count!=0
		{	
			while($row=mysql_fetch_array($result))
			{
				if($row['Upload_to']=="Third_level")
				{
					echo "if(document.getElementById('uploadto_".$row['File_No']."').value==='-1')
							{
								dhtmlx.alert({title:\"Warning!!!\", text:\"Please choose a Upload to field for ".$row['File_No']."\"});
								return false;
							}";
				}
			}
		}
	}
	?>
thisform.submit();
dhtmlx.message("Saving Please Wait...");

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
        <h2>Upload the Edited file </h2>
              <div id="search_drop" style="margin-left:120px; float:left;">
          		<center>
               <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <input type="text" value="Enter a File No here..." name="serfile" size="10" id="searchfield" title="searchfield" onFocus="clearText(this)" onBlur="clearText(this)" />
                  	<input type="submit" name="Searchid" value="Search" alt="Search" id="Searchid" title="Search" />
                </form>
                </center>
            </div>
               <div id="search_drop" style="margin-left:145px; padding-top:5px; text-align:center; padding-left:10px; float:left; color:#FFFFFF;">
          		<center>
               <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    Select Date&nbsp;:<input type="text" size="7" id="date1" name="date1" value="<?php echo date('Y-m-d');?>" autocomplete="off" />&nbsp;&nbsp;&nbsp;&nbsp;
                  	<input type="submit" name="Searchid" value="Search" alt="Search" id="Searchid" title="Search" style="margin-left:0px;" />
                </form>
                </center>
            </div><br>
<br>

       
<?php
$c=1;
$lc=0;
$r=0;
$id=mysql_real_escape_string($_SESSION['EDITOR']);
$name=getname($id);
if(isset($_POST['serfile']))
{
	$fileno=mysql_real_escape_string($_POST['serfile']);
	$result=mysql_query("SELECT * FROM `file_details` FORCE INDEX (`File_No`)  WHERE `File_No` LIKE '%$fileno%'  AND `Third_Editor`='$name'");
}
elseif(isset($_POST['date1']))
{
	$date=$_POST['date1'];
	$result=mysql_query("SELECT * FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Date` ='$date'  AND `Third_Editor`='$name'");
}
else
{	
	$dat=date('Y-m-d');
	echo "<br><center><table><tr><td class=\"result1\">Details of files picked by you in second level on ".$dat."</td></tr></table></center><br>";
	$result=mysql_query("SELECT * FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Date` ='$dat' AND `Third_Editor`='$name'");
}
	//echo $result;
	if($result) //if query ok
	{
		$count=mysql_num_rows($result);
		if($count!=0)// if count!=0
		{	
			echo "<br><center><label class=\"result\"><u>Search Results</u></label></b><br><br>";
			echo "<form name=\"pick\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\" method=\"post\"  enctype=\"multipart/form-data\">";
			echo "<div style=\"width:860px; height: 500px; border: 0px groove #3b3a3a; overflow: auto;\">";
			echo "<table border=\"1\" cellpadding=\"5\" width=\"780\" align=\"center\" class=\"tab\">";
			echo "<th>S.No.</th><th>Date</th><th>File No</th><th >Uploaded to</th></tr>";	
			while($row=mysql_fetch_array($result))
			{
				echo "<tr class=tr".$r.">";
				echo "<td>".htmlentities($c)."</td>";
				echo "<td style=\"width:100px;\">".htmlentities($row['Date'])."<input type=\"hidden\" name=\"date_chk\" id=\"date_chk\" title=\"date_chk\" size=\"10\" value=\"".$row['Date']."\"></td>";
				echo "<td>".htmlentities($row['File_No'])."</td>";
				if($row['Upload_to']=="Third_level")
				{
					echo "<td>
						<select name=\"uploadto_".$row['File_No']."\" title=\"uploadto_".$row['File_No']."\" id=\"uploadto_".$row['File_No']."\" >
                    	<option selected=\"selected\" value=\"-1\">--Select upload type--</option>
						<option value=\"Hospital/Customer\">Hospital / Customer</option>
						<option value=\"IDS/QA_Checkpoint\">IDS / QA Checkpoint</option>
						</td>";
				}
				else
				{
					echo "<td>".htmlentities($row['Upload_to'])."</td>";
				}
				echo "</tr>";
				$c=$c+1;//for row count
				if($r==0)//for row color
				{
					$r=1;
				}
				else
				{
					$r=0;
				}
			}
			echo "</table><br /></div>
			<input type=\"button\" name=\"save\" id=\"save\" value=\"SAVE\" onclick=\"check(this.form)\"/></form>";
		}
		else//if no record
		{
			echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
		}
}
	else//if not set properly
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry please choose the details correctly !!!</center></h1><br /><br /><br /><br /><br /><br />";
	}
		?>
        
	<?php 
   	
		$id=mysql_real_escape_string($_SESSION['EDITOR']);
		$name=getname($id);
		$flag=0;
		if(isset($_POST['date_chk']))
		{
			$dat=$_POST['date_chk'];
		}
		else
		{
			$dat=date('Y-m-d');
		}
		$result=mysql_query("SELECT * FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Date`='$dat'  AND `Third_Editor`='$name'");
		$count=mysql_num_rows($result);
		if($count!=0)
		{
			while($row1=mysql_fetch_array($result))
			{
				
				if(isset($_POST['uploadto_'.$row1['File_No']]))
				{
					$no=mysql_real_escape_string($row1['File_No']);
					
					$upto=mysql_real_escape_string($_POST['uploadto_'.$row1['File_No']]);
					
					$sql=mysql_query("UPDATE `file_details` SET `Upload_to`='$upto',`uptime_III_level`='$datetime' where `File_No`='$no'");
					if($sql)
					{
						$flag=$flag+1;
					}
				}
			}
			if($flag>0)
			{
				echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Upload Details saved Successfully\",
					callback:function(){
					setTimeout(function(){ window.location = \"thirdupload.php\";}, 0);
					}
				});
				
				</script>";
			}
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
