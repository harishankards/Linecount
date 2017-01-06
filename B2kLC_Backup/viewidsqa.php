<?php include('top.php');?>
<script type="text/javascript" language="javascript">
function checkids(thisform)
{	
	if(document.getElementById('idsqa').value==='-1')
	{
		dhtmlx.alert({title:"Warning!!!", text:"Please Choose a type"});
		return false;
	}
	thisform.submit();
}
</script>
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
    <div id="main"><br>
        <h2>Uploaded File Details </h2>
        <form name="sub" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table align="center" width="500" cellpadding="0">
        	<tr align="center">
        		<td class="tdcolor">Choose the Date to See the uploaded Files</td>
			</tr>
        </table>
        
        <table align="center" width="700" cellpadding="2">
            <tr align="left">
                <td class="bold">From<td>:</td></td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date1'])) { echo $_POST['date1']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/>
                </td>
                <td class="bold">To</td><td>:</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date2'])) { echo $_POST['date2']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/>
                </td>
                <td class="bold">Hospital</td>
                <td>:</td>
                <td>
                    <select name="hos" id="hos" class="text ui-widget-content ui-corner-all"  >
                    <option selected="selected" value="-1">--Select Hospital--</option>
                    <?php
                    $sql=mysql_query("select `Hospital_name` from `hospitals` order by `Hospital_name` ");
                    while($row=mysql_fetch_array($sql))
                    {
                    $hsp=$row['Hospital_name'];
                    echo '<option value="'.$hsp.'">'.$hsp.'</option>';
                    }
                    ?>
                    </select>
                 </td> 
        	</tr>
            
        	<tr>
            	<td class="bold">Type</td>
                <td>:</td>
                <td>
                    <select name="idsqa" id="idsqa" class="text ui-widget-content ui-corner-all"  >
                    <option selected="selected" value="-1">--Select Type--</option>
                    <option value="IDS/QA_Checkpoint">IDS/QA_Checkpoint</option>
                    <option value="Third_Level">Third Level</option>
                    </select>
                 </td>
                 
                 <td class="bold" >Editor Name</td>
                 <td>:</td>
                 <td colspan="4">
                    <select name="a_id" id="a_id" class="text ui-widget-content ui-corner-all"  >
                    <option selected="selected" value="-1">--Select Name--</option>
                    <?php
                    $sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='Editor' OR `Emp_desig`='HT-EDITOR' order by `Emp_no`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $id=$row['Emp_no'];
                    $name=$row['Emp_name'];
                    echo '<option value="'.$id.'">'.$name."--[".$id."]".'</option>';
                    }
                    ?>
                    </select>
        		</td>
          	</tr>
            <tr align="center">
                <td colspan="9">
                 <input type="button" name="search" id="search" value="Search" style="height:30px; width:75px;" onClick="checkids(this.form)" >
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

if(isset($_POST['date1'],$_POST['date2'],$_POST['a_id'],$_POST['hos'],$_POST['idsqa']))
{
	$s_date=$_POST['date1'];
	$e_date=$_POST['date2'];
	$id=$_POST['a_id'];
	$hos=$_POST['hos'];
	$idsqa=$_POST['idsqa'];
	
	$query="SELECT `Date`,`Hospital`,`File_No`,`File_Type`,`Linecount`,`Uploadedby`,`Editedby`,`Third_Editor`,`Upload_to` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date'";
	$ser="Search results ";
	
	if($id!=-1)
	{
		$id=getname($id);
	}
	
	if($id!=-1)
	{
		$query=$query." AND `Third_Editor`='$id'";
		$ser=$ser." for ".$id;
	}
	
	if($hos!=-1)
	{
		$query=$query." AND `Hospital`='$hos'";
		$ser=$ser." in ".$hos;
	}
	
	if($idsqa=="IDS/QA_Checkpoint")
	{
		$query=$query." AND `Upload_to`='$idsqa'";
	}
	if($idsqa=="Third_Level")
	{
		$query=$query." AND `Third_level`='YES'";
	}
	
$result=mysql_query($query);

if($result)
{	
	echo "<center><label class=\"result1\"><u>".$ser." for ".$idsqa." files</u></label></b><br><br>";
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		echo "<table align=\"center\"><tr align=\"center\">
                <td>
                <input type=\"checkbox\" value=\"show\" id=\"check\" name=\"check\"  onClick=\"call()\" >Show Linecount Only 
                </td>
            </tr></table>";
		if($count<20)
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 500px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		else
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 800px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		
		echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\">";
		echo "<th>S.No.</th><th>Date</th><th>Hospital</th><th>File No</th><th>LineCount</th><th>Uploaded By</th><th>Edited By</th><th>III - Level Editor</th><th>Uploaded To</th>";
		
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".$c."</td>";
			echo "<td>".$row['Date']."</td>";
			echo "<td>".$row['Hospital']."</td>";
			echo "<td>".$row['File_No']."</td>";
			//echo "<td>".$row['File_Type']."</td>";
			if($row['File_Type']=="Edit")
			{	
				$editlines=$editlines+$row['Linecount'];
			}
			if($row['File_Type']=="Blank")
			{	
				$blanklines=$blanklines+$row['Linecount'];
			}
			echo "<td>".$row['Linecount']."</td>";
			
			$lc=$lc+$row['Linecount'];
			
			echo "<td style=\"width:300px;\">".$row['Uploadedby']."</td>";
			echo "<td style=\"width:300px;\">".$row['Editedby']."</td>";
			echo "<td style=\"width:300px;\">".$row['Third_Editor']."</td>";
			echo "<td style=\"width:300px;\">".$row['Upload_to']."</td>";
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
		echo "<table>";
		echo "<tr class=\"result1\"><td>Total No. of. File</td><td>:</td><td>".$count."</td></tr><br>";
		echo "<tr class=\"result1\"><td>Total No. of. Edit lines</td><td>:</td><td>".$editlines."</td></tr>";
		echo "<tr class=\"result1\"><td>Total No. of. Blank lines</td><td>:</td><td>".$blanklines."</td></tr>";
		echo "<tr class=\"result1\"><td>Total No. of. lines</td><td>:</td><td>".$lc."</td></tr>";
		echo "</table></center>";
	}
	else
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
	
	}
}
}
echo "<br><br>";

?>
        <br />
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
