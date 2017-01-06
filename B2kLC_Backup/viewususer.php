<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
select{ margin-bottom:0px; width:180px; padding: .2em; text-align:left;}
</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
	include('main_top.php');
	?>
    <div id="main">
        <h2>US User ID Details </h2>
        <div id="file_box">
          		<center>
                <form name="file_ser" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <input type="text" value="Enter a ID to search" name="login_id" size="10" id="searchfield" title="searchfield" onFocus="clearText(this)" onBlur="clearText(this)" />
                  	<input type="submit" name="Searchid" value="Search" alt="Search" id="Searchid" title="Search" onClick="show();" />
                </form>
                </center>
            </div><br>
        <form name="sub" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table align="center" width="900" cellpadding="1" cellspacing="0" style="padding-left:20px;">
        	 
            <tr align="left">
                <td class="bold">Branch<td>:</td></td>
                <td>
                  <select name="branch" id="branch" class='ui-widget ui-widget-content ui-corner-all'>
                  <option value='-1'>--Select--</option>
                  <?php
				  $b_sql=mysql_query("SELECT `Inhouse_HT_Branch` FROM `ususer_details` GROUP BY `Inhouse_HT_Branch` ORDER BY `Inhouse_HT_Branch`");
				  $b_count=mysql_num_rows($b_sql);
				  if($b_count!=0)
				  {
				  		while($b_row=mysql_fetch_array($b_sql))
						{
							echo "<option value='".$b_row['Inhouse_HT_Branch']."'>".$b_row['Inhouse_HT_Branch']."</option>";
						}
				  }
                  ?></select>                </td>
                <td class="bold">Account</td><td>:</td>
                <td>
                 <select name="account" id="account" class='ui-widget ui-widget-content ui-corner-all'>
                  <option value='-1'>--Select--</option>
                  <?php
				  $b_sql=mysql_query("SELECT `Account` FROM `ususer_details` GROUP BY `Account` ORDER BY `Account`");
				  $b_count=mysql_num_rows($b_sql);
				  if($b_count!=0)
				  {
				  		while($b_row=mysql_fetch_array($b_sql))
						{
							echo "<option value='".$b_row['Account']."'>".$b_row['Account']."</option>";
						}
				  }
                  ?></select>
                </td> 
                <td class="bold">Platform</td>
                 <td>:</td>
                 <td>
                 <select name="platform" id="platform" class='ui-widget ui-widget-content ui-corner-all'>
                  <option value='-1'>--Select--</option>
                  <?php
				  $b_sql=mysql_query("SELECT `Platform` FROM `ususer_details` GROUP BY `Platform` ORDER BY `Platform`");
				  $b_count=mysql_num_rows($b_sql);
				  if($b_count!=0)
				  {
				  		while($b_row=mysql_fetch_array($b_sql))
						{
							echo "<option value='".$b_row['Platform']."'>".$b_row['Platform']."</option>";
						}
				  }
                  ?></select>
                 </td> 
        	</tr>
            
        	<tr>
            	<td class="bold">DSP / Non DSP</td>
                <td>:</td>
                <td>
                <select name="ndsp" id="ndsp" class="text ui-widget-content ui-corner-all">
                <option value='-1'>--Select--</option>
                  <?php
				  $b_sql=mysql_query("SELECT `DSP/NONDSP` FROM `ususer_details` GROUP BY `DSP/NONDSP` ORDER BY `DSP/NONDSP`");
				  $b_count=mysql_num_rows($b_sql);
				  if($b_count!=0)
				  {
				  		while($b_row=mysql_fetch_array($b_sql))
						{
							echo "<option value='".$b_row['DSP/NONDSP']."'>".$b_row['DSP/NONDSP']."</option>";
						}
				  }
                  ?>    
            	</select></td>
            	<td class="bold">Assigned to</td>
                <td>:</td>
                <td>
                    <select name="assigned" id="assigned" class="text ui-widget-content ui-corner-all">
					<option value='-1'>--Select--</option>
					<?php
				  $b_sql=mysql_query("SELECT `Assigned_User` FROM `ususer_details` GROUP BY `Assigned_User` ORDER BY `Assigned_User`");
				  $b_count=mysql_num_rows($b_sql);
				  if($b_count!=0)
				  {
				  		while($b_row=mysql_fetch_array($b_sql))
						{
							echo "<option value='".$b_row['Assigned_User']."'>".$b_row['Assigned_User']."</option>";
						}
				  }
                  ?>
                    </select>
                 </td>
                 <td class="bold">ID Status</td>
                 <td>:</td>
                 <td> 
                 	<select name="status" id="status" class="text ui-widget-content ui-corner-all">
                    <option value='-1'>--Select--</option>
					<?php
				  $b_sql=mysql_query("SELECT `ID_Status` FROM `ususer_details` GROUP BY `ID_Status` ORDER BY `ID_Status`");
				  $b_count=mysql_num_rows($b_sql);
				  if($b_count!=0)
				  {
				  		while($b_row=mysql_fetch_array($b_sql))
						{
							echo "<option value='".$b_row['ID_Status']."'>".$b_row['ID_Status']."</option>";
						}
				  }
                  ?>
                    
                    </select>
                </td>
          	</tr>
            <tr align="center">
                <td colspan="9">
                <br><input type="submit" name="search"  value="Search" onClick="show()" style="height:30px; width:100px;"/>
                </td>
            </tr>
        </table>        
	</form>
