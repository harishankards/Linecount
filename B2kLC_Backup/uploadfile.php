<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(document.getElementById('fileup').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please choose a file"});
		return false;
	}
	thisform.submit();
	
}

</script>
<style>
input.text { margin-bottom:0px; width:180px; padding: .2em; text-align:left; }
</style>
</head>
<body> 

<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
        <center><h4>Upload Files Here </h4></center>
        <br />
        <center><p>* * * <u>Please upload the file in .ZIP or .RAR</u> * * * </p></center>
        <form name="Filesubmit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" >
         <input type="hidden" name="admin_id" id="admin_id" size="10" value="Administrator">
        <table align="center" width="750" cellspacing="20" style=" padding-left:100px;">
            
            <tr>
                <td>Select the Date</td><td>:</td>
                <td>
                    <input type="text" id="datepicker" title="Select the Date" name="day" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off"  readonly/> 
                </td>
            </tr>
            
            <tr>
                <td>Upload a File</td>
                <td>:</td>
                <td><input type="file" name="fileup" id="fileup" class="text ui-widget-content ui-corner-all" size="10">*Maximun Upload Size 5 MB</td>
            </tr>
       </table>
            <br>
            <center>
            	<input type="button" name="fsubmit" value="Submit" onClick="check(this.form)" />
            </center>
		</form>
        
       <?php
	   $a=1;
		$upstatus=mysql_query("SELECT * FROM `admin_uploads` order by `Date`");
		$upcount=mysql_num_rows($upstatus);
		if($upcount!=0)
		{	
		echo "<h2>Download files here</h2>";
				 if ($handle = opendir($admin_dir)) {
				   while (false !== ($file = readdir($handle)))
					  {
						  if ($file != "." && $file != "..")
					  			{
									//$thelist .= '<a href="'.$file.'">'.$file.'</a>';
									//echo '<a href="'.$admin_local.$file.'">'.$file.'</a><br>';
						  		}
					   }
				 // closedir($handle);
				  }
				  $c=0;
			echo "<center><form name=\"files\" method=\"POST\" action=\"".$_SERVER['PHP_SELF']."\">"; 
			echo "<table border=\"1\" width=\"700\" cellpadding=\"3\" cellspacing=\"0\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\">";
			echo "<th>Select</th><th>S.No</th><th>Date</th><th>File Name</th><th>File Size</th><th>Download</th>";
			while($uprow=mysql_fetch_array($upstatus))
			{
				echo "<tr class=\"tr".$c."\">";
				echo "<td align=\"center\"><input type=\"checkbox\" name=\"files[]\" value=\"".htmlentities($uprow['S.No'])."\" onclick=\"confirmfiles();\"></td> ";
				echo"<td>".$a."</td>";
				echo"<td>".$uprow['Date']."</td>";
				echo"<td>".$uprow['File_name']."</td>";
				echo"<td>".$uprow['File_size']."</td>";
				echo "<td><a href=\"$admin_local".$uprow['File_name']."\"><img src=\"menu/pick.png\" height=\"20\" width=\"20\" /></a></td>";
				echo "</tr>";
				$a=$a+1;
				if($c==0)
				{
					$c=1;
				}
				else
				{
					$c=0;
				}
			}
			echo "</table></form>";
			Print "<script type=\"text/javascript\" language=\"javascript\">
						function confirmfiles()
						{
							if (confirm('Are you sure ? You want to delete this file ?'))
							{
								files.submit();
							}
							else
							{
								return false;
							}
						}
					</script>";
		}
		?>
        
<?php
if(isset($_FILES['fileup'],$_POST['day'],$_POST['admin_id']))
{
	$edtr_id=mysql_real_escape_string($_POST['admin_id']);
	$dat=mysql_real_escape_string($_POST['day']); //date
	//$MAXIMUM_FILESIZE = 5242880;
	$f_ori_name=mysql_real_escape_string($_FILES['fileup']['name']);
	$f_size=mysql_real_escape_string($_FILES['fileup']['size']);
	$f_type=mysql_real_escape_string($_FILES['fileup']['type']);
	$uploaddir = $admin_dir;
	$uploadfile = $uploaddir . basename($f_ori_name);
	if($f_size > 0)
	{
			if(move_uploaded_file($_FILES['fileup']['tmp_name'], $uploadfile)) 
			{
				echo "<br><center>File is valid, and was successfully uploaded.</center><br><br>";
			} 
			else 
			{
				echo "Possible file upload attack!\n";
			}
			$file_size=round(($f_size/1024),2);
			$file_size=round(($file_size/1024),2)."MB";
			$upload=mysql_query("INSERT INTO `admin_uploads` VALUES ('NULL','$dat','$f_ori_name','$f_type','$file_size','$uploadfile')");
			
			if($upload)
			{
				echo "<script> alert('File is uploaded successfully');</script>";
				echo "<script> setTimeout(function(){ window.location = \"uploadfile.php\";}, 0);</script>";
			}
			else
			{
				echo "<script> alert('File alredy exisit');</script>";
			}
	}
	else
	{
		echo "<script> alert('Exceed the Upload limit. Maximum limit is 5 MB');</script>";
	}
		
}
if(!(isset($_POST['files']))=="0")
{		
$myArray=$_POST['files'];
	foreach($myArray as $key => $value)
	{	$value=mysql_real_escape_string($value);	
		$upstatus=mysql_query("SELECT * FROM `admin_uploads` WHERE `S.No`='$value'");
		$upcount=mysql_num_rows($upstatus);
		while($uprow=mysql_fetch_array($upstatus))
		{
			$path_del=$admin_dir.$uprow['File_name'];
			$del=mysql_query("DELETE FROM `admin_uploads` WHERE `S.No`='$value'");
			if($del)
			{
				if (is_file($path_del)) 
					{
						unlink($path_del);
						echo "<script> alert('File deleted successfully !!!');</script>";
						echo "<script> setTimeout(function(){ window.location = \"uploadfile.php\";}, 0);</script>";
					}
			}
			else
			{
				echo "<script> alert('Please choose the data !!!');</script>";
			}
			
		}
		
	}
}
mysql_close($con);	
?>
        <br />
        <br />
        <br />
        <br />
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>		
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>