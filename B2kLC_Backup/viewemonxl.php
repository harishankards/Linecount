<?PHP
error_reporting(0);
session_start();
if(!isset($_SESSION['Admin']))
{ 
	header("location:index.php?msg4=NotAllowed");
}
else
{ 
	$loginas=$_SESSION['Admin'];
	$token=$_SESSION['token'];
	$key=md5($loginas."_Admin@B2K");
	if($token==$key)
	{ 
		include('dbconfig.php');
		include('global.php');
		include('include_dir.php');
	}
	else
	{ 
		header("location:index.php?msg4=NotAllowed");
	}
}
if(isset($_POST['month'],$_POST['esid']))
{
	$month=$_POST['month'];
	$esid=$_POST['esid'];
	$fname="Escript_ID_details_of_".$month;
	$file_type = "x-msdownload";
	$file_ending = "xls";
	HEADER("Content-Type: application/$file_type");
	HEADER("Content-Disposition: attachment; filename=$fname.$file_ending");
	HEADER("Pragma: no-cache");
	echo "<b>Generated on ".date('d-m-Y').".</b><br />";
	if($esid=="-1")
	{
		$que="SELECT `User_ID` FROM `escript_id`";
	}
	else
	{
		$que="SELECT `User_ID` FROM `escript_id` WHERE `User_ID`='$esid'";
	}
	$id_query=mysql_query($que);
	$a=1;
	while($idrow=mysql_fetch_array($id_query))
	{
		$id=$idrow['User_ID'];
		$intat_d_typd2=0;
		$intat_nd_typd2=0;
		$intat_d_edtd2=0;
		$intat_nd_edtd2=0;
		$outtat_d_typd2=0;
		$outtat_nd_typd2=0;
		$outtat_d_edtd2=0;
		$outtat_nd_edtd2=0;
		$intat_d_typd4=0;
		$intat_nd_typd4=0;
		$intat_d_edtd4=0;
		$intat_nd_edtd4=0;
		$outtat_d_typd4=0;
		$outtat_nd_typd4=0;
		$outtat_d_edtd4=0;
		$outtat_nd_edtd4=0;
		$intat_d_typd6=0;
		$intat_nd_typd6=0;
		$intat_d_edtd6=0;
		$intat_nd_edtd6=0;
		$outtat_d_typd6=0;
		$outtat_nd_typd6=0;
		$outtat_d_edtd6=0;
		$outtat_nd_edtd6=0;
		$intat_d_typd8=0;
		$intat_nd_typd8=0;
		$intat_d_edtd8=0;
		$intat_nd_edtd8=0;
		$outtat_d_typd8=0;
		$outtat_nd_typd8=0;
		$outtat_d_edtd8=0;
		$outtat_nd_edtd8=0;
		$intat_d_typd12=0;
		$intat_nd_typd12=0;
		$intat_d_edtd12=0;
		$intat_nd_edtd12=0;
		$outtat_d_typd12=0;
		$outtat_nd_typd12=0;
		$outtat_d_edtd12=0;
		$outtat_nd_edtd12=0;
		$intat_d_typd24=0;
		$intat_nd_typd24=0;
		$intat_d_edtd24=0;
		$intat_nd_edtd24=0;
		$outtat_d_typd24=0;
		$outtat_nd_typd24=0;
		$outtat_d_edtd24=0;
		$outtat_nd_edtd24=0;
		$d_intat_conv2=0;
		$d_outtat_conv2=0;
		$nd_intat_conv2=0;
		$nd_outtat_conv2=0;
		$d_intat_conv4=0;
		$d_outtat_conv4=0;
		$nd_intat_conv4=0;
		$nd_outtat_conv4=0;
		$d_intat_conv6=0;
		$d_outtat_conv6=0;
		$nd_intat_conv6=0;
		$nd_outtat_conv6=0;
		$d_intat_conv12=0;
		$d_outtat_conv12=0;
		$nd_intat_conv12=0;
		$nd_outtat_conv12=0;
		$d_intat_conv24=0;
		$d_outtat_conv24=0;
		$nd_intat_conv24=0;
		$nd_outtat_conv24=0;
		$query=mysql_query("SELECT * FROM `escript_report` WHERE `User_ID`='$id' AND `Month-Year`='$month'");
		
		 echo "<b style=\"padding-left:150px;\">".$a.") Details of \"".$id."\" of the Month ".$month."</b><br />";	
		$a=$a+1;		
		echo "<br><p style=\"padding-left:150px;\">This gives the details about the 2, 4, 6, 8, 10, 12, 24 hours IN TAT and OUT TAT details of the ID \"".$id."\"</p>";
		echo "<table border=\"1\" cellspacing=\"0\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\" style=\"padding-left:150px;\">";
		echo "<tr class=\"tr0\" style=\"background-color:#99CCFF;\">
			
				<td align=\"center\" rowspan=\"2\" width=\"20%\">
					<b>DSP / Non DSP</b>
				</td>
				<td colspan=\"4\" align=\"center\">
					<b>USER ID : ".$id." / Month : ".$month."</b>
				</td>
			</tr>
			<tr class=\"tr1\" style=\"background-color:#99CCFF;\">
				<td width=\"20%\" align=\"center\">
					<b>TAT STATUS</b>
				</td>
				<td width=\"20%\" align=\"center\">
					<b>TYPED</b>
				</td>
				<td width=\"20%\" align=\"center\">
					<b>EDITED</b>
				</td>
				<td width=\"20%\" align=\"center\">
					<b>CONVERTED</b>
				</td>
			</tr>";
		while($report=mysql_fetch_array($query))
		{
			if($report['Exp_TAT']=='2')
			{
				if($report['TAT']=="IN TAT")
				{
					$intat_d_typd2=$intat_d_typd2+$report['DSP_Typed'];
					$intat_nd_typd2=$intat_nd_typd2+$report['NDSP_Typed'];
					$intat_d_edtd2=$intat_d_edtd2+$report['DSP_Edited'];
					$intat_nd_edtd2=$intat_nd_edtd2+$report['NDSP_Edited'];
				}
				else
				{
					$outtat_d_typd2=$outtat_d_typd2+$report['DSP_Typed'];
					$outtat_nd_typd2=$outtat_nd_typd2+$report['NDSP_Typed'];
					$outtat_d_edtd2=$outtat_d_edtd2+$report['DSP_Edited'];
					$outtat_nd_edtd2=$outtat_nd_edtd2+$report['NDSP_Edited'];
				}
			}
			if($report['Exp_TAT']=='4')
			{
				if($report['TAT']=="IN TAT")
				{
					$intat_d_typd4=$intat_d_typd4+$report['DSP_Typed'];
					$intat_nd_typd4=$intat_nd_typd4+$report['NDSP_Typed'];
					$intat_d_edtd4=$intat_d_edtd4+$report['DSP_Edited'];
					$intat_nd_edtd4=$intat_nd_edtd4+$report['NDSP_Edited'];
				}
				else
				{
					$outtat_d_typd4=$outtat_d_typd4+$report['DSP_Typed'];
					$outtat_nd_typd4=$outtat_nd_typd4+$report['NDSP_Typed'];
					$outtat_d_edtd4=$outtat_d_edtd4+$report['DSP_Edited'];
					$outtat_nd_edtd4=$outtat_nd_edtd4+$report['NDSP_Edited'];
				}
			}
			if($report['Exp_TAT']=='6')
			{
				if($report['TAT']=="IN TAT")
				{
					$intat_d_typd6=$intat_d_typd6+$report['DSP_Typed'];
					$intat_nd_typd6=$intat_nd_typd6+$report['NDSP_Typed'];
					$intat_d_edtd6=$intat_d_edtd6+$report['DSP_Edited'];
					$intat_nd_edtd6=$intat_nd_edtd6+$report['NDSP_Edited'];
				}
				else
				{
					$outtat_d_typd6=$outtat_d_typd6+$report['DSP_Typed'];
					$outtat_nd_typd6=$outtat_nd_typd6+$report['NDSP_Typed'];
					$outtat_d_edtd6=$outtat_d_edtd6+$report['DSP_Edited'];
					$outtat_nd_edtd6=$outtat_nd_edtd6+$report['NDSP_Edited'];
				}
			}
			if($report['Exp_TAT']=='8')
			{
				if($report['TAT']=="IN TAT")
				{
					$intat_d_typd8=$intat_d_typd8+$report['DSP_Typed'];
					$intat_nd_typd8=$intat_nd_typd8+$report['NDSP_Typed'];
					$intat_d_edtd8=$intat_d_edtd8+$report['DSP_Edited'];
					$intat_nd_edtd8=$intat_nd_edtd8+$report['NDSP_Edited'];
				}
				else
				{
					$outtat_d_typd8=$outtat_d_typd8+$report['DSP_Typed'];
					$outtat_nd_typd8=$outtat_nd_typd8+$report['NDSP_Typed'];
					$outtat_d_edtd8=$outtat_d_edtd8+$report['DSP_Edited'];
					$outtat_nd_edtd8=$outtat_nd_edtd8+$report['NDSP_Edited'];
				}
			}
			if($report['Exp_TAT']=='12')
			{
				if($report['TAT']=="IN TAT")
				{
					$intat_d_typd12=$intat_d_typd12+$report['DSP_Typed'];
					$intat_nd_typd12=$intat_nd_typd12+$report['NDSP_Typed'];
					$intat_d_edtd12=$intat_d_edtd12+$report['DSP_Edited'];
					$intat_nd_edtd12=$intat_nd_edtd12+$report['NDSP_Edited'];
				}
				else
				{
					$outtat_d_typd12=$outtat_d_typd12+$report['DSP_Typed'];
					$outtat_nd_typd12=$outtat_nd_typd12+$report['NDSP_Typed'];
					$outtat_d_edtd12=$outtat_d_edtd12+$report['DSP_Edited'];
					$outtat_nd_edtd12=$outtat_nd_edtd12+$report['NDSP_Edited'];
				}
			}
			if($report['Exp_TAT']=='24')
			{
				if($report['TAT']=="IN TAT")
				{
					$intat_d_typd24=$intat_d_typd24+$report['DSP_Typed'];
					$intat_nd_typd24=$intat_nd_typd24+$report['NDSP_Typed'];
					$intat_d_edtd24=$intat_d_edtd24+$report['DSP_Edited'];
					$intat_nd_edtd24=$intat_nd_edtd24+$report['NDSP_Edited'];
				}
				else
				{
					$outtat_d_typd24=$outtat_d_typd24+$report['DSP_Typed'];
					$outtat_nd_typd24=$outtat_nd_typd24+$report['NDSP_Typed'];
					$outtat_d_edtd24=$outtat_d_edtd24+$report['DSP_Edited'];
					$outtat_nd_edtd24=$outtat_nd_edtd24+$report['NDSP_Edited'];
				}
			}
		}
		$d_intat_conv2=(2*$intat_d_typd2)+$intat_d_edtd2;
		$d_outtat_conv2=(2*$outtat_d_typd2)+$outtat_d_edtd2;
		$nd_intat_conv2=(2*$intat_nd_typd2)+$intat_nd_edtd2;
		$nd_outtat_conv2=(2*$outtat_nd_typd2)+$outtat_nd_edtd2;
		echo "<tr align=\"center\" class=\"tr0\"><td>2 hrs DSP </td><td>IN TAT</td><td>".$intat_d_typd2."</td><td>".$intat_d_edtd2."</td><td>".$d_intat_conv2."</td></tr>";
		echo "<tr align=\"center\" class=\"tr1\"><td>2 hrs DSP </td><td>OUT TAT</td><td>".$outtat_d_typd2."</td><td>".$outtat_d_edtd2."</td><td>".$d_outtat_conv2."</td></tr>";
		echo "<tr align=\"center\" class=\"tr0\"><td>2 hrs NON DSP </td><td>IN TAT</td><td>".$intat_nd_typd2."</td><td>".$intat_nd_edtd2."</td><td>".$nd_intat_conv2."</td></tr>";
		echo "<tr align=\"center\" class=\"tr1\"><td>2 hrs NON DSP </td><td>OUT TAT</td><td>".$outtat_nd_typd2."</td><td>".$outtat_nd_edtd2."</td><td>".$nd_outtat_conv2."</td></tr>";
		$d_intat_conv4=(2*$intat_d_typd4)+$intat_d_edtd4;
		$d_outtat_conv4=(2*$outtat_d_typd4)+$outtat_d_edtd4;
		$nd_intat_conv4=(2*$intat_nd_typd4)+$intat_nd_edtd4;
		$nd_outtat_conv4=(2*$outtat_nd_typd4)+$outtat_nd_edtd4;
		echo "<tr align=\"center\" class=\"tr0\"><td>4 hrs DSP </td><td>IN TAT</td><td>".$intat_d_typd4."</td><td>".$intat_d_edtd4."</td><td>".$d_intat_conv4."</td></tr>";
		echo "<tr align=\"center\" class=\"tr1\"><td>4 hrs DSP </td><td>OUT TAT</td><td>".$outtat_d_typd4."</td><td>".$outtat_d_edtd4."</td><td>".$d_outtat_conv4."</td></tr>";
		echo "<tr align=\"center\" class=\"tr0\"><td>4 hrs NON DSP </td><td>IN TAT</td><td>".$intat_nd_typd4."</td><td>".$intat_nd_edtd4."</td><td>".$nd_intat_conv4."</td></tr>";
		echo "<tr align=\"center\" class=\"tr1\"><td>4 hrs NON DSP </td><td>OUT TAT</td><td>".$outtat_nd_typd4."</td><td>".$outtat_nd_edtd4."</td><td>".$nd_outtat_conv4."</td></tr>";
		$d_intat_conv6=(2*$intat_d_typd6)+$intat_d_edtd6;
		$d_outtat_conv6=(2*$outtat_d_typd6)+$outtat_d_edtd6;
		$nd_intat_conv6=(2*$intat_nd_typd6)+$intat_nd_edtd6;
		$nd_outtat_conv6=(2*$outtat_nd_typd6)+$outtat_nd_edtd6;
		echo "<tr align=\"center\" class=\"tr0\"><td>6 hrs DSP </td><td>IN TAT</td><td>".$intat_d_typd6."</td><td>".$intat_d_edtd6."</td><td>".$d_intat_conv6."</td></tr>";
		echo "<tr align=\"center\" class=\"tr1\"><td>6 hrs DSP </td><td>OUT TAT</td><td>".$outtat_d_typd6."</td><td>".$outtat_d_edtd6."</td><td>".$d_outtat_conv6."</td></tr>";
		echo "<tr align=\"center\" class=\"tr0\"><td>6 hrs NON DSP </td><td>IN TAT</td><td>".$intat_nd_typd6."</td><td>".$intat_nd_edtd6."</td><td>".$nd_intat_conv6."</td></tr>";
		echo "<tr align=\"center\" class=\"tr1\"><td>6 hrs NON DSP </td><td>OUT TAT</td><td>".$outtat_nd_typd6."</td><td>".$outtat_nd_edtd6."</td><td>".$nd_outtat_conv6."</td></tr>";
		$d_intat_conv8=(2*$intat_d_typd8)+$intat_d_edtd8;
		$d_outtat_conv8=(2*$outtat_d_typd8)+$outtat_d_edtd8;
		$nd_intat_conv8=(2*$intat_nd_typd8)+$intat_nd_edtd8;
		$nd_outtat_conv8=(2*$outtat_nd_typd8)+$outtat_nd_edtd8;
		echo "<tr align=\"center\" class=\"tr0\"><td>8 hrs DSP </td><td>IN TAT</td><td>".$intat_d_typd8."</td><td>".$intat_d_edtd8."</td><td>".$d_intat_conv8."</td></tr>";
		echo "<tr align=\"center\" class=\"tr1\"><td>8 hrs DSP </td><td>OUT TAT</td><td>".$outtat_d_typd8."</td><td>".$outtat_d_edtd8."</td><td>".$d_outtat_conv8."</td></tr>";
		echo "<tr align=\"center\" class=\"tr0\"><td>8 hrs NON DSP </td><td>IN TAT</td><td>".$intat_nd_typd8."</td><td>".$intat_nd_edtd8."</td><td>".$nd_intat_conv8."</td></tr>";
		echo "<tr align=\"center\" class=\"tr1\"><td>8 hrs NON DSP </td><td>OUT TAT</td><td>".$outtat_nd_typd8."</td><td>".$outtat_nd_edtd8."</td><td>".$nd_outtat_conv8."</td></tr>";
		$d_intat_conv12=(2*$intat_d_typd12)+$intat_d_edtd12;
		$d_outtat_conv12=(2*$outtat_d_typd12)+$outtat_d_edtd12;
		$nd_intat_conv12=(2*$intat_nd_typd12)+$intat_nd_edtd12;
		$nd_outtat_conv12=(2*$outtat_nd_typd12)+$outtat_nd_edtd12;
		echo "<tr align=\"center\" class=\"tr0\"><td>12 hrs DSP </td><td>IN TAT</td><td>".$intat_d_typd12."</td><td>".$intat_d_edtd12."</td><td>".$d_intat_conv12."</td></tr>";
		echo "<tr align=\"center\" class=\"tr1\"><td>12 hrs DSP </td><td>OUT TAT</td><td>".$outtat_d_typd12."</td><td>".$outtat_d_edtd12."</td><td>".$d_outtat_conv12."</td></tr>";
		echo "<tr align=\"center\" class=\"tr0\"><td>12 hrs NON DSP </td><td>IN TAT</td><td>".$intat_nd_typd12."</td><td>".$intat_nd_edtd12."</td><td>".$nd_intat_conv12."</td></tr>";
		echo "<tr align=\"center\" class=\"tr1\"><td>12 hrs NON DSP </td><td>OUT TAT</td><td>".$outtat_nd_typd12."</td><td>".$outtat_nd_edtd12."</td><td>".$nd_outtat_conv12."</td></tr>";
		$d_intat_conv24=(2*$intat_d_typd24)+$intat_d_edtd24;
		$d_outtat_conv24=(2*$outtat_d_typd24)+$outtat_d_edtd24;
		$nd_intat_conv24=(2*$intat_nd_typd24)+$intat_nd_edtd24;
		$nd_outtat_conv24=(2*$outtat_nd_typd24)+$outtat_nd_edtd24;
		echo "<tr align=\"center\" class=\"tr0\"><td>24 hrs DSP </td><td>IN TAT</td><td>".$intat_d_typd24."</td><td>".$intat_d_edtd24."</td><td>".$d_intat_conv24."</td></tr>";
		echo "<tr align=\"center\" class=\"tr1\"><td>24 hrs DSP </td><td>OUT TAT</td><td>".$outtat_d_typd24."</td><td>".$outtat_d_edtd24."</td><td>".$d_outtat_conv24."</td></tr>";
		echo "<tr align=\"center\" class=\"tr0\"><td>24 hrs NON DSP </td><td>IN TAT</td><td>".$intat_nd_typd24."</td><td>".$intat_nd_edtd24."</td><td>".$nd_intat_conv24."</td></tr>";
		echo "<tr align=\"center\" class=\"tr1\"><td>24 hrs NON DSP </td><td>OUT TAT</td><td>".$outtat_nd_typd24."</td><td>".$outtat_nd_edtd24."</td><td>".$nd_outtat_conv24."</td></tr>";
		echo "</table><br /><br /><br />";
	}

}
?>
