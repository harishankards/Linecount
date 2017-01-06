<?PHP
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
		header( 'Content-Type: text/html; charset=utf-8' );
		include('dbconfig.php');
		include('global.php');
		include('include_dir.php');
	}
	else
	{ 
		header("location:index.php"); 
	}
}
if(isset($_POST['query']))
{         
$sql = stripslashes($_POST['query']);
$Use_Title = 1;
$now_date = DATE('d-m-Y H:i');
$fname="Employee_details".date('d-M-Y');
$title = "Complete Employee Details";


$file_type = "x-msdownload";
$file_ending = "xls";

//header("Content-type: application/x-msdownload");
//header("Content-Disposition: attachment; filename=total_hours.csv");
HEADER("Content-Type: application/$file_type");
HEADER("Content-Disposition: attachment; filename=$fname.$file_ending");
HEADER("Pragma: no-cache");
HEADER("Expires: 0");
$result = MYSQL_QUERY($sql)
     or DIE("Couldn't execute query:<br>" . MYSQL_ERROR(). "<br>" . MYSQL_ERRNO());

IF (ISSET($w) && ($w==1)) 
{
     
     IF ($Use_Title == 1)
     {
         ECHO("$title\n\n");
     }
    
     $sep = "\n";
 
     WHILE($row = MYSQL_FETCH_ROW($result))
     {
         
         $schema_insert = "";
         FOR($j=0; $j<mysql_num_fields($result);$j++)
         {
         
         $field_name = MYSQL_FIELD_NAME($result,$j);
         
         $schema_insert .= "$field_name:\t";
             IF(!ISSET($row[$j])) {
                 $schema_insert .= "NULL".$sep;
                 }
             ELSEIF ($row[$j] != "") {
                 $schema_insert .= "$row[$j]".$sep;
                 }
             ELSE {
                 $schema_insert .= "".$sep;
                 }
         }
         $schema_insert = STR_REPLACE($sep."$", "", $schema_insert);
         $schema_insert .= "\t";
         PRINT(TRIM($schema_insert));
         
         PRINT "\n----------------------------------------------------\n";
     }
}ELSE{
     
     IF ($Use_Title == 1)
     {
         ECHO("$title\n");
     }
     
     $sep = "\t";
 
     FOR ($i = 1; $i < MYSQL_NUM_FIELDS($result); $i++)
     {
         ECHO MYSQL_FIELD_NAME($result,$i) . "\t";
     }
     PRINT("\n");
    
     WHILE($row = MYSQL_FETCH_ROW($result))
     {
         
         $schema_insert = "";
         FOR($j=1; $j<mysql_num_fields($result);$j++)
         {
             IF(!ISSET($row[$j]))
                 $schema_insert .= "NULL".$sep;
             ELSEIF ($row[$j] != "")
                 $schema_insert .= "$row[$j]".$sep;
             ELSE
                 $schema_insert .= "".$sep;
         }
         $schema_insert = STR_REPLACE($sep."$", "", $schema_insert);
         $schema_insert = PREG_REPLACE("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
         $schema_insert .= "\t";
         PRINT(TRIM($schema_insert));
         PRINT "\n";
     }
}
}
?>