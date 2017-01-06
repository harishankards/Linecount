<?php
	$no1=$_GET['value'];
	include('dbconfig.php');
	$result=mysql_query("select * from `employee` where `Emp_no`='$no1'");
	$row=mysql_fetch_array($result);
	echo $row['Emp_name'];
?>