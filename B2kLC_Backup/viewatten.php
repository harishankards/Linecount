<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function call(thisform)
{
thisform.submit();
}

</script>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
</style>

</head>
<body> 

<div id="outer_wrapper">
	

  <div id="wrapper">
    
   	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
          <center><br><br>
          <form name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
          <table align="center"	width="400" style="padding-left:0px;" >
          	<tr align="center">
          	<td class="bold">Choose a date</td><td>:</td>
          	<td>
            
		  	<input type="text" id="attendate" title="Select the Date" name="date5" value="<?php echo date('Y-m-d');?>" class="text ui-widget-content ui-corner-all" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
           
          </td>
          <td><input type="submit" value="Show Details" name="show" > </td>
          </tr>
          </table>
          </form>
          </center>
          <br>
          <form name="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" action="viewatten.php" method="post">
		  <table align="center" width="700">
            <tr align="center">
                <td class="bold">From&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">To&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">Name&nbsp;:&nbsp;&nbsp;
                <select name="a_id" id="a_id" onChange="call(this.form)" class="text ui-widget-content ui-corner-all" >
                <option value="all">All Details</option>
                <option selected="selected" value="-1">--Select Name--</option>
                <?php
                $sql=mysql_query("select `No`,`Name` from `attn_list` order by `Name`");
                while($row=mysql_fetch_array($sql))
                {
                $id=$row['No'];
                $name=$row['Name'];
                echo '<option value="'.htmlentities($id).'">'.htmlentities($name).'</option>';
                }
                ?>
                </select>
            </td>
            </tr>
            </table>
            </form><br><br>
            <div id="show_admin_detail">
            <?php
			include('dbconfig.php');
			if(isset($_POST['date5']))
			{	
				$date=mysql_real_escape_string($_POST['date5']);
				$result=mysql_query("SELECT * FROM `attendance` WHERE `Date`='$date'");
			}
			elseif(isset($_POST['date1'],$_POST['date2'],$_POST['a_id']))
			{
				$s_date=mysql_real_escape_string($_POST['date1']);
				$e_date=mysql_real_escape_string($_POST['date2']);
				$id=mysql_real_escape_string($_POST['a_id']);
				if($id=="all")
				{
					echo "<center><table><tr><td class=\"show\">Details of Emplyees From&nbsp; ".htmlentities($s_date)."&nbsp;to&nbsp;".htmlentities($e_date)."</td></tr></table></center><br>";
					$result=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' order by `No`");
				}
				else
				{
					$count_full=0;
					$count_half=0;
					$count_leave=0;
					$count_double=0;
					$count_night=0;
					echo "<center><table><tr><td class=\"show\">Details of Emplyee ID&nbsp;\"".htmlentities($id)."\"&nbsp;From&nbsp; ".htmlentities($s_date)."&nbsp;to&nbsp;".htmlentities($e_date)."</td></tr></table></center><br>";
					$result=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id'");
					$count_res=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id'");
					/*$full=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Full/Half/Leave`='Full'");
					$count_full=mysql_num_rows($full);
					$half=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Full/Half/Leave`='Half'");
					$count_half=mysql_num_rows($half);
					$leave=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Full/Half/Leave`='Leave'");
					$count_leave=mysql_num_rows($leave);
					$doublepay=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Double_pay`='YES'");
					$count_double=mysql_num_rows($doublepay);
					$night=	mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Full/Half/Leave`='Night'");
					$count_night=mysql_num_rows($night);
					*/
					while($count_row=mysql_fetch_array($count_res))
					{
						if($count_row['Full/Half/Leave']=='Full')
						{
							$count_full=$count_full+1;
						}
						if($count_row['Full/Half/Leave']=='Half')
						{
							$count_half=$count_half+1;
						}
						if($count_row['Full/Half/Leave']=='Leave')
						{
							$count_leave=$count_leave+1;
						}
						if($count_row['Full/Half/Leave']=='Night')
						{
							$count_night=$count_night+1;
						}
						if($count_row['Double_pay']=='YES')
						{
							$count_double=$count_double+1;
						}
					}
				}
			}
			else
			{
				$dat=date('Y-m-d');
				$result=mysql_query("SELECT * FROM `attendance` WHERE `Date`='$dat' order by `No`");
			}
			$count=mysql_num_rows($result);
			if($count>0)
			{
				Print "<center>"; 
				if($count<10)
				{
					Print "<div style=\"width: 900px; height: 150px; border: 0px groove #3b3a3a; overflow: auto;\">";
				}
				else
				{
					Print "<div style=\"width: 900px; height: 600px; border: 0px groove #3b3a3a; overflow: auto;\">";
				}
				Print "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"880\"  align=\"center\" class=\"text ui-widget-content ui-corner-all tab\" >";
				Print "<th>Options</th><th>Date</th><th>No</th><th>Name</th><th>Full / Half / Leave</th><th>Double Pay</th><th>Comments</th><th>Extra Hours</th>";
				Print "<tbody>";
				$c=1;
				while($row=mysql_fetch_array($result))
				{	
					$e_name=$row['Name'];
					Print "<tr class=\"tr".$c."\" align=\"center\" >";
					Print "<td align=\"center\" ><table align=\"center\"><tr align=\"center\"><td style=\"border:0px;\" align=\"center\"><a><img src=\"menu/notes.png\" title=\"Edit Attendance details\" height=\"18\" width=\"18\" onclick=\"update('".$row['S_No']."');\" ></a></td><td style=\"border:0px;\"><img src=\"menu/button-cross_sticker.png\" height=\"20\" width=\"20\" title=\"Delete file details\" style=\"cursor:pointer;\" onclick=\"deletefile('".$row['S_No']."');\"></td></tr></table></td> "; 
					Print "<td>".htmlentities($row['Date'])."</td>";
					Print "<td>".htmlentities($row['No']) . "</td> ";
					Print "<td class=\"cl_left\">".htmlentities($row['Name']) . "</td> ";
					Print "<td> ".htmlentities($row['Full/Half/Leave']) . " </td>";
					Print "<td>".htmlentities($row['Double_pay']) . "</td> "; 
					Print "<td> ".htmlentities($row['Comments']) . " </td>";
					Print "<td> ".htmlentities($row['Extra_hrs']) . " </td>";
					Print "</tr>";
					if($c==1)
					{
						$c=0;
					}
					else
					{
						$c=1;
					}
				}
				Print "</tbody>";
				Print "</table>";
				Print "</div>";
				if(isset($_POST['a_id']))
				{
					if($id!="all")
					{
						Print "<h4>Summary for  <u>".htmlentities($e_name)."</u></h4>";
						Print "<table class=\"tab\" border=\"1\" width=\"300\">";
						Print "<th>Options</th><th>No.Of days</th>";
						Print "<tr><td>Total No of Days Present</td><td>".htmlentities($count_full)."</td></tr>";
						Print "<tr><td>Total No of Half Days </td><td>".htmlentities($count_half)."</td></tr>";
						Print "<tr><td>Total No of Leave </td><td>".htmlentities($count_leave)."</td></tr>";
						Print "<tr><td>Total No of Double Pay </td><td>".htmlentities($count_double)."</td></tr>";
						Print "<tr><td>Total No of Night shift </td><td>".htmlentities($count_night)."</td></tr>";
						Print "</table>";
					}
				}
				Print "<br><br>";
				
				Print "</center>";
				Print "<script type=\"text/javascript\" language=\"javascript\">
						function update(emp_no)
						{
							var eno=emp_no;
							if (confirm('Are you sure ? You want to update ?'))
							{
								window.location = \"attendance.php?no=\"+eno;
							}
							else
							{
								return false;
							}
							
						}
						</script>";
				Print "<script type=\"text/javascript\" language=\"javascript\">
						function deletefile(emp_no)
						{
							var eno=emp_no;
							if (confirm('Are you sure ? You want to Delete ?'))
							{
								window.location = \"viewatten.php?no=\"+eno;
							}
							else
							{
								return false;
							}
						}
						</script>";
			}
			else
			{
				echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
				
			}
if(!(isset($_GET['no']))=="0")
{	
	$value=$_GET['no'];
	$query = "DELETE from `attendance` where `S_No` ='$value' ";
	$res = mysql_query($query);
	if($res)
	{
		$comment=$id." has deleted attendence details for the Employee ".$value."\n";
		$fp = fopen($log_dir.$uploadby.".txt", "a+");
		fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
		fclose($fp);
		echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Employee has been deleted Successfully !!!\",
					callback:function(){
					setTimeout(function(){ window.location = \"viewatten.php\";}, 0);
					}
				});
				</script>";
	}
	else
	{
		echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Employee attendance details not deleted Successfully !!!\",
					callback:function(){
					setTimeout(function(){ window.location = \"viewatten.php\";}, 0);
					}
				});
				</script>";
	}
}
mysql_close($con);
?>  
            </div>
                     
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->

</body>
<script src="js/element.js"></script>
</html>
