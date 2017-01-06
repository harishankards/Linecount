<?php
include('dbconfig.php');
include('include_dir.php');
include('global.php');
if(!(isset($_POST['pref']))=="0")
{		
	$myArray=$_POST['pref'];
	foreach($myArray as $key => $value)
	{	
		header("location:updatevendor.php?no=".$value."");
	}
}
else
{
	echo "<script> alert('Please choose the data !!!');</script>";
}

?>