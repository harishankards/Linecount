<?php 
	include('dbconfig.php');
	include('global.php');
		if(isset($_POST['pref'],$_POST['edtrid']))
		{
			if(!(isset($_POST['pref']))=="0")
			{		
				//include ('dbconf.php');
				$value=trim($_POST['pref']);
				$id=mysql_real_escape_string($_POST['edtrid']);
				$name=getname($id);
					
					$ck_sql=mysql_query("SELECT count(`File_No`) FROM `file_details` FORCE INDEX (`File_No`) WHERE `File_No`='$value'");
					$count_sql=mysql_num_rows($ck_sql);
					if($count_sql==1)
					{
						$sql=mysql_query("UPDATE `file_details` SET `Editedby`='$name',`pick_time_edtr`='$datetime' where `File_No`='$value'");
						/*echo "<script> setTimeout(function(){ window.location = window.location.href;}, 0);</script>";*/
						echo "<script> window.location = \"editor1.php\";</script>";
					}
					else
					{
						echo "<script> dhtmlx.alert({
							title:\"Opps !!!\",
							ok:\"Ok\",
							text:\"Sorry File is already picked by someone.\",
							callback:function(){
							setTimeout(function(){ window.location = \"editor1.php\";}, 0);
							}
						});
						
						</script>";
					}
				
			}
			else
			{
				echo "<script> alert('Please choose the data !!!');</script>";
			}
		}
		if(isset($_POST['fileno'],$_POST['edtrid']))
		{
			
			if(!(isset($_POST['fileno']))=="0")
			{		
				
				//include ('dbconf.php');
				$value=trim($_POST['fileno']);
				$id=mysql_real_escape_string($_POST['edtrid']);
				$name=getname($id);
				
				    $ck_sql=mysql_query("SELECT count(`File_No`) FROM `file_details` FORCE INDEX (`File_No`) WHERE `File_No`='$value'");
					$count=mysql_num_rows($ck_sql);
					if($count==1)
					{
						$upto=mysql_real_escape_string($_POST['uploadto']);
						$ac="98";
						$comm="No Comments";
						if($upto=="Third_level")
						{
							$third="YES";
							$thirdeditor='Not yet Edited';
						}
						else
						{
							$third="NO";
							$thirdeditor='No Third Editing';
						}
						$sql=mysql_query("UPDATE `file_details` SET `Upload_to`='$upto',`Third_level`='$third',`Third_Editor`='$thirdeditor',`Time_up_edit`='$datetime', `Accuracy`='$ac',`Comments`='$comm' where `File_No`='$value'");
						if($sql)
						{
							echo "<script> window.location = \"editor1.php\";</script>";
						}
						
					}
					else
					{
						echo "<script> dhtmlx.alert({
							title:\"Opps !!!\",
							ok:\"Ok\",
							text:\"Sorry File is already picked by someone.\",
							callback:function(){
							setTimeout(function(){ window.location = \"editor.php\";}, 0);
							}
						});
						</script>";
					}
			}
			else
			{
				echo "<script> alert('Please choose the data !!!');</script>";
			}
		}
		mysql_close($con);
		?>