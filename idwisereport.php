<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
select{ margin-bottom:0px; width:180px; padding: .2em; text-align:left;}
</style>
<script type="text/javascript">
function check(thisform)
{
	if(thisform.client.value==='-1')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Choose a Client"});
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
        <h2>Uploaded File Details </h2>
        <form name="sub" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table align="center" width="900" cellpadding="1" cellspacing="0">
        	<tr align="center"><td colspan="9" class="result1" align="center" style="text-align:center; font-size:13px;">Choose the Data to See the ID wise Report<br><br></td></tr>
            <tr align="left">
                <td class="bold">From<td>:</td></td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date1'])) { echo $_POST['date1']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">To</td><td>:</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date2'])) { echo $_POST['date2']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold"></td>
                 <td></td>
                 <td> </td>
        	</tr>
            <tr>
            	<td class="bold">Client</td>
                <td>:</td>
                <td>
                <select name="client" id="client" class="text ui-widget-content ui-corner-all">
                    <?
					$client_show='';
					if(isset($_POST['client']))
					{	
						$client_show=$_POST['client'];
						if($client_show!='-1')
						{
							echo "<option selected=\"selected\" value=".$client_show.">".$client_show."</option>";
							echo "<option value=\"-1\">--Select All--</option>";
						}
						else
						{
							echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
						}
					}
					else
					{
						echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
					}
					$sql=mysql_query("select `Client_name` from `client` order by `Client_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $des=$row['Client_name'];
					if($des!=$client_show)
					{
                    	echo '<option value="'.$des.'">'.$des.'</option>';
					}
                    }
                    ?>
            	</select></td>
            	<td class="bold">Platform</td>
                <td>:</td>
                <td>
                    <select name="platform" id="platform" class="text ui-widget-content ui-corner-all">
					<?
					$hos_show='';
					if(isset($_POST['hos']))
					{	
						$hos_show=$_POST['hos'];
						if($hos_show!='-1')
						{
							echo "<option selected=\"selected\" value=\"".$hos_show."\">".$hos_show."</option>";
							echo "<option value=\"-1\">--Show All--</option>";
						}
						else
						{
							echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
						}
					}
					else
					{
						echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
					}
					$sql=mysql_query("select `Platform_name` from `platform` order by `Platform_name`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $hsp=$row['Platform_name'];
					if($hsp!=$hos_show)
					{
						echo '<option value="'.$hsp.'">'.$hsp.'</option>';
					}
                    }
                    ?>
                    
                    </select>
                 </td>
                 <td class="bold">Platform ID</td>
                 <td>:</td>
                 <td> <select name="plat_id" id="plat_id" class="text ui-widget-content ui-corner-all">
                    <?
					$plat_id_show='';
					if(isset($_POST['plat_id']))
					{	
						$plat_id_show=$_POST['plat_id'];
						if($plat_id_show!='-1')
						{
							echo "<option selected=\"selected\" value=".$plat_id_show.">".$plat_id_show."</option>";
							echo "<option value=\"-1\">--Show All--</option>";
						}
						else
						{
							echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
						}
					}
					else
					{
						echo "<option selected=\"selected\" value=\"-1\">--Show All--</option>";
					}
                    $sql=mysql_query("select `username` from `id_details` order by `username` ");
                    while($row=mysql_fetch_array($sql))
                    {
                    $p_id=$row['username'];
					if($plat_id_show!=$p_id)
					{
                    	echo '<option value="'.$p_id.'">'.$p_id.'</option>';
					}
                    }
                    ?>
                    </select>
                </td>
          	</tr>
            <tr align="center">
                <td colspan="9">
                <br>
                <input type="button" name="search"  value="Search" style="height:30px; width:85px;" onClick="check(this.form)" />
                </td>
            </tr>
        </table>    
	</form>
    <br><br>
<?php
$ser='Search Results';
if(isset($_POST['date1'],$_POST['date2'],$_POST['plat_id'],$_POST['platform'],$_POST['client']))
{
	$s_date=$_POST['date1'];
	$e_date=$_POST['date2'];
	$id=$_POST['plat_id'];
	$platform=$_POST['platform'];
	$client=$_POST['client'];
	//echo "ID Wise Line Count details from ".$s_date." to ".$e_date."<br>";
	$a=1;
	$tot_blank_jobs=0;
	$tot_edit_jobs=0;
	$tot_blank=0;
	$tot_edit=0;
	$final_tot=0;
	$file_count=0;
	//For MLS
	
	$query="SELECT `username` FROM `id_details` WHERE `Client`='$client'";
	if($id!='-1')
	{
		$query=$query." AND `username`='$id'";
	}
	if($platform!='-1')
	{
		$query=$query." AND `Platform`='$platform'";
	}
	$sql=mysql_query($query);
	$count=mysql_num_rows($sql);
	if($count!=0)
	{
		echo "<center><p class=\"show\">ID Wise Report From ".$s_date." to ".$e_date."</p>";
		echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"2\" class=\"text ui-widget-content ui-corner-all tab\" align=\"center\" width=\"800\">";
		echo "<th>S.No. </th><th> ID </th><th> No. of Blank Files </th><th> No. of Edit files </th><th> Blank lines </th><th> Edit lines </th><th> Total LineCount </th>";
		$c=0;
		while($row1=mysql_fetch_array($sql))
		{
			$id=$row1['username'];
			$edit=0;
			$edit_job=0;
			$blank=0;
			$blank_job=0;
			$total_lc=0;
			$up_query="SELECT `File_Type`,`Linecount` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Platform_id`='$id'";
			$up_result=mysql_query($up_query);
			$up_count=mysql_num_rows($up_result);
			while($uprow=mysql_fetch_array($up_result))
			{				
				$file_count=$file_count+1;
				if($uprow['File_Type']=="Edit")
				{	
					$edit=$edit+$uprow['Linecount'];
					$edit_job=$edit_job+1;
				}
				if($uprow['File_Type']=="Blank")
				{	
					$blank=$blank+$uprow['Linecount'];
					$blank_job=$blank_job+1;
				}
				$total_lc=$total_lc+$uprow['Linecount'];
			}
			echo "<tr class=\"tr".$c."\"><td> $a </td><td> $id </td><td> $blank_job </td><td> $edit_job </td><td> $blank </td><td> $edit </td><td> $total_lc </td></tr>";
			$a=$a+1;
			if($c==0)
			{
				$c=1;
			}
			else
			{
				$c=0;
			}
			$tot_blank_jobs=$tot_blank_jobs+$blank_job;
			$tot_edit_jobs=$tot_edit_jobs+$edit_job;
			$tot_blank=$tot_blank+$blank;
			$tot_edit=$tot_edit+$edit;
			$final_tot=$final_tot+$total_lc;
		}
		echo "</table><br><br>";
		echo "<table border=\"1\" class=\"text ui-widget-content ui-corner-all tab\" cellspacing=\"0\" cellpadding=\"2\" align=\"center\">";
		echo "<th>Particulars</th><th>Line / Jobs</th>";
		echo "<tr><td>No. of Files </td><td> $file_count</td></tr>";
		echo "<tr><td>No. of Edit Files </td><td> $tot_edit_jobs</td></tr>";
		echo "<tr><td>No. of Blank Fiels </td><td> $tot_blank_jobs</td></tr>";
		echo "<tr><td>No. of Edit Lines </td><td> $tot_edit</td></tr>";
		echo "<tr><td>No. of Blank Lines </td><td> $tot_blank</td></tr>";
		echo "<tr><td>Final No. of Lines </td><td> $final_tot</td></tr></table>";
	}
	else
	{
		echo "<br><br><center><h1>Sorry no Record found !!!</h1></center><br><br>";
	}
	
}
mysql_close($con);
?>
        <br />
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>