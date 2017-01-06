<?php
			include('dbconfig.php');
			if(isset($_GET['date5']))
			{	
				$date=$_GET['date5'];
				$result=mysql_query("SELECT * FROM `attendance` WHERE `Date`='$date'");
			}
			elseif(isset($_GET['date3'],$_GET['date4'],$_GET['a_id']))
			{
				$s_date=$_GET['date3'];
				$e_date=$_GET['date4'];
				$id=$_GET['a_id'];
				if($id=="all")
				{
					echo "<center><table><tr><td class=\"tdcolor\">Details of Emplyees From&nbsp; ".$s_date."&nbsp;to&nbsp;".$e_date."</td></tr></table></center><br>";
					$result=mysql_query("SELECT * FROM `attendance` WHERE `Date` BETWEEN '$s_date' AND '$e_date' order by `No`");
				}
				else
				{
					$count_full='';
					$count_half='';
					$count_leave='';
					$count_double='';
					$count_night='';
					echo "<center><table><tr><td class=\"tdcolor\">Details of Emplyee ID&nbsp;\"".$id."\"&nbsp;From&nbsp; ".$s_date."&nbsp;to&nbsp;".$e_date."</td></tr></table></center><br>";
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
				$result=mysql_query("SELECT * FROM `attendance` order by `S_No`");
			}
			$count=mysql_num_rows($result);
			if($count>0)
			{
				Print "<center><form name=\"contact\" method=\"POST\" action=\"#\">"; 
				if($count<10)
				{
					Print "<div style=\"width: 900px; height: 150px; border: 0px groove #3b3a3a; overflow: auto;\">";
				}
				else
				{
					Print "<div style=\"width: 900px; height: 300px; border: 0px groove #3b3a3a; overflow: auto;\">";
				}
				Print "<table border=\"0\" cellpadding=\"3\" width=\"700\"  align=\"center\" class=\"tab\"  bgcolor=\"#dbdedf\">";
				Print "<th>Select</th><th>Date</th><th>No</th><th>Name</th><th>Full / Half / Leave</th><th>Double Pay</th><th>Comments</th>";
				Print "<tbody>";
				$c=1;
				while($row=mysql_fetch_array($result))
				{	
					$e_name=$row['Name'];
					Print "<tr class=\"tr".$c."\" align=\"center\" >";
					Print "<td align=\"center\" ><input type=\"checkbox\" name=\"pref[]\" value=\"".$row['S_No']."\" onclick=\"highlight_row(this, 'LightBlue');\"></td> "; 
					Print "<td>".$row['Date']."</td>";
					Print "<td>".$row['No'] . "</td> ";
					Print "<td>".$row['Name'] . "</td> ";
					Print "<td> ".$row['Full/Half/Leave'] . " </td>";
					Print "<td>".$row['Double_pay'] . "</td> "; 
					Print "<td> ".$row['Comments'] . " </td>";
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
				if(isset($_GET['a_id']))
				{
					if($id!="all")
					{
						Print "<h4>Summary for  <u>".$e_name."</u></h4>";
						Print "<table class=\"tab\" border=\"1\" width=\"300\">";
						Print "<th>Options</th><th>No.Of days</th>";
						Print "<tr><td>Total No of Days Present</td><td>".$count_full."</td></tr>";
						Print "<tr><td>Total No of Half Days </td><td>".$count_half."</td></tr>";
						Print "<tr><td>Total No of Leave </td><td>".$count_leave."</td></tr>";
						Print "<tr><td>Total No of Double Pay </td><td>".$count_double."</td></tr>";
						Print "<tr><td>Total No of Night shift </td><td>".$count_night."</td></tr>";
						Print "</table>";
					}
				}
				Print "<br><br>";
				Print "<center><input type=\"submit\" name=\"Del\" id=\"Del\" class=\"button\" value=\"Delete\" onclick=\"return confirmDelete(this.form)\"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"submit\" name=\"update\" id=\"update\" class=\"button\" value=\"Update\" onclick=\"return confirmupdate(this.form)\"/></center>";
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
						function confirmupdate(thisform)
						{
							if (confirm('Are you sure ? You want to Update this ID ?'))
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
				Print"<script> setTimeout(function(){ window.location = \"viewatten.php\";}, 3000);</script>";
			}
?>  