<?php include('mlstop.php');?>
<style>
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }

select { margin-bottom:0px; width:165px; padding: .2em; text-align:left; }
select { margin-bottom:0px; width:165px; padding: .2em; text-align:left; }

#f_platformid{text-transform:uppercase;}
.target { font-size:50px; color:#00CCFF; font:Georgia, "Times New Roman", Times, serif; text-align:center; }
.target_to_achieve { font-size:50px; color:#FF0000; font:Georgia, "Times New Roman", Times, serif; text-align:center; }
.tar { font-size:20px; color:#FF9933; font:Georgia, "Times New Roman", Times, serif; text-align:center; }
.poptar { font-size:12px; color:#FF9933; font:Georgia, "Times New Roman", Times, serif; text-align:center; }
.poptarget { font-size:30px; color:#00CCFF; font:Georgia, "Times New Roman", Times, serif; text-align:center; }
.headings { font-size:15px; color:#0099FF; font:Georgia, "Times New Roman", Times, serif; text-align:left; }
a, a:link, a:visited {
	color: #FF9933; text-align:center;
}
fieldset { padding:0; border:0; margin-top:25px; text-align:left; }
.ui-dialog .ui-state-error { padding: .3em; }
.validateTips { border: 1px solid transparent; padding: 0.3em; }
.mess{ color:#FF0000; }
</style>
<script src="js/jquery/jquery-1.8.3.js"></script>
<script src="js/jquery/textualizer.js"></script>
<script language="javascript" type="text/javascript">
function reload()
{
        setTimeout(function(){ window.location = "mls.php";}, 0);
}
function check(thisform)
{
	var Exp = /^[0-9.]+$/;
	if(document.getElementById('f_platformid').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter a Platform ID"});
		return false;
	}
	if(document.getElementById('f_hospital').value==='-1')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Hospital"});
		return false;
	}
	if(document.getElementById('fileno').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter a File Number"});
		return false;
	}
		
	if(document.getElementById('f_min').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter File minutes"});
		return false;
	}
	
	if(document.getElementById('fileup').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Character count"});
		return false;
	}
	
	if(document.getElementById('fileup').value.length>0)
	{
		var checkCount = document.getElementById('fileup').value;
		var checkTotalLineCount = checkCount / 65;
		
		if(checkTotalLineCount > 999)
		{
			dhtmlx.alert({title:"Warning!!!", text:"Character count you have entered is "+checkCount+". Actual Line count is "+checkTotalLineCount+", Line count should not be grater than 999."});
			return false;
		}
	}
	
	
	if (!document.getElementById('fileup').value.match(Exp)) 
    {
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Numeric alues"});
        return false;
    } 
	var don = document.getElementsByName('type');
	var count=0;
	for(var i=0;i<don.length;i++)
	{
			if(!don[i].checked)
		{
			count=count+1;
		}
	}
	if(count==2)
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose file type"});
		return false;
	}
	
	
	thisform.submit();
	dhtmlx.message("Uploading Please Wait...");	
}
      
function share()
{
	proofed();
	pjofile();
	if(document.getElementById('shared').checked==true)
	{
		document.getElementById('showcount').style.display = '';
	}
	else
	{
		document.getElementById('showcount').style.display='none';
	}
}

function callcount()
{
	var cnt=document.getElementById('count').value;
	if(cnt<=4)
	{
		for(i=1;i<=cnt;i++)
		{
			addTextBox();
		}
	}
	else
	{
		dhtmlx.alert({title:"Warning!!!", text:"File must be shared by less than 4 members"});
	}
}
var inival=0;
function addTextBox()
{
	var newArea = add_New_Element();
	var htcontents = "<table align=\"center\" width=\"550\" cellspacing=\"2\" style=\" padding-left:20px;\"><tr><td width=\"150\">MLS ID "+inival+" </td><td>:</td><td><input type='text' name='mls"+inival+"' title='MLS ID "+inival+"' id='mls"+inival+"' value='' class='text ui-widget-content ui-corner-all'/></td></tr></table>";
	document.getElementById(newArea).innerHTML = htcontents; // You can any other elements in place of 'htcontents'
}
	
function add_New_Element() 
{
	inival=inival+1; // Increment element number by 1
	var ni = document.getElementById('showshare');
	var newdiv = document.createElement('div'); // Create dynamic element
	var divIdName = 'my'+inival+'Div';
	newdiv.setAttribute('id',divIdName);
	ni.appendChild(newdiv);
	return divIdName;
}

function proofed()
{
	if(document.getElementById('proof').checked==true)
	{
		document.getElementById('showproof').style.display = '';
	}
	else
	{
		document.getElementById('showproof').style.display='none';
	}
}
function pjofile()
{
	if(document.getElementById('pjovoice').checked==true)
	{
		document.getElementById('showpjo').style.display = '';
	}
	else
	{
		document.getElementById('showpjo').style.display='none';
	}
}
</script>
</head>
<body onLoad="share()">
<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');?>
    <div id="main">
        <table border="0" cellpadding="5" align="center" style="font-size:11px;">
        <tr>
        <td style="height:600px;">
       <table class="ui-widget ui-widget-content ui-corner-all" style="height:600px;">
                <tr class="ui-widget-header">
                    <td align="center" style="height:35px; font-size:18px;" class="ui-widget ui-corner-all">Upload Completed Files Here</td>
                </tr>
                <tr>
            	<td style="padding:5px;">
                <form name="Filesubmit" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" >
                <table align="center" width="550" cellspacing="3" style=" padding-left:20px;">
                    
                     <tr>
                        <td align="left">Select the Shift</td>
                        <td>:</td>
                        <td title="Select Shift" align="left">
                        <div id="shiftradioset">
                            <input type="radio" name="shift" id="d_shift" value="Day"><label for="d_shift">Day</label>
                            <input type="radio" name="shift" id="n_shift" value="Night"><label for="n_shift">Night</label>
                        </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="left">Select the Date</td><td>:</td>
                        <td align="left">
                        <input type="text" id="datepicker" title="Select the Date" name="day" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="left">Platform ID</td><td>:</td>
                        <td align="left">
                            <input type="text" name="f_platformid" id="f_platformid" size="15" value="<?php if(isset($_SESSION['platform_id'])) { echo $_SESSION['platform_id']; }?>" class="text ui-widget-content ui-corner-all" title="Enter the Platform ID for once" >
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="left">Hospital</td><td>:</td>
                        <td align="left">
                            <select name='f_hospital' id='f_hospital' class="text ui-widget-content ui-corner-all" title="Choose the Hospital for once">
                            <option selected='selected' value='-1'>--Select Hospital--</option>
                            <?
                            $hos_show='';
                            if(isset($_SESSION['Hospital']))
                            {	
                                $hos_show=$_SESSION['Hospital'];
                                if($hos_show!='-1')
                                {
                                    echo "<option selected=\"selected\" value=\"".$hos_show."\">".$hos_show."</option>";
                                    echo "<option value=\"-1\">--Select All--</option>";
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
                    </tr>
                    
                    <tr align="left">
                        <td align="left">File No</td><td>:</td>
                        <td align="left">
                            <input type="text" name="fileno" id="fileno" size="15" value="" class="text ui-widget-content ui-corner-all" title="Enter the File Number" onBlur="checkNum(this);" autocomplete="off">
                        </td>
                    </tr>
                    
                     <tr align="left">
                        <td align="left">File Minutes</td>
                        <td>:</td>
                        <td align="left"><input type="text" title="Enter the File minutes" name="f_min" id="f_min" size="10" class="text ui-widget-content ui-corner-all" autocomplete="off">&nbsp;&nbsp;(ex&nbsp;:&nbsp;5:35)</td>
                    </tr>
                    
                    <tr align="left">
                        <td align="left">Character / Line Count</td>
                        <td>:</td>
                        <td align="left"><input type="text" name="fileup" id="fileup" size="15" maxlength="6" title="Please Enter the character count or linecount" class="text ui-widget-content ui-corner-all" onBlur="checkNum(this);" autocomplete="off"><a rel="imgtip[0]">&nbsp;&nbsp;Point your mouse here</a></td>
                    </tr>
                    <tr align="left">
                    <td></td><td></td><td><p style="color:#FF0000; font-size:9pt;">(" For <b>Dictaphone</b> Users Please Enter <b>Linecount</b> and for <b>Others</b> Please enter <b>Character Count</b> ")</p></td></tr>
                   
                    <tr align="left">
                        <td align="left">File type</td>
                        <td>:</td>
                        <td align="left" title="Please Select a File Type">
                        <div id="typeradioset">
                            <input type="radio" name="type" id="radio1" value="Blank" ><label for="radio1">Blank</label>
                            <input type="radio" name="type" id="radio2" value="Edit"><label for="radio2">Edit</label>
                        </div>
                        </td>
                    </tr>
                    
                    <tr align="left">
                        <td align="left">DUP</td>
                        <td>:</td>
                        <td align="left" title="Please select if it is DUP File">
                        <select name="dup" id="dup" class="text ui-widget-content ui-corner-all">
                            <option selected="selected" value="-1">--Select upload type--</option>
                            <?php
                            $sql=mysql_query("select `Nature` from `jobnature` order by `Nature` ");	
                            while($row=mysql_fetch_array($sql))
                            {
                                $nat=$row['Nature'];
                                echo '<option value="'.htmlentities($nat).'">DUP/'.htmlentities($nat).'</option>';
                            }
                            echo '<option value="DUP/ADT">DUP/ADT</option>';
                            ?>
                        </select> * Please choose only if DUP
                        </td >
                    </tr>
                    
                    
                    <tr align="left">
                        <td align="left">Click if it is a shared</td>
                        <td>:</td>
                        <td align="left"><input type="checkbox" name="shared" id="shared" value="shared" onClick="share()" title="Click if it is a Shared File" > Shared</td>
                    </tr>
                    
                    <tr align="left">
                        <td width="150" align="left">Click if it is a proofed</td>
                        <td>:</td>
                        <td align="left"><input type="checkbox" name="proof" id="proof" value="proofed" onClick="proofed()" title="Click if it is a Proofed File" > Proofed</td>
                    </tr>
                    
                    <tr align="left">
                        <td width="150" align="left">Click if it is a PJO</td>
                        <td>:</td>
                        <td align="left"><input type="checkbox" name="pjovoice" id="pjovoice" value="PJO" onClick="pjofile()" title="Click if it is a PJO File" > PJO File</td>
                    </tr>
        
               </table>
                    <div id="showpjo">
                        <table align="center" width="550" cellspacing="2" style=" padding-left:20px;">
                            <tr align="left">
                                <td width="150" align="left">Voice No</td>
                                <td>:</td>
                                <td align="left"><input type="text" name="voiceno" id="voiceno" size="15" value=""  class="text ui-widget-content ui-corner-all" onBlur="checkNum(this);" autocomplete="off"> * Please enter only if it is a PJO file</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div id="showcount">
                        <table align="center" width="550" cellspacing="2" style=" padding-left:20px;">
                            <tr>
                                <td width="150" align="left">Enter the No. MLS Shared</td>
                                <td>:</td>
                                <td align="left"><input type="text" name="count" id="count" size="15" value="" onBlur=" callcount()" class="text ui-widget-content ui-corner-all" autocomplete="off">* Please enter the No. of MLS Shared</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div id="showshare">
                      
                    </div>
                    
                     <div id="showproof">
                        <table align="center" width="550" cellspacing="2" style=" padding-left:20px;">
                            <tr>
                                <td width="150" align="left">Proofer MLS ID</td>
                                <td>:</td>
                                <td align="left"><input type="text" name="p_mls" id="p_mls" size="15" value="" class="text ui-widget-content ui-corner-all" autocomplete="off" > * Please enter only MLS ID</td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <center>
                        <input type="button" name="fsubmit" value="Submit File Details" onClick="check(this.form)" style="height:30px; width:150px;"/>
                    </center>
                </form>
             </td>
            </tr>
          </table>
        </td>
        <td>
             <?php
			 $t_lc=0;
			 $nt_lc=0;
			 $dat=date('Y-m-d');
			 $profile_chk=mysql_query("SELECT `Target_lines`,`DUP_target` FROM `mlsprofile` WHERE `ID` ='$id'");
			 $check_count=mysql_num_rows($profile_chk);
			 if($check_count!=0)
			 {
			 	 while($p_row=mysql_fetch_array($profile_chk))
				 {
				 	$ndup_target=$p_row['Target_lines'];
					$dup_target=$p_row['DUP_target'];
				 }
				 $upload_by=$_SESSION['EMP_NAME_ID'];
				 $result=mysql_query("SELECT `Linecount`,`Upstatus` FROM `file_details` FORCE INDEX (`File_No`) WHERE `Date`='$dat' AND	`Uploadedby`='$upload_by'");
				 $t_count=mysql_num_rows($result);
				 if($t_count!=0)
				 {
					while($t_row=mysql_fetch_array($result))
					{
						if($t_row['Upstatus']=="No DUP")
						{
							$nt_lc=$nt_lc+$t_row['Linecount'];
						}
						else
						{
							$t_lc=$t_lc+$t_row['Linecount'];
						}
					}
					$dup_toachieve=$dup_target-$t_lc;
					$ndup_toachieve=$ndup_target-$nt_lc;
					?>
					<table class="ui-widget ui-widget-content ui-corner-all" style="height:295px; padding:.1em; width:300px;">
					<tr class="ui-widget-header">
						<td align="center" style="height:35px; font-size:18px;" class="ui-widget ui-corner-all">Non DUP Target</td>
					</tr>
					<tr>
					<td style="padding:5px;">
                    <?
					if($ndup_toachieve>=0)
					{
						echo "<p class=\"tar\">you have achieved<br></p> <p class=\"target\"><br>".$nt_lc."</p>";
						echo "<br><br><p class=\"tar\">still you have to achieve</p> <p class=\"target_to_achieve\"><br>".$ndup_toachieve."</p>";
					}
					else
					{
						echo "<br><p class=\"target\"><br>Hurrah !!!</p>";
						echo "<br><br><p class=\"tar\">you have achieved your target</p> <p class=\"target\"><br>".$nt_lc."</p>";
						
					}
					?>
                    </td>
                    </tr>
                    </table>
                    <table class="ui-widget ui-widget-content ui-corner-all" style="height:295px; margin-top:10px; padding:.01em; width:300px;">
					<tr class="ui-widget-header">
						<td align="center" style="height:35px; font-size:18px;" class="ui-widget ui-corner-all">DUP Target</td>
					</tr>
					<tr>
					<td style="padding:5px;">
                    <?
					if($dup_toachieve>=0)
					{
						echo "<p class=\"tar\">you have achieved<br></p> <p class=\"target\"><br>".$t_lc."</p><br><br>";
						echo "<p class=\"tar\">Still you have to achieve<br></p> <p class=\"target_to_achieve\"><br>".$dup_toachieve."</p>";
					}
					else
					{
						echo "<br><p class=\"target\"><br>Hurrah !!!</p>";
						echo "<br><br><p class=\"tar\">you have achieved your target</p> <p class=\"target\"><br>".$t_lc."</p>";
						
					}
					?>
                    </td>
                    </tr>
                    </table>
                    <?
				} 
				 else
				 {
				 	?>
                    <table class="ui-widget ui-widget-content ui-corner-all" style="height:600px; padding:.01em; width:300px;">
					<tr class="ui-widget-header">
						<td align="center" style="height:35px; font-size:18px;" class="ui-widget ui-corner-all">Today's Target</td>
					</tr>
					<tr>
					<td style="padding:5px;">
                    <?
					
					echo "<br><br><p class=\"tar\">Still you have to achieve</p> <p class=\"target_to_achieve\"><br>".$ndup_target."</p><br><p class=\"tar\">Non DUP Lines</p> ";
					
					echo "<br><p class=\"tar\">Still you have to achieve</p> <p class=\"target_to_achieve\"><br>".$dup_target."</p><br><p class=\"tar\">DUP Lines</p>";
					
					?>
                    </td>
                    </tr>
                    </table>
                    <?
				 }
			  }
			  else
			  {
			        echo "<div class=\"roundborder\">";
                    echo "<br><center><h4>Create Profile</h4></center>";
					echo "<p class=\"tar\">Please Update your Profile </p><center><button id=\"update_profile\">Create Profile</button></center></div>";
					?>
              <div id="dialog-form" title="Profile details">
              <form id="createprofileform" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                  <fieldset>
                  <p class="validateTips">All form fields are required.</p>
                  <table cellpadding="2" align="center" cellspacing="2">
          
          	<tr align="left">
                <td align="left">User ID</td>
                <td align="left">:</td>
                <td><input type="text" name="e_id" id="e_id" size="28" Value="<?php echo $_SESSION['MLS'];?>" class="text ui-widget-content ui-corner-all " autocomplete="off" readonly/></td>
                <td align="left"></td>
            </tr>
            
            <tr align="left">
                <td>Username</td>
                <td>:</td>
                <td><input type="text" name="e_name" id="e_name" size="28" Value="<?php echo $_SESSION['EMP_NAME_ONLY'];?>" class="text ui-widget-content ui-corner-all" autocomplete="off" readonly/></td>
            </tr>
            <tr align="left">
                <td align="left">Primary Account</td>
                <td align="left">:</td>
                <td align="left"> <select name="primary" id="primary" class="text ui-widget-content ui-corner-all">
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
            
            <tr align="left">
                <td>Secondary Account</td>
                <td>:</td>
                <td align="left">
                   <select name="secondary" id="secondary" class="text ui-widget-content ui-corner-all">
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
            
             <tr align="left">
                <td>Tertiary Account</td>
                <td>:</td>
                <td align="left">
                   <select name="tertiary" id="tertiary" class="text ui-widget-content ui-corner-all">
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
            
            <tr align="left">
                <td>Optional Account (1)</td>
                <td>:</td>
                <td align="left">
                   <select name="optional1" id="optional1" class="text ui-widget-content ui-corner-all">
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
            
            <tr align="left">
                <td>Optional Account (2)</td>
                <td>:</td>
                <td align="left">
                   <select name="optional2" id="optional2" class="text ui-widget-content ui-corner-all">
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
            <tr align="left">
                <td>Non DUP Target Lines</td>
                <td>:</td>
                <td align="left">
                   <input type="text" name="ndup_target" id="ndup_target" size="28" class="text ui-widget-content ui-corner-all" autocomplete="off" />
                </td>
                <td>
                    <span title="Enter your Daily Editing Target Lines" class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; cursor:pointer;"></span>				
               	</td>
            </tr>
            <tr align="left">
                <td>DUP Target Lines</td>
                <td>:</td>
                <td align="left">
                   <input type="text" name="dup_target" id="dup_target" size="28" class="text ui-widget-content ui-corner-all" autocomplete="off"/>
                </td>
                <td>
                    <span title="Enter your DUP Target Lines <b>( Optional ).</b>" class="ui-icon ui-icon-info" style="float: left; margin-right: .3em; cursor:pointer;"></span>				
               	</td>
            </tr>
            <tr>
                <td align="left">Working Hours</td>
                <td>:</td>
                <td align="left">
                   <input type="text" name="w_hrs" id="w_hrs" size="28" class="text ui-widget-content ui-corner-all" autocomplete="off" />
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
             
            <!-- <div class="roundborder" style="height:309px;">
             <center><h4>Updates</h4></center>
             <?php include('scrolling.php');?>
         	</div>-->
        </td>
        </tr>
        </table>

    </div> <!-- end of main -->
	<div id="main_bottom"></div>		
<?php include('footer.php'); ?>
    <script>
  $(function() {
    var first = $( "#primary" ),
      second = $( "#secondary" ),
      third = $( "#tertiary" ),
	  ndup = $( "#ndup_target" ),
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
			
				if(createprofileform.ndup_target.value==="")
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
  $( "#update_profile" )
      .button()
      .click(function() {
        $( "#dialog-form" ).dialog( "open" );
      });
  $(function() {
		$( "#dialog-message" ).dialog({
		  modal: true,
		  width: 300,
		  buttons: {
			Ok: function() {
			  $( this ).dialog( "close" );
			  document.location.href = "mls.php";
			}
		  }
		});
		});

	$(function() {
		//$( "#shiftradioset" ).buttonset();
		//$( "#typeradioset" ).buttonset();
	});
	
	$(document).ready(function(){
  	var currentTime ="<?php echo date('G');?>";
	
	if (currentTime >= 6 && currentTime < 22) 
	{
		$('input:radio[name=shift]:nth(0)').attr('checked',true);
	}
    	else if (currentTime >= 0  && currentTime < 6) 
	{
		$('input:radio[name=shift]:nth(1)').attr('checked',true);
    	}
	else if(currentTime >=22 && currentTime <24)
	{
		$('input:radio[name=shift]:nth(1)').attr('checked',true);
	}
  });
  </script>
 
<?php
if(isset($_POST['e_id'],$_POST['e_name'],$_POST['primary'],$_POST['secondary'],$_POST['tertiary'],$_POST['optional1'],$_POST['optional2'],$_POST['ndup_target'],$_POST['dup_target'],$_POST['w_hrs']))
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
	$ndup_target=mysql_real_escape_string($_POST['ndup_target']);
	$dup_target=mysql_real_escape_string($_POST['dup_target']);
	$hrs=mysql_real_escape_string($_POST['w_hrs']);
	$sql=mysql_query("INSERT INTO `mlsprofile` VALUES ('$dat','$id','$name','$primary','$secondary','$tertiary','$opt1','$opt2','$ndup_target','$dup_target','$hrs')");
	if($sql)
	{
		$comment=$loginas." has added MLS Profile into the Database";
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

if(isset($_POST['fileup'],$_POST['fileno'],$_POST['day'],$_POST['shift'],$_POST['f_min'],$_POST['type'],$_POST['dup'],$_POST['f_hospital']))
{
	$mls_id=$id;//MLS Name
	$dat=mysql_real_escape_string(trim($_POST['day'])); //date
	$shift=mysql_real_escape_string(trim($_POST['shift']));
	$type=mysql_real_escape_string(trim($_POST['type'])); //File type
	$f_dup=mysql_real_escape_string(trim($_POST['dup'])); //Dup type
	$f_hospital=mysql_real_escape_string(trim($_POST['f_hospital'])); // Hospital Name
	$_SESSION['Hospital']=$f_hospital;
	$f_platform_id=mysql_real_escape_string(trim($_POST['f_platformid'])); // platform ID Name
	$_SESSION['platform_id']=strtoupper($f_platform_id);
	$f_min=mysql_real_escape_string(trim($_POST['f_min']));; // File Minutes
	$shared='';
	$sh='';
	$sh_cnt=mysql_real_escape_string(trim($_POST['count'])); // Shared Count
	$flag='';
	$plat_id=mysql_real_escape_string(trim($_SESSION['platform_id']));
	if(isset($_POST['shared']))
	{
		$sh=mysql_real_escape_string(trim($_POST['shared']));
		$shared_file="YES";
	}
	else
	{
		$shared_file="NO";
	}
	
	if(isset($_POST['proof']))
	{
		$proof=mysql_real_escape_string(trim($_POST['proof']));
		if($proof=="proofed")
		{
			$p_id=mysql_real_escape_string(trim($_POST['p_mls']));
			$proofedby=getname($p_id);
		}
		else
		{
			$proofedby="No Proofing";
		}
	}
	else
	{
		$proofedby="No Proofing";
	}
	if(isset($_POST['pjovoice']))
	{
		$pjo_voice=mysql_real_escape_string(trim($_POST['pjovoice']));
		if($pjo_voice=="PJO")
		{
			$pjo_voice=mysql_real_escape_string(trim($_POST['voiceno']));
		}
		else
		{
			$pjo_voice="No Voice";
		}
	}
	else
	{
		$pjo_voice="No Voice";
	}
	$date_sep=$_POST['day'];
	$f_type=$type;
	$f_shift=$shift;
	for($i=1;$i<=$sh_cnt;$i++)
	{
		$e_id=mysql_real_escape_string(trim(strtoupper($_POST['mls'.$i])));
		$shared=$shared.",".getname($e_id);
	}
	
	if($f_dup==-1)
	{
		$editedby="Not yet Edited";
		$upstatus="No DUP";
		$accuracy='';
		$flag=1;
		$thirdlevel='Not yet Edited';
		$thirdeditor='Not yet Edited';
		$upload_to='Not yet Edited';
	}
	elseif($f_dup=="DUP/ADT")
	{
		$editedby="Not yet Edited";
		$upstatus="DUP/ADT";
		$accuracy='';
		$flag=1;
		$thirdlevel='Not yet Edited';
		$thirdeditor='Not yet Edited';
		$upload_to='Not yet Edited';

	}
	else
	{
		$hosp=mysql_query("SELECT `Job_nature` FROM `hospitals` WHERE `Hospital_name`='$f_hospital'");
		while($hrow=mysql_fetch_array($hosp))
		{
			if($f_dup<=$hrow['Job_nature'])
			{
				$editedby="DUP / ".$f_dup;
				$upstatus="DUP / ".$f_dup;
				$accuracy='100';
				$flag=1;
				$thirdlevel="DUP / ".$f_dup;
				$thirdeditor="DUP / ".$f_dup;
				$upload_to="Hospital/Cusotmer";
			}
			else
			{
				$editedby="Not yet Edited";
				$upstatus="DUP / ".$f_dup;
				$flag=1;
				$accuracy='';
				$thirdlevel='Not yet Edited';
				$thirdeditor='Not yet Edited';
				$upload_to='Not yet Edited';
			}
		}
	}
	
	if($flag==1)
	{
		$uploadby=$mls_id;
		$mls_no=$uploadby;
		$vendor_name=$_SESSION['Vendorname'];
		$client=mysql_query("SELECT `Client`,`Platform` FROM `hospitals` WHERE `Hospital_name`='$f_hospital'");
		while($crow=mysql_fetch_array($client))
		{
			$f_client=$crow['Client'];
			$f_platform=$crow['Platform'];
		}
		
		$uploadby=$_SESSION['idsilmlsname'];
		if($sh=="shared")
		{
			$uploadby=$shared;
		}
		$ori_file_no=mysql_real_escape_string(trim($_POST['fileno']));
		//$f_name = preg_replace('/\D/', '',$ori_file_no);
		$f_name = preg_replace("/[^A-Za-z0-9]/", "",$ori_file_no);
		$textLength=mb_strlen($_POST['fileup'], 'UTF-8');
		//echo $textLength;
		if($textLength!=0)
		{
			
			$c_count=mysql_real_escape_string(trim($_POST['fileup']));
			if($f_platform=='DICTAPHONE')
			{
				$size=$c_count;
			}
			else
			{
				$size=$c_count/65;
			}
			$linecount=round($size,$round_value);
			$today=$date_sep;
			$pick_by_edit='';
			$Time_by_edit='';
			$pick_by_III_level='';
			$uptime_by_III_level='';
			$uploadfile=$mls_id;
			$upload=mysql_query("INSERT INTO `file_details` VALUES ('NULL','$today','$f_shift','$vendor_name','$f_client','$f_hospital','$plat_id','$f_name','$pjo_voice','$f_type','$f_min','$linecount','$upstatus','$shared_file','$uploadby','$proofedby','$editedby','$thirdlevel','$thirdeditor','$upload_to','$accuracy','$editedby','$datetime','$pick_by_edit','Time_by_edit','$pick_by_III_level','$uptime_by_III_level','$uploadfile')");
			
			echo "<div id='dialog-message' title='File details' >";
			if($upload)
			{
			$uploadby=$_SESSION['idsilmlsname'];
			$fp = fopen($log_dir.$uploadby.".txt", "a+");
			$comment=$mls_id." has uploaded a DUP file ".$f_name." in IDSIL / PJO";
			fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
			fclose($fp);
			if($sh=="shared")
			{
				$sh_linecount=($linecount/$sh_cnt);
				$sh_linecount=round($sh_linecount,$round_value);
				for($i=1;$i<=$sh_cnt;$i++)
				{	
					$upname=strtoupper(mysql_real_escape_string(trim($_POST['mls'.$i])));
					$uploadby=getname($upname);
					$sh_upload=mysql_query("INSERT INTO `shared_files` VALUES ('NULL','$today','$vendor_name','$f_client','$f_hospital','$f_name','$f_type','$upstatus','$uploadby','$sh_linecount')");
				}
			}
			echo '<div class="ui-widget">
				<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
					<p style="padding-top:10px; text-align:center;"><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					<strong>Success!</strong> Your files details updated successfully.</p>
				</div>
				</div>';
			 }
			 else
			 {
			  echo '<div class="ui-widget">
					<div class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
						<p style="padding-top:10px; text-align:center;"><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
						<strong>Error !</strong> File already Exist please check.</p>
					</div>
				</div>';
			 }
			 echo "
			  <p style='font-size:10px;'>
				<table align=\"center\">
				<tr><td>Platform ID</td><td>:</td><td>".$plat_id."</td></tr>
				<tr><td>Client</td><td>:</td><td>".$f_client."</td></tr>
				<tr><td>Hospital</td><td>:</td><td>".htmlentities($f_hospital)."</td></tr>
				<tr><td>File No</td><td>:</td><td>".htmlentities($f_name)."</td></tr>
				<tr><td>File Type</td><td>:</td><td>".htmlentities($f_type)."</td></tr>
				<tr><td>File Minutes</td><td>:</td><td>".htmlentities($f_min)."</td></tr>
				<tr><td>Upload Type</td><td>:</td><td>".htmlentities($upstatus)."</td></tr>
				<tr><td>Line Count</td><td>:</td><td>".htmlentities($linecount)."</td></tr>
				</table>
			  </p>
			</div>";	
		}
		else
		{
			echo "<script> dhtmlx.alert({
			title:\"Warning !!!\",
			ok:\"Ok\",
			text:\"Uploaded file is empty please check\"
			});</script>";
		}
		
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
		$f_day=date('Y-m-d',time()-60*60*24*6);
		$t_day=date('Y-m-d');
		$notes_q=mysql_query("SELECT `Date`,`Note` FROM  `notes` WHERE `Date` BETWEEN '$f_day' AND '$t_day' AND `To`!='QC' AND `Client`!='Escription'");
		$count_notes=mysql_num_rows($notes_q);
		if($count_notes!=0)
		{
			$a=1;
			echo "<div class=\"roundborder\">";
			echo "<center><p class=\"headings\">Updates</p></center>";
			echo "<table border=\"1\" width=\"350\" cellspacing=\"0\" class=\"ui-widget ui-widget-content ui-corner-all\" align=\"center\">";
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
		//Leave Notes
		$t_day=date('Y-m-d',time()+60*60*24*1);
		$n_day=date('Y-m-d',time()+60*60*24*6);
		$leave_q=mysql_query("SELECT `Leave_Date`,`Permission_status` FROM  `leave_request` WHERE `Employee_ID`='$loginas' AND `Leave_Date` BETWEEN '$t_day' AND '$n_day'");
		$count_leave=mysql_num_rows($leave_q);
		if($count_leave!=0)
		{
			$a=1;
			echo "<div class=\"roundborder\">";
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
		//Previous Day
		$p_day=date('Y-m-d',time()-60*60*24*1);
		$up_by=$_SESSION['idsilmlsname'];
		$lc_q=mysql_query("SELECT `Linecount` FROM `file_details` WHERE `Uploadedby`='$up_by' AND `Date`='$p_day'");
		$lc_count=mysql_num_rows($lc_q);
		if($lc_count!=0)
		{
			$lines=0;
			while($lc_row=mysql_fetch_array($lc_q))
			{
			$lines=$lines+$lc_row['Linecount'];
			}
			echo "<div class=\"roundborder\">";
			echo "<center><p class=\"headings\">Previous Day Lines</p></center>";
			echo "<p class=\"poptar\">Yesterday you have achieved <span class=\"poptarget\">".$lines."</span></p>";
			echo "</div>";
		}
		//Upload Updates
		$upload_q=mysql_query("SELECT `File_name`,`File_location` FROM  `admin_uploads`");
		$count_upload=mysql_num_rows($upload_q);
		if($count_upload!=0)
		{
			$a=1;
			echo "<div class=\"roundborder\">";
			echo "<center><p class=\"headings\">Uploads</p></center>";
			echo "<table border=\"1\"  width=\"350\" cellspacing=\"0\" class=\"ui-widget ui-widget-content ui-corner-all\" align=\"center\">";
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