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
		$zip_name="B2K File Details";
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
	
	$file_dir=$main_dir.$year."/".$month."/".$date."/";
	
	$files=glob($file_dir."*.*"); 
	
	if(extension_loaded('zip'))
	{ 
		// Checking ZIP extension is available
		if(isset($files) and count($files) > 0)
		{ 
			// Checking files are selected
			$zip = new ZipArchive(); // Load zip library 
			$zip_name = "MLS Files-".$date.".zip"; // Zip name
			echo $zip_name;
			if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
			{ 
				 // Opening zip file to load files
				$error .= "* Sorry ZIP creation failed at this time";
			}
			foreach($files as $file)
			{ 
				$zip->addFile($file); // Adding files into zip
			}
			$zip->close();
			
			// push to download the zip			 
			readfile($zip_name);
			// remove zip file is exists in temp path
			unlink($zip_name);
			
		}
		else
		$error .= "Please select file to zip ";
	}
	else
	$error .= "You dont have ZIP extension";
	if($error)
	{
		echo "<script> setTimeout(function(){ window.location = \"listfiles.php?e=".$error."\";}, 0);</script>";
	}
	
}
?>