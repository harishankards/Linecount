<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:left; }

select { margin-bottom:0px; width:320px; padding: .2em; text-align:center; }

#f_platformid{text-transform:uppercase;}
</style>
</head>
<body> 

<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
    
        <h2>Log Entry </h2>
        <form name="sub" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <table align="center" width="450" cellpadding="1" cellspacing="5">
            <tr align="center">
            <td class="result" colspan="4">Choose the Date to Login details</td>
            </tr>
            <tr align="left">
                <td class="bold">From&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/></td>
                <td class="bold">To&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/></td>
            </tr>
            <tr align="left">
            <td class="bold" colspan="4" style="text-align:left;">Employee Name&nbsp;&nbsp;:&nbsp;&nbsp;
                    <select name="a_id" id="a_id" class="text ui-widget-content ui-corner-all">
                    <option selected="selected" value="-1">--Show All Details--</option>
                    <?php
                    $sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='MLS' OR `Emp_desig`='HT-MLS' OR `Emp_desig`='EDITOR' OR `Emp_desig`='HT-EDITOR' order by `Emp_no`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $id=$row['Emp_no'];
                    $name=$row['Emp_name'];
                    echo '<option value="'.htmlentities($id).'">'.htmlentities($name)."--".htmlentities($id).'</option>';
                    }
					echo '<option value="Admin">Administrator</option>';
                    ?>
                    </select>
        		</td>
           </tr>
            <tr align="center">
                <td colspan="4">
                <input type="submit" value="Show LOG details" name="search" id="search" style="height:30px; width:150px;" >
                </td>
            </tr>
       </table>
	</form>
<?php
$c=1;
$lc=0;
$r=0;
$editlines=0;
$blanklines=0;
$ser="Search results ";
if(isset($_POST['date1'],$_POST['date2'],$_POST['a_id']))
{
	$s_date=mysql_real_escape_string($_POST['date1']);
	$e_date=mysql_real_escape_string($_POST['date2']);
	$id=mysql_real_escape_string($_POST['a_id']);
	
	$query="SELECT * FROM `log_file` WHERE `Date` BETWEEN '$s_date' AND '$e_date'";
	$ser="Search results ";
	
	if($id!=-1)//if id is set
	{
		$query=$query." AND `Loginas`='$id'";
		$ser=$ser." for ".$id;
	}
	
	$result=mysql_query($query);
}

else
{	
	$dat=date('Y-m-d');
	echo "<center><table><tr><td class=\"result1\">Details of the Employees Logged in ".htmlentities($dat)."</td></tr></table></center><br>";
	$result=mysql_query("SELECT * FROM `log_file`  WHERE `Date` ='$dat'");
}


if($result)
{	
	echo "<br><br><center><label class=\"result\">".htmlentities($ser)." </label></b><br><br>";
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		
		if($count<20)
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 250px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		else
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 450px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		
		echo "<table border=\"1\" cellpadding=\"2\" width=\"880\" align=\"center\" class=\"tab\">";
		echo "<th>S.No.</th><th>Date</th><th>Login As</th><th>Log in time (IST)</th><th>Log out time (IST)</th><th>Host name</th><th>IP Address</th>";
		
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".htmlentities($c)."</td>";
			echo "<td>".htmlentities($row['Date'])."</td>";
			echo "<td>".htmlentities($row['Loginas'])."</td>";
			echo "<td>".htmlentities($row['Log_in_time'])."</td>";
			echo "<td>".htmlentities($row['Log_out_time'])."</td>";
			echo "<td>".htmlentities($row['Host_name'])."</td>";
			echo "<td>".htmlentities($row['IP_address'])."</td>";
			echo "</tr>";
			
			$c=$c+1;
			
			if($r==0)
			{
				$r=1;
			}
			else
			{
				$r=0;
			}
		}
		echo "</table></div></center>";
	}
	else
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
	
	}
}
echo "<br><br>";
mysql_close($con);
?>
        <br />
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