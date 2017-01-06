<?PHP
session_start();
set_time_limit(0);
ini_set("memory_limit","512M");
ini_set("upload_max_filesize", "256M");
ini_set("post_max_size", "200M");
ini_set("max_input_time","20000");
ini_set("max_execution_time","20000");
if(!isset($_SESSION['Admin']))
{ 
	header("location:index.php?msg4=NotAllowed");
}
else
{ 
	$loginas=$_SESSION['Admin'];
	$token=$_SESSION['token'];
	$key=md5($loginas."_Admin@B2K");
	if($token==$key)
	{ 
		include('dbconfig.php');
		include('global.php');
		include('include_dir.php');
	}
	else
	{ 
		header("location:index.php?msg4=NotAllowed");
	}
}

if(isset($_POST['query'],$_POST['mis_query'],$_POST['ad_query']))
{         
$sql = stripslashes($_POST['query']);
$missing_sql = stripslashes($_POST['mis_query']);
$audit_sql = stripslashes($_POST['ad_query']);
$Use_Title = 1;
$now_date = DATE('d-m-Y H:i');
$fname="File_details".date('d-M-Y');
$title = "Complete File Details";

IF (ISSET($w) && ($w==1))
{
     $file_type = "msword";
     $file_ending = "doc";
}ELSE {
     $file_type = "x-msdownload";
     $file_ending = "xls";
}
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
         ECHO("\n\nEdited File Details\n\n");
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
         ECHO("\n\nEdited File Details\n");
     }
     
     $sep = "\t";
 
     FOR ($i = 0; $i < (MYSQL_NUM_FIELDS($result)); $i++)
     {
         ECHO MYSQL_FIELD_NAME($result,$i) . "\t";
     }
     PRINT("\n");
    
     WHILE($row = MYSQL_FETCH_ROW($result))
     {
         
         $schema_insert = "";
         FOR($j=0; $j<(mysql_num_fields($result));$j++)
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

$missing_result = MYSQL_QUERY($missing_sql)
     or DIE("Couldn't execute query:<br>" . MYSQL_ERROR(). "<br>" . MYSQL_ERRNO());

IF (ISSET($w) && ($w==1)) 
{
     
     IF ($Use_Title == 1)
     {
         ECHO("\n\nMissing File Details\n\n");
     }
    
     $sep = "\n";
 
     WHILE($row = MYSQL_FETCH_ROW($missing_result))
     {
         
         $schema_insert = "";
         FOR($j=0; $j<mysql_num_fields($missing_result);$j++)
         {
         
         $field_name = MYSQL_FIELD_NAME($missing_result,$j);
         
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
         ECHO("\n\nMissing File Details\n");
     }
     
     $sep = "\t";
 
     FOR ($i = 0; $i < (MYSQL_NUM_FIELDS($missing_result)); $i++)
     {
         ECHO MYSQL_FIELD_NAME($missing_result,$i) . "\t";
     }
     PRINT("\n");
    
     WHILE($row = MYSQL_FETCH_ROW($missing_result))
     {
         
         $schema_insert = "";
         FOR($j=0; $j<(mysql_num_fields($missing_result));$j++)
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


$audit_result = MYSQL_QUERY($audit_sql)
     or DIE("Couldn't execute query:<br>" . MYSQL_ERROR(). "<br>" . MYSQL_ERRNO());

IF (ISSET($w) && ($w==1)) 
{
     
     IF ($Use_Title == 1)
     {
         ECHO("\n\nAuditing File Details\n\n");
     }
    
     $sep = "\n";
 
     WHILE($row = MYSQL_FETCH_ROW($audit_result))
     {
         
         $schema_insert = "";
         FOR($j=0; $j<mysql_num_fields($audit_result);$j++)
         {
         
         $field_name = MYSQL_FIELD_NAME($audit_result,$j);
         
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
         ECHO("\n\nAuditing File Details\n");
     }
     
     $sep = "\t";
 
     FOR ($i = 0; $i < (MYSQL_NUM_FIELDS($audit_result)); $i++)
     {
         ECHO MYSQL_FIELD_NAME($audit_result,$i) . "\t";
     }
     PRINT("\n");
    
     WHILE($row = MYSQL_FETCH_ROW($audit_result))
     {
         
         $schema_insert = "";
         FOR($j=0; $j<(mysql_num_fields($audit_result));$j++)
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