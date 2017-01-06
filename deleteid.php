<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}

function highlight_row(the_element, checkedcolor) {
if(the_element.parentNode.parentNode.style.backgroundColor != checkedcolor) {
the_element.parentNode.parentNode.style.backgroundColor = checkedcolor;
} 
else {
the_element.parentNode.parentNode.style.backgroundColor = '';
}
}
function check(thisform)
{
	if(document.getElementById('searchfield1').value==='-1')
	{
		alert('Please Choose a Hospital');
		return false;
	}
	thisform.submit(thisform);
}
function checkid(thisform)
{
	if(document.getElementById('searchfield').value==='Enter a Hospital ID here...')
	{
		alert('Please enter valid Hospital ID to search');
		return false;
	}
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
          <center>
          <table width="600">
          <tr align="center">
          <td>
          <div id="search_box">
          		<center>
                <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <input type="text" value="Enter a Hospital ID here..." name="serid" size="10" id="searchfield" title="searchfield" onFocus="clearText(this)" onBlur="clearText(this)" />
                  	<input type="button" name="Searchid" value="Search" alt="Search" id="Searchid" title="Search" onClick="checkid(this.form)" />
                </form>
                </center>
            </div>
            </td>
            <td>
            <div id="search_drop">
          		<center>
                <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <select name="searchfield1" id="searchfield1" >
                    <option selected="selected" value="-1">--Select Hospital--</option>
                    <?php
                    $sql=mysql_query("select `Hospital_name` from `hospitals` order by `Hospital_name` ");
                    while($row=mysql_fetch_array($sql))
                    {
                    $hsp=$row['Hospital_name'];
                    echo '<option value="'.htmlentities($hsp).'">'.htmlentities($hsp).'</option>';
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
            
            
            <br /><br />
          <?php
		  	
			if(isset($_POST['serid']))
			{
				$no=mysql_real_escape_string($_POST['serid']);
				$result=mysql_query("SELECT * FROM `id_details` WHERE `username`='$no' order by `username`");
			}
			elseif(isset($_POST['searchfield1']))
			{
				$des=mysql_real_escape_string($_POST['searchfield1']);
				if($des=="All")
				{
					$result=mysql_query("SELECT * FROM `id_details` order by `Client`");
				}
				else
				{
					$result=mysql_query("SELECT * FROM `id_details` WHERE `Hospital`='$des' order by `Hospital`");
				}
			}
			else
			{
				$result=mysql_query("SELECT * FROM `id_details` order by `Client`");
			}
			$count=mysql_num_rows($result);
			if($count>0)
			{
				Print "<center><form name=\"contact\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">"; 
				Print "<div style=\"width: 900px; height: 500px; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table border=\"0\" cellpadding=\"3\" width=\"700\"  align=\"center\" class=\"tab\"  bgcolor=\"#dbdedf\">";
				Print "<th>Select</th><th>Client</th><th>Platform</th><th>Hospital</th><th>Username</th><th>Password</th><th>Working Status</th><th>Alloted to</th>";
							
				Print "<tbody>";
				$c=1;
				while($row=mysql_fetch_array($result))
				{	
					Print "<tr class=\"tr".$c."\" align=\"center\" >";
					Print "<td align=\"center\" ><input type=\"checkbox\" name=\"hid[]\" value=\"".htmlentities($row['No'])."\" onclick=\"highlight_row(this, 'LightBlue');\"></td> "; 
					Print "<td>".htmlentities($row['Client']) . "</td> ";
					Print "<td>".htmlentities($row['Platform']) . "</td> ";
					Print "<td>".htmlentities($row['Hospital']) . "</td> ";
					Print "<td>".htmlentities($row['username']) . "</td> ";
					Print "<td> ".htmlentities($row['password']) . " </td>";
					Print "<td>".htmlentities($row['Working_status']) . "</td> "; 
					Print "<td>".htmlentities($row['Alloted_to']) . "</td> "; 
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
				Print "<center><input type=\"submit\" name=\"delete\" id=\"delete\" class=\"button\" value=\"Delete\" onclick=\"return confirmDelete(this.form)\"/></center>";
				Print "</form></center>";
				Print "<script type=\"text/javascript\" language=\"javascript\">
						function confirmDelete(thisform)
						{
							if (confirm('Are you sure ? You want to Delete this ID ?'))
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
			if(!(isset($_POST['hid']))=="0")
			{		
			$myArray=$_POST['hid'];
				foreach($myArray as $key => $value)
				{	
					$del=mysql_query("DELETE FROM `id_details` WHERE `No`='$value'");
					if($del)
					{
						echo "<script> alert('ID details deleted successfully !!!');</script>";
						echo "<script> setTimeout(function(){ window.location = \"deleteid.php\";}, 0);</script>";
					}
					else
					{
						echo "<script> alert('Please choose the data !!!');</script>";
					}
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
