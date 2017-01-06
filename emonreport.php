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

	if(thisform.monthpicker.value==="")
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Select a Month"});
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
            
            <h2>Upload Escription TAT Excel Details</h2>
            <br />
            <p style="color:#FF0000; text-align:center; font-size:14px;">Upload a MS-Excel ( 97-2003 ) (*.xls) File</p>
            <table align="center" cellspacing="10">
            <tr>
            <td align="left">Choose File</td>
            <td width="10">:</td>
            <td><input type="file" name="file" id="file" /></td>
            </tr>
            <tr>
            <td>Month</td>
            <td>:</td>
            <td> <input type="text" id="monthpicker" title="Select the Date" name="month" value="<?php echo date('F Y');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off"  readonly/>
			</td>
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
			if(isset($_FILES['file'],$_POST['month']))
			{
             $month=$_POST['month'];           
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
					$hr_id = $data->sheets[0]["cells"][$x][1];
					$user_id = $data->sheets[0]["cells"][$x][2];
					$job_id = $data->sheets[0]["cells"][$x][3];
					$dic_date = $data->sheets[0]["cells"][$x][4];
					$sub_date = $data->sheets[0]["cells"][$x][5];
					$cust_name = $data->sheets[0]["cells"][$x][6];
					$exp_tat = $data->sheets[0]["cells"][$x][7];
					$tat = $data->sheets[0]["cells"][$x][8];
					$dsp_typed = $data->sheets[0]["cells"][$x][9];
					$ndsp_typed = $data->sheets[0]["cells"][$x][10];
					$dsp_edited = $data->sheets[0]["cells"][$x][11];
					$ndsp_edited = $data->sheets[0]["cells"][$x][12];
					$query="INSERT INTO `escript_report` VALUES ('NULL','$month','$hr_id','$user_id','$job_id','$dic_date','$sub_date','$cust_name','$exp_tat','$tat','$dsp_typed','$ndsp_typed','$dsp_edited','$ndsp_edited')";
					//$id_query= "INSERT INTO `escript_id` VALUES ('NULL','$hr_id','$user_id')";
					//echo "$hr_id \t $user_id \t $job_id \t $dic_date \t $sub_date \t $cust_name \t $exp_tat \t $tat \t $dsp_typed \t $ndsp_typed \t $dsp_edited \t $ndsp_edited <br>";
			    	$res=mysql_query($query);
					//$res_id=mysql_query($id_query);
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
<script src="js/element.js"></script>
</html>