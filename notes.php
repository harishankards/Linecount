<?php
include('dbconfig.php');
echo "<img src=\"menu/check.png\" height=\"20\" width=\"20\" /><label id=\"alert\">&nbsp;*** For any Support / Queries contact Administrator mobile no: <b>+91 7871731117</b> ***&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>";
$note_sql=mysql_query("SELECT * FROM `notes`");
$note_count=mysql_num_rows($note_sql);
if($note_count!=0)
{
	while($note_row=mysql_fetch_array($note_sql))
	{
		if($note_row['Note']!='')
		{
			echo "<img src=\"menu/check.png\" height=\"20\" width=\"20\" /><label id=\"notice\">&nbsp;".$note_row['Note']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>";
		}
	}
	
}
else
{
	$quote_sql=mysql_query("SELECT * FROM `quotes`");
	$quote_count=mysql_num_rows($quote_sql);
	if($quote_count!=0)
	{
		$no=$quote_count;
		$i=1;
		while($quote_row=mysql_fetch_array($quote_sql))
		{
				$list[$i]=$quote_row['Quotes']." - ".$quote_row['By'];
				$i=$i+1;
		}
		$no=rand(1,$no);
		echo "<img src=\"menu/check.png\" height=\"20\" width=\"20\" /><label id=\"quotes\">&nbsp;\" ".$list[$no]." \"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>";
	}
}



?>