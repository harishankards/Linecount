<?php
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
	
	$file_no="51367715";
	$mysql=mysql_query("SELECT * FROM `file_contents` WHERE `File_no`='$file_no'");
	while($row=mysql_fetch_array($mysql))
	{
		$file=$row['Mls_version'];
	}
	
	function decrypt($string, $key) 
	{
	  $result = '';
	  $string = base64_decode($string);
	  for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	  }
	  return $result;
	}
	$key="B2L_MLS";
	$mls_de=decrypt($file, $key);
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=".$file_no."_Compared.doc");
		echo "<html>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
		echo "<body>";
		print("$mls_de");
		echo "</body>";
		echo "</html>";

?>