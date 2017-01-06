<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:160px; padding: .2em; text-align:left; }
select { margin-bottom:0px; width:165px; padding: .2em; text-align:center; }
</style>
<script language="javascript" type="text/javascript">
function check(thisform)
{
	if(document.getElementById('user').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter a Username"});
		return false;
	}
	if(document.getElementById('c_pass').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter current password"});
		return false;
	}
	if(document.getElementById('n_pass').value==='')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please enter a new password"});
		return false;
	}
	if(document.getElementById('vendor').value==='-1')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please select a Team"});
		return false;
	}
	if(document.getElementById('mode').value==='-1')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please select a Mode"});
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
	<h2>Create User</h2>
                    
          		<center>
                <form name="create user" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
      			<table width="400" align="center" cellpadding="2">
                <tr>
                <td class="bold">
                	Username
                </td>
                <td>:</td>
                <td>
                	<input type="text" name="user" id="user" size="28" value="" class="text ui-widget-content ui-corner-all">
                </td>
                </tr>
                
                <tr>
                <td class="bold">
                	Password
                </td>
                <td>:</td>
                <td>
                	<input type="text" name="c_pass" id="c_pass" size="28" value="" class="text ui-widget-content ui-corner-all">
                </td>
                </tr>
                
                <tr>
                <td class="bold">
                	Confirm Password
                </td>
                <td>:</td>
                <td>
                	<input type="text" name="n_pass" id="n_pass" size="28" value="" class="text ui-widget-content ui-corner-all">
                </td>
                </tr>
                <tr>
                <td class="bold">Choose Team</td>
                 <td>:</td>
                 <td>
                     <select name="vendor" id="vendor" class="text ui-widget-content ui-corner-all" >
                        <option selected="selected" value="-1">--Select Team--</option>
                        <?php
                        $sql=mysql_query("select `Vendor_name` from `vendor` order by `Vendor_name`");
                        while($row=mysql_fetch_array($sql))
                        {
                        $vend=$row['Vendor_name'];
                        echo '<option value="'.$vend.'">'.$vend.'</option>';
                        }
                        ?>
                	</select>
                </td>
                </tr>
                <tr>
                <td class="bold">Mode</td>
                <td>:</td>
                <td>
                    <select name="mode" id="mode"  class="text ui-widget-content ui-corner-all">
                    <option selected="selected" value="-1">--Select Mode--</option>
                    <option value="Full Control">Full Control</option>
                    <option value="Monitoring">Monitoring</option>
                    </select>
                 </td>
                </tr>
                <tr><td colspan="1" align="center"><br><input type="button" value="Create" name="change" onClick="check(this.form)" style="height:30px; width:100px;"></td><td colspan="2" align="center"><br><input type="reset" value="Reset" name="reset" style="height:30px; width:100px; margin-left:-50px;"></td></tr>
                </table>
                <table width="500" align="center" cellpadding="15" style="padding-left:30px;">
                
                </table>
                </form>
                	
                </center>
            <br /><br />
          <?php
		  	$r=1;
			if(isset($_POST['user'],$_POST['c_pass'],$_POST['n_pass'],$_POST['vendor'],$_POST['mode']))
			{
				$username=mysql_real_escape_string($_POST['user']);
				$old=mysql_real_escape_string($_POST['c_pass']);
				$new=mysql_real_escape_string($_POST['n_pass']);
				$vend=mysql_real_escape_string($_POST['vendor']);
				$mode=mysql_real_escape_string($_POST['mode']);
				if($old==$new)
				{
					$result=mysql_query("INSERT INTO `admin` VALUES ('$username',SHA('$new'),'$vend','$mode')");
					if($result)
					{
						echo "<script> alert('New user added Successfully');</script>";
					}
					else
					{
						echo "<script> alert('User already exist');</script>";
					}
				}
				else
				{
					echo "<script> alert('Password didnot match');</script>";
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
