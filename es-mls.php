<?php include('es-mlstop.php');?>
<style>
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }
select { margin-bottom:0px; width:165px; padding: .2em; text-align:left; }
textarea { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }
</style>
<script language="javascript" type="text/javascript">
function reload()
{
        setTimeout(function(){ window.location = "es-mls.php";}, 0);
}
function check(thisform)
{
	var Exp = /^[0-9.]+$/;
	if(document.getElementById('p_id').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Escription ID"});
		return false;
	}
	if(document.getElementById('f_hos').value==='-1')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Hospital"});
		return false;
	}
	if(document.getElementById('dsp_status').value==='-1')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose a DSP Status"});
		return false;
	}
	if(document.getElementById('fileno').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter a Job Number"});
		return false;
	}
	/*if(document.getElementById('lines').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Line count"});
		return false;
	}
	if(!document.getElementById('lines').value.match(Exp)) 
    {
		dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Numeric Values"});
        return false;
    } */
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
		dhtmlx.alert({title:"Warning!!!", text:"Please select Job type"});
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
    <table border="0" cellpadding="0" align="center" style="font-size:11px; width:815px;"> 
        <tr>
        <td width="65%">
            <table class="ui-widget ui-widget-content ui-corner-all" style="height:550px; width:500px;">
            <tr class="ui-widget-header">
                <td align="center" style="height:35px; font-size:18px;" class="ui-widget ui-corner-all">Upload Completed Files Here</td>
            </tr>
            <tr>
            <td style="padding:5px;">
            <center><p style="color:#FF0000; font-size:12pt;"><b>*&nbsp; Please Update your linecount <a href="es-mlsview.php">Here</a></b></p></center>
            <form name="Filesubmit" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <center>
            <br>
            <table align="center" cellspacing="3" width="400" cellpadding="2">
               <tr align="left">
                    <td width="150">EScription ID</td>
                    <td>:</td>
                    <td><input type="text" name="p_id" id="p_id" size="15" maxlength="15" value="<?php if(isset($_SESSION['escriptid'])){ echo $_SESSION['escriptid'];}?>" class="text ui-widget-content ui-corner-all">
                    </td>
               </tr>
               <tr align="left">
                    <td width="100">Shift</td>
                    <td>:</td>
                    <td>
                    <div id="shiftradioset">
                            <input type="radio" name="shift" id="d_shift" value="Day" checked="true"><label for="d_shift">Day</label>
                            <input type="radio" name="shift" id="n_shift" value="Night"><label for="n_shift">Night</label>
                    </div>
                    </td>
                </tr>
                
                <tr align="left">
                    <td>Date</td><td>:</td>
                    <td>
                      <input type="text" id="datepicker" title="Select the Date" name="day" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off"  readonly/> ( YYYY-MM-DD )
                    </td>
                </tr>
                
                <tr align="left">
                    <td>Hospital</td><td>:</td>
                    <td>
                        <select name="f_hos" id="f_hos" class="text ui-widget-content ui-corner-all">
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
                        $sql=mysql_query("select `Hospital_name` from `hospitals` WHERE `Client`='Nuance' order by `Hospital_name`");
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
                    <td>DSP / NON DSP</td>
                    <td>:</td>
                    <td>
                    <select name="dsp_status" id="dsp_status" class="text ui-widget-content ui-corner-all">
                    <?
                        if(isset($_SESSION['Dsp_status']))
                        {	
                            $type_show=$_SESSION['Dsp_status'];
                            if($type_show!='-1')
                            {
                                echo "<option selected=\"selected\" value=".$type_show.">".$type_show."</option>";
                                if($type_show=="DSP")
                                {
                                    echo "<option value=\"NON-DSP\">NON DSP</option>";
                                }
                                else
                                {
                                    echo "<option value=\"DSP\">DSP</option>";
                                }
                            }
                            else
                            {
                                echo "<option selected=\"selected\" value=\"-1\">--Select Status--</option>";
                            }
                        }
                        else
                        {
                            echo "<option selected=\"selected\" value=\"-1\">--Select Status--</option>";
                            echo "<option value=\"DSP\">DSP</option>";
                            echo "<option value=\"NON-DSP\">NON DSP</option>";
                        }
                        ?>
                    </select> 
                    </td>
                </tr>
                
               <tr align="left">
                    <td>JOB No</td><td>:</td>
                    <td>
                        <input type="text" name="fileno" id="fileno" size="15" value="" class="text ui-widget-content ui-corner-all" autocomplete="off" onBlur="checkNum(this);">
                    </td>
                </tr>
               <tr align="left">
                <td>File type</td>
                    <td>:</td>
                    <td>
                     <div id="typeradioset">
                            <input type="radio" name="type" id="radio1" value="Trans" ><label for="radio1">Trans</label>
                            <input type="radio" name="type" id="radio2" value="Edit"><label for="radio2">Edit</label>
                     </div>
                    </td>
                </tr>
                <tr align="left">
                    <td>Line Count</td>
                    <td>:</td>
                    <td><input type="text" name="lines" id="lines" size="7" maxlength="7" class="text ui-widget-content ui-corner-all" autocomplete="off"></td>
                </tr>
                 
                <tr align="left">
                    <td>Pending Reason</td>
                    <td>:</td>
                    <td>
                    <select name="pend_rsn" id="pend_rsn" class="text ui-widget-content ui-corner-all">
                        <option selected="selected" value="-1">--Select Reason--</option>
                        <option value="1 Blank">1 Blank</option>
                        <option value="2 Blanks">2 Blanks</option>
                        <option value="3 Blanks">3 Blanks</option>
                        <option value="NTS_others">NTS_Others pending</option>
                        <option value="Fullreview">Full Review</option>
                   </select><span style="color:#FF0000; font-size:12pt;">&nbsp;&nbsp;*&nbsp;*</span>
                   </td>
                </tr>
                
                <tr align="left">
                    <td>Comment</td>
                    <td>:</td>
                    <td>
                        <textarea name="comment" id="comment" rows="3" class="text ui-widget-content ui-corner-all" title="Please Leave a comment about a pending reason"></textarea><span style="color:#FF0000; font-size:12pt;">&nbsp;&nbsp;*</span>
                    </td>
                </tr>
                <tr align="left">
                <td></td><td></td><td width="400"><p style="color:#FF0000; font-size:9pt;"><b>*&nbsp; Please leave a comment about pending reason<br>*&nbsp;* Please Select If pended to QC / Senior QC</b></p></td></tr>
           </table>
           </center>
                <center>
                    <input type="button" name="fsubmit" value="Submit" onClick="check(this.form)" />
                </center>
            </form>
            </td>
            </tr>
            </table>
        </td>
        <td width="40%">
            <table class="ui-widget ui-widget-content ui-corner-all" style="height:270px; width:300px;">
                <tr class="ui-widget-header">
                    <td align="center" style="height:35px; font-size:18px;" class="ui-widget ui-corner-all">Todays taget</td>
                </tr>
                <tr>
                <td style="padding:5px;">
                </td>
                </tr>
            </table>
            <table class="ui-widget ui-widget-content ui-corner-all" style="height:270px; width:300px; margin-top:10px;">
                <tr class="ui-widget-header">
                    <td align="center" style="height:35px; font-size:18px;" class="ui-widget ui-corner-all">Updates</td>
                </tr>
                <tr>
                <td style="padding:5px;">
                </td>
                </tr>
            </table> 
        </td>
        </tr>
        </table>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>		
    <?php include('footer.php');?>
