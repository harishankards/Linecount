<?php include('editortop.php');?>
<style>
input.text { margin-bottom:0px; width:165px; padding: .2em; text-align:left; }
#datepicker { margin-bottom:0px; width:80px; padding: .2em; text-align:center; }
input.button { margin-bottom:0px; width:75px; padding: .2em; text-align:center; cursor:pointer; }
select { margin-bottom:0px; width:170px; padding: .2em; text-align:center }
.target { font-size:40px; color:#00CCFF; font:Georgia, "Times New Roman", Times, serif; text-align:center; }
.target_to_achieve { font-size:40px; color:#FF0000; font:Georgia, "Times New Roman", Times, serif; text-align:center;}
.tar { font-size:16px; color:#FF9933; font:Georgia, "Times New Roman", Times, serif; text-align:left; line-height:20px; padding:0px; letter-spacing:1px; }
.poptar { font-size:12px; color:#FF9933; font:Georgia, "Times New Roman", Times, serif; text-align:center; }
.poptarget { font-size:30px; color:#00CCFF; font:Georgia, "Times New Roman", Times, serif; text-align:center; }
.headings { font-size:15px; color:#0099FF; font:Georgia, "Times New Roman", Times, serif; text-align:left; }
.mess{ color:#FF0000; }
a, a:link, a:visited {
	color: #FF9933; text-align:center;
}
.clr{
color:#6666FF;
font-size:15px;
}
fieldset { padding:0; border:0; margin-top:25px; }
#panel1_display{
position:fixed;
float:right;
padding-left:10px;
}
</style>
</head>
<body>
<div id="outer_wrapper">
  <div id="wrapper">
  
		<?php 
        include('main_top.php');
        ?>
        <div id="main">
         <?php
			 $t_lc=0;
			 $m_lc=0;
			 $total_target=0;
			 $check_count=0;
			 $m_count=0;
			 $t_count=0;
			 $file_count=0;
			 $dat=date('Y-m-d');
			 $id=mysql_real_escape_string($_SESSION['EDITOR']);
			 $profile_chk=mysql_query("SELECT `Edit_target` FROM `editor_profile` WHERE `ID` ='$id'");
			 $check_count=mysql_num_rows($profile_chk);
			 if($check_count!=0)
			 {
			 	 while($p_row=mysql_fetch_array($profile_chk))
				 {
				 	$target=$p_row['Edit_target'];
				 }
				 $upload_by=$_SESSION['EMP_NAME_ID'];
				 $result=mysql_query("SELECT `Linecount` FROM `file_details` FORCE INDEX (`File_No`) WHERE `Date`='$dat' AND	`Editedby`='$upload_by'");
				 $missing=mysql_query("SELECT `Linecount` FROM `missing_files` WHERE `Date`='$dat' AND	`Edit_by`='$upload_by'");
				 $m_count=mysql_num_rows($missing);
				 $target=$target;
				 $t_count=mysql_num_rows($result);
				 $file_count=$m_count+$t_count;
				 echo "<table align=\"center\"><tr>";
				 echo "<td><div class=\"ui-widget-content ui-corner-all clr\" style=\"margin-top:0px;\"><table style=\"padding:10px;\"><tr align=\"left\"><td align=\"left\">Total No. of. Files</td><td>:</td><td>".$file_count."</td></tr></table></div></td> ";
				 echo "<td><div class=\"ui-widget-content ui-corner-all\" style=\"margin-top:0px; padding:7px;\"><table cellspacing=\"2\" align=\"center\">";
				 if( ($t_count!=0) || ($m_count!=0) )
				 {
					while($t_row=mysql_fetch_array($result))
					{
						$t_lc=$t_lc+$t_row['Linecount'];
					}
					
					while($m_row=mysql_fetch_array($missing))
					{
						$m_lc=$m_lc+$m_row['Linecount'];
					}
					$toachieve=$target-$t_lc-$m_lc;
					$total_target=$t_lc+$m_lc;
					if($toachieve>=0)
					{
						echo "<tr align=\"left\"><td align=\"left\"><p class=\"tar\">You have achieved</p></td><td><span class=\"target\">&nbsp;".$total_target.", </span></td> ";
						echo "<td align=\"left\"><p class=\"tar\">Still you have to achieve</p></td><td><span class=\"target_to_achieve\">&nbsp;".$toachieve."</span></td></tr>";
					}
					else
					{
						echo "<tr align=\"left\"><td align=\"left\"><p class=\"tar\">you have achieved your target</p></td><td><p class=\"target\">".$total_target."</p></td></tr>";
					}
					
				 } 
				 else
				 {
					  echo "<tr><td><p class=\"tar\">Still you have to achieve</p></td><td><span class=\"target_to_achieve\">&nbsp;".$target."</span></td></tr></p> ";
				 }
				 echo "</table></div></td></tr></table>";
			  }
			  else
			  {
					echo "<table cellspacing=\"10\" cellpadding=\"1\" align=\"center\"><tr align=\"left\"><td align=\"left\"><p class=\"tar\">Please Update your Profile </p></td><td><center><button id=\"update_profile\">Create Profile</button></center></td></tr></table>";
			 ?>
              <div id="dialog-form" title="Profile details">
              <form id="createprofileform" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                  <fieldset>
                  <p class="validateTips">All form fields are required.</p>
                     <table cellpadding="2" align="center" cellspacing="2">
          
          	<tr>
                <td>User ID</td>
                <td>:</td>
                <td><input type="text" name="e_id" id="e_id" size="28" Value="<?php echo $_SESSION['EDITOR'];?>" class="text ui-widget-content ui-corner-all" autocomplete="off" readonly/></td>
                <td></td>
            </tr>
            
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><input type="text" name="e_name" id="e_name" size="28" Value="<?php echo $_SESSION['EMP_NAME_ONLY'];?>" class="text ui-widget-content ui-corner-all" autocomplete="off" readonly/></td>
            </tr>
            <tr>
                <td>Primary Account</td>
                <td>:</td>
                <td> <select name="primary" id="primary" class="text ui-widget-content ui-corner-all" >
					<?
						echo "<option selected=\"selected\" value=\"primary\">--Select--</option>";
						$sql1=mysql_query("select `Hospital_name` from `hospitals` where `Client`='IDSIL' or `Client`='PJO' order by `Hospital_name` ");
						while($row1=mysql_fetch_array($sql1))
						{
							$hsp1=$row1['Hospital_name'];
							echo '<option value="'.$hsp1.'">'.$hsp1.'</option>';
						}
                    ?>
                    </select></td>
                    <td>
                    <span title="Select your Primary Account" class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; cursor:pointer;"></span>				
                    </td>
            </tr>
            
            <tr>
                <td>Secondary Account</td>
                <td>:</td>
                <td>
                   <select name="secondary" id="secondary" class="text ui-widget-content ui-corner-all" >
					<?
						echo "<option selected=\"selected\" value=\"secondary\">--Select--</option>";
						$sql2=mysql_query("select `Hospital_name` from `hospitals` where `Client`='IDSIL' or `Client`='PJO' order by `Hospital_name` ");
						while($row2=mysql_fetch_array($sql2))
						{
							$hsp2=$row2['Hospital_name'];
							echo '<option value="'.$hsp2.'">'.$hsp2.'</option>';
						}
                    ?>
                    </select>
                </td>
                <td>
                <span title="Select your Secondary Account" class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; cursor:pointer;"></span>				
                    </td>
            </tr>
            
             <tr>
                <td>Tertiary Account</td>
                <td>:</td>
                <td>
                   <select name="tertiary" id="tertiary" class="text ui-widget-content ui-corner-all" >
					<?
						echo "<option selected=\"selected\" value=\"tertiary\">--Select--</option>";
						$sql3=mysql_query("select `Hospital_name` from `hospitals` where `Client`='IDSIL' or `Client`='PJO' order by `Hospital_name` ");
						while($row3=mysql_fetch_array($sql3))
						{
							$hsp3=$row3['Hospital_name'];
							echo '<option value="'.$hsp3.'">'.$hsp3.'</option>';
						}
                    ?>
                    </select>
                </td>
                <td>
                    <span title="Select your Tertiary Account" class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; cursor:pointer;"></span>				
               	</td>
            </tr>
            
            <tr>
                <td>Optional Account (1)</td>
                <td>:</td>
                <td>
                   <select name="optional1" id="optional1" class="text ui-widget-content ui-corner-all" >
					<?
						echo "<option selected=\"selected\" value=\"optional1\">--Select--</option>";
						$sql4=mysql_query("select `Hospital_name` from `hospitals` where `Client`='IDSIL' or `Client`='PJO' order by `Hospital_name` ");
						while($row4=mysql_fetch_array($sql4))
						{
							$hsp4=$row4['Hospital_name'];
							echo '<option value="'.$hsp4.'">'.$hsp4.'</option>';
						}
                    ?>
                    </select>
                </td>
                <td>
                    <span title="Choose your Optional Account 1" class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; cursor:pointer;"></span>				
               	</td>
            </tr>
            
            <tr>
                <td>Optional Account (2)</td>
                <td>:</td>
                <td>
                   <select name="optional2" id="optional2" class="text ui-widget-content ui-corner-all" >
					<?
						echo "<option selected=\"selected\" value=\"optional2\">--Select--</option>";
						$sql5=mysql_query("select `Hospital_name` from `hospitals` where `Client`='IDSIL' or `Client`='PJO' order by `Hospital_name` ");
						while($row5=mysql_fetch_array($sql5))
						{
							$hsp5=$row5['Hospital_name'];
							echo '<option value="'.$hsp5.'">'.$hsp5.'</option>';
						}
                    ?>
                    </select>
                </td>
                <td>
                    <span title="Choose your Optional Account 2" class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; cursor:pointer;"></span>				
               	</td>
            </tr>
            <tr>
                <td>Editing Target Lines</td>
                <td>:</td>
                <td>
                   <input type="text" name="edit_target" id="edit_target" size="28" class="text ui-widget-content ui-corner-all" autocomplete="off" />
                </td>
                <td>
                    <span title="Enter your Daily Editing Target Lines" class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; cursor:pointer;"></span>				
               	</td>
            </tr>
            <tr>
                <td>DUP Target Lines</td>
                <td>:</td>
                <td>
                   <input type="text" name="dup_target" id="dup_target" size="28" class="text ui-widget-content ui-corner-all" autocomplete="off"/>
                </td>
                <td>
                    <span title="Enter your DUP Target Lines <b>( Optional ).</b>" class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; cursor:pointer;"></span>				
               	</td>
            </tr>
            <tr>
                <td>Working Hours</td>
                <td>:</td>
                <td>
                   <input type="text" name="w_hrs" id="w_hrs" size="28" class="text ui-widget-content ui-corner-all" autocomplete="off" style="margin-bottom:0px; width:150px; padding: .2em; text-align:left "/>
                </td>
                <td>
                    <span title="Enter your Working hours <b>( Optional ).</b>" class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; cursor:pointer;"></span>				
               	</td>
            </tr>
          </table>
                  </fieldset>
              </form>
			</div>		
             <?
			  }
			 ?>
             <h2>Pick uploaded files of MLS</h2>
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
            </div>
            
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
		$result=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Uploadedby`,`Editedby`,`Upstatus`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Uploadedby`!='$name' AND `File_No` LIKE '%$fileno%' LIMIT 0 , 2");
	}
	elseif(isset($_POST['date1']))
	{
		$date=trim($_POST['date1']);
		$result=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Uploadedby`,`Editedby`,`Upstatus`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Date` ='$date' AND `Editedby`='Not yet Edited' AND `Uploadedby`!='$name' LIMIT 0 , 10");
	}
	else
	{	
		$dat=date('Y-m-d');
		$chk_count=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Uploadedby`,`Editedby`,`Upstatus`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Editedby`='$name' AND `Upload_to`='Not yet Edited' LIMIT 0,10");
		$count=mysql_num_rows($chk_count);
		//echo $count.$name;
		if($count>0)
		{
			$result=$chk_count;
		}
		else
		{
			$result=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Uploadedby`,`Editedby`,`Upstatus`,`Upload_to` FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Date` ='$dat' AND `Editedby`='Not yet Edited' AND `Uploadedby`!='$name' LIMIT 0 , 10");
		}
		echo "<center><br><table align=\"center\" width=\"400\"><tr><td class=\"show\">Details of files uploaded by the MLS </td></tr></table></center>";
	}
		echo $q;
		if($result) //if query ok
		{
			$count=mysql_num_rows($result);
			if($count!=0)// if count!=0
			{	
				echo "<br><center><label class=\"result\"><u>Search Results</u></label><br><br>";
				echo "<div style=\"width:880px; height: auto; border: 0px groove #3b3a3a; overflow: auto;\">";
				echo "<table border=\"1\" width=\"860\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\" cellpadding=\"3\" cellspacing=\"0\" >";
				echo "<tr class=\"ui-widget-header\"><th>S.No.</th><th>Date</th><th>Hospital</th><th>File No</th><th>Line count</th><th>Uploaded By</th><th>Picked by</th><th>Upload to</th></tr>";
				while($row=mysql_fetch_array($result))
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
					Print "<td align=\"center\"><form name=\"pick".$row['File_No']."\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\" method=\"post\"><table align=\"center\"><tr><td width=\"70\">".htmlentities($row['Upstatus'])."</td><td>
					<input type=\"hidden\" name=\"pref\" value=\"".htmlentities($row['File_No'])."\">
					<input type=\"hidden\" id=\"edtrid\" name=\"edtrid\" value=\"".htmlentities($_SESSION['EDITOR'])."\">
					<input type=\"submit\" name=\"pick\" id=\"pick\" class=\"button\" value=\"Pick\" onclick=\"return confirmpick(this.form)\"/></td></tr></table></form></td>";
					}
					else
					{
						Print "<td align=\"center\" >".htmlentities($row['Editedby'])."</td>";
					}
					if($row['Upload_to']=="Not yet Edited")
					{
						echo "<script>
						function call_file".$row['File_No']."(thisform)
						{
							if(document.getElementById('uploadto_".$row['File_No']."').value==='-1')
							{
								dhtmlx.alert({title:\"Warning!!!\", text:\"Please choose a Upload to field for ".$row['File_No']."\"});
								return false;
							}
							else
							{
								thisform.submit();
							}
						}</script>";
					}
					$name=$_SESSION['idsileditorname'];
					if(strtoupper($row['Editedby'])==$name)
					{
						$file_no=trim($row['File_No']);
						if($row['Upload_to']=="Not yet Edited" && $row['Hospital']!="NEWPORTBAY")
						{
							echo "<td align=\"center\">
								<form name=\"uploadto_".$file_no."_form\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\" method=\"post\">
								<table align=\"center\">
								<tr align=\"center\">
								<td style=\"border:0px;\">
								<input type=\"hidden\" name=\"fileno\" id=\"fileno\" title=\"fileno\" size=\"15\" value=\"".$file_no."\">
								<input type=\"hidden\" id=\"upedtrid\" name=\"edtrid\" value=\"".htmlentities($_SESSION['EDITOR'])."\">
								<select name=\"uploadto\" title=\"uploadto_".$file_no."\" id=\"uploadto_".$file_no."\" class=\"text ui-widget-content ui-corner-all button\" >
								<option selected=\"selected\" value=\"-1\">--Select upload type--</option>
								<option value=\"Hospital/Customer\">Hospital / Customer</option>
								<option value=\"IDS/QA_Checkpoint\">IDS / QA Checkpoint</option>
								<option value=\"Third_level\">Third Level </option>
								</td>
								<td style=\"border:0px;\">
								<input type=\"button\" name=\"upload\" id=\"upload\" class=\"button\" value=\"Save\" onclick=\"call_file".$file_no."(this.form)\"/>
								</td>
								</tr>
								</table>
								</form>
								</td>";
						}
						elseif($row['Upload_to']=="Not yet Edited"&& $row['Hospital']=="NEWPORTBAY")
						{
							echo "<td align=\"center\">
								<form name=\"uploadto_".$file_no."_form\" action=\"".htmlentities($_SERVER['PHP_SELF'])."\" method=\"post\">
								<table align=\"center\">
								<tr >
								<td style=\"border:0px;\">
								<input type=\"hidden\" name=\"fileno\" id=\"fileno\" title=\"fileno\" size=\"15\" value=\"".$file_no."\">
								<input type=\"hidden\" id=\"upedtrid\" name=\"edtrid\" value=\"".htmlentities($_SESSION['EDITOR'])."\">
								<select name=\"uploadto\" title=\"uploadto_".$file_no."\" id=\"uploadto_".$file_no."\" class=\"text ui-widget-content ui-corner-all button\">
								<option selected=\"selected\" value=\"-1\">--Select upload type--</option>
								<option value=\"Hospital/Customer\">Hospital / Customer</option>
								<option value=\"Blank\">Blank</option>
								<option value=\"Full_Proof\">Full proof</option>
								</td>
								<td style=\"border:0px;\">
								<input type=\"button\" name=\"upload\" id=\"upload\" value=\"Save\" onclick=\"call_file".$file_no."(this.form)\" class=\"button\"/>
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
}
echo "<br>";
		?>
        
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
    <script>
	$(function() {
    var first = $( "#primary" ),
      second = $( "#secondary" ),
      third = $( "#tertiary" ),
	  ndup = $( "#edit_target" ),
	  dup = $( "#dup_target" ),
	  hrs = $( "#w_hrs" ), 
	  opt1 = $( "#optional1" ),
	  opt2 = $( "#optional2" ),
      allFields = $( [] ).add( first ).add( second ).add( third ).add( ndup ).add( dup ).add( hrs ).add( opt1 ).add( opt2 ),
	  tips = $( ".validateTips" );
	function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-error" );
      setTimeout(function() {
        tips.removeClass( "ui-state-error", 1500 );
      }, 500 );
    }
    $( "#dialog-form" ).dialog({
	  autoOpen: false,
      modal: true,
	  width: 500,
      buttons: {
        "Create Profile": function() {
		     allFields.removeClass( "ui-state-error" );
		     if(createprofileform.primary.value==='primary')
				{
					first.addClass( "ui-state-error" );
					updateTips( "Please choose a Primary account" );
					setTimeout(function() {
					first.removeClass( "ui-state-error", 1500 );
					  }, 500 );
					return false;
				}
				if(createprofileform.secondary.value==='secondary')
				{
					second.addClass( "ui-state-error" );
					updateTips( "Please choose a Secondary account" );
					setTimeout(function() {
					second.removeClass( "ui-state-error", 1500 );
					  }, 500 );
					return false;
				}
				
				if(createprofileform.tertiary.value==='tertiary')
				{
				    third.addClass( "ui-state-error" );
				    updateTips( "Please choose a Tertiary account" );
					setTimeout(function() {
					third.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
			
				if(createprofileform.edit_target.value==="")
				{
				  ndup.addClass( "ui-state-error" );
				    updateTips( "Please enter a Non Dup Target" );
					setTimeout(function() {
					ndup.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				if(createprofileform.dup_target.value==="")
				{
				  dup.addClass( "ui-state-error" );
				    updateTips( "Please enter a Dup Target" );
					setTimeout(function() {
					dup.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				if(createprofileform.w_hrs.value==="")
				{
				  hrs.addClass( "ui-state-error" );
				    updateTips( "Please enter a Working Hours" );
					setTimeout(function() {
					hrs.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				if(document.getElementById('primary').value===document.getElementById('secondary').value)
				{
					first.addClass( "ui-state-error" );
					second.addClass( "ui-state-error" );
				    updateTips( "Primary and Secondary are the same" );
					setTimeout(function() {
					first.removeClass( "ui-state-error", 1500 );
					  }, 500 );
					setTimeout(function() {
					second.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				if(document.getElementById('primary').value===document.getElementById('tertiary').value)
				{
					first.addClass( "ui-state-error" );
					third.addClass( "ui-state-error" );
				    updateTips( "Primary and Tertiary are the same" );
					setTimeout(function() {
					first.removeClass( "ui-state-error", 1500 );
					  }, 500 );
					setTimeout(function() {
					third.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				if(document.getElementById('primary').value===document.getElementById('optional1').value)
				{
					first.addClass( "ui-state-error" );
					opt1.addClass( "ui-state-error" );
				    updateTips( "Primary and Optional 1 are the same" );
					setTimeout(function() {
					first.removeClass( "ui-state-error", 1500 );
					  }, 500 );
					setTimeout(function() {
					opt1.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				if(document.getElementById('primary').value===document.getElementById('optional2').value)
				{
					first.addClass( "ui-state-error" );
					opt2.addClass( "ui-state-error" );
				    updateTips( "Primary and Optional 2 are the same" );
					setTimeout(function() {
					first.removeClass( "ui-state-error", 1500 );
					  }, 500 );
					setTimeout(function() {
					opt2.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				if(document.getElementById('secondary').value===document.getElementById('tertiary').value)
				{
					second.addClass( "ui-state-error" );
					third.addClass( "ui-state-error" );
				    updateTips( "Secondary and Tertiary are the same" );
					setTimeout(function() {
					second.removeClass( "ui-state-error", 1500 );
					  }, 500 );
					setTimeout(function() {
					third.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				if(document.getElementById('secondary').value===document.getElementById('optional1').value)
				{
					second.addClass( "ui-state-error" );
					otp1.addClass( "ui-state-error" );
				    updateTips( "Secondary and Optional 1 are the same" );
					setTimeout(function() {
					second.removeClass( "ui-state-error", 1500 );
					  }, 500 );
					setTimeout(function() {
					otp1.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				if(document.getElementById('secondary').value===document.getElementById('optional2').value)
				{
					second.addClass( "ui-state-error" );
					opt2.addClass( "ui-state-error" );
				    updateTips( "Secondary and Optional 2 are the same" );
					setTimeout(function() {
					second.removeClass( "ui-state-error", 1500 );
					  }, 500 );
					setTimeout(function() {
					opt2.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				if(document.getElementById('tertiary').value===document.getElementById('optional1').value)
				{
					third.addClass( "ui-state-error" );
					opt1.addClass( "ui-state-error" );
				    updateTips( "Tertiary and Optional 2 are the same" );
					setTimeout(function() {
					third.removeClass( "ui-state-error", 1500 );
					  }, 500 );
					setTimeout(function() {
					opt1.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				if(document.getElementById('tertiary').value===document.getElementById('optional2').value)
				{
					third.addClass( "ui-state-error" );
					opt2.addClass( "ui-state-error" );
				    updateTips( "Tertiary and Optional 2 are the same" );
					setTimeout(function() {
					third.removeClass( "ui-state-error", 1500 );
					  }, 500 );
					setTimeout(function() {
					opt2.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				if(document.getElementById('optional2').value===document.getElementById('optional1').value)
				{
					opt1.addClass( "ui-state-error" );
					opt2.addClass( "ui-state-error" );
				    updateTips( "Optional 1 and Optional 2 are the same" );
					setTimeout(function() {
					opt1.removeClass( "ui-state-error", 1500 );
					  }, 500 );
					setTimeout(function() {
					opt2.removeClass( "ui-state-error", 1500 );
					  }, 500 );
				    return false;
				}
				$('#createprofileform').submit();
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        allFields.val( "" ).removeClass( "ui-state-error" );
      },
	  show: {
        effect: "clip",
        duration: 250
      }
    });
  });
	$(function() {
		$( "#dialog-message" ).dialog({
		  modal: true,
		  width: 300,
		  buttons: {
			Ok: function() {
			  $( this ).dialog( "close" );
			  document.location.href = "editor.php";
			}
		  }
		});
		});
 	  $( "#update_profile" )
      .button()
      .click(function() {
        $( "#dialog-form" ).dialog( "open" );
      });
	</script>

            <?php 
			
		if(isset($_POST['pref'],$_POST['edtrid']))
		{
			if(!(isset($_POST['pref']))=="0")
			{		
				//include ('dbconf.php');
				$value=trim($_POST['pref']);
				$name=$_SESSION['idsileditorname'];
					
					$ck_sql=mysql_query("SELECT `File_No` FROM `file_details` FORCE INDEX (`File_No`) WHERE `File_No`='$value' AND `Editedby`='Not yet Edited'");
					$count=mysql_num_rows($ck_sql);
					if($count==1)
					{
						$sql=mysql_query("UPDATE `file_details` SET `Editedby`='$name',`pick_time_edtr`='$datetime' where `File_No`='$value'");
						$uploadby=$name;
						$fp = fopen($log_dir.$uploadby.".txt", "a+");
						$comment=$id." has picked a file ".$value." in IDSIL / PJO";
						fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
						fclose($fp);
						echo "<script> setTimeout(function(){ window.location = window.location.href;}, 0);</script>";
					}
					else
					{
						echo "<script> dhtmlx.alert({
							title:\"Opps !!!\",
							ok:\"Ok\",
							text:\"Sorry File is already picked by someone.\",
							callback:function(){
							setTimeout(function(){ window.location = window.location.href;}, 0);
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
				
					$ck_sql=mysql_query("SELECT `File_No` FROM `file_details` FORCE INDEX (`File_No`) WHERE `File_No`='$value' AND `Upload_to`='Not yet Edited'");
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
						$sql=mysql_query("UPDATE `file_details` SET `Upload_to`='$upto',`Third_level`='$third',`Third_Editor`='$thirdeditor',`Time_up_edit`='$datetime', `Accuracy`='$ac',`Comments`='$comm' where `File_No`='$value'");
						if($sql)
						{
							$uploadby=$_SESSION['idsileditorname'];
							$fp = fopen($log_dir.$uploadby.".txt", "a+");
							$comment=$id." has uploaded a file ".$value." to ".$upto." in IDSIL / PJO";
							fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
							fclose($fp);
							echo "<script> setTimeout(function(){ window.location = \"editor.php\";}, 0);</script>";
						}
						
					}
					else
					{
						echo "<script> dhtmlx.alert({
							title:\"Opps !!!\",
							ok:\"Ok\",
							text:\"Sorry File is already picked by someone.\",
							callback:function(){
							setTimeout(function(){ window.location = \"editor.php\";}, 0);
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
		if(isset($_POST['e_id'],$_POST['e_name'],$_POST['primary'],$_POST['secondary'],$_POST['tertiary'],$_POST['optional1'],$_POST['optional2'],$_POST['edit_target'],$_POST['dup_target']))
{
	$dat=date('Y-m-d');
	$id=mysql_real_escape_string($_POST['e_id']);
	$name=mysql_real_escape_string($_POST['e_name']);
	$name=strtoupper($name);
	$primary=mysql_real_escape_string($_POST['primary']);
	$secondary=mysql_real_escape_string($_POST['secondary']);
	$tertiary=mysql_real_escape_string($_POST['tertiary']);
	$opt1=mysql_real_escape_string($_POST['optional1']);
	$opt2=mysql_real_escape_string($_POST['optional2']);
	if($opt1=="optional1")
	{
		$opt1="";
	}
	if($opt2=="optional2")
	{
		$opt2="";
	}
	$e_target=mysql_real_escape_string($_POST['edit_target']);
	$d_target=mysql_real_escape_string($_POST['dup_target']);
	$hours=mysql_real_escape_string($_POST['w_hrs']);
	if($d_target=='')
	{
		$d_target=0;
	}
	$sql=mysql_query("INSERT INTO `editor_profile` VALUES ('$dat','$id','$name','$primary','$secondary','$tertiary','$opt1','$opt2','$e_target','$d_target','$hours')");
	if($sql)
	{
		$comment=$loginas." has added Editor Profile into the Database";
		$fp = fopen($log_dir.$loginas.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<div id='dialog-message' title='Profile details' >";
		  echo '<div class="ui-widget">
				<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
					<p style="padding-top:10px; text-align:center;"><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					<strong>Success !!!</strong> Your Profiles has updated successfully.</p>
				</div>
			</div>';
		echo "</div>";
	 }
	 else
	 {
			echo "<div id='dialog-message' title='Profile details' >";
			  echo '<div class="ui-widget">
					<div class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
						<p style="padding-top:10px; text-align:center;"><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
						<strong>Oops !!!</strong> Your Profiles has not updated.</p>
					</div>
				</div>';
			echo "</div>";
	 }
}
		?>
        

    <?php
echo '<script>
		  $(function() {
		$( "#dialog" ).dialog({
		  modal: true,
		  width: 450
		});
		});
	  </script>';
	
	if(!isset($_SESSION['messages']))
	{
		echo "<div id=\"dialog\" title=\"Important Notifications\">";
		echo "<center><img src=\"images/b2k_logo.png\" height=\"55\" width=\"78\"></center>";
		//Notes
		$f_day=date('Y-m-d',time()-60*60*24*1);
		$t_day=date('Y-m-d',time()+60*60*24*2);
		$notes_q=mysql_query("SELECT `Date`,`Note` FROM  `notes` WHERE `Date` BETWEEN '$f_day' AND '$t_day' AND `To`!='MT' AND `Client`!='Escription'");
		$count_notes=mysql_num_rows($notes_q);
		if($count_notes!=0)
		{
			$a=1;
			echo "<div class=\"ui-widget ui-widget-content ui-corner-all\">";
			echo "<center><p class=\"headings\">Updates</p></center>";
			echo "<table border=\"1\" cellspacing=\"0\" class=\"ui-widget ui-widget-content ui-corner-all\" align=\"center\">";
			echo "<tr class=\"ui-widget-header\" ><th>S.No</th><th>Date</th><th>Notification</th></tr>";
			while($no_row=mysql_fetch_array($notes_q))
			{
				$no_date=$no_row['Date'];
				$notes=$no_row['Note'];
				echo "<tr align=\"center\"><td>".$a."</td><td>".$no_date."</td><td align=\"left\"><p class=\"mess\">".$notes."</p></td></tr>";
				$a=$a+1;
			}
			echo "</table>";
			echo "</div>";
		}
		//Previous Day
		$lc_count=0;
		$mlc_count=0;
		$lines=0;
		$mlines=0;
		$tot_line=0;
		$p_day=date('Y-m-d',time()-60*60*24);
		$lc_q=mysql_query("SELECT `Linecount` FROM `file_details` WHERE `Editedby`='$name' AND `Date`='$p_day'");
		$lc_count=mysql_num_rows($lc_q);
		$mlc_q=mysql_query("SELECT `Linecount` FROM `missing_files` WHERE `Edit_by`='$name' AND `Date`='$p_day'");
		$mlc_count=mysql_num_rows($mlc_q);
		if( ($lc_count!=0) || ($mlc_count!=0) )
		{
			$line=0;
			while($lc_row=mysql_fetch_array($lc_q))
			{
			$lines=$lines+$lc_row['Linecount'];
			}
			while($mlc_row=mysql_fetch_array($mlc_q))
			{
			$mlines=$mlines+$mlc_row['Linecount'];
			}
			$tot_lines=$lines+$mlines;
			echo "<div class=\"ui-widget ui-widget-content ui-corner-all\">";
			echo "<center><p class=\"headings\">Previous Day Lines</p></center>";
			echo "<p class=\"poptar\">Yesterday you have achieved<span class=\"target\">".$tot_lines."</span></p>";
			echo "</div>";
		}
		//Leave Notes
		$t_day=date('Y-m-d',time()+60*60*24*1);
		$n_day=date('Y-m-d',time()+60*60*24*6);
		$leave_q=mysql_query("SELECT `Leave_Date`,`Permission_status` FROM  `leave_request` WHERE `Employee_ID`='$loginas' AND `Leave_Date` BETWEEN '$t_day' AND '$n_day'");
		$count_leave=mysql_num_rows($leave_q);
		if($count_leave!=0)
		{
			$a=1;
			echo "<div class=\"ui-widget ui-widget-content ui-corner-all\">";
			echo "<center><p class=\"headings\">Leave Updates</p></center>";
			echo "<table border=\"1\"  width=\"350\" cellspacing=\"0\" class=\"ui-widget ui-widget-content ui-corner-all\" align=\"center\">";
			echo "<tr class=\"ui-widget-header\" ><th>S.No</th><th>Leave Date</th><th>Status</th></tr>";
			while($l_row=mysql_fetch_array($leave_q))
			{
				echo "<tr align=\"center\"><td>".$a."</td><td>".$l_row['Leave_Date']."</td><td align=\"left\">".$l_row['Permission_status']."</td></tr>";
				$a=$a+1;
			}
			echo "</table>";
			echo "</div>";
		}
		//Upload Updates
		$upload_q=mysql_query("SELECT `File_name`,`File_location` FROM  `admin_uploads`");
		$count_upload=mysql_num_rows($upload_q);
		if($count_upload!=0)
		{
			$a=1;
			echo "<div class=\"ui-widget ui-widget-content ui-corner-all\">";
			echo "<br><center><p class=\"headings\">Uploads</p></center>";
			echo "<table border=\"1\" cellspacing=\"0\" class=\"ui-widget ui-widget-content ui-corner-all\" align=\"center\">";
			echo "<tr class=\"ui-widget-header\" ><th>S.No</th><th>File Name</th><th>Download</th></tr>";
			while($up_row=mysql_fetch_array($upload_q))
			{
			$upfile_name=$up_row['File_name'];
			echo "<tr align=\"center\"><td>".$a."</td><td align=\"left\">".$upfile_name."</td><td align=\"center\"><a href=\"$admin_local".$upfile_name."\" align=\"center\"><img src=\"menu/pick.png\" height=\"20\" width=\"20\" /></a></td></tr>";
			$a=$a+1;
			}
			echo "</table>";
			echo "</div>";
		}
		
		$_SESSION['messages']=1;
		echo "</div>";
	}
?>       

</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
