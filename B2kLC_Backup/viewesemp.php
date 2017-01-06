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
</script>
<style>
input.text { margin-bottom:0px; width:165px; padding: .2em; text-align:left; }
select { margin-bottom:0px; width:165px; padding: .2em; text-align:center; }

</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
    
   	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
    <form name="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <table align="center">
              <tr align="center">
                  <td>  
                      <div class="ui-widget">
                          <label for="tags">Search by Name : </label>
                          <input id="tags" name="empname" class="text ui-widget-content ui-corner-all"/>
                      </div>
                  </td>
                  <td><input type="submit" value="Check"></td>
              </tr>
         </table>
         </form>
         <br>
    	  <form name="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <table align="center">
         <tr align="center">
          <td class="bold">Choose Team</td><td>:</td>
          <td>
                    <select id="serid" name="serid" class="text ui-widget-content ui-corner-all">
                    <option selected="selected" value="-1">--Select Team--</option>
                    <?php
                    $sql=mysql_query("select `Vendor_name` from `vendor` order by `Vendor_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $des=$row['Vendor_name'];
                    echo '<option value="'.htmlentities($des).'">'.htmlentities($des).'</option>';
                    }
                    ?>
            </select>&nbsp;&nbsp;
            </td>
            <td class="bold">Choose Designation</td><td>:</td>
            <td>
                <select name="ser_des"  class="text ui-widget-content ui-corner-all tab">
                    <option selected="selected" value="-1">--Select Designation--</option>
                    <?php
                    $sql=mysql_query("select `Designation` from designation order by `Designation`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $des=$row['Designation'];
                    echo '<option value="'.htmlentities($des).'">'.htmlentities($des).'</option>';
                    }
                    ?>
            </select>
            </td><td>
                  	<input type="submit" name="Searchdes" value="Search" alt="Search" id="Searchdes" title="Search" onClick="show()" />
             </td>
            </tr>
            </table>
            </form>
            
            
            <br /><br />
          <?php
		  	
			if(isset($_POST['serid'],$_POST['ser_des']))
			{
				$no=$_POST['serid'];
				$des=$_POST['ser_des'];
				$query="SELECT * FROM `es_employee`";
				if(($no!=-1)&&($des!=-1))
				{
					$query=$query." WHERE `Vendor`='$no' AND `Emp_desig`='$des' order by `Emp_no`";
				}
				if(($des==-1)&&($no!=-1))
				{
					$query=$query." WHERE `Vendor`='$no'";
				}
				if(($des!=-1)&&($no==-1))
				{
					$query=$query." WHERE `Emp_desig`='$des'";
				}
			}
			elseif(isset($_POST['empname']))
			{
				$emp_name=$_POST['empname'];
				$query="SELECT * FROM `es_employee` WHERE `Emp_name` LIKE '%$emp_name%' order by `Emp_no`";
			}
			else
			{
				$query="SELECT * FROM `es_employee` order by `Emp_no`";
			}
			
			$result=mysql_query($query);
			$sendquery=$query;
			$count=mysql_num_rows($result);
			if($count>0)
			{
				$comment=$loginas." has Viewed Employee Details";
				$fp = fopen($log_dir.$loginas.".txt", "a+");
				fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
				fclose($fp);
				Print "<center>"; 
				Print "<div style=\"width: 900px; height: 450px; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table width=\"900\" border=\"1\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\" cellpadding=\"3\" cellspacing=\"0\">";
				Print "<th>Options</th><th>Team</th><th>Employee ID</th><th>Password</th><th>Name</th><th>Designation</th><th>D.O.B</th><th>Address</th><th>Mobile No</th><th>Telephone</th><th>Mail Id</th><th>ID Status</th><th>Login Status</th>";
							
				Print "<tbody>";
				$c=1;
				while($row=mysql_fetch_array($result))
				{	
					if($row['Emp_phno']!='' || $row['Emp_tel']!='')
					{
						$phoneno=$row['Emp_phno'].",".$row['Emp_tel'];
					}
					else
					{
						$phoneno="Not Available Please Update !!!";
					}
					Print "<tr class=\"tr".$c."\" align=\"center\" title=\"".$row['Emp_name']." -> ".$phoneno."\" style=\"cursor:pointer;\" >";
					Print "<td align=\"center\" ><table><tr><td style=\"border:0px;\"><a><img src=\"menu/notes.png\" title=\"Edit Employee details\" height=\"20\" width=\"20\" onclick=\"update('".$row['Emp_no']."');\" ></a></td><td style=\"border:0px;\"><a><img src=\"menu/button-cross_sticker.png\" height=\"20\" width=\"20\" title=\"Delete Employee details\" onclick=\"deleteemp('".$row['Emp_no']."');\"></a></td></tr></table></td> "; 
					Print "<td>".$row['Vendor'] . "</td> ";
					Print "<td>".$row['Emp_no'] . "</td> ";
					Print "<td>".$row['password'] . "</td> ";
					Print "<td>".$row['Emp_name'] . "</td> ";
					Print "<td> ".$row['Emp_desig'] . " </td>";
					Print "<td>".$row['Emp_dob'] . "</td> "; 
					Print "<td> ".$row['Emp_add'] . " </td>";
					Print "<td> ".$row['Emp_phno'] . "</td>";
					Print "<td> ".$row['Emp_tel'] . " </td>";
					Print "<td> ".$row['Emp_mail'] . " </td>";
					Print "<td> ".$row['ID_Status'] . " </td>";
					if($row['Log_status']=="YES")
					{
						echo "<td>
						<form name=\"up_status\" action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">
						<table><tr><td style=\"border:0px;\">
						<input type=\"hidden\" name=\"empno\" id=\"empno\" value=\"".$row['Emp_no']."\">
						<select name=\"logstatus\" id=\"logstatus\">
						<option selected=\"selected\" value=\"".$row['Log_status']."\">".$row['Log_status']."</option>";
						$hsp=$row['Log_status'];
						if($hsp=="YES")
						{
							echo '<option value="NO">NO</option>';
						}
						else
						{
							echo '<option value="YES">YES</option>';
						}
						echo "</select></td>
						<td style=\"border:0px;\">
						<input type=\"submit\" name=\"save\" id=\"save\" value=\"Save\"></td></tr></table>
						</form></td>";
					}
					else
					{	
						Print "<td> ".$row['Log_status'] . " </td>";
					}
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
				Print "</center>";
				Print "<script type=\"text/javascript\" language=\"javascript\">
						function update(emp_no)
						{
							var eno=emp_no;
							if (confirm('Are you sure ? You want to update this '+eno+'?'))
							{
								window.location = \"updateemp.php?no=\"+eno+\"&acc=escription\";
							}
							else
							{
								return false;
							}
							
						}
						function deleteemp(emp_no)
						{
							var eno=emp_no;
							if (confirm('Are you sure ? You want to delete this '+eno+'?'))
							{
								window.location = \"viewesemp.php?del_emp_no=\"+eno;
							}
							else
							{
								return false;
							}
							
						}
						</script>";
			echo "<br><center><strong>***The output of the Excel is based on your selection Criteria***</strong></center>";
			Print "<br><center><form name=\"xl\" method=\"post\" action=\"toexcel.php\">";
			Print "<input type=\"hidden\" Value=\"Employee Details\" name=\"rep_name\" id=\"name\" />";
			Print "<input type=\"hidden\" Value=\"$sendquery\" name=\"query\" id=\"query\" />";
			Print "<input type=\"submit\" value=\"Get Employee details as Excel\" name=\"Filedetails\"/>";
			Print "</form></center>";
			}
			else
			{
				echo "<br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br />";
			}
			
			?>  
            <?
			if(isset($_POST['empno']))
			{
				$no=$_POST['empno'];
				$status=$_POST['logstatus'];
				/*echo "<script> alert('".$no.$status."');</script>";*/
				$upsql=mysql_query("UPDATE `es_employee` SET `Log_status`='$status' WHERE `Emp_no`='$no'");
				if($upsql)
				{
					echo "<script>alert('updated successfully'); setTimeout(function(){ window.location = window.location.href;}, 0);</script>";
				}
			}
			if(isset($_GET['del_emp_no']))
			{		
				$value=mysql_real_escape_string($_GET['del_emp_no']);	
				$del=mysql_query("DELETE FROM `es_employee` WHERE `Emp_no`='$value'");
				if($del)
				{
					$comment=$loginas." has Deleted Employee Details ".$value;
					$fp = fopen($log_dir.$loginas.".txt", "a+");
					fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
					echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"Employee details of ID ".$value." deleted successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"viewesemp.php\";}, 0);
								}
							});
							</script>";
				}
				else
				{
					echo "<script> alert('Please choose the data !!!');</script>";
				}
			}
			?>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
  </div> 
	<!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
<script>
    $(function() {
        $( document ).tooltip({
            track: true
        });
    });
    </script>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(thisform.e_no.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Employee ID"});
      return false;
    }
	if(thisform.e_pass.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Password"});
      return false;
    }
	
	if(thisform.e_name.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Employee name"});
      return false;
    }
	
	if(thisform.e_vndr.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Team"});
      return false;
    }
	
	if(thisform.e_des.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Designation"});
      return false;
    }
	
	if(thisform.e_status.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a ID Status"});
      return false;
    }
	thisform.submit();
	save();
}
</script>
  <script>
  $(function() {
    var availableTags = [
		<?php
		$empsql=mysql_query("SELECT `Emp_name` FROM `es_employee` order by `Emp_no`");
		while($emprow=mysql_fetch_array($empsql))
		{
		$e_name=$emprow['Emp_name'];
		echo '"'.$e_name.'",';
		}
		echo '"end"';
		?>

    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  });
  function sub(thisform)
  {
  	thisform.submit();
  }
  </script>


</body>
</html>
