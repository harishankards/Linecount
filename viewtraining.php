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
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:left; }
select{ margin-bottom:0px; width:250px; padding: .2em; text-align:left; }
</style>
</head>
<body> 

<div id="outer_wrapper">
	

  <div id="wrapper">
    
   	<?php 
	include('main_top.php');
	?>
    <div id="main"><br>
          
          <br>
          <form name="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		  <table align="center" width="750" >
          <tr>
          <td class="bold">From&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">To&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php echo date('Y-m-d');?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
            <td class="tdcolor" width="300">Name&nbsp;:&nbsp;&nbsp;</td><td><select name="a_id" id="a_id" onChange="call(this.form)" class="text ui-widget-content ui-corner-all">
            <option selected="selected" value="-1">--Select Name--</option>
            <?php
            $sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` order by `Emp_name`");
            while($row=mysql_fetch_array($sql))
            {
            $id=$row['Emp_no'];
			$name=$row['Emp_name'];
            echo '<option value="'.$id.'">'.$name.'</option>';
            }
            ?>
            <option value="all">All</option>
            </select></td>
            </tr>
            </table>
            </form><br><br>
            <div id="show_admin_detail">
            <?php
			if(isset($_POST['date1'],$_POST['date2'],$_POST['a_id']))
			{
				$s_date=mysql_real_escape_string($_POST['date1']);
				$e_date=mysql_real_escape_string($_POST['date2']);
				$id=mysql_real_escape_string($_POST['a_id']);
				$name=getname($id);
				if($id=="all")
				{
					$result=mysql_query("SELECT * FROM `training` WHERE `Date` BETWEEN '$s_date' AND '$e_date'");
				}
				else
				{
					$result=mysql_query("SELECT * FROM `training` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Trainee_name`='$name'");
				}
				
			}
			else
			{
				$result=mysql_query("SELECT * FROM `training` order by `Date`");
			}
			$count=mysql_num_rows($result);
			if($count>0)
			{
				Print "<center><form name=\"contact\" method=\"POST\" action=\"".$_SERVER['PHP_SELF']."\">"; 
				if($count<10)
				{
					Print "<div style=\"width: 900px; height: 250px; border: 0px groove #3b3a3a; overflow: auto;\">";
				}
				else
				{
					Print "<div style=\"width: 900px; height: 600px; border: 0px groove #3b3a3a; overflow: auto;\">";
				}
				Print "<table border=\"1\" cellspacing=\"0\" cellpadding=\"2\" width=\"880\"  align=\"center\" class=\"text ui-widget-content ui-corner-all tab\"  bgcolor=\"#dbdedf\">";
				Print "<th width=\"20\">Option</th><th>Date</th><th>Trainer</th><th>Trained to whom</th><th>No. of Hours</th>";
				Print "<tbody>";
				$c=1;
				while($row=mysql_fetch_array($result))
				{	
					Print "<tr class=\"tr".htmlentities($c)."\" align=\"center\" >";
					Print "<td align=\"center\"><table align=\"center\"><tr align=\"center\"><td style=\"border:0px;\"><img src=\"menu/button-cross_sticker.png\" height=\"20\" width=\"20\" title=\"Delete file details\" style=\"cursor:pointer;\" onclick=\"deletefile('".$row['S.No']."');\"></td></tr></table></td> "; 
					Print "<td>".htmlentities($row['Date'])."</td>";
					Print "<td>".htmlentities($row['Trainee_name']). "</td> ";
					Print "<td>".htmlentities($row['To_whom']). "</td> ";
					Print "<td> ".htmlentities($row['No_of_hours']). " </td>";
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
				
				Print "<br><br>";
				Print "</form></center>";
				Print "<script type=\"text/javascript\" language=\"javascript\">
						function deletefile(no)
						{
							var sno=no;
							if (confirm('Are you sure ? You want to delete this Training detail ?'))
							{
								window.location = \"viewtraining.php?no=\"+sno;
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
				echo "<br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br />";
			}
?>  
            </div>
           
<?php

	if(!(isset($_GET['no']))=="0")
		{	
			//$comp=implode(',', $_POST['pref']);
			$myArray=$_GET['no'];
			$query = "DELETE from `training` where `S.No` ='$myArray' ";
			$res = mysql_query($query);
			if($res)
			{
				$comment=$loginas." has Deleted Training hours Details";
				$fp = fopen($log_dir.$loginas.".txt", "a+");
				fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
				fclose($fp);
				echo "<script> dhtmlx.alert({
						title:\"Success !!!\",
						ok:\"Ok\",
						text:\"Training Details deleted Successfully\",
						callback:function(){
						setTimeout(function(){ window.location = \"viewtraining.php\";}, 0);
						}
					});
					</script>";
			}
			else
			{
				echo "<script> dhtmlx.alert({
						title:\"Success !!!\",
						ok:\"Ok\",
						text:\"Training Details not deleted Successfully\",
						callback:function(){
						setTimeout(function(){ window.location = \"viewtraining.php\";}, 0);
						}
					});
					</script>";
			}
		}
		
?>		           
            <br /><br />
          
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php
include('dbconfig.php');


?>
</body>
<script src="js/element.js"></script>
</html>
