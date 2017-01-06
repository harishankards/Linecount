<?php include('monitortop.php');?><style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
select{ margin-bottom:0px; width:180px; padding: .2em; text-align:left; }
</style>
</head>
<body> 
<div id="outer_wrapper">
  <div id="wrapper">
	<?php
    include('header.php');
    if(isset($_SESSION['Vendor_Admin']))
    { 
        include('ak_tecmenu.php');
        $vendor_name=$_SESSION['Vendor_Admin'];
    }
    ?>
<div id="main_top"><center><br><?php echo"<label id=\"welcome_note\">Welcome ".$vendor_name."</label>";?></center></div>
    <div id="main"><br>
        <h2>Uploaded File Details </h2>
        <form name="sub" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <table align="center" width="700" cellpadding="0">
        <tr align="center">
        <td class="bold">Choose the Date to See the uploaded Files</td>
		</tr>
        </table>
        <table align="center" width="700" cellpadding="5">
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
        <tr><td class="bold">Hospital</td>
        <td>:</td>
        <td>
            <select name="hos" id="hos" class="text ui-widget-content ui-corner-all">
           
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
            $sql=mysql_query("select `Hospital_name` from `hospitals` WHERE `Client`='Nuance'order by `Hospital_name` ");
            while($row=mysql_fetch_array($sql))
            {
            $hsp=$row['Hospital_name'];
            if($hsp!=$hos_show)
            {
                echo '<option value="'.$hsp.'">'.$hsp.'</option>';
            }
            }
            ?>
            </select>
         </td>
         <td class="bold">Editor Name</td>
     <td>:</td>
         <td>
        <select name="a_id" id="a_id" class="text ui-widget-content ui-corner-all">
        <?php

		if(isset($_POST['a_id']))
		{	
			$a_id_show=$_POST['a_id'];
			if($a_id_show!='-1')
			{
				echo "<option selected=\"selected\" value=\"$a_id_show\">".$a_id_show."</option>";
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
        $sql=mysql_query("select `Emp_no`,`Emp_name` from `employee` WHERE `Emp_desig`='Editor' OR `Emp_desig`='HT-EDITOR' order by `Emp_name`");
        while($row=mysql_fetch_array($sql))
        {
        $id=$row['Emp_no'];
        $name=$row['Emp_name'];
        echo '<option value="'.$id.'">'.$name." - [".$id."]".'</option>';
        }
        ?>
        </select>
        </td>
        </tr>
        <tr>
        <td colspan="6" align="center">
        <input type="submit" name="search" value="Search">
        </td>
        </tr>
        </table>
        
       </form>
		<div id="show_admin_detail">
<?php
$c=1;
$lc=0;
$r=0;
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

	$query="SELECT `Date`,`Hospital`,`File_No`,`File_type`,`Linecount`,`MT`,`Pending_Reason`,`QC` FROM `escript_filedetails` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Pending_Reason`!='Direct Submission'";
	$ser="Search results ";
	
	if($id!=-1)//if id is set
	{
		$query=$query." AND `Editedby`='$id'";
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
	echo "<center><table><tr><td class=\"result1\">Details of files uploaded by the Editors on ".$dat."</td></tr></table></center><br>";
	$query="SELECT `Date`,`Hospital`,`File_No`,`File_Type`,`Linecount`,`Uploadedby`,`Editedby` FROM `escript_filedetails`  WHERE `Date` ='$dat' AND `Editedby`!='Not Edited Yet'";
	$result=mysql_query("$query");
	$ser="Search results ";
	$sendquery=$query;
}
if($result)
{
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		echo "<table align=\"center\">
		<tr align=\"center\">
        <td>
        <input type=\"checkbox\" value=\"show\" id=\"check\" name=\"check\"  onClick=\"call()\" >Show Linecount Only
        </td>
        </tr></table>";
		echo "<center><label class=\"result\"><u>".$ser."</u></label></b><br><br>";
		if($count<20)
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 350px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		else
		{
			echo "<div id=\"detail\" style=\"width:900px; height: 600px; border: 0px groove #3b3a3a; overflow: auto;\">";
		}
		echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"880\" align=\"center\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"font-size: 11px;\">";
		echo "<tr class=\"ui-widget-header\"><th>S.No.</th><th>Date</th><th>Hospital</th><th>File No</th><th>File Type</th><th>LineCount</th><th>Uploaded By</th><th>Edited By</th></tr>";
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".$c."</td>";
			echo "<td style=\"width:80px;\">".$row['Date']."</td>";
			echo "<td>".$row['Hospital']."</td>";
			echo "<td>".$row['File_No']."</td>";
			echo "<td style=\"width:80px;\">".$row['File_type']."</td>";
			echo "<td>".$row['Linecount']."</td>";
			$lc=$lc+$row['Linecount'];
			echo "<td style=\"width:300px;\">".$row['MT']."</td>";
			echo "<td style=\"width:300px;\">".$row['QC']."</td>";
			//echo "<td>".$row['File_location']."</td>";
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
		echo "<tr class=\"result1\"><td>Total No. Of.File</td><td>:</td><td>".$count."</td></tr><br>";
		echo "<tr class=\"result1\"><td>Total No. Of.Lines</td><td>:</td><td>".$lc."</td></tr>";
		echo "</table></center>";
		echo "<br><center><strong>***The output of the Excel is based on your selection Criteria***</strong></center>";
		Print "<br><br><center><form name=\"xl\" method=\"post\" action=\"monitor-report.php\">";
		Print "<input type=\"hidden\" Value=\"$sendquery\" name=\"mls_query\" id=\"query\" />";
		Print "<input type=\"hidden\" Value=\"Edited File Details\" name=\"rep_name\" id=\"name\" />";
		Print "<input type=\"submit\" value=\"Get Edited File details as Excel\" name=\"Filedetails\"/>";
		Print "</form></center></td></tr></table>";
	}
	else
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
	}
}
?>
		</div>
        <br />
        <div class="cleaner"></div>
        <div class="cleaner"></div>
    </div> <!-- end of main -->
	<div id="main_bottom"></div>
    <?php include('footer.php');?>
</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
</html>