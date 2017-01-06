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
	$key=md5($loginas."_B2K");
	if($token==$key)
	{ 
		
		include('dbconfig.php');
	}
	else
	{ 
		header("location:index.php"); 
	}
}
?>
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
		
		require('fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',10);

$pdf->Cell(50,3,"Cool PHP to PDF Tutorial by WebSpeaks.in");
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,5,"Sr.no.");
$pdf->Cell(350,5,"Message");
$pdf->Ln();
$pdf->Cell(450,3,"-------------------------------------------------------------------------------------");

	// Get data records from table.
	$result=mysql_query("select * from bank_details ");
	while($row=mysql_fetch_array($result))
	{
		$pdf->Cell(10,5,"{$row['Vendor']}");
		$pdf->MultiCell(350,5,"{$row['Account_No']}");
	}
$pdf->Output();
	}

}

?>
<?php


?>
