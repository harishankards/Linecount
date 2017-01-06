<?php include('top.php');?>
<style>
input.text { margin-bottom:0px; width:75px; padding: .2em; text-align:center; }
select{ margin-bottom:0px; width:180px; padding: .2em; text-align:left; }
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
            $sql=mysql_query("select `Hospital_name` from `hospitals` order by `Hospital_name` ");
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

	$query="SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Uploadedby`,`Editedby` FROM `file_details` WHERE `Date` BETWEEN '$s_date' AND '$e_date' AND `Editedby`!='Not yet Edited'";
	$ser="Search results ";
	
	$missing_query="SELECT `Date`,`Hospital`,`File_no`,`Linecount`,`Edit_by` FROM `missing_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date'";
	
	$audit_query="SELECT `Date`,`Hospital`,`File_no`,`Linecount`,`Audit_by` FROM `audit_files` WHERE `Date` BETWEEN '$s_date' AND '$e_date'";
	if($id!=-1)//if id is set
	{
		$query=$query." AND `Editedby`='$id'";
		$missing_query=$missing_query."AND `Edit_by`='$id'";
		$audit_query=$audit_query."AND `Audit_by`='$id'";
		$ser=$ser." for ".$id;
	}
	
	if($hos!=-1)//if hospital is set
	{
		$query=$query." AND `Hospital`='$hos'";
		$missing_query=$missing_query."AND `Hospital`='$hos'";
		$audit_query=$audit_query."AND `Hospital`='$hos'";
		$ser=$ser." in ".$hos;
	}
	$sendquery=$query;
	$send_missing_query=$missing_query;
	$send_audit_query=$audit_query;
	$result=mysql_query($query);
	$missing_result=mysql_query($missing_query);
	$audit_result=mysql_query($audit_query);
}
else
{	
	$dat=date('Y-m-d');
	echo "<center><table><tr><td class=\"result1\">Details of files uploaded by the Editors on ".$dat."</td></tr></table></center><br>";
	$query="SELECT `Date`,`Hospital`,`File_No`,`Linecount`,`Uploadedby`,`Editedby` FROM `file_details`  WHERE `Date` ='$dat' AND `Editedby`!='Not yet Edited'";
	$missing_query="SELECT `Date`,`Hospital`,`File_no`,`Linecount`,`Edit_by` FROM `missing_files` WHERE `Date`='$dat'";
	$audit_query="SELECT `Date`,`Hospital`,`File_no`,`Linecount`,`Audit_by` FROM `audit_files` WHERE `Date`='$dat'";
	$sendquery=$query;
	$send_missing_query=$missing_query;
	$send_audit_query=$audit_query;
	$result=mysql_query($query);
	$missing_result=mysql_query($missing_query);
	$audit_result=mysql_query($audit_query);
	$ser="Search results ";
}
echo "<div id=\"tabs\" >
          <ul>
            <li><a href=\"#Edited\">Edited Lines</a></li>
			<li><a href=\"#Audit\">Audit Lines</a></li>
			<li><a href=\"#Missing\">Missing LInes</a></li>
          </ul>";
