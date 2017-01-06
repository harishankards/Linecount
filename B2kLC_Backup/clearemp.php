<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
function check(thisform)
{
	if(thisform.e_clnt.value==='Add Client')
    {
      alert("Please Enter a Valid Client");
      return false;
    }
	thisform.submit();
}
function checkdes(thisform)
{
	if(thisform.searchfield1.value==="-1")
    {
      alert("Please Enter a Valid Client");
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
          <div id="main">
          <br>
          <center><h2>Select an Employee to delete their entries</h2></center>
          <div id="search_drop" style="margin-left:315px;">
          		<center>
               
                <form name="addclient" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <select name="searchfield1" id="searchfield1" >
                    <option selected="selected" value="-1">--Select Client--</option>
                    <?php
                    $sql=mysql_query("select * from `employee` order by `Emp_no`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $id=$row['Emp_no'];
					$name=$row['Emp_name'];
                    echo '<option value="'.htmlentities($id).'">'.htmlentities($name).'</option>';
                    }
                    ?>
            </select>&nbsp;&nbsp;
                  	<input type="button" name="Searchdes" value="Delete" alt="Search" id="Searchdes" title="Search" onClick="checkdes(this.form)" />
                </form>
                </center>
            </div>
			<br />
			<br />
			<br />
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    
   	<?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php

if(isset($_POST['searchfield1']))
{	
	$client=mysql_real_escape_string($_POST['searchfield1']);
	$result=mysql_query("DELETE FROM `file_details` WHERE `up`='$client'");
	if($result)
	{
		echo "<script> alert('Client details Deleted Successfully');</script>";
		echo "<script> setTimeout(function(){ window.location = \"addclient.php\";}, 0);</script>";
	}
}
mysql_close($con);
?>
</body>
<script src="js/element.js"></script>
</html>
