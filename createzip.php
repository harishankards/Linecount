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
		include('include_dir.php');
		include('global.php');
		$zip_name="B2K File Details".$datetime;
		header('Content-type: application/zip');
		header('Content-Disposition: attachment; filename="'.$zip_name.'.zip"');
		header("Pragma: no-cache"); 
		header("Expires: 0");
	}
	else
	{ 
		header("location:index.php"); 
	}
}
if(isset($_POST['downdate']))
{
	$error = ""; //error holder
	
	$p_date=$_POST['downdate'];
	$year=date('Y', strtotime($p_date));
	$month=date('F-Y', strtotime($p_date));
	$dat=explode("-",$p_date);
	$date=$dat[2]."-".$dat[1]."-".$dat[0];
	
	$file_dir1=$main_dir.$year."/".$month."/".$date."/";
	if(extension_loaded('zip'))
	{ 
		
			$zip = new ZipArchive(); // Load zip library
			$zip_name = "B2K Files-".$date.".zip"; // Zip name
			echo $zip_name;
			if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
			{ 
				$error .= "* Sorry ZIP creation failed at this time";
			}
			$dhandle = opendir($file_dir1);
			$files = array();
			if ($dhandle) 
			{
			   while (false !== ($fname = readdir($dhandle))) 
			   {
				  if (($fname != '.') && ($fname != '..')) 
				  {
					  $files[] = (is_dir( "./$fname" )) ? "(Dir) {$fname}" : $fname;
				  }
			   }
			   closedir($dhandle);
			}
			foreach($files as $file)
			{ 
				$folder_name=$file_dir1.$file;
				echo $folder_name;
				$folder = opendir($folder_name);
				while (false !== ($fname = readdir($folder))) 
			   {
				  if (($fname != '.') && ($fname != '..')) 
				  {
					  $full_path=$folder_name."/".$fname;
					  $zip->addFile($full_path);
				  }
			   }
			}
			$zip->close();
			// push to download the zip			 
			readfile($zip_name);
			// remove zip file is exists in temp path
			unlink($zip_name);
	}
	else
	$error .= "You dont have ZIP extension";
	if($error)
	{
		echo "<script> setTimeout(function(){ window.location = \"listfiles.php?e=".$error."\";}, 0);</script>";
	}
	
}
?>