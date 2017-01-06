<?php
include('dbconfig.php');
include('include_dir.php');
include('global.php');
if(!(isset($_POST['pref']))=="0")
{		
	$myArray=$_POST['pref'];
	foreach($myArray as $key => $value)
	{	
		header("location:updateemp.php?no=".$value."");
	}
}
elseif(!(isset($_POST['hid']))=="0")
{		
	$myArray=$_POST['hid'];
	foreach($myArray as $key => $value)
	{	
		header("location:updateid.php?no=".$value."");
	}
}
elseif(!(isset($_POST['atten']))=="0")
	{		
		$myArray=$_POST['atten'];
		foreach($myArray as $key => $value)
		{	
			header("location:attendance.php?no=".$value."");
		}
	}
else
{
	echo "<script> alert('Please choose the data !!!');</script>";
}

?>