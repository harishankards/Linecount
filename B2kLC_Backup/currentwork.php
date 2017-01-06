<?php
include('dbconfig.php');
$mls_count=0;
$editor_count=0;
$htmls_count=0;
$htedtr_count=0;
$upstatus=mysql_query("SELECT `Emp_desig` FROM `employee` WHERE `Log_status`='YES'");
$upcount=mysql_num_rows($upstatus);
if($upcount!=0)
{
	while($uprow=mysql_fetch_array($upstatus))
	{
		if($uprow['Emp_desig']=="MLS")
		{
			$mls_count=$mls_count+1;
		}
		if($uprow['Emp_desig']=="EDITOR")
		{
			$editor_count=$editor_count+1;
		}
		if($uprow['Emp_desig']=="HT-MLS")
		{
			$htmls_count=$htmls_count+1;
		}
		if($uprow['Emp_desig']=="HT-EDITOR")
		{
			$htedtr_count=$htedtr_count+1;
		}
	}
}
?>
<h2>Current Employee Status</h2>
<table width="800" border="1" align="center" class="ui-widget ui-widget-content ui-corner-all" cellpadding="3" cellspacing="0" style="font-size: 12px;">
<tr class="ui-widget-header"><th>No. of MLS (<?php echo htmlentities($mls_count);?>)</th><th>No. of Editors (<?php echo htmlentities($editor_count); ?>)</th><th>No. of HT-MLS (<?php echo htmlentities($htmls_count);?>)</th><th>No. of HT-Editors (<?php echo htmlentities($htedtr_count); ?>)</th></tr>
<tr align="center">
<td width="205" >
<div style="width:170px; height:200px; overflow:auto; color:#000000;">
<?php 
$mlsstatus=mysql_query("SELECT `Emp_name` FROM `employee` WHERE `Emp_desig`='MLS' AND `Log_status`='YES'");
$mlscount=mysql_num_rows($mlsstatus);
if($mlscount!=0)
{	
	while($mlsrow=mysql_fetch_array($mlsstatus))
	{
		echo htmlentities($mlsrow['Emp_name'])."<br>";
	}
}
else
{
	echo " MLS have not logged yet";
}
?>
</div>
</td>
<td >
<div style="width:170px; height:200px; overflow:auto; color:#000000;">
<?php 
$edtstatus=mysql_query("SELECT `Emp_name` FROM `employee` WHERE `Emp_desig`='EDITOR' AND `Log_status`='YES'");
$edtcount=mysql_num_rows($edtstatus);
if($edtcount!=0)
{	
	while($edtrow=mysql_fetch_array($edtstatus))
	{
		echo htmlentities($edtrow['Emp_name'])."<br>";
	}
}
else
{
	echo " Editors have not logged yet";
}
?>
</div>
</td>
<td >
<div style="width:170px; height:200px; overflow:auto; color:#000000;">
<?php 
$htmlsstatus=mysql_query("SELECT `Emp_name` FROM `employee` WHERE `Emp_desig`='HT-MLS' AND `Log_status`='YES'");
$htmlscount=mysql_num_rows($htmlsstatus);
if($htmlscount!=0)
{	
	while($htmlsrow=mysql_fetch_array($htmlsstatus))
	{
		echo htmlentities($htmlsrow['Emp_name'])."<br>";
	}
}
else
{
	echo " HT-MLS have not logged yet";
}
?>
</div>
</td>
<td >
<div style="width:170px; height:200px; overflow:auto; color:#000000;">
<?php 
$htstatus=mysql_query("SELECT `Emp_name` FROM `employee` WHERE `Emp_desig`='HT-EDITOR' AND `Log_status`='YES'");
$htcount=mysql_num_rows($htstatus);
if($htcount!=0)
{	
	
	while($htrow=mysql_fetch_array($htstatus))
	{
		echo htmlentities($htrow['Emp_name'])."<br>";
	}
}
else
{
	echo " HT-Editors have not logged yet";
}
?>
</div>
</td>
</tr>
</table>