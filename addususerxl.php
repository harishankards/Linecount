<?php 
error_reporting(0);
include('top.php');?>
<style>
input.text { margin-bottom:0px; width:125px; padding: .2em; text-align:center; }
input.file { margin-bottom:0px; width:125px; padding: .2em; text-align:center; }
select{ margin-bottom:0px; width:180px; padding: .2em; text-align:left;}
.ui-datepicker-calendar {
    display: none;
    }
 
</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.file.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Choose a File"});
      return false;
    }

	
	thisform.submit();
	save();
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
    <br>
    <script>
function call() 
{
	var qty = parseInt(document.getElementById('f_tot').value);
	if (document.getElementById('f_tot').value==='')
	{
	qty=0;
	}
	var tot = qty + 1;
	document.getElementById('f_tot').value=tot;
}
function id_call() 
{
	var idqty = parseInt(document.getElementById('id_tot').value);
	if (document.getElementById('id_tot').value==='')
	{
	idqty=0;
	}
	var idtot = idqty + 1;
	document.getElementById('id_tot').value=idtot;
}
</script>

 	<form name="Filesubmit" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" > 
            
            <h2>Upload US User Excel Details</h2>
            <br />
            <p style="color:#FF0000; text-align:center; font-size:14px;">Upload a MS-Excel ( 97-2003 ) (*.xls) File</p>
            <table align="center" cellspacing="10">
            <tr>
            <td align="left">Choose File</td>
            <td width="10">:</td>
            <td><input type="file" name="file" id="file" /></td>
            </tr>
            <tr><td colspan="3" align="center"><br><input type="button" name="fsubmit" value="Submit"  onClick="check(this.form)"/></td></tr>
            </table>
			<center></center>
            </form>
            <br />
			<br />
            <table align="center">
            <tr><td>Total No Of Records</td><td>:</td><td><input type="text" name="f_tot" id="f_tot" size="6" class="text ui-widget-content ui-corner-all"></td></tr>
            <!--<tr><td>Total No Of Users</td><td>:</td><td><input type="text" name="id_tot" id="id_tot" size="3" class="text ui-widget-content ui-corner-all"></td></tr>-->
            </table>
            <?php
			if(isset($_FILES['file']))
			{
                       
			echo "<strong>The Uploaded file is </strong> <u>".$_FILES['file']['name']."</u><br><br>";
			require_once 'reader.php';
			$uploaddir = $admin_dir;//for localhost
			$uploadfile = $uploaddir . basename($_FILES['file']['name']);
			//chmod($uploadfile,755);
            echo $uploadfile;
			if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
				echo "File is valid, and was successfully uploaded.\n<br><br>";
			} 
			else 
			{
				echo "Possible file upload attack!\n";
			}
			//echo 'Here is some more debugging info:';
			//print_r($_FILES);
			print "</pre>";
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			$data->read($uploadfile);
			$tot=count($data->sheets[0]["cells"]);
			$tot=$tot-1;
			$count=0;
			$not=0;
			echo "<strong>Total No. of records are ".$tot."</strong><br><br>";
			
			for ($x=2; $x<=count($data->sheets[0]["cells"]); $x++) 
				{
					$u_hr_id = $data->sheets[0]["cells"][$x][1];
					$u_name_as_per_hr = $data->sheets[0]["cells"][$x][2];
					$u_Login_id = $data->sheets[0]["cells"][$x][3];
					$u_password = $data->sheets[0]["cells"][$x][4];
					$u_mt_qc = $data->sheets[0]["cells"][$x][5];
					$u_Fiesa_id = $data->sheets[0]["cells"][$x][6];
					$u_fiesa_pass = $data->sheets[0]["cells"][$x][7];
					$u_Mar_id = $data->sheets[0]["cells"][$x][8];
					$u_Mar_pass = $data->sheets[0]["cells"][$x][9];
					$u_assigned_user = $data->sheets[0]["cells"][$x][10];
					$u_assigned_date = $data->sheets[0]["cells"][$x][11];
					$u_platform = $data->sheets[0]["cells"][$x][12];
					$u_account = $data->sheets[0]["cells"][$x][13];
					$u_DSP_NonDSP = $data->sheets[0]["cells"][$x][14];
					$u_in_house = $data->sheets[0]["cells"][$x][15];
					$u_id_status = $data->sheets[0]["cells"][$x][16];
					
					$c_sql=mysql_query("SELECT * FROM `ususer_details` WHERE `HR_ID`='$u_hr_id' AND `Login_Id`='$u_Login_id' AND `Assigned_User`='$u_assigned_user' AND  `Account`='$u_account' AND `DSP/NONDSP`='$u_DSP_NonDSP' AND `Inhouse_HT_Branch`='$u_in_house'");
					$c_count=mysql_num_rows($c_sql);
					if($c_count==0)
					{
						$query="INSERT INTO `ususer_details` VALUES ('NULL','$u_hr_id','$u_name_as_per_hr','$u_Login_id','$u_password','$u_mt_qc','$u_Fiesa_id','$u_fiesa_pass','$u_Mar_id','$u_Mar_pass','$u_assigned_user','$u_assigned_date','$u_platform','$u_account','$u_DSP_NonDSP','$u_in_house','$u_id_status')";
					
			    		$res=mysql_query($query);
						echo "<script> call(); </script>";
						if($res)
						{
							$count=$count+1;
						}
						if(!$res)
						{
							$not=$not+1;
						}
						if($res_id)
						{
							$id_count=$id_count+1;
							echo "<script> id_call(); </script>";
						}
					}
					
					
					
				}
				echo "<br><br><strong>".$count." records are inserted successfully.</strong><br><br>";
				echo "<strong>".$not." records are already Exist.</strong><br><br>";
			}
?>

     <br />
     <br />
     <br />
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
</body>
</html>
