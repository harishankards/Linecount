<?php include('editortop.php');?>
<script type="text/javascript" language="javascript">
<?php
$id=mysql_real_escape_string($_SESSION['EDITOR']);
$name=getname($id);
if(isset($_POST['serfile']))
{
	$fileno=trim($_POST['serfile']);
	$result=mysql_query("SELECT `File_No`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `File_No` LIKE '%$fileno%' LIMIT 0 , 5");
}
elseif(isset($_POST['date1']))
{
	$date=trim($_POST['date1']);
	$result=mysql_query("SELECT `File_No`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Date` ='$date' AND `Editedby`='Not yet Edited' OR `Upload_to`='Not yet Edited' LIMIT 0 , 15");
}
else
{	
	$dat=date('Y-m-d');
	$chk_count=mysql_query("SELECT `File_No`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Editedby`='$name' AND `Upload_to`='Not yet Edited' LIMIT 0,10");
	$count=mysql_num_rows($chk_count);
	//echo $count.$name;
	if($count>0)
	{
		$result=$chk_count;
	}
	else
	{
		$result=mysql_query("SELECT `File_No`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Date` ='$dat' AND `Editedby`='Not yet Edited' OR  `Upload_to`='Not yet Edited' LIMIT 0 , 15");
	}
}
if($result) //if query ok
	{
		$count=mysql_num_rows($result);
		if($count!=0)// if count!=0
		{	
			while($row=mysql_fetch_array($result))
			{
				$f_no=trim($row['File_No']);
				if($row['Upload_to']=="Not yet Edited")
				{
					echo "
					function call_file".$f_no."(thisform)
					{
						if(document.getElementById('uploadto_".$f_no."').value==='-1')
						{
							dhtmlx.alert({title:\"Warning!!!\", text:\"Please choose a Upload to field for ".$f_no."\"});
							return false;
						}
						else
						{
							thisform.submit();
						}
					}";
				}
			}
		}
	}
	?>
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
	$fileno=trim($_POST['serfile']);
	$result1=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Uploadedby`,`Editedby`,`Upstatus`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `File_No` LIKE '%$fileno%' LIMIT 0 , 5");
}
elseif(isset($_POST['date1']))
{
	$date=trim($_POST['date1']);
	$result1=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Uploadedby`,`Editedby`,`Upstatus`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Date` ='$date' AND `Editedby`='Not yet Edited' OR `Upload_to`='Not yet Edited' LIMIT 0 , 15");
}
else
{	
	$dat=date('Y-m-d');
	$chk_count1=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Uploadedby`,`Editedby`,`Upstatus`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Editedby`='$name' AND `Upload_to`='Not yet Edited' LIMIT 0,15");
	$count1=mysql_num_rows($chk_count1);
	//echo $count.$name;
	if($count1>0)
	{
		$result1=$chk_count1;
	}
	else
	{
		$result1=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Uploadedby`,`Editedby`,`Upstatus`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Editedby`='Not yet Edited' AND `Upload_to`='Not yet Edited' LIMIT 0 , 15");
	}
	echo "<center><br><table align=\"center\" width=\"400\"><tr><td class=\"show\">Details of files uploaded by the MLS </td></tr></table></center><br>";
}
	//echo $result;
	if($result1) //if query ok
	{
		$count=mysql_num_rows($result1);
		if($count!=0)// if count!=0
		{	
			echo "<center><br><label class=\"result\"><u>Search Results</u></label></b><br><br>";
			echo "<div style=\"width:880px; height: auto; border: 0px groove #3b3a3a; overflow: auto;\">";
			echo "";
			echo "<table border=\"1\" cellpadding=\"2\" width=\"780\" align=\"center\" class=\"tab\">";
			echo "<th>S.No.</th><th>Date</th><th>Hospital</th><th>File No</th><th>Line count</th><th>Uploaded By</th><th>Picked by</th><th>Upload to</th>";
			while($row=mysql_fetch_array($result1))
			{
				echo "<tr class=tr".$r.">";
				echo "<td>".htmlentities($c)."</td>";
				echo "<td>".htmlentities($row['Date'])."</td>";
				echo "<td>".htmlentities($row['Hospital'])."</td>";
				echo "<td>".$row['File_No']."</td>";
				echo "<td>".htmlentities($row['Linecount'])."</td>";
				echo "<td>".htmlentities($row['Uploadedby'])."</td>";
				
				if($row['Editedby']=='Not yet Edited')
				{
				Print "<td><form name=\"pick".$row['File_No']."\" action=\"edit_update.php\" method=\"post\">".htmlentities($row['Upstatus'])."<br>
				<input type=\"hidden\" name=\"pref\" value=\"".htmlentities($row['File_No'])."\">
				<input type=\"hidden\" id=\"edtrid\" name=\"edtrid\" value=\"".htmlentities($_SESSION['EDITOR'])."\">
				<input type=\"submit\" name=\"pick\" id=\"pick\" class=\"button\" value=\"Pick\" onclick=\"return confirmpick(this.form)\"/></form></td>";
				}
				else
				{
					Print "<td align=\"center\" >".htmlentities($row['Editedby'])."</td>";
				}
				$id=mysql_real_escape_string($_SESSION['EDITOR']);
				$name=getname($id);
				if($row['Editedby']==$name)
				{
					$file_no=trim($row['File_No']);
					if($row['Upload_to']=="Not yet Edited" && $row['Hospital']!="NEWPORTBAY")
					{
						echo "<td>
							<form name=\"uploadto_".$file_no."_form\" action=\"edit_update.php\" method=\"post\">
							<table>
							<tr>
							<td style=\"border:0px;\">
							<input type=\"hidden\" name=\"fileno\" id=\"fileno\" title=\"fileno\" size=\"15\" value=\"".$file_no."\">
							<input type=\"hidden\" id=\"upedtrid\" name=\"edtrid\" value=\"".htmlentities($_SESSION['EDITOR'])."\">
							<select name=\"uploadto\" title=\"uploadto_".$file_no."\" id=\"uploadto_".$file_no."\" >
							<option selected=\"selected\" value=\"-1\">--Select upload type--</option>
							<option value=\"Hospital/Customer\">Hospital / Customer</option>
							<option value=\"IDS/QA_Checkpoint\">IDS / QA Checkpoint</option>
							<option value=\"Third_level\">Third Level </option>
							</td>
							<td style=\"border:0px;\">
							<input type=\"button\" name=\"upload\" id=\"upload\" value=\"Save\" onclick=\"call_file".$file_no."(this.form)\"/>
							</td>
							</tr>
							</table>
							</form>
							</td>";
					}
					elseif($row['Upload_to']=="Not yet Edited"&& $row['Hospital']=="NEWPORTBAY")
					{
						echo "<td>
							<form name=\"uploadto_".$file_no."_form\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\" method=\"post\">
							<table>
							<tr>
							<td style=\"border:0px;\">
							<input type=\"hidden\" name=\"fileno\" id=\"fileno\" title=\"fileno\" size=\"15\" value=\"".$file_no."\">
							<input type=\"hidden\" id=\"upedtrid\" name=\"edtrid\" value=\"".htmlentities($_SESSION['EDITOR'])."\">
							<select name=\"uploadto\" title=\"uploadto_".$file_no."\" id=\"uploadto_".$file_no."\" >
							<option selected=\"selected\" value=\"-1\">--Select upload type--</option>
							<option value=\"Hospital/Customer\">Hospital / Customer</option>
							<option value=\"Blank\">Blank</option>
							<option value=\"Full_Proof\">Full proof</option>
							</td>
							<td style=\"border:0px;\">
							<input type=\"button\" name=\"upload\" id=\"upload\" value=\"Save\" onclick=\"call_file".$file_no."(this.form)\"/>
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
		?>
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
    <?php
	include('dbconfig.php');
	if(!isset($_SESSION['limit']))
	{
		$note_sql=mysql_query("SELECT * FROM `notes` WHERE `Date`='$date_only'");
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