<?php
$c=1;
$lc=0;
$r=0;
$editlines=0;
$blanklines=0;
$query='';
$ser='Search Results';
if(isset($_POST['login_id']))
{
	$login_id=mysql_real_escape_string($_POST['login_id']);
	$result=mysql_query("SELECT * FROM `ususer_details` WHERE `Login_Id` LIKE '%$login_id%'");
	$ser="Search Results for User ID ".$login_id;
}
elseif(isset($_POST['branch'],$_POST['account'],$_POST['platform'],$_POST['assigned'],$_POST['status']))
{
	$branch=mysql_real_escape_string($_POST['branch']);
	$account=mysql_real_escape_string($_POST['account']);
	$platform=mysql_real_escape_string($_POST['platform']);
	$assigned_to=mysql_real_escape_string($_POST['assigned']);
	$dsp=mysql_real_escape_string($_POST['ndsp']);
	$status=mysql_real_escape_string($_POST['status']);
	
	$query="SELECT * FROM `ususer_details` WHERE ('1'='1')";
	if($branch!=-1)
	{
		$branch=$branch;
		$query=$query." AND `Inhouse_HT_Branch`='$branch'";
		$ser="Search Results for ".$branch;
	}
	
	if($account!=-1)//if hospital is set
	{
		$query=$query." AND `Account`='$account'";
		$ser="Search Results for ".$account;
	}
	
	if($platform!=-1)//if file type is set
	{
		$query=$query." AND `Platform`='$platform'";
		$ser="Search Results for ".$platform;
	}
	
	if($assigned_to!=-1)//if file type is set
	{
		$query=$query." AND `Assigned_User`='$assigned_to'";
		$ser="Search Results for ".$assigned_to;
	}
	if($dsp!=-1)//if file type is set
	{
		$query=$query." AND `DSP/NONDSP`='$dsp'";
		$ser="Search Results for ".$dsp;
	}
	
	if($status!=-1)//if file type is set
	{
		$query=$query." AND `ID_Status`='$status'";
		$ser="Search Results for ".$status;
	}
	
	$result=mysql_query($query);
}

else
{	
	$dat=date('Y-m-d');
	echo "<center><table><tr><td class=\"result1\">Details of US User Details</td></tr></table></center>";
	$query="SELECT * FROM `ususer_details`";
	$result=mysql_query($query);
	
	$ser='';
}
$sendquery=$query;

