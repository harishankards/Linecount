<?php
$dbmode="SERVER";
if($dbmode=="SERVER")
{
$dbHost = "www.b2klinecount.com";
$dbUser = "b2kliytk_b2kad12";
$dbPass = "b2k123";
$dbName = "b2kliytk_b2k_lc";
}
if($dbmode=="LOCAL")
{
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "b2k_database";
}
$dbC = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName)
        or die('Error Connecting to MySQL DataBase');
$con = mysql_connect($dbHost,$dbUser,$dbPass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db($dbName, $con);
?>