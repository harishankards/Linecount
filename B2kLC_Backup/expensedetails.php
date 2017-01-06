<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center }
select { margin-bottom:0px; width:125px; padding: .2em; text-align:center; }
</style>
</head>
<body> 

<div id="outer_wrapper">

  <div id="wrapper">
    
   	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
        
       <center><p class="result">Choose the Date to Login details</p></center>
        
        <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
       <table align="center" width="800" cellpadding="2">
            <tr align="center">
                <td class="bold">From&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">To&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="result1">Select Income or Expense</td>
                <td>:</td>
                <td>
                <select name="inc_ex" id="inc_ex" class="text ui-widget-content ui-corner-all">
                <option selected="selected" value="-1">--Select--</option>
                <option value="EXPENSE">Expense</option>
                <option value="INCOME">Income</option>
                </select>
                </td>
            </tr>
             <tr align="center">
                <td colspan="9">
                <input type="submit" value="Search" name="search" id="search" >
                </td>
            </tr>
            </table>
            </center>
            </form>
            
            <br /><br />
          <?php
		  	$r=1;
			if(isset($_POST['date1'],$_POST['date2'],$_POST['inc_ex']))
			{
				$s_date=mysql_real_escape_string($_POST['date1']);
				$e_date=mysql_real_escape_string($_POST['date2']);
				$inc=mysql_real_escape_string($_POST['inc_ex']);
				if($inc!=-1)
				{
					$query="SELECT * FROM `accounts_log`WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Income_exp`='$inc'";
				}
				else
				{
					$query="SELECT * FROM `accounts_log`WHERE `Date` BETWEEN '$s_date' AND '$e_date'";
				}
			}
			else
			{
				$query="SELECT * FROM `accounts_log` order by `Date`";
			}
			$sendquery=$query;
			$result=mysql_query($query);
			$count=mysql_num_rows($result);
			if($count>0)
			{
				Print "<center><form name=\"contact\" method=\"post\" action=\"upsup.php\">";
				Print "<center><label class=\"result1\">Search results</label></center><br>"; 
				Print "<div style=\"width: 900px; height: 350px; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"700\"  align=\"center\" class=\"text ui-widget-content ui-corner-all tab\" >";
				Print "<th>S.No</th><th>Date</th><th>Income / Expense</th><th>Voucher No</th><th>Particulars</th><th>Amount</th><th>Balance Amount</th>";
							
				Print "<tbody>";
				$c=1;
				while($row=mysql_fetch_array($result))
				{	
					Print "<tr class=\"tr".$c."\" align=\"center\" >";
					Print "<td>".htmlentities($r).".</td> ";
					Print "<td>".htmlentities($row['Date']) . "</td> ";
					Print "<td>".htmlentities($row['Income_exp']) . "</td> ";
					Print "<td>".htmlentities($row['Voucher_no']) . "</td> ";
					Print "<td>".htmlentities($row['Particulars']) . "</td> ";
					Print "<td> ".htmlentities($row['Amount']) . " </td>";
					Print "<td>".htmlentities($row['Balance']) . "</td> "; 
					Print "</tr>";
					if($c==1)
					{
						$c=0;
					}
					else
					{
						$c=1;
					}
					$r=$r+1;
				}
				Print "</tbody>";
				Print "</table>";
				Print "</div>";
				Print "<br><br>";
				Print "</form></center>";
				echo "<br><center><strong>***The output of the Excel is based on your selection Criteria***</strong></center>";
				Print "<br><br><center><form name=\"xl\" method=\"post\" action=\"toexcel.php\">";
				Print "<input type=\"hidden\" Value=\"$sendquery\" name=\"query\" id=\"query\" />";
				Print "<input type=\"hidden\" Value=\"Accounts Details\" name=\"rep_name\" id=\"name\" />";
				Print "<input type=\"submit\" value=\"Get Accounts details as Excel\" name=\"Filedetails\"/>";
				Print "</form></center></td></tr></table>";
			}
			else
			{
				echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
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
