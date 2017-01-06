<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
select{ margin-bottom:0px; width:180px; padding: .2em; text-align:left;}
</style>

</head>
<body> 

<div id="outer_wrapper">

  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
    <h2>PJO Details </h2>
        <form name="sub" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
        <center><p class="result">Choose the Date to See details</p></center>
        
        <table align="center" width="600" cellpadding="10">
        
        <table align="center" width="400" cellpadding="2">
            <tr align="left">
                <td class="bold">From<td>:</td></td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date1'])) { echo $_POST['date1']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/>
                </td>
                <td class="bold">To</td><td>:</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date2'])) { echo $_POST['date2']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/>
                </td> 
                
        	</tr>
           <tr align="center">
                <td colspan="6">
                <input type="submit" value="Search" name="search" id="search" style="height:30px; width:75px;" >
                </td>
            </tr>
        </table>
     </form>
   
    <?php
	if(isset($_POST['date1'],$_POST['date2']))
	{
		$cc=1;
		$cr=0;
		$s_date=$_POST['date1'];
		$e_date=$_POST['date2'];
		$client=mysql_query("SELECT * FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Client`='PJO'");
		echo "<h4><center>PJO Details</center></h4>";
		echo "<table border=\"1\" width=\"700\" class=\"text ui-widget-content ui-corner-all tab\" align=\"center\" cellspacing=\"0\" cellpadding=\"1\">";
		echo "<th>S.No</th><th>Date</th><th>Client</th><th>Hospital</th><th>File No</th><th>Voice No</th><th>Type</th>";
		while($vnrow=mysql_fetch_array($client))
		{
			echo "<tr aling=\"center\" class=\"tr".$cr."\">";
			echo "<td>".$cc."</td>";
			echo "<td>".$vnrow['Date']."</td>";
			echo "<td>".$vnrow['Client']."</td>";
			echo "<td>".$vnrow['Hospital']."</td>";
			echo "<td>".$vnrow['File_No']."</td>";
			echo "<td>".$vnrow['Voice_No']."</td>";
			echo "<td>".$vnrow['Upload_to']."</td></tr>";
			$cc=$cc+1;
			if($cr==1)
			{
				$cr=0;
			}
			else
			{
				$cr=1;
			}
		}
		echo "</table><br>";
		Print "<center><form name=\"xl\" method=\"post\" action=\"pjoxl.php\">";
		Print "<input type=\"hidden\" value=$s_date name=\"start\" id=\"start\" />";
		Print "<input type=\"hidden\" value=$e_date name=\"end\" id=\"end\" />";
		Print "<input type=\"submit\" value=\"Export to Excel\" name=\"inhouse\"/>";
		Print "</form></center></td></tr></table>";
	}
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
