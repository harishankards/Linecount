<?php 
	include('dbconfig.php');
   	include('global.php');
	
		$id="B2KER003";
		$name=getname($id);
		$flag=0;
		if(isset($_POST['date_chk']))
		{
			$dat=$_POST['date_chk'];
		}
		else
		{
			$dat=date('Y-m-d');
		}
		$result=mysql_query("SELECT * FROM `file_details` FORCE INDEX (`File_No`)  WHERE `Editedby`='$name' AND `Upload_to`='Not yet Edited'");
		$count=mysql_num_rows($result);
		echo $count;
		if($count!=0)
		{
			echo $result;
			while($row1=mysql_fetch_array($result))
			{
				echo $row1['File_No'];
				$no=$row1['File_No'];
				echo $_GET['File'];
				if(isset($_POST['uploadto_'.$row1['File_No']]))
				{
					
					echo $row1['File_No'];
					$no=$row1['File_No'];
					//$ac=mysql_real_escape_string($_POST['acc_'.$row1['File_No']]);
					//$comm=mysql_real_escape_string($_POST['comm_'.$row1['File_No']]);
					$upto=mysql_real_escape_string($_POST['uploadto_'.$row1['File_No']]);
					echo $upto.$ac.$no;
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
					$sql=mysql_query("UPDATE `file_details` SET `Upload_to`='$upto',`Third_level`='$third',`Third_Editor`='$thirdeditor',`Time_up_edit`='$datetime', `Accuracy`='$ac',`Comments`='$comm' where `File_No`='$no'");
					echo $sql; 
					if($sql)
					{
						$flag=$flag+1;
					}
				}
				else
				{
					echo "error";
				}
			}
			if($flag>0)
			{
				echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Upload Details saved Successfully\",
					callback:function(){
					setTimeout(function(){ window.location = \"filereview.php\";}, 0);
					}
				});
				
				</script>";
			}
		}
		
	mysql_close($con);
	?>