if($result)
{	
	echo "<center><label class=\"result1\">".$ser."</label></b><br>";
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		echo "<table><tr align=\"center\">
                <td>
                <input type=\"checkbox\" value=\"show\" id=\"check\" name=\"check\"  onClick=\"call()\" >Show Linecount Only 
                </td>
            </tr></table>";
		//echo "<form name=\"file_delete\" method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">"; 
		if($count<20)
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 300px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		else
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 400px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		
		echo "<table border=\"1\" cellpadding=\"2\"  cellspacing=\"0\" width=\"100%\" align=\"center\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\">";
		echo "<tr class=\"ui-widget-header\"><th>Options<th>S.No.</th><th>HR Id</th><th>Name as Per HRMS</th><th>Login ID</th><th>Password</th><th>MT or QC</th><th>Fiesa ID</th><th>Fiesa Password</th><th>MAR Id</th><th>MAR Password</th><th>Assigned User</th><th>Assigned Date</th><th>Platform</th><th>Account</th><th>DSP / Non DSP</th><th>In House / HT / Branch</th><th>ID Status</th></tr>";
		
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td align=\"center\">
			<table><tr><td style=\"border:0px;\"><img src=\"menu/notes.png\" title=\"Edit file details\" height=\"20\" width=\"20\"  style=\"cursor:pointer;\" onclick=\"\"></td><td style=\"border:0px;\"><img src=\"menu/button-cross_sticker.png\" height=\"20\" width=\"20\" title=\"Delete file details\" style=\"cursor:pointer;\" onclick=\"deletefile('".$row['S.No']."');\"></td></tr></table>
			</td> "; 
			echo "<td>".htmlentities($c)."</td>";
			echo "<td>".htmlentities($row['HR_ID'])."</td>";
			echo "<td>".htmlentities($row['Name_As_Per_HRMS'])."</td>";
			echo "<td>".htmlentities($row['Login_Id'])."</td>";
			echo "<td>".htmlentities($row['Password'])."</td>";
			echo "<td>".htmlentities($row['MT_QC'])."</td>";
			echo "<td>".htmlentities($row['Fiesa_ID'])."</td>";
			echo "<td>".htmlentities($row['Fiesa_Password'])."</td>";
			echo "<td>".htmlentities($row['MAR_ID'])."</td>";
			echo "<td>".htmlentities($row['MAR_Password'])."</td>";
			echo "<td>".htmlentities($row['Assigned_User'])."</td>";
			echo "<td>".htmlentities($row['Assigned_date'])."</td>";
			echo "<td>".htmlentities($row['Platform'])."</td>";
			echo "<td>".htmlentities($row['Account'])."</td>";
			echo "<td>".htmlentities($row['DSP/NONDSP'])."</td>";
			echo "<td>".htmlentities($row['Inhouse_HT_Branch'])."</td>";
			echo "<td>".htmlentities($row['ID_Status'])."</td>";
			echo "</tr>";
			
			$c=$c+1;
			
			if($r==0)
			{
				$r=1;
			}
			else
			{
				$r=0;
			}
		}
		echo "</table></div>";
		echo "<script type=\"text/javascript\" language=\"javascript\">
				function update(file_no)
				{
					var fno=file_no;
					if (confirm('Are you sure ? You want to update this '+fno+'?'))
					{
						window.location = \"viewususer.php?fno=\"+fno;
					}
					else
					{
						return false;
					}
				}
				function deletefile(file_no)
				{
					var fno=file_no;
					if (confirm('Are you sure ? You want to delete this '+fno+'?'))
					{
						window.location = \"viewususer.php?file_no_del=\"+fno;
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
		echo "<br /><h1><center>Sorry No Record Found !!!</center></h1><br />";
	
	}
}
?>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
    <?php
	if(isset($_GET['file_no_del']))
	{		
		$value=$_GET['file_no_del'];
		$del=mysql_query("DELETE FROM `ususer_details`  WHERE `S.No`='$value'");
		if($del)
		{
			$comment=$loginas." has Deleted the details of the ID ".$value.".";
			$fp = fopen($log_dir.$loginas.".txt", "a+");
			fwrite($fp, PHP_EOL ."[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
			fclose($fp);
			echo "<script> dhtmlx.alert({
					title:\"Success !!!\",
					ok:\"Ok\",
					text:\"Details of the File ".$value."  is deleted successfully !!!\",
					callback:function(){
					setTimeout(function(){ window.location = \"viewususer.php\";}, 0);
					}
				});
				</script>";
			
		}
	}
	?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>