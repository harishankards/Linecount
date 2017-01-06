<?php
session_start();
require_once('calendar/classes/tc_calendar.php');
if(!isset($_SESSION['Admin']))
{ 
header("location:index.php"); 
}
else
{ 
	$loginas=$_SESSION['Admin'];
	$token=$_SESSION['token'];
	$key=md5($loginas."_Admin@B2K");
	if($token==$key)
	{ 
		header( 'Content-Type: text/html; charset=utf-8' );
		include('dbconfig.php');
	}
	else
	{ 
		header("location:index.php"); 
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>B2k Medical Transcription</title>
<meta name="keywords" content="B2klinecount, B2k Medical Transcription , Erode" />
<meta name="description" content="B2klinecount, B2k Medical Transcription, Erode" />
<link rel="shortcut icon" href="images/shortcut.png" size="32*32" />
<style>
/*@page { size 8.5in 11in; margin: 2cm };*/
</style>
</head>
<body onload="window.print()">
<?php
if(isset($_POST['acc_no']))
{
$acc_no=mysql_real_escape_string($_POST['acc_no']);
$sql=mysql_query("SELECT * FROM `bank_details` WHERE `Account_No`='$acc_no' LIMIT 0,1");
	while($row=mysql_fetch_array($sql))
	{
		$name=$row['Name'];
		$address=$row['Address'];
		$bank_name=$row['Bank_name'];
		$branch_add=$row['Branch_add'];
		$ifsc_code=$row['IFSC_Code'];
		$acc_type=$row['Account_Type'];
		$acc_no=$row['Account_No'];
	}

}

?>
<table align="center" style="font-size:11px;" width="700">
<tr align="center"><td width="94%"></td><td width="6%" style="border:1px solid #000000;">A-128</td></tr></table>

<table align="center" style="font-size:11px;" width="700">
<tr><td width="55%">APPLICATION-CUM-VOUCHER FOR RTGS/NEFT PAYMENT</td><td width="20%">DATE:</td><td>RTGS <input type="checkbox" name="rtgs" /></td><td>NEFT <input type="checkbox" name="neft" /></td></tr></table>
<table align="center" style="font-size:11px;" width="700" cellpadding="8">
<tr>
<td style="border:1px solid #000000;" width="65%"><img src="images/csblogo.jpg" height="104" width="458" border="1px" /></td><td style="border:1px solid #000000; padding-left:10px;">To,<br />THE MANAGER,<br />THE CATHOLIC SYRIAN BANK,<br />ERODE.<br /><br />Branch IBR CODE</td>
</tr>
</table>
<table align="center" style="font-size:11px;" width="700">
<tr>
<td style="border:1px solid #000000;" width="100%">DEAR SIR / MADAM,<br />PLEASE REMIT FUNDS AS PER DETAILS GIVEN BELOW AND WE AUTHORISE YOU TO DEBIT ALONG WITH YOUR CHARGES TO MY / OUR ACCOUNT WITH YOU, WE AGREE TO ABIDE BY THE TERMS AND CONDITIONS GIVEN OVERLEAF.</td>
</tr>
</table>
<table align="center" style="font-size:11px;" width="700" border="1" cellspacing="0">
<tr align="center"><td width="4%">S.No</td><td colspan="2" width="48%"><b>DETAILS OF APPLICANT</b></td><td colspan="2" width="48%"><b>DETAILS OF BENEFICIARY</b></td></tr>

<tr><td align="center">1.</td><td width="24%"><b>NAME</b></td><td width="24%"><b style="padding-left:20px;  letter-spacing:1px;">B2K , ERODE.</b></td><td width="15%"><b>NAME</b></td><td width="33%"><b style="padding-left:5px;"><?php echo $name; ?></b></td></tr>

<tr><td align="center">2.</td><td width="24%" align="center"><b>ACCOUNT TYPE</b></td><td width="24%" align="center"><b>ACCOUNT NUMBER</b></td><td width="15%" rowspan="2"><b>ADDRESS</b></td><td width="33%" rowspan="2"><b style="padding-left:5px;"><?php echo $address; ?></b></td></tr>

<tr><td align="center"></td><td width="24%" align="center"><b>CURRENT</b></td><td width="24%" align="center"><b style=" letter-spacing:1px;">0022 00253548195001</b></td></tr>

<tr><td align="center" rowspan="2"  height="60">3.</td><td width="24%" rowspan="2" colspan="2"  height="60"><b>AMOUNT OF REMITTANCE(RS.):<br />BANK CHARGES (incl. Ser Tax):<br />TOTAL</b></td><td width="15%" align="left" colspan="1"  height="30"><b>BANK:</b></td><td width="33%" align="left" colspan="1"  height="30"><b style="padding-left:5px;"><?php echo $bank_name; ?></b></td></tr>

<tr><td align="left" width="24%" colspan="2"  height="60"><b>BRANCH WITH ADDRESS:<br /><b style="padding-left:5px;"><?php echo $branch_add; ?></b></b></td></tr>

<tr align="center"><td width="4%">4.</td><td colspan="2" width="48%" align="left" height="45"><b>AMOUNT OF REMITTANCE IN WORDS<br /><br /></b></td><td width="15%"><b>IFSC CODE</b></td><td width="33%" align="left"><b style="padding-left:5px; letter-spacing:1px;"><?php echo $ifsc_code; ?></b></td></tr>

<tr><td align="center" rowspan="2"  height="40">5.</td><td width="24%" rowspan="2" colspan="2"  height="40"><b>DETAILS OF PAYMENT:<br /><center><p style="font-size:14px;">CSB</p></center></b></td><td width="15%" align="left" colspan="1"  height="30"><b>ACCOUNT TYPE:</b></td><td width="33%" align="left" colspan="1"  height="30"><b style="padding-left:5px;"><?php echo $acc_type; ?></b></td></tr>
<tr><td align="left" width="15%" colspan="1"  height="20"><b>A/C NO:</b></td><td align="left" width="33%" colspan="1"  height="20"><b style="padding-left:5px; letter-spacing:1px;"><?php echo $acc_no; ?></b></td></tr>

<tr align="center"><td width="4%">6.</td><td colspan="1" width="24%" align="left"><b>CHEQUE NUMBER</b></td><td colspan="1" width="24%" align="left"></td><td align="left" width="15%" colspan="1"  height="20"><b>CONFIRM  A/C NO:</b></td><td align="left" width="33%" colspan="1"  height="20"><b style="padding-left:5px; letter-spacing:1px;"><?php echo $acc_no; ?></b></td></tr>
</table>

<table align="center" style="font-size:11px;" width="700" border="1" cellspacing="0">
<tr align="center"><td width="4%">7.</td><td colspan="1" width="24%" align="left" height="30"><b>PAN NUMBER (IF APPLICABLE)</b></td><td colspan="1" width="24%" align="left" height="30"></td><td width="24%" rowspan="2" align="left"><b>REMARKS:<br /><br /><br />REF NO:</b></td><td width="24%" height="10" align="left"></td></tr>

<tr><td align="center" rowspan="2"  height="30">8.</td><td width="24%" rowspan="2" colspan="2"  height="30"><b>APPLICANT 'S SIGNATURE<br /><br /><br /></b></td><td width="33%" align="left" colspan="1"  height="20"><b>SIGN-CHECKED</b></td></tr>
<tr><td align="left" width="15%" colspan="1"  height="60"><b>SIGN-MAKER:<br /><br /><br /></b></td><td align="left" width="33%" colspan="1"  height="30"><b>SIGN-AUTHORISOR<br /><br /><br />DATE:________ TIME:</b></td></tr>
<tr>
<td align="left" colspan="5">
FOR OFFICE USE ONLY (REMITTING BRANCH)<br />
<p style="padding-left:20px;">
1. APPLICANT 'S SIGNATURE VERIFIED AND AMOUNT DEBITED FROM THE ACCOUNT.<br />
2. ALL OPERATIONAL GUIDELINES RELATING TO RTGS HAVE BEEN OBSERVED WITHOUT ANY DEVIATION.<br />
3. HO CREDIT TP RTGS(307) MEMO NO:
</p>
</td>
</tr>
<tr><td colspan="2">FAX THIS FORM TO: 022-22641872</td><td>DATE:</td><td>TIME:</td><td>AUTHORISED SIGNATORY</td></tr>
</table>
<table align="center" style="font-size:9px;" width="700" border="0" cellspacing="0" cellpadding="10">
<tr align="center"><td><img src="images/cuthere.jpg" width="50" height="10" /></td><td><img src="images/cuthere.jpg" width="50" height="10" /></td><td><img src="images/cuthere.jpg" width="50" height="10" /></td><td><img src="images/cuthere.jpg" width="50" height="10" /></td><td><img src="images/cuthere.jpg" width="50" height="10" /></td></tr>
</table>
<table align="center" style="font-size:9px;" width="700" border="1" cellspacing="0">
<tr><td align="center" width="40%">RTGS APPLICATION ACKNOWLEDGEMENT<br />(TO THE FILLED IN BY THE APPLICANT)</td><td width="60" align="center">APPLICANT'S DETAILS</td></tr>
<tr><td colspan="2" align="left" height="25">BENEFICIARY DETAILS:<br /></td></tr>
<tr><td colspan="2" align="left" height="25">FOR THE CATHOLIC SYRIAN BANK:<br /><br />AUTHORISED SIGNATORY:____________________________  DATE:_______________ TIME:__________ AM / PM</td></tr>
</table>
</body>
</html>
