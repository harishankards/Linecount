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
	if(document.getElementById('user').value==='')
	{
		alert('Please enter a username');
		return false;
	}
	if(document.getElementById('c_pass').value==='')
	{
		alert('Please enter current password');
		return false;
	}
	if(document.getElementById('n_pass').value==='')
	{
		alert('Please enter a new password');
		return false;
	}
	thisform.submit(thisform);
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
	<h2>Change Password</h2>
                    
          		<center>
                <form name="" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      			<table width="500" align="center" cellpadding="15">
                <tr>
                <td>
                	Username
                </td>
                <td>:</td>
                <td>
                	<input type="text" name="user" id="user" size="28" value="">
                </td>
                </tr>
                
                <tr>
                <td>
                	Current Password
                </td>
                <td>:</td>
                <td>
                	<input type="text" name="c_pass" id="c_pass" size="28" value="">
                </td>
                </tr>
                
                <tr>
                <td>
                	New Password
                </td>
                <td>:</td>
                <td>
                	<input type="text" name="n_pass" id="n_pass" size="28" value="">
                </td>
                </tr>
                </table>
                
                <table width="500" align="center" cellpadding="15" style="padding-left:30px;">
                <tr><td><input type="button" value="Change" name="change" onClick="check(this.form)" ></td><td><input type="reset" value="Reset" name="reset"></td></tr>
                </table>
                </form>
                </center>
            <br /><br />
          <?php
			if(isset($_POST['user'],$_POST['c_pass'],$_POST['n_pass']))
			{
				$username=mysql_real_escape_string($_POST['user']);
				$old=mysql_real_escape_string($_POST['c_pass']);
				$new=mysql_real_escape_string($_POST['n_pass']);
				
				$result=mysql_query("UPDATE `admin` SET `password`=SHA('$new') WHERE `password`=SHA('$old') AND `username`='$username'");
				if($result)
				{
					$comment=$loginas." has Changed Password for ".$username;
					$fp = fopen($log_dir.$loginas.".txt", "a+");
					fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
					echo "<script> alert('New Password Updated Successfully');</script>";
				}
				else
				{
					$comment=$loginas." has tried to change Password for ".$username;
					$fp = fopen($log_dir.$loginas.".txt", "a+");
					fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
					echo "<script> alert('Password  not Updated try again');</script>";
				}
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
