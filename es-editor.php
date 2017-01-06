<?php include('es-editortop.php');
$id=mysql_real_escape_string($_SESSION['ES-EDITOR']);
if(!isset($_SESSION['eseditorname']))
{
	$_SESSION['eseditorname']=getname($id);
	$name=mysql_real_escape_string($_SESSION['eseditorname']);
}
else
{
	$name=mysql_real_escape_string($_SESSION['eseditorname']);
}
?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center }
#p_id { margin-bottom:0px; width:95px; padding: .2em; text-align:center; text-transform:uppercase; }
input.button { margin-bottom:0px; width:75px; padding: .2em; text-align:center; cursor:pointer; }
select { margin-bottom:0px; width:165px; padding: .2em; text-align:left; }
.mtcomm{ color:#3399FF; font-size:12px;}
</style>
<script>
function setpid()
{
	if(document.getElementById('p_id').value==='Please SET')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Escroption ID"});
		return false;
	}
	else
	{
		return true;
	}
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
        <h2>Pick uploaded files of MLS </h2>
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
                    Select Date&nbsp;:&nbsp;<input type="text" id="datepicker" title="Select the Date" name="date1" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" readonly />&nbsp;&nbsp;&nbsp;&nbsp;
                  	<input type="submit" name="Searchid" value="Search" alt="Search" id="Searchid" title="Search" style="margin-left:0px;" />
               </form>
                </center>
            </div><br>
<br>		
<?php
$c=1;
$lc=0;
$r=0;
if(isset($_POST['p_id']))
{
	$temp_id=$_POST['p_id'];
	$check_id=mysql_query("SELECT `User_ID` FROM `escript_id` WHERE `User_ID`='$temp_id'");
	$check_row=mysql_num_rows($check_id);
	if($check_row=='1')
	{
		$_SESSION['ES_Editor_pid']=strtoupper($_POST['p_id']);
	}
	else
	{
		echo "<script> dhtmlx.alert({
				title:\"Opps !!!\",
				ok:\"Ok\",
				text:\"Sorry Escription ID Doesnt Exist.\",
				callback:function(){
				
				}
			});
			
			</script>";
	}
}

