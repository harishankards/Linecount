<?php include('editortop.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center }
input.button { margin-bottom:0px; width:75px; padding: .2em; text-align:center; cursor:pointer; }
select { margin-bottom:0px; width:165px; padding: .2em; text-align:center }
</style>
</head>
<body> 

<div id="outer_wrapper">
  <div id="wrapper">
		<?php 
        include('main_top.php');
        ?>
        <div id="main"><br>
        <h2>Pick uploaded files of Editors</h2>
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
                    Select Date&nbsp;:&nbsp;&nbsp;<input type="text" id="datepicker" title="Select the Date" name="date1" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" readonly />&nbsp;&nbsp;&nbsp;&nbsp;
                  	<input type="submit" name="Searchid" value="Search" alt="Search" id="Searchid" title="Search" style="margin-left:0px;" />
               </form>
                </center>
            </div><br>
<br>		

<?php
$c=1;
$lc=0;
$r=0;
$name=$_SESSION['idsileditorname'];
if(!isset($_POST['pref'],$_POST['edtrid']) && !isset($_POST['fileno'],$_POST['edtrid']))
{
	
	if(isset($_POST['serfile']))
	{
		$fileno=trim($_POST['serfile']);
		$result=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Editedby`,`Third_level`,`Third_Editor`,`Upstatus`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `File_No` AND `Editedby`!='$name' LIKE '%$fileno%' LIMIT 0 , 2");
	}
	elseif(isset($_POST['date1']))
	{
		$date=trim($_POST['date1']);
		$result=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Editedby`,`Third_level`,`Third_Editor`,`Upstatus`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Date` ='$date' AND `Upload_to`='Third_level' AND `Editedby`!='$name' LIMIT 0 , 10");
	}
	else
	{	
		$dat=date('Y-m-d');
		$chk_count=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Editedby`,`Third_level`,`Third_Editor`,`Upstatus`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Upload_to`='Third_level' AND `Editedby`!='$name' AND `Third_Editor`='$name'");
		$count=mysql_num_rows($chk_count);
		//echo $count.$name;
		if($count>0)
		{
			$result=$chk_count;
		}
		else
		{
			$result=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Editedby`,`Third_level`,`Third_Editor`,`Upstatus`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE  `Date`='$dat' AND `Upload_to`='Third_level' AND `Editedby`!='$name' LIMIT 0 , 10");
		}
		echo "<center><br><table align=\"center\" width=\"400\"><tr><td class=\"show\">Details of files uploaded by the Editor</td></tr></table></center><br>";
	}
		//echo $result;
		if($result) //if query ok
		{
			$count=mysql_num_rows($result);
			if($count!=0)// if count!=0
			{	
				echo "<center><br><label class=\"result\"><u>Search Results</u></label></b><br><br>";
				echo "<div style=\"width:880px; height: auto; border: 0px groove #3b3a3a; overflow: auto;\">";
				echo "<table border=\"1\" width=\"860\" class=\"text ui-widget-content ui-corner-all tab\" cellpadding=\"3\" cellspacing=\"0\">";
				echo "<th>S.No.</th><th>Date</th><th>Hospital</th><th>File No</th><th>Line count</th><th>Edited By</th><th>Picked by</th><th>Upload to</th>";
				while($row=mysql_fetch_array($result))
				{
					echo "<tr class=tr".$r.">";
					echo "<td>".htmlentities($c)."</td>";
					echo "<td>".htmlentities($row['Date'])."</td>";
					echo "<td>".htmlentities($row['Hospital'])."</td>";
					echo "<td>".$row['File_No']."</td>";
					echo "<td>".htmlentities($row['Linecount'])."</td>";
					echo "<td>".htmlentities($row['Editedby'])."</td>";
					$f_no=trim($row['File_No']);
					if($row['Upload_to']=="Third_level")
					{
						echo "<script>
						function call_file".$f_no."(thisform)
						{
							if(document.getElementById('fuploadto_".$f_no."').value==='-1')
							{
								dhtmlx.alert({title:\"Warning!!!\", text:\"Please choose a Upload to field for ".$f_no."\"});
								return false;
							}
							else
							{
								thisform.submit();
							}
						}</script>";
					}
					if(($row['Third_level']=='YES')&& ($row['Third_Editor']=='Not yet Edited'))
					{
					Print "<td align=\"center\" ><form name=\"pick".$row['File_No']."\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\" method=\"post\"><table align=\"center\"><tr><td>".htmlentities($row['Upstatus'])."</td><td>
					<input type=\"hidden\" name=\"pref\" value=\"".htmlentities($row['File_No'])."\">
					<input type=\"hidden\" id=\"edtrid\" name=\"edtrid\" value=\"".htmlentities($_SESSION['EDITOR'])."\">
					<input type=\"submit\" name=\"pick\" id=\"pick\" class=\"button\" value=\"PICK\" onclick=\"return confirmpick(this.form)\"/></td></tr></table></form></td>";
					}
					else
					{
						Print "<td align=\"center\" >".htmlentities($row['Third_Editor'])."</td>";
					}
					$name=$_SESSION['idsileditorname'];
					if(($row['Upload_to']=='Third_level')&&(strtoupper($row['Third_Editor'])==$name))
					{
						echo "<td align=\"center\">
							<form name=\"uploadto_".trim($row['File_No'])."\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\" method=\"post\">
							<table align=\"center\">
							<tr align=\"center\">
							<td>
							<input type=\"hidden\" name=\"fileno\" id=\"fileno\" title=\"fileno\" size=\"15\" value=\"".trim($row['File_No'])."\">
							<input type=\"hidden\" id=\"upedtrid\" name=\"edtrid\" value=\"".htmlentities($_SESSION['EDITOR'])."\">
							<select name=\"uploadto\" title=\"uploadto_".trim($row['File_No'])."\" id=\"fuploadto_".trim($row['File_No'])."\" class=\"text ui-widget-content ui-corner-all button\">
							<option selected=\"selected\" value=\"-1\">--Select upload type--</option>
							<option value=\"Hospital/Customer\">Hospital / Customer</option>
							<option value=\"IDS/QA_Checkpoint\">IDS / QA Checkpoint</option>
							</td>
							<td>
							<input type=\"button\" name=\"upload\" id=\"upload\" value=\"Save\" onclick=\"call_file".trim($row['File_No'])."(this.form)\" class=\"button\" />
							</td>
							</tr>
							</table>
							</form>
							</td>";
					}
					else
					{
						echo "<td>".htmlentities($row['Upload_to'])."</td>";
					}
					echo "</tr></form>";
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
				echo "</table></div>";
	
				Print "<script type=\"text/javascript\" language=\"javascript\">
							function confirmpick(thisform)
							{
								if (confirm('Are you sure ? You want to pick this job ?'))
								{
									thisform.submit();
								}
								else
								{
									return false;
								}
							}
							</script>";
			}
			else//if no record
			{
				echo "<br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br />";
			
			}
	}
		else//if not set properly
		{
			echo "<br /><br /><h1><center>Sorry please choose the details correctly !!!</center></h1><br /><br /><br />";
		}
	
}
		?>
        <br />
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
        
        <?php 
		if(isset($_POST['pref'],$_POST['edtrid']))
		{
			if(!(isset($_POST['pref']))=="0")
			{		
				//include ('dbconf.php');
				$value=trim($_POST['pref']);
				$name=$_SESSION['idsileditorname'];
					$ck_sql=mysql_query("SELECT `File_No` FROM `file_details` FORCE INDEX (`File_No`) WHERE `File_No`='$value' AND `Third_Editor`='Not yet Edited'");
					$count=mysql_num_rows($ck_sql);
					if($count==1)
					{
						$sql=mysql_query("UPDATE `file_details` SET `Third_Editor`='$name',`pick_time_III_level`='$datetime' where `File_No`='$value'");
						if($sql)
						{
							$uploadby=$name;
							$fp = fopen($log_dir.$uploadby.".txt", "a+");
							$comment=$id." has Picked a file ".$value." in Third Level in IDSIL / PJO";
							fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
							fclose($fp);
							echo "<script> setTimeout(function(){ window.location = \"thirdlevel.php\";}, 0);</script>";
						}
					}
					else
					{
						echo "<script> dhtmlx.alert({
							title:\"Opps !!!\",
							ok:\"Ok\",
							text:\"Sorry File is already picked by someone.\",
							callback:function(){
							setTimeout(function(){ window.location = \"thirdlevel.php\";}, 0);
							}
						});
						
						</script>";
					}
				
			}
			else
			{
				echo "<script> alert('Please choose the data !!!');</script>";
			}
		}
		if(isset($_POST['fileno'],$_POST['edtrid']))
		{
			
			if(!(isset($_POST['fileno']))=="0")
			{		
				
				//include ('dbconf.php');
				$value=trim($_POST['fileno']);
				$name=$_SESSION['idsileditorname'];
				
					$ck_sql=mysql_query("SELECT `File_No` FROM `file_details` FORCE INDEX (`File_No`) WHERE `File_No`='$value' AND `Upload_to`='Third_level'");
					$count=mysql_num_rows($ck_sql);
					if($count==1)
					{
						$upto=mysql_real_escape_string($_POST['uploadto']);
						$ac="98";
						$comm="No Comments";
						if($upto=="Third_level")
						{
							$third="YES";
							$thirdeditor='Not yet Edited';
						}
						else
						{
							$third="NO";
							$thirdeditor='No Third Editing';
						}
						$sql=mysql_query("UPDATE `file_details` SET `Upload_to`='$upto',`uptime_III_level`='$datetime' where `File_No`='$value'");
						if($sql)
						{
							$uploadby=$name;
							$fp = fopen($log_dir.$uploadby.".txt", "a+");
							$comment=$id." has uploaded a file ".$value." in Third Level to ".$upto." in IDSIL / PJO";
							fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
							fclose($fp);
							echo "<script> setTimeout(function(){ window.location = \"thirdlevel.php\";}, 0);</script>";
						}
						
					}
					else
					{
						echo "<script> dhtmlx.alert({
							title:\"Opps !!!\",
							ok:\"Ok\",
							text:\"Sorry File is already picked by someone.\",
							callback:function(){
							setTimeout(function(){ window.location = \"thirdlevel.php\";}, 0);
							}
						});
						</script>";
					}
			}
			else
			{
				echo "<script> alert('Please choose the data !!!');</script>";
			}
		}
		?>

</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
