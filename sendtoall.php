<?php
set_time_limit(0);
ini_set("memory_limit","512M");
ini_set("max_input_time","20000");
ini_set("max_execution_time","20000");
$dbHost = "www.b2klinecount.com";
$dbUser = "b2kliytk_b2kad12";
$dbPass = "b2k123";
$dbName = "b2kliytk_b2k_lc";
$con = mysql_connect($dbHost,$dbUser,$dbPass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db($dbName, $con);

date_default_timezone_set('Asia/Calcutta');
$s_flag=0;
$f_flag=0;
$emp_sql=mysql_query("select `Emp_name`,`Emp_no`,`Emp_mail`,`Emp_desig` from `employee` WHERE `Emp_desig`='MLS' OR `Emp_desig`='EDITOR' OR `Emp_desig`='HT-EDITOR' OR `Emp_desig`='HT-MLS' ");
while($row=mysql_fetch_array($emp_sql))
{
	$no=$row['Emp_no'];
	$nam=$row['Emp_name'];
	$d_b="24";
	$date=date("Y-m-d", time() - 60 * 60 * $d_b);
	$show_date=date("d-F-Y", time() - 60 * 60 * $d_b);
	$name=$nam."-".$no;
	$email=$row['Emp_mail'];
	if($email!='')
	{
		$to  = $email;
		$subject = "Daily Productivity Report";
		$cc="b2klinecount@gmail.com";
		$bcc="asteroid90@gmail.com";
		$msg="Dear ".$name.",<br>Greetings,<br>";
		$msg=$msg."Productivity details of <b><u>".$show_date."</u></b><br>";
		if($row['Emp_desig']=="MLS" || $row['Emp_desig']=="HT-MLS")
		{
			$count=0;
			$c=1;
			$lc=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`File_Type`,`Linecount`,`Upstatus` FROM `file_details` WHERE `Uploadedby`='$name' AND `Date`='$date'");
			$count=mysql_num_rows($lc);
			if($count!=0)
			{	
				$msg=$msg."<br /><table border=\"1\" cellpadding=\"2\"><tr style=\"background-color:#6797ad;\"><th>S.No</th><th>Date</th><th>Hospital</th><th>File No</th><th>File Type</th><th>Linecount</th><th>Upload Type</th></tr>";
				$col="#deffdd";
				$total=0;
				while($lc_row=mysql_fetch_array($lc))
				{
					$msg=$msg."<tr style=\"background-color:".$col.";\"  align=\"center\"><td>".$c."</td><td>".$lc_row['Date']."</td><td>".$lc_row['Hospital']."</td><td>".$lc_row['File_No']."</td><td>".$lc_row['File_Type']."</td><td>".$lc_row['Linecount']."</td><td>".$lc_row['Upstatus']."</td></tr>";
					$total=$total+$lc_row['Linecount'];
					$c=$c+1;
					if($col=="#deffdd")
					{
						$col="#ffece0";
					}
					else
					{
						$col="#deffdd";
					}
				}
				$msg=$msg."<tr style=\"background-color:".$col.";\" align=\"center\"><td></td><td></td><td></td><td></td><td>Total Lines</td><td>".$total."</td><td></td></tr></table>";
				$name='';
			}
			else
			{
				$msg=$msg."<br><b>No files are available </b><br>";
				$name='';
			}
		}
		
		if($row['Emp_desig']=="EDITOR" || $row['Emp_desig']=="HT-EDITOR")
		{
			
			$count=0;
			$c=1;
			//Edited Lines
			$edlc=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`File_Type`,`Linecount` FROM `file_details` WHERE `Editedby`='$name' AND `Date`='$date'");
			$count=mysql_num_rows($edlc);
			$msg=$msg."<p><b><u>Edited file details</u></b></p><br>";
			if($count!=0)
			{	
				$msg=$msg."<table border=\"1\"><tr style=\"background-color:#6797ad;\"  align=\"center\"><th>S.No</th><th>Date</th><th>Hospital</th><th>File No</th><th>File Type</th><th>Linecount</th></tr>";
				$col="#deffdd";
				$total=0;
				while($edlc_row=mysql_fetch_array($edlc))
				{
					$msg=$msg."<tr style=\"background-color:".$col.";\"><td>".$c."</td><td>".$edlc_row['Date']."</td><td>".$edlc_row['Hospital']."</td><td>".$edlc_row['File_No']."</td><td>".$edlc_row['File_Type']."</td><td>".$edlc_row['Linecount']."</td></tr>";
					$total=$total+$edlc_row['Linecount'];
					$c=$c+1;
					if($col=="#deffdd")
					{
						$col="#ffece0";
					}
					else
					{
						$col="#deffdd";
					}
				}
				$msg=$msg."<tr style=\"background-color:".$col.";\" align=\"center\"><td></td><td></td><td></td><td></td><td>Total Lines</td><td>".$total."</td></tr></table>";
			}
			else
			{
				$msg=$msg."<br><b>No files are available</b><br>";
			}
			$count=0;
			$c=1;
			$duplc=mysql_query("SELECT `Date`,`Hospital`,`File_No`,`File_Type`,`Linecount`,`Upstatus` FROM `file_details` WHERE `Uploadedby`='$name' AND `Date`='$date'");
			$count=mysql_num_rows($duplc);
			$msg=$msg."<p><b><u>DUP file details</u></b></p><br>";
			if($count!=0)
			{	
				$msg=$msg."<table border=\"1\"><tr style=\"background-color:#6797ad;\"><th>S.No</th><th>Date</th><th>Hospital</th><th>File No</th><th>File Type</th><th>Linecount</th><th>Upload Type</th></tr>";
				$col="#deffdd";
				$total=0;
				while($duplc_row=mysql_fetch_array($duplc))
				{
					$msg=$msg."<tr style=\"background-color:".$col.";\" align=\"center\"><td>".$c."</td><td>".$duplc_row['Date']."</td><td>".$duplc_row['Hospital']."</td><td>".$duplc_row['File_No']."</td><td>".$duplc_row['File_Type']."</td><td>".$duplc_row['Linecount']."</td><td>".$duplc_row['Upstatus']."</td></tr>";
					$total=$total+$duplc_row['Linecount'];
					$c=$c+1;
					if($col=="#deffdd")
					{
						$col="#ffece0";
					}
					else
					{
						$col="#deffdd";
					}
				}
				$msg=$msg."<tr style=\"background-color:".$col.";\" align=\"center\"><td></td><td></td><td></td><td></td><td>Total Lines</td><td>".$total."</td><td></td></tr></table>";
			}
			else
			{
				$msg=$msg."<br><b>No files are available</b><br>";
			}
		}
		$msg=$msg."<br><p style=\"color:red;\">This is a system generated e-mail, Please do not reply to this e-mail ID.</p><p style=\"color:blue;\">For Any issues Contact Administrator:<br>Email ID : adminb2k@gmail.com<br> Contact No : 0424-2277069</p>
				<p style=\"color:blue;\">Bytes 2 Knowledge,<br>Erode.</p>";
		$msg=$msg."<u><b><p style=\"color:blue; font-size:9pt;\">Privileged and Confidential:</b></u></p><p style=\"color:#a7a7a7; font-size:10pt;\"> The information in this e-mail message may contain confidential personal information that is privileged and legally protected from disclosure. This information is intended only for the personal and confidential use of the intended recipient(s). If the reader of this message is not the intended recipient or an agent responsible for delivering it to the intended recipient, you are hereby notified that you have received this document in error and that any review, dissemination, distribution, or copying of this message is strictly prohibited. If you have received this communication in error, please notify us immediately by e-mail, and delete the original message.</p>";
		$message = $msg;
		//echo $message;
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		//$headers .= 'To: '.$to.'' . "\r\n";
		$headers .= 'From: Admin B2K <admin@b2klinecount.com>' . "\r\n";
		$headers .= 'Cc: '.$cc.'' . "\r\n";
		$headers .= 'Bcc: '.$bcc.'' . "\r\n";
		
		// Mail it
		$res=mail($to, $subject, $message, $headers);
		if($res)
		{
			$s_flag=$s_flag+1;
		}
		else
		{
			$f_flag=$f_flag+1;
		}
		
	}
}
echo "".$s_flag." was Success and ".$f_flag."was Failure";
?>