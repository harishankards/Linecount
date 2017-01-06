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
    <div id="main"><br>
        <h2>Uploaded File Details </h2>
        <form name="sub" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table align="center" width="500" cellpadding="0">
        	<tr align="center">
        		<td class="tdcolor">Choose the Date to See the audited files</td>
			</tr>
        </table>
        
        <table align="center" width="700" cellpadding="2">
            <tr align="left">
                <td class="bold">From<td>:</td></td>
                <td>
                  <input type="text" id="from" name="date1" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date1'])) { echo $_POST['date1']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td>
                <td class="bold">To</td><td>:</td>
                <td>
                 <input type="text" id="to" name="date2" class="text ui-widget-content ui-corner-all" value="<?php if(isset($_POST['date2'])) { echo $_POST['date2']; } else { echo date('Y-m-d'); }?>" style="cursor:pointer;" autocomplete="off" readonly/> ( YYYY-MM-DD )
                </td> 
        	</tr>
            
        	<tr>
            	<td class="bold">Hospital</td>
                <td>:</td>
                <td>
                    <select name="hos" id="hos"  class="text ui-widget-content ui-corner-all" >
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
                 <td class="bold">Editor Name</td>
                 <td>:</td>
                 <td>
                    <select name="a_id" id="a_id"  class="text ui-widget-content ui-corner-all">
                    <option selected="selected" value="-1">--Select Name--</option>
                    <?php
                    $sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='Editor' OR `Emp_desig`='HT-EDITOR' order by `Emp_no`");
                    while($row=mysql_fetch_array($sql))
                    {
                    $id=$row['Emp_no'];
                    $name=$row['Emp_name'];
                    echo '<option value="'.$id.'">'.$name." [".$id."]".'</option>';
                    }
                    ?>
                    </select>
        		</td>
          	</tr>
            
        </table>
        
        <table align="center" width="500" cellpadding="5">
           
            
            <tr align="center">
                <td>
                <a><input type="submit" name="search" id="search"  value="Search" style="height:30px; width:75px;"></a>
                </td>
            </tr>
        </table>
	</form>
<?php
$c=1;
$lc=0;
$r=0;
$ser='';
if(isset($_POST['date1'],$_POST['date2'],$_POST['a_id'],$_POST['hos']))
{
	$s_date=$_POST['date1'];
	$e_date=$_POST['date2'];
	$id=$_POST['a_id'];
	$hos=$_POST['hos'];
	
	if($id!=-1)
	{
		$id=getname($id);
	}
	
	$query="SELECT * FROM `audit_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date'";
	$ser="Search results ";
	
	if($id!=-1)//if id is set
	{
		$query=$query." AND `Audit_by`='$id'";
		$ser=$ser." for ".$id;
	}
	
	if($hos!=-1)//if hospital is set
	{
		$query=$query." AND `Hospital`='$hos'";
		$ser=$ser." in ".$hos;
	}
	$sendquery=$query;
	$result=mysql_query($query);
}

else
{	
	$dat=date('Y-m-d');
	echo "<center><table><tr><td class=\"result1\">Details of files audited by the editors on ".$dat."</td></tr></table></center><br>";
	$query="SELECT * FROM `audit_files`  WHERE `Date` ='$dat'";
	$result=mysql_query($query);
}


if($result)
{	
	echo "<center><label class=\"result\"><u>".$ser." audited files</u></label></b><br><br>";
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
			echo "<div id=\"detail\" style=\"width:900px; height: 400px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		else
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 600px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		
		echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"800\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\">";
		echo "<th>Options</th><th>Date</th><th>Client</th><th>Hospital</th><th>File No</th><th>LineCount</th><th>Audited by</th>";
		
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td align=\"center\">
				<table><tr><td style=\"border:0px;\"><img src=\"menu/notes.png\" title=\"Edit file details\" height=\"20\" width=\"20\"  style=\"cursor:pointer;\" onclick=\"update('".$row['File_no']."');\"></td><td style=\"border:0px;\"><img src=\"menu/button-cross_sticker.png\" height=\"20\" width=\"20\" title=\"Delete file details\" style=\"cursor:pointer;\" onclick=\"deletefile('".$row['File_no']."');\"></td></tr></table>
				</td> ";
			echo "<td>".$row['Date']."</td>";
			echo "<td>".$row['Client']."</td>";
			echo "<td>".$row['Hospital']."</td>";
			echo "<td>".$row['File_no']."</td>";
			echo "<td>".$row['Linecount']."</td>";
			$lc=$lc+$row['Linecount'];
			echo "<td>".$row['Audit_by']."</td>";
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
		echo "<script type=\"text/javascript\" language=\"javascript\">
				function update(file_no)
				{
					var fno=file_no;
					if (confirm('Are you sure ? You want to update this '+fno+'?'))
					{
						window.location = \"auditupdate.php?fno=\"+fno;
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
						window.location = \"viewauditfile.php?file_no_del=\"+fno;
					}
					else
					{
						return false;
					}
				}
				</script>";
		echo "<tr class=\"result1\"><td>Total No. Of.File</td><td>:</td><td>".$count."</td></tr><br>";
		echo "<tr class=\"result1\"><td>Total No. Of.Lines</td><td>:</td><td>".$lc."</td></tr>";
		echo "</table></center>";
		echo "<br><center><strong>***The output of the Excel is based on your selection Criteria***</strong></center>";
		Print "<br><br><center><form name=\"xl\" method=\"post\" action=\"toexcel.php\">";
		Print "<input type=\"hidden\" Value=\"$sendquery\" name=\"query\" id=\"query\" />";
		Print "<input type=\"hidden\" Value=\"Audit File Details\" name=\"rep_name\" id=\"name\" />";
		Print "<input type=\"submit\" value=\"Get Audit details as Excel\" name=\"Filedetails\"/>";
		Print "</form></center></td></tr></table>";
	}
	else
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
	
	}
}

if(isset($_GET['file_no_del']))
{		
	$value=$_GET['file_no_del'];
	$del=mysql_query("DELETE FROM `audit_files`  WHERE `File_No`='$value'");
	$del_shared=mysql_query("DELETE FROM `shared_files`  WHERE `File_no`='$value'");
	if($del)
	{
		echo "<script> alert('Details of the File ".$value."  is deleted successfully !!!');</script>";
		echo "<script> window.location = \"viewupload.php\";</script>";
		
	}

}

?>

        <br />
        <br />
        <br />
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
