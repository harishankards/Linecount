<?php
date_default_timezone_set('Asia/Calcutta');
$datetime = date('Y-m-d h:i:s a', time());
$date_only=date('Y-m-d', time());
$round_value=2;
$file_reduce=25;
function getname($empno)
{
	$emp_name='';
	$no=$empno;
	$getname=mysql_query("SELECT `Emp_name` FROM `employee` WHERE `Emp_no`='$no'");
	while($row=mysql_fetch_array($getname))
	{
		$name=$row['Emp_name'];
		$emp_name=$name."-".$no;
	}
	return($emp_name);
}
function getname_itself($empno)
{
	$emp_name='';
	$no=$empno;
	$getname=mysql_query("SELECT `Emp_name` FROM `employee` WHERE `Emp_no`='$no'");
	while($row=mysql_fetch_array($getname))
	{
		$name=$row['Emp_name'];
		$emp_name=$name;
	}
	return($emp_name);
}

?>