if(!isset($_POST['pref'],$_POST['edtrid']) && !isset($_POST['fileno'],$_POST['upedtrid'],$_POST['uploadto']))
{
	if(isset($_POST['serfile']))
	{
		$fileno=trim($_POST['serfile']);
		$result=mysql_query("SELECT `Date`,`Hospital`,`Platform_ID`,`File_No`,`Linecount`,`MT`,`Pending_Reason`,`MT_Comment`,`DSP/NONDSP`,`QC`,`Upload_to` FROM `escript_filedetails` FORCE INDEX (`File_No`)  WHERE `File_No` LIKE '%$fileno%' AND `MT`!='$name' LIMIT 0 , 5");
	}
	elseif(isset($_POST['date1']))
	{
		$date=trim($_POST['date1']);
		$result=mysql_query("SELECT `Date`,`Hospital`,`Platform_ID`,`File_No`,`Linecount`,`MT`,`Pending_Reason`,`MT_Comment`,`DSP/NONDSP`,`QC`,`Upload_to` FROM `escript_filedetails` FORCE INDEX (`File_No`)  WHERE `Date` ='$date' AND `QC`='Not Yet Picked' AND `Upload_to`='Not yet Edited' AND `MT`!='$name' LIMIT 0 , 15");
	}
	else
	{	
		$dat=date('Y-m-d');
		$chk_count=mysql_query("SELECT `Date`,`Hospital`,`Platform_ID`,`File_No`,`Linecount`,`MT`,`QC`,`Pending_Reason`,`MT_Comment`,`DSP/NONDSP`,`Upload_to` FROM `escript_filedetails` FORCE INDEX (`File_No`)  WHERE `QC`='$name' AND `Upload_to`='Not yet Edited' AND `MT`!='$name' LIMIT 0,15");
		$count=mysql_num_rows($chk_count);
		if($count>0)
		{
			$result=$chk_count;
		}
		else
		{
			$result=mysql_query("SELECT `Date`,`Hospital`,`Platform_ID`,`File_No`,`Linecount`,`MT`,`Pending_Reason`,`MT_Comment`,`DSP/NONDSP`,`QC`,`Upload_to` FROM `escript_filedetails` FORCE INDEX (`File_No`)  WHERE `QC`='Not Yet Picked' AND `Upload_to`='Not yet Edited' AND `MT`!='$name' LIMIT  0 , 15");
		}
		echo "<center><br><table align=\"center\" width=\"400\"><tr><td class=\"show\">Details of files uploaded by the MLS </td></tr></table></center><br>";
	}
		if($result) //if query ok
		{
			$count=mysql_num_rows($result);
			if($count!=0)// if count!=0
			{	
				echo "<table><tr>
					<td colspan=\"9\" class=\"bold\">";
					if(isset($_SESSION['ES_Editor_pid']))
					{
						$p_id=$_SESSION['ES_Editor_pid'];
						echo "<form name=\"setid\" action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">EScription ID&nbsp;&nbsp;:&nbsp;&nbsp;<input type=\"text\" name=\"p_id\" id=\"p_id\" size=\"15\" maxlength=\"15\" onFocus=\"clearText(this)\" onBlur=\"clearText(this)\" value=\"".$p_id."\" class=\"text ui-widget-content ui-corner-all button\"><input type=\"submit\" value=\"Change ID\" onclick=\"return setpid();\"></form>";
						
					}
					else
					{
						$p_id='Please SET';
						echo "<form name=\"setid\" action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">EScription ID&nbsp;&nbsp;:&nbsp;&nbsp;<input type=\"text\" name=\"p_id\" id=\"p_id\" size=\"15\" maxlength=\"15\" onFocus=\"clearText(this)\" onBlur=\"clearText(this)\" value=\"".$p_id."\" class=\"text ui-widget-content ui-corner-all button\"><input type=\"submit\" value=\"Save ID\" onclick=\"return setpid();\"></form>";
					}
				   echo "</td></tr></table>";
				echo "<center><br><label class=\"result\"><u>Search Results</u></label></b><br><br>";
				echo "<div style=\"width:900px; height: auto; border: 0px groove #3b3a3a; overflow: auto;\">";
				echo "<table border=\"1\" width=\"880\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\" cellpadding=\"2\" cellspacing=\"0\">";
				echo "<tr class=\"ui-widget-header\"><th>S.No.</th><th>Date</th><th>Hospital</th><th>Escriptionist ID</th><th>File No</th><th>Line count</th><th>Uploaded By</th><th>Picked by</th><th>Upload to</th></tr>";
				
				while($row=mysql_fetch_array($result))
				{
					echo "<tr class=tr".$r.">";
					echo "<td>".htmlentities($c)."</td>";
					echo "<td>".htmlentities($row['Date'])."</td>";
					echo "<td>".htmlentities($row['Hospital'])."</td>";
					echo "<td>".htmlentities($row['Platform_ID'])."<br>(".htmlentities($row['DSP/NONDSP']).") </td>";
					echo "<td>".$row['File_No']."</td>";
					echo "<td>".htmlentities($row['Linecount'])."</td>";
					echo "<td>".htmlentities($row['MT'])."<br><strong>MT Comment:</strong><span class=\"mtcomm\">".htmlentities($row['MT_Comment'])."</td>";
					
					if($row['QC']=='Not Yet Picked')
					{
					Print "<td><form name=\"pick".$row['File_No']."\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\" method=\"post\"><table align=\"center\"><tr><td width=\"80\"><span style=\"color:#FF0000;\">".htmlentities($row['MT_Comment'])."</span></td><td>
					<input type=\"hidden\" name=\"pref\" value=\"".htmlentities($row['File_No'])."\">
					<input type=\"hidden\" id=\"edtrid\" name=\"edtrid\" value=\"".$_SESSION['eseditorname']."\">
					<input type=\"button\" name=\"pick\" id=\"pick\" class=\"button\" value=\"Pick\" onclick=\"return confirmpick(this.form)\"/></td></tr></table></form></td>";
					}
					else
					{
						Print "<td align=\"center\" >".htmlentities($row['QC'])."</td>";
					}
					if($row['QC']==$name)
					{
						$file_no=trim($row['File_No']);
						if($row['Upload_to']=="Not Yet Edited")
						{
							echo "<td align=\"center\">
								<form name=\"uploadto_".$file_no."_form\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\" method=\"post\">
								<table align=\"center\">
								<tr><td><textarea name=\"comment\" id=\"comment_".$file_no."\" rows=\"3\" cols=\"20\" title=\"Add comment for ".$file_no."\" class=\"text ui-widget-content ui-corner-all\"></textarea></td><td style=\"border:0px;\" rowspan=\"3\">
								<input type=\"button\" name=\"upload\" id=\"upload\" value=\"Save\" onclick=\"call_file".$file_no."(this.form)\" style=\"height:90px; width:50px;\"/>
								</td>
								</tr>
								<tr>
								<td colspan=\"2\">
								<div id=\"ratings\">
									<input type=\"radio\" name=\"rate\" id=\"radio1\" value=\"1\" ><label for=\"radio1\" title=\"Very poor\">1</label>
                            		<input type=\"radio\" name=\"rate\" id=\"radio2\" value=\"2\"><label for=\"radio2\" title=\"Poor\">2</label>
									<input type=\"radio\" name=\"rate\" id=\"radio3\" value=\"3\" ><label for=\"radio3\" title=\"Moderate\">3</label>
									<input type=\"radio\" name=\"rate\" id=\"radio4\" value=\"4\"><label for=\"radio4\" title=\"Good\">4</label>
									<input type=\"radio\" name=\"rate\" id=\"radio5\" value=\"5\" ><label for=\"radio5\" title=\"Very good\">5</label>
								</div>
								</td>
								</tr>
								<tr align=\"center\">
								<td style=\"border:0px;\">
								<input type=\"hidden\" name=\"fileno\" id=\"fileno\" title=\"fileno\" size=\"15\" value=\"".$file_no."\">
								<input type=\"hidden\" id=\"upedtrid\" name=\"upedtrid\" value=\"".htmlentities($_SESSION['eseditorname'])."\">
								<select name=\"uploadto\" title=\"uploadto_".$file_no."\" id=\"uploadto_".$file_no."\" class=\"text ui-widget-content ui-corner-all\">
								<option selected=\"selected\" value=\"-1\">--Select upload type--</option>
								<option value=\"Hospital/Customer\">Hospital / Customer</option>
								<option value=\"Senior QC\">Senior QC</option>
								</select>
								</td>
								</tr>
								</table>
								</form>
								</td>";
								$f_no=trim($row['File_No']);
								if($row['Upload_to']=="Not Yet Edited")
								{
									echo "<script>
									function call_file".$f_no."(thisform)
									{
										if(document.getElementById('uploadto_".$f_no."').value==='-1')
										{
											dhtmlx.alert({title:\"Warning!!!\", text:\"Please choose a Upload to field for ".$f_no."\"});
											return false;
										}
										if(document.getElementById('comment_".$f_no."').value==='')
										{
											dhtmlx.alert({title:\"Warning!!!\", text:\"Please add comment for ".$f_no."\"});
											return false;
										}
										var don = document.getElementsByName('rate');
										var count=0;
										for(var i=0;i<don.length;i++)
										{
												if(!don[i].checked)
											{
												count=count+1;
											}
										}
										if(count==5)
										{
											dhtmlx.alert({title:\"Warning!!!\", text:\"Please rate this file\"});
											return false;
										}
										else
										{
											thisform.submit();
										}
									}</script>";
								}
						}
						else
						{
							echo "<td>".htmlentities($row['Upload_to'])."</td>";
						}
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
								var check=setpid();
								if(check)
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
								else
								{
									return false;
								}
							}
							</script>";
				echo "<br /><center>* If your JOB NO is not in the above list, please use <b>\"File search\"</b>.</center>";
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
	
}
		?>
        
        <?php 
		if(isset($_POST['pref'],$_POST['edtrid']))
		{
			if(!(isset($_POST['pref']))=="0")
			{		
				$value=trim($_POST['pref']);
				$name_pos=mysql_real_escape_string($_POST['edtrid']);
				$ck_sql=mysql_query("SELECT * FROM `escript_filedetails` FORCE INDEX (`File_No`) WHERE `File_No`='$value' AND `QC`='Not Yet Picked'");
				$count=mysql_num_rows($ck_sql);
				if($count==1)
				{
					$qcid=$_SESSION['ES_Editor_pid'];
					$sql=mysql_query("UPDATE `escript_filedetails` SET `QC`='$name_pos',`QC_Platform_ID`='$qcid' where `File_No`='$value'");
					$uploadby=$name_pos;
					$fp = fopen($log_dir.$uploadby.".txt", "a+");
					$comment=$id." has picked a file ".$value." in Escription";
					fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
					echo "<script> setTimeout(function(){ window.location = \"es-editor.php\";}, 0);</script>";
				}
				else
				{
					echo "<script> dhtmlx.alert({
						title:\"Opps !!!\",
						ok:\"Ok\",
						text:\"Sorry File is already picked by someone.\",
						callback:function(){
						setTimeout(function(){ window.location = \"es-editor.php\";}, 0);
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
		if(isset($_POST['fileno'],$_POST['upedtrid'],$_POST['uploadto'],$_POST['comment']))
		{
			if(!(isset($_POST['fileno']))=="0")
			{		
				$value=trim($_POST['fileno']);
				$name_pos=mysql_real_escape_string($_POST['upedtrid']);
				$ck_sql=mysql_query("SELECT * FROM `escript_filedetails` FORCE INDEX (`File_No`) WHERE `File_No`='$value' AND `Upload_to`='Not yet Edited'");
				$count=mysql_num_rows($ck_sql);
				if($count==1)
				{
					$qcid=$_SESSION['ES_Editor_pid'];
					$qc_comm=mysql_real_escape_string($_POST['comment']);
					$qc_rate=mysql_real_escape_string($_POST['rate']);
					$qc_rate=$qc_rate." Star";
					$upto=mysql_real_escape_string($_POST['uploadto']);
					$sql=mysql_query("UPDATE `escript_filedetails` SET `Upload_to`='$upto',`QC_Platform_ID`='$qcid',`QC_ratings`='$qc_rate',`QC_Comment`='$qc_comm',`Time_by_qc`='$datetime' where `File_No`='$value' AND `QC`='$name_pos'");
					if($sql)
					{
						$uploadby=$name_pos;
						$fp = fopen($log_dir.$uploadby.".txt", "a+");
						$comment=$id." has uploaded a file ".$value." to ".$upto." in Escription";
						fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
						fclose($fp);
						echo "<script> setTimeout(function(){ window.location = \"es-editor.php\";}, 0);</script>";
					}
					
				}
				else
				{
					echo "<script> dhtmlx.alert({
						title:\"Opps !!!\",
						ok:\"Ok\",
						text:\"Sorry File is already picked by someone.\",
						callback:function(){
						setTimeout(function(){ window.location = \"es-editor.php\";}, 0);
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
		mysql_close($con);
		?>
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
    
	<script>
	$(function() {
		$( "#ratings" ).buttonset();
	});
	</script>
    
    <?php
	include('dbconfig.php');
	if(!isset($_SESSION['limit']))
	{
		$note_sql=mysql_query("SELECT `Note` FROM `notes` WHERE `Date`='$date_only'");
		$note_count=mysql_num_rows($note_sql);
		if($note_count!=0)
		{
			while($note_row=mysql_fetch_array($note_sql))
			{
				
				if($note_row['Note']!='')
				{
					$msg=trim($note_row['Note']);
					$string = preg_replace("/\s+/"," ",$msg);
					if(!strpos("+",$string))
					{
					 $pattern = array("/^[\s+]/","/[\s+]$/","/\s/");
					 $replace = array("",""," ");
					 $string = preg_replace($pattern,$replace,$string);
					}
					echo "<script>
					dhtmlx.modalbox({ 
					text:\"".$string."\",
					width:\"500px\",
					position:\"top\",
					buttons:[\"Ok\"]
					});</script>";
				}
			}
			$_SESSION['limit']=1;
		}	
	}
	?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>
