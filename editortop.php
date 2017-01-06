<?php
error_reporting(0);
session_cache_limiter('private');
$cache_limiter = session_cache_limiter();
session_cache_expire(500);
$cache_expire = session_cache_expire();
session_start();
set_time_limit(0);
ini_set("memory_limit","512M");
ini_set("upload_max_filesize", "256M");
ini_set("post_max_size", "200M");
ini_set("max_input_time","20000");
ini_set("max_execution_time","20000");
header('Cache-control: private'); 
header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', false); 
header('Pragma: no-cache');
if(!isset($_SESSION['EDITOR']))
{ 
header("location:index.php"); 
}
else
{ 
	$loginas=$_SESSION['EDITOR'];
	$token=$_SESSION['token'];
	$key=md5($loginas."_B2KIDSIL");
	if($token==$key)
	{ 
		header( 'Content-Type: text/html; charset=utf-8' );
		include('dbconfig.php');
		include('include_dir.php');
		include('global.php');
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
<title>B2k Medical Transcription | Editor</title>
<meta name="keywords" content="B2klinecount, B2k Medical Transcription , Erode , Tamilnadu" />
<meta name="description" content="B2klinecount, B2k Medical Transcription, Erode, Tamilnadu" />
<link rel="shortcut icon" href="images/shortcut.png" size="32*32" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/fisheye.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="css/menu.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="codebase/themes/message_growl_dark.css">
<link rel="stylesheet" href="js/jquery/themes/redmond/jquery-ui-1.10.1.custom.css"/>