<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(document.getElementById('searchfield1').value==='-1')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Hospital"});
		return false;
	}
	thisform.submit(thisform);
	show();
}
function checkid(thisform)
{
	if(document.getElementById('searchfield').value==='Enter a Hospital ID here...')
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
                    <input type="text" value="Enter a Hospital ID here..." name="serid" size="10" id="searchfield" title="searchfield" onFocus="clearText(this)" onBlur="clearText(this)" />
                  	<input type="button" name="Searchid" value="Search" alt="Search" id="Searchid" title="Search" onClick="checkid(this.form)" />
                </form>
                </center>
            </div>
            </td>
            <td>
            <div id="search_drop">
          		<center>
                <form name="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <select name="searchfield1" id="searchfield1" >
                    <option selected="selected" value="-1">--Select Hospital--</option>
                    <?php
                    $sql=mysql_query("select `Hospital_name` from `hospitals` order by `Hospital_name` ");
                    while($row=mysql_fetch_array($sql))
                    {
                    $hsp=$row['Hospital_name'];
                    echo '<option value="'.$hsp.'">'.$hsp.'</option>';
                    }
                    ?>
                    <option value="All">Show all</option>
                    </select>&nbsp;&nbsp;
                  	<input type="button" name="Searchdes" value="Search" alt="Search" id="Searchdes" title="Search" onClick="check(this.form)" />
                </form>
                	
                </center>
            </div>
            </td>
            </tr>
            </table>
            </center>
          <?php
		  	$ser='';
			if(isset($_POST['serid']))
			{
				$no=$_POST['serid'];
				$query="SELECT * FROM `id_details` WHERE `username`='$no'";
				$result=mysql_query($query);
				$ser="Search result for ".$no."";
				$comment=$loginas." has Viewed details of ID ".$no.".";
				$fp = fopen($log_dir.$loginas.".txt", "a+");
				fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
				fclose($fp);
			}
			elseif(isset($_POST['searchfield1']))
			{
				$des=$_POST['searchfield1'];
				if($des=="All")
				{
					$query="SELECT * FROM `id_details` order by `Client`";
					$result=mysql_query($query);
					$ser="Search result for all ID";
					$comment=$loginas." has Viewed all ID details .";
					$fp = fopen($log_dir.$loginas.".txt", "a+");
					fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
				}
				else
				{
					$query="SELECT * FROM `id_details` WHERE `Hospital`='$des'";
					$result=mysql_query($query);
					$ser="Search result for ".$des."";
					$comment=$loginas." has Viewed details of ID which belongs to the Hoospital ".$des.".";
					$fp = fopen($log_dir.$loginas.".txt", "a+");
					fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
				}
			}
			else
			{
				$query="SELECT * FROM `id_details` order by `Client`";
				$result=mysql_query($query);
			}
			$sendquery=$query;
			$count=mysql_num_rows($result);
			if($count>0)
			{
				Print "<center><label class=\"show\">".$ser."</label></center><br>";
				Print "<center><div style=\"width: 850px; height: 300px; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"830\"  align=\"center\" class=\"text ui-widget-content ui-corner-all tab\"  >";
				Print "<th>Options</th><th>Client</th><th>Platform</th><th>Hospital</th><th>Username</th><th>Password</th><th>Working Status</th><th>Alloted to</th>";
				$c=1;
				while($row=mysql_fetch_array($result))
				{	
					Print "<tr class=\"tr".$c."\" align=\"center\" >";
					Print "<td align=\"center\" ><table><tr><td style=\"border:0px;\"><a><img src=\"menu/notes.png\" title=\"Edit Employee details\" height=\"20\" width=\"20\" onclick=\"update('".$row['No']."');\" ></a></td><td style=\"border:0px;\"><a><img src=\"menu/button-cross_sticker.png\" height=\"20\" width=\"20\" title=\"Delete Employee details\" onclick=\"deleteemp('".$row['No']."');\"></a></td></tr></table></td> "; 
					Print "<td>".$row['Client'] . "</td> ";
					Print "<td>".$row['Platform'] . "</td> ";
					Print "<td>".$row['Hospital'] . "</td> ";
					Print "<td>".$row['username'] . "</td> ";
					Print "<td> ".$row['password'] . " </td>";
					Print "<td>".$row['Working_status'] . "</td> "; 
					Print "<td>".$row['Alloted_to'] . "</td> "; 
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
				Print "</table>";
				Print "</div>";
				Print "</center>";
				Print "<script type=\"text/javascript\" language=\"javascript\">
						function update(emp_no)
						{
							var eno=emp_no;
							if (confirm('Are you sure ? You want to update this '+eno+'?'))
							{
								window.location = \"updateid.php?no=\"+eno;
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
								window.location = \"viewid.php?del_id=\"+eno;
							}
							else
							{
								return false;
							}
							
						}
						</script>";
				echo "<br><center><strong>***The output of the Excel is based on your selection Criteria***</strong></center><br>";
				Print "<center><form name=\"xl\" method=\"post\" action=\"toexcel.php\">";
				Print "<input type=\"hidden\" Value=\"$sendquery\" name=\"query\" id=\"query\" />";
				Print "<input type=\"hidden\" Value=\"ID Details\" name=\"rep_name\" id=\"name\" />";
				Print "<input type=\"submit\" value=\"Get ID details as Excel\" name=\"Filedetails\"/>";
				Print "</form></center>";
			}
			else
			{
				echo "<br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br />";
			}
			if(isset($_GET['del_id']))
			{		
				$value=mysql_real_escape_string($_GET['del_id']);	
				$del=mysql_query("DELETE FROM `id_details` WHERE `No`='$value'");
				if($del)
				{
					$comment=$loginas." has deleted a ID details of ID".value.".";
					$fp = fopen($log_dir.$loginas.".txt", "a+");
					fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
					echo "<script> dhtmlx.alert({
								title:\"Success !!!\",
								ok:\"Ok\",
								text:\"ID details deleted successfully !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"viewid.php\";}, 0);
								}
							});
							</script>";
				}
				else
				{
					echo "<script> dhtmlx.alert({
								title:\"Error !!!\",
								ok:\"Ok\",
								text:\"Please check ID details cannot able to delete !!!\",
								callback:function(){
								setTimeout(function(){ window.location = \"viewid.php\";}, 0);
								}
							});
							</script>";
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
