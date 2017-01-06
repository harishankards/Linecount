<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:180px; padding: .2em; text-align:left; }

select { margin-bottom:0px; width:185px; padding: .2em; text-align:center; }
</style>
<script language="javascript" type="text/javascript">
function checkid(thisform)
{
	if(document.getElementById('searchfield').value==='Enter a ID here...')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter valid Hospital ID to search"});
		return false;
	}
	thisform.submit();
	show();
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
          <center>
          <table width="600">
          <tr align="center">
          <td>
          <div id="search_box">
          		<center>
                <form name="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="text" value="Enter a ID here..." name="serid" size="10" id="searchfield" title="searchfield" onFocus="clearText(this)" onBlur="clearText(this)" />
                  	<input type="button" name="Searchid" value="Search" alt="Search" id="Searchid" title="Search" onClick="checkid(this.form)" />
                </form>
                </center>
            </div>
            </td>
            </tr>
            </table>
            </center>
            
            
            <br /><br />
          <?php
		  	$ser='';
			if(isset($_POST['serid']))
			{
				$no=$_POST['serid'];
				$query="SELECT * FROM `escript_id` WHERE `User_ID`='$no'";
				$result=mysql_query($query);
				$ser="Search result for ".$no."";
				$comment=$loginas." has Viewed details of ID ".$no." in Escription.";
				$fp = fopen($log_dir.$loginas.".txt", "a+");
				fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
				fclose($fp);
			}
			else
			{
				$query="SELECT * FROM `escript_id` order by `User_ID`";
				$result=mysql_query($query);
				$comment=$loginas." has Viewed ID details in Escription.";
				$fp = fopen($log_dir.$loginas.".txt", "a+");
				fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
				fclose($fp);
			}
			$sendquery=$query;
			$count=mysql_num_rows($result);
			if($count>0)
			{
				Print "<center><label class=\"show\">".$ser."</label></center><br>";
				Print "<div style=\"width: 900px; height: 300px; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table border=\"1\" cellspacing=\"0\" cellpadding=\"2\" width=\"880\"  align=\"center\" class=\"text ui-widget-content ui-corner-all tab\"  >";
				Print "<th>Options</th><th>HR ID</th><th>Username</th><th>User ID</th><th>Fiesa ID</th><th>Fiesa Password</th><th>MIR Password</th><th>Working Status</th><th>Alloted to</th>";
				$hos_query=mysql_query("SELECT * from `escript_id`");
				$no=mysql_num_fields($hos_query);
				for($i=9;$i<$no;$i++)
				{
					$col=mysql_field_name($hos_query,$i);
					Print "<th>".$col." Password</th>";
				} 
				Print "<tbody>";
				$c=1;
				while($row=mysql_fetch_array($result))
				{	
					Print "<tr class=\"tr".$c."\" align=\"center\" >";
					Print "<td align=\"center\" ><table><tr><td style=\"border:0px;\"><a><img src=\"menu/notes.png\" title=\"Edit Employee details\" height=\"20\" width=\"20\" onclick=\"update('".$row['User_ID']."');\" ></a></td><td style=\"border:0px;\"><a><img src=\"menu/button-cross_sticker.png\" height=\"20\" width=\"20\" title=\"Delete Employee details\" onclick=\"deleteemp('".$row['User_ID']."');\"></a></td></tr></table></td> "; 
					Print "<td>".$row['HR_ID'] . "</td> ";
					Print "<td>".$row['Username'] . "</td> ";
					Print "<td>".$row['User_ID'] . "</td> ";
                                        Print "<td>".$row['Fiesa_ID'] . "</td> ";
					Print "<td>".$row['Fiesa_password'] . "</td> ";
					Print "<td> ".$row['MIR_Password'] . " </td>";
					Print "<td>".$row['Status'] . "</td> "; 
					Print "<td>".$row['Alloted_to'] . "</td> "; 
					$hos_query1=mysql_query("SELECT * from `escript_id`");
					$no1=mysql_num_fields($hos_query1);
					for($i=9;$i<$no1;$i++)
					{
						$col1=mysql_field_name($hos_query1,$i);
						Print "<td>".$row["$col1"]."</td>";
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
				Print "<script type=\"text/javascript\" language=\"javascript\">
						function update(emp_no)
						{
							var eno=emp_no;
							if (confirm('Are you sure ? You want to update this '+eno+'?'))
							{
								window.location = \"es-updateid.php?no=\"+eno;
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
								window.location = \"es-viewid.php?del_id=\"+eno;
							}
							else
							{
								return false;
							}
							
						}
						</script>";
				Print "</center>";
				echo "<br><center><strong>***The output of the Excel is based on your selection Criteria***</strong></center>";
				Print "<center><form name=\"xl\" method=\"post\" action=\"toexcel.php\">";
				Print "<input type=\"hidden\" Value=\"$sendquery\" name=\"query\" id=\"query\" />";
				Print "<input type=\"hidden\" Value=\"ID Details\" name=\"rep_name\" id=\"name\" />";
				Print "<input type=\"submit\" value=\"Get ID details as Excel\" name=\"Filedetails\"/>";
				Print "</form></center></td></tr></table>";
			}
			else
			{
				echo "<br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br />";
			}
			if(isset($_GET['del_id']))
			{		
				$value=mysql_real_escape_string($_GET['del_id']);	
				$del=mysql_query("DELETE FROM `escript_id` WHERE `User_ID`='$value'");
				if($del)
				{
					echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"ID details deleted successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"es-viewid.php\";}, 0);
								}
							});
							</script>";
				}
				else
				{
					echo "<script> alert('Please try again !!!');</script>";
				}
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