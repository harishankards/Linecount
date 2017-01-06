<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function highlight_row(the_element, checkedcolor) {
if(the_element.parentNode.parentNode.style.backgroundColor != checkedcolor) {
the_element.parentNode.parentNode.style.backgroundColor = checkedcolor;
} 
else {
the_element.parentNode.parentNode.style.backgroundColor = '';
}
}
function call(thisform)
{
thisform.submit();
}

</script>

</head>
<body> 

<div id="outer_wrapper">
	

  <div id="wrapper">
    
   	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
          <center><br><br>
          <table align="center"	width="600" style="padding-left:200px;" >
          	<tr align="center">
          	<td class="tdcolor">Choose a date</td><td>:</td>
          	<td>
            <form name="form1" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" >
		  	<input type="text" id="attendate" name="date5" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
            
            </form>
          </td>
          </tr>
          </table>
          </center>
          <br>
          <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
		  <table align="center" width="600">
          <tr align="center">
            <td class="show" colspan="3">Choose the Date to See the uploaded Files</td>
            </tr>
            <tr align="center">
                <td class="bold">From&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">To&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
            </tr>
            </table>
            </td>
            <td class="tdcolor" width="300">Name&nbsp;:&nbsp;&nbsp;<select name="a_id" id="a_id" onChange="call(this.form)" >
            <option selected="selected" value="-1">--Select Name--</option>
            <?php
            $sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` order by `Emp_no`");
            while($row=mysql_fetch_array($sql))
            {
            $id=$row['Emp_no'];
			$name=$row['Emp_name'];
            echo '<option value="'.htmlentities($id).'">'.htmlentities($name).'</option>';
            }
            ?>
            <option value="all">All</option>
            </select></td>
            </tr>
            </table>
            </form><br><br>
            <div id="show_admin_detail">
            <?php
			if(isset($_POST['date5']))
			{	
				$date=mysql_real_escape_string($_POST['date5']);
				$result=mysql_query("SELECT * FROM `attendance` WHERE `Date`='$date'");
			}
			elseif(isset($_POST['date3'],$_POST['date4'],$_POST['a_id']))
			{
				$s_date=mysql_real_escape_string($_POST['date3']);
				$e_date=mysql_real_escape_string($_POST['date4']);
				$id=mysql_real_escape_string($_POST['a_id']);
				if($id=="all")
				{
					echo "<center><table><tr><td class=\"tdcolor\">Details of Emplyees From&nbsp; ".htmlentities($s_date)."&nbsp;to&nbsp;".htmlentities($e_date)."</td></tr></table></center><br>";
					$result=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' order by `No`");
				}
				else
				{
					$count_full='';
					$count_half='';
					$count_leave='';
					$count_double='';
					$count_night='';
					echo "<center><table><tr><td class=\"tdcolor\">Details of Emplyee ID&nbsp;\"".htmlentities($id)."\"&nbsp;From&nbsp; ".htmlentities($s_date)."&nbsp;to&nbsp;".htmlentities($e_date)."</td></tr></table></center><br>";
					$result=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id'");
					$full=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Full/Half/Leave`='Full'");
					$count_full=mysql_num_rows($full);
					$half=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Full/Half/Leave`='Half'");
					$count_half=mysql_num_rows($half);
					$leave=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Full/Half/Leave`='Leave'");
					$count_leave=mysql_num_rows($leave);
					$doublepay=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Double_pay`='YES'");
					$count_double=mysql_num_rows($doublepay);
					$night=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `No`='$id' AND `Full/Half/Leave`='Night'");
					$count_night=mysql_num_rows($night);
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
				Print "<center><form name=\"contact\" method=\"POST\" action=\"".$_SERVER['PHP_SELF']."\">"; 
				if($count<10)
				{
					Print "<div style=\"width: 900px; height: 150px; border: 0px groove #3b3a3a; overflow: auto;\">";
				}
				else
				{
					Print "<div style=\"width: 900px; height: 600px; border: 0px groove #3b3a3a; overflow: auto;\">";
				}
				Print "<table border=\"0\" cellpadding=\"3\" width=\"880\"  align=\"center\" class=\"tab\"  bgcolor=\"#dbdedf\">";
				Print "<th>Select</th><th>Date</th><th>No</th><th>Name</th><th>Full / Half / Leave</th><th>Double Pay</th><th>Comments</th><th>Extra Hours</th>";
				Print "<tbody>";
				$c=1;
				while($row=mysql_fetch_array($result))
				{	
					$e_name=htmlentities($row['Name']);
					Print "<tr class=\"tr".$c."\" align=\"center\" >";
					Print "<td align=\"center\" ><input type=\"checkbox\" name=\"atten[]\" value=\"".htmlentities($row['S_No'])."\" onclick=\"highlight_row(this, 'LightBlue');\"></td> "; 
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
				Print "<center><input type=\"submit\" name=\"Del\" id=\"Del\" class=\"button\" value=\"Delete\" onclick=\"return confirmDelete(this.form)\"/></center>";
				Print "</form></center>";
				Print "<script type=\"text/javascript\" language=\"javascript\">
						function confirmDelete(thisform)
						{
							if (confirm('Are you sure ? You want to delete this ID ?'))
							{
								thisform.submit();
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
?>  
            </div>
           
<?php
if(!(isset($_POST['atten']))=="0")
{	
	$myArray=$_POST['atten'];
	foreach($myArray as $key => $value)
		{
			$query = "DELETE from `attendance` where `S_No` ='$value' ";
			$res = mysql_query($query);
			$result=mysql_query("select * from `attendance`");
			Print"<script> setTimeout(function(){ window.location = \"deleteatten.php\";}, 0);</script>";
		}
	if($res)
	{
		echo "<script> alert ('Employee has been deleted Successfully !!!'); </script>";
	}
	else
	{
		echo "<script> alert('Please choose the data which you want to delete!!!');</script>";
	}
}

mysql_close($con);
?>		           
          
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->

</body>
<script src="js/element.js"></script>
</html>