echo "<div id=\"Edited\">";
if($result)
{
	$count=mysql_num_rows($result);
	if($count!=0)
	{	
		echo "<center><label class=\"result\"><u>".$ser."</u></label></b><br><br>";
		echo "<div id=\"detail\" style=\"width:850px; height: 400px; border: 0px groove #3b3a3a; overflow: auto;\">";
		echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"800\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\">";
		echo "<th>S.No.</th><th>Date</th><th>Hospital</th><th>File No</th><th>LineCount</th><th>Uploaded By</th><th>Edited By</th></tr>";
		while($row=mysql_fetch_array($result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".$c."</td>";
			echo "<td style=\"width:90px;\">".$row['Date']."</td>";
			echo "<td>".$row['Hospital']."</td>";
			echo "<td>".$row['File_No']."</td>";
			echo "<td>".$row['Linecount']."</td>";
			$lc=$lc+$row['Linecount'];
			echo "<td style=\"width:300px;\">".$row['Uploadedby']."</td>";
			echo "<td style=\"width:300px;\">".$row['Editedby']."</td>";
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
	}
	else
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
	
	}
}
echo "</div>";
echo "<div id=\"Audit\">";
if($audit_result)
{	
	$audit_lc=0;
	$c=1;
	$r=0;
	$audit_count=mysql_num_rows($audit_result);
	if($audit_count!=0)
	{	
		echo "<center><label class=\"result\"><u>".$ser."</u></label></b><br><br>";
		echo "<div id=\"detail\" style=\"width:850px; height: 400px; border: 0px groove #3b3a3a; overflow: auto;\">";
		echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"800\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\">";
		echo "<th>S.No.</th><th>Date</th><th>Hospital</th><th>File No</th><th>LineCount</th><th>Edited By</th></tr>";
		while($audit_row=mysql_fetch_array($audit_result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".$c."</td>";
			echo "<td style=\"width:90px;\">".$audit_row['Date']."</td>";
			echo "<td>".$audit_row['Hospital']."</td>";
			echo "<td>".$audit_row['File_no']."</td>";
			echo "<td>".$audit_row['Linecount']."</td>";
			$audit_lc=$audit_lc+$audit_row['Linecount'];
			echo "<td style=\"width:300px;\">".$audit_row['Audit_by']."</td>";
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
		echo "<tr class=\"result1\"><td>Total No. Of.File</td><td>:</td><td>".$audit_count."</td></tr><br>";
		echo "<tr class=\"result1\"><td>Total No. Of.Lines</td><td>:</td><td>".$audit_lc."</td></tr>";
		echo "</table></center>";
	}
	else
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
	
	}
}
echo "</div>";
echo "<div id=\"Missing\">";
if($missing_result)
{
	$mis_lc=0;
	$c=1;
	$r=0;
	$mis_count=mysql_num_rows($missing_result);
	if($mis_count!=0)
	{	
		echo "<center><label class=\"result\"><u>".$ser."</u></label></b><br><br>";
		echo "<div id=\"detail\" style=\"width:850px; height: 400px; border: 0px groove #3b3a3a; overflow: auto;\">";
		echo "<table border=\"1\" cellpadding=\"2\" cellspacing=\"0\" width=\"800\" align=\"center\" class=\"text ui-widget-content ui-corner-all tab\">";
		echo "<th>S.No.</th><th>Date</th><th>Hospital</th><th>File No</th><th>LineCount</th><th>Edited By</th></tr>";
		while($mis_row=mysql_fetch_array($missing_result))
		{
			echo "<tr class=tr".$r.">";
			echo "<td>".$c."</td>";
			echo "<td style=\"width:90px;\">".$mis_row['Date']."</td>";
			echo "<td>".$mis_row['Hospital']."</td>";
			echo "<td>".$mis_row['File_no']."</td>";
			echo "<td>".$mis_row['Linecount']."</td>";
			$mis_lc=$mis_lc+$mis_row['Linecount'];
			echo "<td style=\"width:300px;\">".$mis_row['Edit_by']."</td>";
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
		echo "<tr class=\"result1\"><td>Total No. Of.File</td><td>:</td><td>".$mis_count."</td></tr><br>";
		echo "<tr class=\"result1\"><td>Total No. Of.Lines</td><td>:</td><td>".$mis_lc."</td></tr>";
		echo "</table></center>";
	}
	else
	{
		echo "<br /><br /><br /><br /><br /><h1><center>Sorry No Record Found !!!</center></h1><br /><br /><br /><br /><br /><br />";
	
	}
}
echo "</div>";

echo "</div>";
echo "<br><center><strong>***The output of the Excel is based on your selection Criteria***</strong></center>";
		Print "<br><br><center><form name=\"xl\" method=\"post\" action=\"admineditorreport.php\">";
		Print "<input type=\"hidden\" Value=\"$sendquery\" name=\"query\" id=\"query\" />";
		Print "<input type=\"hidden\" Value=\"$send_missing_query\" name=\"mis_query\" id=\"mis_query\" />";
		Print "<input type=\"hidden\" Value=\"$send_audit_query\" name=\"ad_query\" id=\"ad_query\" />";
		Print "<input type=\"hidden\" Value=\"Edited File Details\" name=\"rep_name\" id=\"name\" />";
		Print "<input type=\"submit\" value=\"Get Complete File details as Excel\" name=\"Filedetails\"/>";
		Print "</form></center></td></tr></table>";
?>
		</div>
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
            <script>
 $(function() {
    $( "#tabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "<div><center><br><br><br><br><img src=\"images/ajax/01.gif\"></center><br><br><br><br><br><div>" );
        });
      }
    });
  });
  </script>

</div><!-- end of wrapper -->
</div> <!-- end of outter wrapper -->
</body>
<script src="js/element.js"></script>
</html>