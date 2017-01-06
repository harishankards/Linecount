<?php
echo $_POST['Del'];
if(!empty($_POST['Del']))
	{
	if(!(isset($_POST['pref']))=="0")
		{	
			//$comp=implode(',', $_POST['pref']);
			$myArray=$_POST['pref'];
			foreach($myArray as $key => $value)
				{
					$query = "DELETE from `attendance` where `S_No` ='$value' ";
					$res = mysql_query($query);
					$result=mysql_query("select * from `attendance`");
					Print"<script> setTimeout(function(){ window.location = \"viewatten.php\";}, 0);</script>";
				}
			if($res)
			{
				echo "<script> alert ('Employee has been deleted Successfully !!!'); </script>";
			}
		}
		else
		{
			$result=mysql_query("SELECT * FROM `employee`");
			echo "<script> alert('Please choose the data which you want to delete!!!');</script>";
		}
	}
if(!empty($_POST['update']))
{
	if(!(isset($_POST['pref']))=="0")
	{		
		include ('dbconf.php');
		$myArray=$_POST['pref'];
		foreach($myArray as $key => $value)
		{	
			Print"<script> setTimeout(function(){ window.location = \"attendance.php?no=".$value."\";}, 0);</script>";
		}
	}
	else
	{
		echo "<script> alert('Please choose the data !!!');</script>";
	}
}
?>		