<?php include('top.php');?>

<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
</style></head>
<body> 

<div id="outer_wrapper">
	

  <div id="wrapper">
    
   <?php 
	include('main_top.php');
	?>
    <div id="main"><br>
           <br><br>
          <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
		  <center><p>Click Show to see the complete details in between the date ranges</p></center>
           <table align="center" width="450">
          <tr align="center">
          <td class="bold">From&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                  <input type="text" id="from" name="date3" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">To&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                 <input type="text" id="to" name="date4" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>            </tr>
            </table><br>
            <center>
            <table width="300">
            <tr align="center">
            <td>
            <input type="submit" value="Show" name="sub">
            </td>
            </tr>
            </table>
            </center>	
            </form><br><br>
	        </center> 
           
  <?php
  	include('dbconfig.php');
	if(isset($_POST['date3'],$_POST['date4']))
    {	
		$s_date=mysql_real_escape_string($_POST['date3']);
		$e_date=mysql_real_escape_string($_POST['date4']);
		$sql=mysql_query("select * from `attn_list`  order by `Name`");
		Print "<center>"; 
		Print "<div style=\"width: 730px; height: 500px; border: 0px groove #3b3a3a; overflow: auto;\">";
		Print "<center><table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"700\"  align=\"center\" class=\"text ui-widget-content ui-corner-all tab\"  bgcolor=\"#dbdedf\">";
		Print "<th>S.No</th><th>Name</th><th>No. of Full days</th><th>No. of Half days</th><th>No. of Days Leave</th><th>No. of Days Double Pay</th><th>No. of Night Shift</th>";
		$no=1;
		$c=1;
		while($row=mysql_fetch_array($sql))
		{
		$id=$row['No'];
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
		Print "<tr class=\"tr".$c."\" align=\"center\"><td>".$no."</td><td>".$row['Name']."</td><td>".$count_full."</td><td>".$count_half."</td><td>".$count_leave."</td><td>".$count_double."</td><td>".$count_night."</td></tr>";
		
		if($c==1)
		{
			$c=0;
		}
		else
		{
			$c=1;
		}
		$no=$no+1;				
		}
		Print "</table></center>";
		
		Print "</div><br><br>";
		Print "<form name=\"contact\" method=\"post\" action=\"attenreport.php\">";
		Print "<input type=\"hidden\" value=$s_date name=\"start\" id=\"start\" />";
		Print "<input type=\"hidden\" value=$e_date name=\"end\" id=\"end\" />";
		Print "<input type=\"submit\" value=\"Export to Excel\" name=\"Export\"/>";
		Print "</form></center>";
    }
	mysql_close($con);
    ?>
    </div>
    <div id="main_bottom"></div>
    <?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div>

</body>
<script src="js/element.js"></script>
</html>