<script>
  $(function() {
    $( "#dialog-message" ).dialog({
      modal: true,
	  width: 300,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
		  document.location.href = "es-mls.php";
        }
      }
    });
  });
  $(function() {
		$( "#shiftradioset" ).buttonset();
		$( "#typeradioset" ).buttonset();
	});
</script>
<?php
if(isset($_POST['p_id'],$_POST['shift'],$_POST['day'],$_POST['f_hos'],$_POST['dsp_status'],$_POST['fileno'],$_POST['fileno'],$_POST['type']))
{
	$_SESSION['escriptid']=mysql_real_escape_string(trim(strtoupper($_POST['p_id'])));
	$_SESSION['Hospital']=mysql_real_escape_string(trim($_POST['f_hos']));
	$_SESSION['Dsp_status']=mysql_real_escape_string(trim($_POST['dsp_status']));
	$_SESSION['day']=mysql_real_escape_string(trim($_POST['day']));
	$f_platform_ID=mysql_real_escape_string(trim(strtoupper($_POST['p_id'])));
	$f_mls_id=$_SESSION['ES-MLS'];//MLS Name
	$f_date=mysql_real_escape_string(trim($_POST['day'])); //date
	$f_shift=mysql_real_escape_string(trim($_POST['shift']));//Shift
	$f_no=mysql_real_escape_string(trim($_POST['fileno']));//File no
	$f_type=mysql_real_escape_string(trim($_POST['type'])); //File type
	$f_dup=mysql_real_escape_string(trim($_POST['dsp_status'])); //Dup type
	$f_hospital=mysql_real_escape_string(trim($_POST['f_hos'])); // Client Name
	$f_lines=mysql_real_escape_string(trim($_POST['lines']));
	if(($f_lines=='') || ($f_lines<0))
	{
		$f_lines=0;
	}
	$cur_date=date('Y-m-d');
	if($_POST['pend_rsn']=='-1')
	{
		
		$pend="Direct Submission";
		$mt_comment="Direct Submission";
		$qc="Direct Submission";
		$QC_id="Direct Submission";
		$QC_comment="Direct Submission";
		$pick_by_QC='Direct Submission';
		$uploadto="Client";
	}
	elseif($_POST['pend_rsn']=="Senior QC")
	{
		$pend="Direct Submission";
		$qc="Direct Submission";
		$QC_id="Direct Submission";
		$uploadto="Direct Submission";
		$pick_by_QC='Direct Submission';

	}
	else
	{
		$pend=$_POST['pend_rsn'];
		$mt_comment=$_POST['comment'];
		$qc="Not Yet Picked";
		$QC_id="Not Yet Picked";
		$QC_comment="Not Yet Picked";
		$uploadto="Not Yet Edited";
		$pick_by_QC='';
	}
	$vendor_name=$_SESSION['Vendorname'];
	$id_query=mysql_query("SELECT `User_ID` FROM `escript_id` WHERE `User_ID`='$f_platform_ID'");
	$id_count=mysql_num_rows($id_query);
	if($id_count!=0)
	{
		$client_query=mysql_query("SELECT `Client`,`Platform` FROM `hospitals` WHERE `Hospital_name`='$f_hospital'");
		while($crow=mysql_fetch_array($client_query))
		{
			$f_client=$crow['Client'];
			$f_platform=$crow['Platform'];
		}
		$uploadby=$_SESSION['esmlsname'];
		$linecount=round($f_lines,$round_value);
		$Time_by_mls=$datetime;
		$qc_ratings="Not yet picked";
		$upload=mysql_query("INSERT INTO `escript_filedetails` VALUES ('NULL','$f_date','$f_shift','$vendor_name','$f_client','$f_hospital','$f_platform','$f_platform_ID','$f_dup','$f_no','$f_type','$linecount','$uploadby','$pend','$mt_comment','$QC_id','$qc','$qc_ratings','$QC_comment','$uploadto','$Time_by_mls','$pick_by_QC')");
			echo "<div id='dialog-message' title='File details' >";
			if($upload)
			{
			$uploadby=$_SESSION['esmlsname'];
			$comment=$f_mls_id." has added the file in Escription, File No:".$f_no;
			$fp = fopen($log_dir.$uploadby.".txt", "a+");
			fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
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
				<tr><td>Platform ID</td><td>:</td><td>".$f_platform_ID."</td></tr>
				<tr><td>Client</td><td>:</td><td>".$f_client."</td></tr>
				<tr><td>Hospital</td><td>:</td><td>".htmlentities($f_hospital)."</td></tr>
				<tr><td>File No</td><td>:</td><td>".htmlentities($f_no)."</td></tr>
				<tr><td>File Type</td><td>:</td><td>".htmlentities($f_type)."</td></tr>
				<tr><td>Upload Type</td><td>:</td><td>".htmlentities($f_dup)."</td></tr>
				<tr><td>Line Count</td><td>:</td><td>".htmlentities($linecount)."</td></tr>
				</table>
			  </p>
			</div>";
		}
		else
		{	
			echo "<script> dhtmlx.alert({
					title:\"Error !!!\",
					ok:\"Ok\",
					text:\"ID Doesn't Exist Please contact Administrator\"
					});
				</script>";
		}
}
?>
<?php
/*
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
*/
?>
	   
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>