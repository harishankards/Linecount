<?php
//Global Values
/*--------Setting Main Directory------------*/
$mode="SERVER";
if($mode=="SERVER")
{
	$main_dir="/home/b2kliytk/public_html/cronmysqlbackup/";
	$admin_dir="/home/b2kliytk/public_html/uploads/admin/";
	$local_dir="/cronmysqlbackup/";
	$log="/home/b2kliytk/public_html/logs/";
	$admin_local='/uploads/admin/';
	$local='/uploads/';
    $log_local="/logs/";
}
if($mode=="LOCAL")
{
	$main_dir="/xampp/htdocs/B2K/cronmysqlbackup/";
	$admin_dir="/xampp/htdocs/B2K/uploads/admin/";
	$local_dir="/xampp/htdocs/B2K/cronmysqlbackup/";
	$log="/xampp/htdocs/B2K/Logs/";
	$admin_local='/B2K/uploads/admin/';
	$local='/B2K/uploads/';
}
/*--------Setting Local Directory------------*/
$log_year=date("Y");
$path_year = $log.$log_year;
if ( ! is_dir($path_year)) 
{
	mkdir($path_year,0777);
}

/*--------Setting Month Directory------------*/

$log_month=date("F");
$path_month = $path_year."/".$log_month;
if ( ! is_dir($path_month)) 
{
	mkdir($path_month,0777);
}

/*--------Setting Date Directory------------*/

$log_date=date("d-m-Y");
$path_date = $path_month."/".$log_date;
if ( ! is_dir($path_date)) 
{
	mkdir($path_date,0777);
}
$log_dir=$path_date."/";
?>