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
                    <input type="text" value="<?php if(isset($_POST['serid']))
					{
						echo $_POST['serid'];
					}
					else
					{
					echo "Enter a Employee ID here...";
					}
				?>" name="serid" size="10" id="searchfield" title="searchfield" onFocus="clearText(this)" onBlur="clearText(this)" />
                  	<input type="submit" name="Searchid" value="Search" alt="Search" id="Searchid" title="Search" />
                </form>
                </center>
            </div>
            </td>
            <td>
            <div id="search_drop">
          		<center>
                <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <select name="searchfield1" id="searchfield1" >
                    <option selected="selected" value="-1">--Select Designation--</option>
                    <?php
                    $sql=mysql_query("select `Designation` from `designation` order by `Designation`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $des=$row['Designation'];
                    echo '<option value="'.htmlentities($des).'">'.htmlentities($des).'</option>';
                    }
                    ?>
            </select>&nbsp;&nbsp;
                  	<input type="submit" name="Searchdes" value="Search" alt="Search" id="Searchdes" title="Search" />
                </form>
                	
                </center>
            </div>
            </td>
            </tr>
            </table>
            </center>
            
            
            <br /><br />
          <?php
		  	
			if(isset($_POST['Searchid']))
			{
				$no=mysql_real_escape_string($_POST['serid']);
				$no=strtoupper($no);
				$result=mysql_query("SELECT * FROM `employee` WHERE `Emp_no` LIKE '%$no%'");
			}
			elseif(isset($_POST['Searchdes']))
			{
				$des=mysql_real_escape_string($_POST['searchfield1']);
				$result=mysql_query("SELECT * FROM `employee` WHERE `Emp_desig`='$des'");
			}
			else
			{
				$result=mysql_query("SELECT * FROM `employee` order by `Emp_no`");
			}
			$count=mysql_num_rows($result);
			if($count>0)
			{
				Print "<center><form name=\"contact\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">"; 
				Print "<div style=\"width: 900px; height: 500px; border: 0px groove #3b3a3a; overflow: auto;\">";
				Print "<table border=\"0\" cellpadding=\"3\" width=\"700\"  align=\"center\" class=\"tab\"  bgcolor=\"#dbdedf\">";
				Print "<th>Select</th><th>Vendor</th><th>Employee ID</th><th>Password</th><th>Name</th><th>Designation</th><th>D.O.B</th><th>Address</th><th>Mobile No</th><th>Telephone</th><th>Mail Id</th>";
							
				Print "<tbody>";
				$c=1;
				while($row=mysql_fetch_array($result))
				{	
					Print "<tr class=\"tr".$c."\" align=\"center\" >";
					Print "<td align=\"center\" ><input type=\"checkbox\" name=\"pref[]\" value=\"".htmlentities($row['Emp_no'])."\" onclick=\"highlight_row(this, 'LightBlue');\"></td> "; 
					Print "<td>".htmlentities($row['Vendor']) . "</td> ";
					Print "<td>".htmlentities($row['Emp_no']) . "</td> ";
					Print "<td>".htmlentities($row['password']) . "</td> ";
					Print "<td>".htmlentities($row['Emp_name']) . "</td> ";
					Print "<td> ".htmlentities($row['Emp_desig']) . " </td>";
					Print "<td>".htmlentities($row['Emp_dob']) . "</td> "; 
					Print "<td> ".htmlentities($row['Emp_add']) . " </td>";
					Print "<td> ".htmlentities($row['Emp_phno']) . " </td>";
					Print "<td> ".htmlentities($row['Emp_tel']) . " </td>";
					Print "<td> ".htmlentities($row['Emp_mail']) . " </td>";
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
				Print "<center><input type=\"submit\" name=\"Del\" id=\"Del\" class=\"button\" value=\"Delete\" onclick=\"return confirmDelete(this.form)\"/></center>";
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
						</script>";
			}
			else
			{
				echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
			}
			if(!(isset($_POST['pref']))=="0")
			{		
			$myArray=$_POST['pref'];
				foreach($myArray as $key => $value)
				{	$value=mysql_real_escape_string($value);	
					$del=mysql_query("DELETE FROM `employee` WHERE `Emp_no`='$value'");
					if($del)
					{
						echo "<script> alert('Employee details deleted successfully !!!');</script>";
						echo "<script> setTimeout(function(){ window.location = \"deleteemp.php\";}, 0);</script>";
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
