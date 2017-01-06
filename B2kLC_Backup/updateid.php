<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}
function check(thisform)
{
	if(thisform.e_hsp.value==='Add Hospital')
    {
      alert("Please Enter a Valid Hospital");
      return false;
    }

	if(thisform.e_clnt.value==="-1")
    {
      alert("Choose a valid Client");
      return false;
    }
	if(thisform.e_plt.value==="-1")
    {
      alert("Choose a valid Platform");
      return false;
    }
	thisform.submit();
}
function checkdes(thisform)
{
	if(thisform.searchfield1.value==="-1")
    {
      alert("Choose a Valid Platform");
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
          <form name="empdata" action="#" method="post">
          <?php
          	$no=$_GET['no'];
			$result=mysql_query("SELECT * FROM `id_details` WHERE `No`='$no'");
			while($row=mysql_fetch_array($result))
			{

			?>
            <input type="hidden" name="e_no" id="e_no" size="28" Value="<?php echo $row['No'];?>" />
          <center><h2>Enter the ID Details</h2></center>
          <table cellpadding="5" align="center" cellspacing="20">
          
          	<tr>
                <td>Username</td>
                <td>:</td>
                <td><input type="text" name="e_name" id="e_name" size="28" Value="<?php echo $row['username'];?>" /></td>
            </tr>
            
            <tr>
                <td>Password</td>
                <td>:</td>
                <td><input type="text" name="e_pass" id="e_pass" size="28" Value="<?php echo $row['password'];?>" /></td>
            </tr>
            
            <tr>
                <td>Choose a Client</td>
                <td>:</td>
                <td>
                    <select name="e_clnt" id="e_clnt" >
                    <option selected="selected" value="<?php echo $row['Client'];?>"><?php echo $row['Client'];?></option>
                    <?php
                    $sql=mysql_query("select `Client_name` from `client` order by `Client_name`");
                    while($row1=mysql_fetch_array($sql))
                    {
                    $clnt=$row1['Client_name'];
                    echo '<option value="'.$clnt.'">'.$clnt.'</option>';
                    }
                    ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Choose a Platform</td>
                <td>:</td>
                <td>
                    <select name="e_plt" id="e_plt" >
                    <option selected="selected" value="<?php echo $row['Platform'];?>"><?php echo $row['Platform'];?>-</option>
                    <?php
                    $sql=mysql_query("select `Platform_name` from `platform` order by `Platform_name`");
                    while($row2=mysql_fetch_array($sql))
                    {
                    $plat=$row2['Platform_name'];
                    echo '<option value="'.$plat.'">'.$plat.'</option>';
                    }
                    ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Choose a Hospital</td>
                <td>:</td>
                <td>
                    <select name="e_hsp" id="e_hsp" >
                    <option selected="selected" value="<?php echo $row['Hospital'];?>"><?php echo $row['Hospital'];?></option>
                    <?php
                    $sql=mysql_query("select `Hospital_name` from `hospitals` order by `Hospital_name`");
                    while($row3=mysql_fetch_array($sql))
                    {
                    $hsp=$row3['Hospital_name'];
                    echo '<option value="'.$hsp.'">'.$hsp.'</option>';
                    }
                    ?>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Working Status</td>
                <td>:</td>
                <td>
                    <select name="e_wrk" id="e_wrk" >
                    <option selected="selected" value="<?php echo $row['Working_status'];?>"><?php echo $row['Working_status'];?></option>
                    <option value="Working">Working</option>
                    <option value="Not Working">Not Working</option>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td>Alloted to</td>
                <td>:</td>
                <td><input type="text" name="e_altd" id="e_altd" size="28" Value="<?php echo $row['Alloted_to'];?>" /></td>
            </tr>
            
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
          <tr><td><input type="button" value="Submit" name="sub" onClick="check(this.form)"/></td></tr>
          </table>
          </form>
         <?php
		 }
		 ?>
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

if(isset($_POST['e_plt'],$_POST['e_clnt'],$_POST['e_hsp'],$_POST['e_name'],$_POST['e_pass'],$_POST['e_wrk']))
{
	$no=$_POST['e_no'];
	$name=strtoupper($_POST['e_name']);
	$pass=$_POST['e_pass'];
	$hos=$_POST['e_hsp'];
	$plat=$_POST['e_plt'];
	$clnt=$_POST['e_clnt'];
	$wrk=$_POST['e_wrk'];
	if(!($_POST['e_altd']==''))
	{
		$alloted_to=$_POST['e_altd'];
	}
	else
	{
		$alloted_to='Not alloted';
	}
	$sql=mysql_query("UPDATE `id_details` SET `Client`='$clnt',`Platform`='$plat',`Hospital`='$hos',`username`='$name',`password`='$pass',`Working_status`='$wrk',`Alloted_to`='$alloted_to' WHERE `No`='$no'");
	if($sql)
	{
		echo "<script> alert('ID Details updated Successfully');</script>";
		echo "<script> setTimeout(function(){ window.location = \"viewid.php\";}, 0);</script>";
	}
	else
	{
		echo "<script> alert('ID Details not update please try again later');</script>";
		echo "<script> setTimeout(function(){ window.location = \"viewid.php\";}, 0);</script>";
	}
	
}
?>
</body>
<script src="js/element.js"></script>
</html>
