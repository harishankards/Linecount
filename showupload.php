<?php
include('dbconfig.php');
include('include_dir.php');
if(isset($_GET['s_date'],$_GET['e_date'],$_GET['a_id'],$_GET['hos']))
{
	
	$s_date=$_GET['s_date'];
	$e_date=$_GET['e_date'];
	$id=$_GET['a_id'];
	$hos=$_GET['hos'];
	//echo $s_date.$e_date;
	//echo $main_dir.$year."/".$month."/".$date."/";
	//echo "<br><br><strong>".$date." Files</strong><br><br>";
	$c=1;
	$lc=0;
	$r=0;
	if(($id=='-1')&&($hos=='-1'))
	{
		echo "<center><table><tr><td class=\"tdcolor\">Details of Files from&nbsp; ".$s_date."&nbsp;to&nbsp;".$e_date."</td></tr></table></center><br>";
		$result=mysql_query("SELECT * FROM `file_details`  WHERE `Date` BETWEEN '$s_date' AND '$e_date'");
	}
	elseif(!($id=='-1')&&!($hos=='-1'))
	{
		echo "<center><table><tr><td class=\"tdcolor\">Details of Employee id &nbsp;\"".$id."\"&nbsp; in the client&nbsp; \"".$hos."\"&nbsp;from&nbsp; ".$s_date."&nbsp;to&nbsp;".$e_date."</td></tr></table></center><br>";
		$result=mysql_query("SELECT * FROM `file_details`  WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$id' AND `client`='$hos'");
	}
	elseif(($id=='-1')&&!($hos=='-1'))
	{
		echo "<center><table><tr><td class=\"tdcolor\">Details of Client&nbsp;\"".$hos."\"&nbsp;from&nbsp; ".$s_date."&nbsp;to&nbsp;".$e_date."</td></tr></table></center><br>";
		$result=mysql_query("SELECT * FROM `file_details`  WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `client`='$hos'");
	}
	elseif(!($id=='-1')&&($hos=='-1'))
	{	
		echo "<center><table><tr><td class=\"tdcolor\">Details of Employee ID&nbsp;\"".$id."\"&nbsp;from&nbsp; ".$s_date."&nbsp;to&nbsp;".$e_date."</td></tr></table></center><br>";
		$result=mysql_query("SELECT * FROM `file_details`  WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Uploadedby`='$id' ");
	}
	if($result)
	{
		$count=mysql_num_rows($result);
		if($count!=0)
		{	
			
			echo "<center><label class=\"result\"><u>Search Results</u></label></b><br><br>";
			echo "<div style=\"width:860px; height: 600px; border: 0px groove #3b3a3a; overflow: auto;\">";
			echo "<table border=\"1\" cellpadding=\"10\" width=\"780\" align=\"center\" class=\"tab\">";
			echo "<th>S.No.</th><th>Date</th><th>Client</th><th>File No</th><th>File Type</th><th>File Mins</th><th>LineCount</th><th>Uploaded By</th><th>Edited By</th><th>Time of Upload</th></tr>";
			while($row=mysql_fetch_array($result))
			{
				echo "<tr class=tr".$r.">";
				echo "<td>".$c."</td>";
				echo "<td>".$row['Date']."</td>";
				echo "<td>".$row['client']."</td>";
				$year=date('Y', strtotime($row['Date']));
				$month=date('F-Y', strtotime($row['Date']));
				$dat=explode("-",$row['Date']);
				$date=$dat[2]."-".$dat[1]."-".$dat[0];
				echo "<td><a href=\"$local_dir".$year."/".$month."/".$date."/".$row['File_No'].".doc\">".$row['File_No']."</a></td>";
				echo "<td>".$row['File_Type']."</td>";
				echo "<td>".$row['File_min']."</td>";
				echo "<td>".$row['Linecount']."</td>";
				$lc=$lc+$row['Linecount'];
				echo "<td>".$row['Uploadedby']."</td>";
				echo "<td>".$row['Editedby']."</td>";
				echo "<td>".$row['Time_of_upload']."</td>";
				//echo "<td>".$row['File_location']."</td>";
				echo "</tr>";
				$c=$c+1;
				if($r==0)
				{
					$r=1;
				}
				else
				{
					$r=0;
				}
			}
			echo "</table></div>";
			echo "<table>";
			echo "<tr class=\"result\"><td>Total No. Of.File</td><td>:</td><td>".$count."</td></tr><br>";
			echo "<tr class=\"result\"><td>Total No. Of.Lines</td><td>:</td><td>".$lc."</td></tr>";
			echo "</table></center>";
		}
		else
		{
			echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
		
		}
	}
	else
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry please choose the details correctly !!!</center></h1><br /><br /><br /><br /><br /><br />";
	}
}


elseif(isset($_GET['date1'],$_GET['date2'],$_GET['mls']))
{

	$s_date=$_GET['date1'];
	$e_date=$_GET['date2'];
	$name=$_GET['mls'];
	//echo $s_date.$e_date;
	//echo $main_dir.$year."/".$month."/".$date."/";
	//echo "<br><br><strong>".$date." Files</strong><br><br>";
	$c=1;
	$r=0;
	$result=mysql_query("SELECT * FROM `file_details`  WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND	`Uploadedby`='$name'");
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		echo "<center><label class=\"result\"><u>Search Results</u></label></b><br><br>";
		echo "<div style=\"width: 770px; height: 600px; border: 0px groove #3b3a3a; overflow: auto;\">";
		echo "<table border=\"1\" cellpadding=\"10\" width=\"750\" align=\"center\" class=\"tab\">";
		echo "<th>S.No.</th><th>Date</th><th>Client</th><th>File No</th><th>File Type</th><th>LineCount</th><th>Time of Upload</th></tr>";
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".$c."</td>";
			echo "<td>".$row['Date']."</td>";
			echo "<td>".$row['client']."</td>";
			$year=date('Y', strtotime($row['Date']));
			$month=date('F-Y', strtotime($row['Date']));
			$dat=explode("-",$row['Date']);
			$date=$dat[2]."-".$dat[1]."-".$dat[0];
			echo "<td><a href=\"$local_dir".$year."/".$month."/".$date."/".$row['File_No'].".doc\">".$row['File_No']."</a></td>";
			echo "<td>".$row['File_Type']."</td>";
			echo "<td>".$row['Linecount']."</td>";
			echo "<td>".$row['Time_of_upload']."</td>";
			echo "</tr>";
			$c=$c+1;
			if($r==0)
			{
				$r=1;
			}
			else
			{
				$r=0;
			}
		}
		echo "</table>";
		echo "</div></center>";
	}
	else
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
	
	}
}

?>