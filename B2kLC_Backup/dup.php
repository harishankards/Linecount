<?php include('editortop.php');?>
<style>
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }
select { margin-bottom:0px; width:165px; padding: .2em; text-align:left; }
fieldset { padding:0; border:0; margin-top:25px; }
#f_platformid{text-transform:uppercase;}
.target { font-size:50px; color:#00CCFF; font:Georgia, "Times New Roman", Times, serif; text-align:center; }
.target_to_achieve { font-size:50px; color:#FF0000; font:Georgia, "Times New Roman", Times, serif; text-align:center; }
.tar { font-size:20px; color:#FF9933; font:Georgia, "Times New Roman", Times, serif; text-align:center; }
a, a:link, a:visited {
	color: #FF9933; text-align:center;
}
</style>
<script language="javascript" type="text/javascript">
function reload()
{
        setTimeout(function(){ window.location = "dup.php";}, 0);
}
function check(thisform)
{
	if(document.getElementById('plat_id').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter a platform ID"});
		return false;
	}
	if(document.getElementById('f_hospital').value==='-1')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Hospital"});
		return false;
	}
	if(document.getElementById('dup').value==='-1')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Dup Status"});
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
	if(document.getElementById('fileno').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter a File number"});
		return false;
	}
	if(document.getElementById('f_min').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter File minutes"});
		return false;
	}
	var Exp = /^[0-9]+$/;
	if(document.getElementById('fileup').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter a charachter count"});
		return false;
	}
	if (!document.getElementById('fileup').value.match(Exp)) 
    {
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Numeric Values"});
        return false;
    } 
	
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
<div id="main">
<table border="0" cellpadding="5" align="center" style="font-size:11px;">
    <tr align="center">
        <td width="64%">
            <table class="ui-widget ui-widget-content ui-corner-all" style="height:450px;">
                <tr class="ui-widget-header">
                    <td align="center" style="height:35px; font-size:18px;" class="ui-widget ui-corner-all">Upload Completed Files Here</td>
                </tr>
                <tr>
            	<td>
                <form name="Filesubmit" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" >
                    <table align="center" width="520" cellspacing="5" style="padding-left:65px;">
                        <tr>
                            <td align="left">Select the Shift</td>
                            <td>:</td>
                            <td align="left">
                                <div id="shiftradioset">
                                    <input type="radio" name="shift" id="d_shift" value="Day" checked="true"><label for="d_shift">Day</label>
                                    <input type="radio" name="shift" id="n_shift" value="Night"><label for="n_shift">Night</label>
                                </div>
                            </td>
                        </tr>
                        
                        <tr align="left">
                            <td align="left">Select the Date</td><td>:</td>
                            <td align="left">
                                <input type="text" id="datepicker" title="Select the Date" name="date1" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                            </td>
                        </tr>
                        
                        <tr align="left">
                            <td align="left">Platform ID</td>
                            <td>:</td>
                            <td align="left">
                                <input type="text" name="plat_id" id="plat_id" size="15" value="<?php if(isset($_SESSION['platform_id'])){ echo $_SESSION['platform_id'];}?>" class="text ui-widget-content ui-corner-all">
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="left">Choose Hospital</td><td>:</td>
                            <td align="left">
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
                            <td align="left">DUP</td>
                            <td>:</td>
                            <td align="left">
                                <select name="dup" id="dup" class="text ui-widget-content ui-corner-all">
                                <option selected="selected" value="-1">--Select upload type--</option>
                                <?php
                                echo '<option value="No DUP">Non DUP / Full review</option>';
                                $sql=mysql_query("select `Nature` from `jobnature` order by `Nature`");	
                                while($row=mysql_fetch_array($sql))
                                {
                                    $nat=$row['Nature'];
                                    echo '<option value="'.htmlentities($nat).'">DUP/'.htmlentities($nat).'</option>';
                                }
                                echo '<option value="DUP/ADT">DUP/ADT</option>';
                                ?>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="left">File type</td>
                            <td>:</td>
                            <td align="left">
                                <div id="typeradioset">
                                    <input type="radio" name="type" id="radio1" value="Blank" ><label for="radio1">Blank</label>
                                    <input type="radio" name="type" id="radio2" value="Edit"><label for="radio2">Edit</label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <tr>
                            <td align="left">File No</td><td>:</td>
                            <td align="left">
                                <input type="text" name="fileno" id="fileno" size="15" value="" class="text ui-widget-content ui-corner-all" autocomplete="off" onBlur="checkNum(this);">
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="left">File's Character Count</td>
                            <td>:</td>
                            <td align="left">
                                <input type="text" name="fileup" id="fileup" size="15" maxlength="5" class="text ui-widget-content ui-corner-all" autocomplete="off" onBlur="checkNum(this);"><a rel="imgtip[0]">&nbsp;&nbsp;To Know Click Here</a>
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="left">File Minutes</td>
                            <td>:</td>
                            <td align="left">
                                <input type="text" name="f_min" id="f_min" size="10" class="text ui-widget-content ui-corner-all" autocomplete="off">
                            </td>
                        </tr>
                        
                        <tr>
                            <td align="left">Voice No</td>
                            <td>:</td>
                            <td align="left">
                                <input type="text" name="voiceno" id="voiceno" size="15" value="" class="text ui-widget-content ui-corner-all" autocomplete="off"> * Please enter only if it is a PJO file
                            </td>
                        </tr>
                    </table>
                    <br>
                    <center>
                    <input type="button" name="fsubmit" value="Submit File Details" onClick="check(this.form)" style="height:30px; width:150px;" />
                    </center>
                </form>
            </td>
            </tr>
            </table>
        </td>
    
        <td>
            <table class="ui-widget ui-widget-content ui-corner-all" style="height:280px; width:300px;">
            <tr class="ui-widget-header"><td align="center" class="ui-widget ui-corner-all" style="height:35px; font-size:18px;">Todays Target</td></tr>
            <tr>
            <td>
                <?php
                $t_lc=0;
                $dat=date('Y-m-d');
                $profile_chk=mysql_query("SELECT `DUP_target` FROM `editor_profile` WHERE `ID` ='$id'");
                $check_count=mysql_num_rows($profile_chk);
                if($check_count!=0)
                {
                    while($p_row=mysql_fetch_array($profile_chk))
                    {
                        $target=$p_row['DUP_target'];
                    }
                    if($target!=0)
                    {
                        $upload_by=$_SESSION['EMP_NAME_ID'];
                        $result=mysql_query("SELECT `Linecount` FROM `file_details` FORCE INDEX (`File_No`) WHERE `Date`='$dat' AND	`Uploadedby`='$upload_by'");
                        $target=$target;
                        $t_count=mysql_num_rows($result);
                        if($t_count!=0)
                        {
                            while($t_row=mysql_fetch_array($result))
                            {
                                $t_lc=$t_lc+$t_row['Linecount'];
                            }
                            $toachieve=$target-$t_lc;
                            if($toachieve>=0)
                            {
                                echo "<br><p class=\"tar\">you have achieved<br></p> <p class=\"target\"><br>".$t_lc."</p>";
                                echo "<br><br><p class=\"tar\">still you have to achieve</p> <p class=\"target_to_achieve\"><br>".$toachieve."</p>";
                            }
                            else
                            {
                                echo "<br><p class=\"target\"><br>Hurrah !!!</p>";
                                echo "<br><br><p class=\"tar\">you have achieved your target</p> <p class=\"target\"><br>".$t_lc."</p>";
                            }
                        } 
                        else
                        {
                            echo "<br><br><p class=\"tar\">still you have to achieve</p> <p class=\"target_to_achieve\"><br>".$target."</p>";
                        }
                    }
                    else
                    {
                        echo "<br><br><p class=\"tar\">Please Update your Profile </p><br><center><button id=\"update_profile\">Update Profile</button></center>";
                    ?>
                    <div id="dialog-form" title="Profile Update">
                    <form id="updateprofile" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <fieldset>
                    <table align="center">
                        <tr>
                            <td>
                                <label for="name">DUP Target Lines</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" name="dup_line" id="dup_line" class="text ui-widget-content ui-corner-all" />
                            </td>
                        </tr>
                    </table>
                    </fieldset>
                    </form>
                    </div>		
                    <?
                    }
                }
                else
                {
                echo "<br><br><p class=\"tar\">Please Update your Profile </p><br><center><button id=\"create_profile\">Create Profile</button></center>";
                ?>
                <div id="dialog-modal" title="Basic modal dialog">
                <p>Please Create your profile in Editor page.</p>
                </div>
                <?
                }
                ?>
            </td>
        </tr>
        </table>
        <table class="ui-widget ui-widget-content ui-corner-all" style="height:160px; width:300px; margin-top:10px;">
            <tr class="ui-widget-header">
                <td align="center" class="ui-widget ui-corner-all" style="height:35px; font-size:18px;">Updates</td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
    </td>
    </tr>
</table>
    <div class="cleaner"></div>
    <div class="cleaner"></div>
</div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
    <script>
	$(function() {
    $( "#dialog-modal" ).dialog({
	  autoOpen: false,
      height: 145,
      modal: true,
	  buttons: {
        "ok": function() {
          document.location.href = "editor.php";
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
    });
  });
  	$(function() {
    $( "#dialog-message" ).dialog({
	  autoOpen: false,
      height: 390,
      modal: true,
	  buttons: {
        "ok": function() {
          document.location.href = "dup.php";
        }
       },
    });
  });
    $(function() {
    $( "#dialog-form" ).dialog({
	  autoOpen: false,
      modal: true,
	  width: 330,
      buttons: {
        "Update Profile": function() {
          $('#updateprofile').submit();
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        allFields.val( "" ).removeClass( "ui-state-error" );
      }
    });
  });

  $( "#update_profile" )
      .button()
      .click(function() {
        $( "#dialog-form" ).dialog( "open" );
      });
	 $( "#create_profile" )
      .button()
      .click(function() {
        $( "#dialog-modal" ).dialog( "open" );
      });
	  $(function() {
		$( "#shiftradioset" ).buttonset();
		$( "#typeradioset" ).buttonset();
	});
  </script>
      <?php
	  if(isset($_POST['dup_line']))
	  {
	  	$dupl=$_POST['dup_line'];
		$re_query=mysql_query("UPDATE `editor_profile` SET `DUP_target`='$dupl' WHERE `ID`='$id'");
		if($re_query)
		{
	  		echo "<script>alert('success');</script>";
	  	}
	  }
if(isset($_POST['fileup'],$_POST['fileno'],$_POST['date1'],$_POST['shift'],$_POST['type'],$_POST['dup'],$_POST['f_hospital']))
{
	$dat=mysql_real_escape_string(trim($_POST['date1'])); //date
	$f_shift=mysql_real_escape_string(trim($_POST['shift']));
	$f_type=mysql_real_escape_string(trim($_POST['type'])); //File type
	$f_dup=mysql_real_escape_string(trim($_POST['dup'])); //Dup type
	$f_hospital=mysql_real_escape_string(trim($_POST['f_hospital'])); // Client Name
	$_SESSION['Hospital']=$f_hospital;
	$f_min=mysql_real_escape_string(trim($_POST['f_min']));// File Minutes
	$f_name=mysql_real_escape_string(trim($_POST['fileno']));
	$flag='';
	$plat_id=strtoupper(mysql_real_escape_string(trim($_POST['plat_id'])));
	$_SESSION['platform_id']=$plat_id;
	$uploadby=$_SESSION['idsileditorname'];
	
	if(isset($_POST['voiceno']))
	{
		if($_POST['voiceno']!='')
		{
			$pjo_voice=$_POST['voiceno'];
		}
		else
		{
			$pjo_voice="No Voice";
		}
	}

	if($f_dup=="DUP/ADT")
	{
		$editedby="Not yet Edited";
		$upstatus="DUP/ADT";
		$accuracy='';
		$flag=1;
		$thirdlevel='Not yet Edited';
		$thirdeditor='Not yet Edited';
		$upload_to='Not yet Edited';
		$pick_by_edit='';
		$Time_by_edit='';
	}
	
	elseif($f_dup=="No DUP")
	{
		$editedby="Not yet Edited";
		$upstatus="No DUP";
		$accuracy='';
		$flag=1;
		$thirdlevel='Not yet Edited';
		$thirdeditor='Not yet Edited';
		$upload_to='Not yet Edited';
		$pick_by_edit='';
		$Time_by_edit='';
	}
	
	else
	{
		$hosp=mysql_query("SELECT * FROM `hospitals` WHERE `Hospital_name`='$f_hospital'");
		while($hrow=mysql_fetch_array($hosp))
		{
			$no_blnk=$hrow['Job_nature'];
			if($f_dup<=$hrow['Job_nature'])
			{
				$editedby="DUP / ".$f_dup;
				$upstatus="DUP / ".$f_dup;
				$accuracy='100';
				$flag=1;
				$thirdlevel="NO";
				$upload_to="Hospital/Customer";
				$pick_by_edit=$datetime;
				$Time_by_edit=$datetime;
				$thirdeditor='No Third Editing';
			}
			else
			{
				$editedby="DUP / ".$f_dup;
				$upstatus="DUP / ".$f_dup;
				$flag=1;
				$accuracy='';
				$editedby="Not yet Edited";
				$thirdlevel='Not yet Edited';
				$thirdeditor='Not yet Edited';
				$upload_to='Not yet Edited';
				$pick_by_edit='';
				$Time_by_edit='';
			}
		}
	}
	
	if($flag==1)
	{
		$vendor_name=$_SESSION['Vendorname'];
		$client=mysql_query("SELECT * FROM `hospitals` WHERE `Hospital_name`='$f_hospital'");
		while($crow=mysql_fetch_array($client))
		{
			$f_client=$crow['Client'];
		}
		
		$c_count =mysql_real_escape_string(trim($_POST['fileup']));
		$size=$c_count/65;
		$linecount=round($size,$round_value);
		$today=$dat;
		$pick_by_III_level='';
		$uptime_by_III_level='';
		$uploadfile='';
		$shared_file='NO';
		$proofedby='No Proofing';
		$upload=mysql_query("INSERT INTO `file_details` VALUES ('NULL','$today','$f_shift','$vendor_name','$f_client','$f_hospital','$plat_id','$f_name','$pjo_voice','$f_type','$f_min','$linecount','$upstatus','$shared_file','$uploadby','$proofedby','$editedby','$thirdlevel','$thirdeditor','$upload_to','$accuracy','$editedby','$datetime','$pick_by_edit','$Time_by_edit','$pick_by_III_level','$uptime_by_III_level','$uploadfile')");
	
		echo "<div id='dialog-message' title='File details' >";
		if($upload)
		{
		$uploadby=$_SESSION['idsileditorname'];
		$fp = fopen($log_dir.$uploadby.".txt", "a+");
		$comment=$etr_id." has uploaded a DUP file ".$f_name." in IDSIL / PJO";
		fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
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
				text:\"You are not allowed to submit with ".$f_dup." blanks for this ".$f_hospital." account\"
				});
			</script>";
	}
		
}
?>

</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>
