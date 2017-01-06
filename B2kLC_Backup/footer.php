<style>
#menu{
z-index:1;
}
</style>
<div id="dock">
<ul class="menu_l" >
<?php
if(isset($_SESSION['Admin']))
{ ?>
	<li><a href="http://www.google.com" target="_blank" title="Google"><img src="icons/google.png" alt="Google" height="35" width="35"/></a></li>
    <li><a href="https://www.gmail.com" title="Gmail" target="_blank"	><img src="icons/gmail.png" alt="Gmail" height="35" width="35"/></a></li>
    <li><a href="https://webconsole.trcr.com/login.aspx" title="Webconsole" target="_blank" ><img src="icons/trans.png" alt="Webconsole" height="35" width="35"/></a></li>
     <li><a href="https://secure.trcr.com/" title="Secure Login" target="_blank" ><img src="icons/trans.png" alt="Secure Login" height="35" width="35"/></a></li>
    <li><a href="http://www.pjats.com/careers/" title="Scoop" target="_blank"><img src="icons/pjo.png" alt="Scoop" height="35" width="35"/></a></li>
    <li><a href="https://pjaproduction.pjats.com/HomePage/display.jsp" title="Ruby" target="_blank"	><img src="icons/ruby.png" alt="Ruby" height="35" width="35"/></a></li>
    <li><a href="https://newportbay.aaita.com/TAPlus/Login.jsp" title="Newport Bay" target="_blank"	><img src="icons/TA.png" alt="Newport Bay" height="35" width="35"/></a></li>
    <li><a href="https://samc.aaita.com/TAPlus/Login.jsp" title="SAMC" target="_blank"	><img src="icons/TA.png" alt="SAMC" height="35" width="35"/></a></li>
    
     <li><a href="https://connecticut.aaita.com/TAPlus/Login.jsp" title="Allotment" target="_blank"	><img src="icons/TA.png" alt="Allotment" height="35" width="35"/></a></li>
<?    
}
elseif(isset($_SESSION['MLS']))
{ 
?>
	<li><a href="http://www.google.com" target="_blank" title="Google"><img src="icons/google.png" alt="Google" height="35" width="35"/></a></li>
    <li><a href="https://webconsole.trcr.com/login.aspx" title="Webconsole" target="_blank" ><img src="icons/trans.png" alt="Webconsole" height="35" width="35"/></a></li>
     <li><a href="https://secure.trcr.com/" title="Secure Login" target="_blank" ><img src="icons/trans.png" alt="Secure Login" height="35" width="35"/></a></li>
    <li><a href="http://www.pjats.com/careers/" title="Scoop" target="_blank"><img src="icons/pjo.png" alt="Scoop" height="35" width="35"/></a></li>
    <li><a href="https://pjaproduction.pjats.com/HomePage/display.jsp" title="Ruby" target="_blank"	><img src="icons/ruby.png" alt="Ruby" height="35" width="35"/></a></li>
    <li><a href="https://newportbay.aaita.com/TAPlus/Login.jsp" title="Newport Bay" target="_blank"	><img src="icons/TA.png" alt="Newport Bay" height="35" width="35"/></a></li>
    <li><a href="https://samc.aaita.com/TAPlus/Login.jsp" title="SAMC" target="_blank"	><img src="icons/TA.png" alt="SAMC" height="35" width="35"/></a></li>
    <li><a href="http://www.drugs.com/" title="Drugs.com" target="_blank"	><img src="icons/drugs.png" alt="Drugs" height="35" width="35"/></a></li>
     <li><a href="http://upin.ecare.com//" title="E-Care Online" target="_blank"	><img src="icons/e-care.png" alt="Drugs" height="35" width="35"/></a></li>
<?
}
elseif(isset($_SESSION['EDITOR']))
{ 
?>
	<li><a href="http://www.google.com" target="_blank" title="Google"><img src="icons/google.png" alt="Google" height="35" width="35"/></a></li>
    <li><a href="https://webconsole.trcr.com/login.aspx" title="Webconsole" target="_blank" ><img src="icons/trans.png" alt="Webconsole" height="35" width="35"/></a></li>
     <li><a href="https://secure.trcr.com/" title="Secure Login" target="_blank" ><img src="icons/trans.png" alt="Secure Login" height="35" width="35"/></a></li>
    <li><a href="http://www.pjats.com/careers/" title="Scoop" target="_blank"><img src="icons/pjo.png" alt="Scoop" height="35" width="35"/></a></li>
    <li><a href="https://pjaproduction.pjats.com/HomePage/display.jsp" title="Ruby" target="_blank"	><img src="icons/ruby.png" alt="Ruby" height="35" width="35"/></a></li>
    <li><a href="https://newportbay.aaita.com/TAPlus/Login.jsp" title="Newport Bay" target="_blank"	><img src="icons/TA.png" alt="Newport Bay" height="35" width="35"/></a></li>
    <li><a href="https://samc.aaita.com/TAPlus/Login.jsp" title="SAMC" target="_blank"	><img src="icons/TA.png" alt="SAMC" height="35" width="35"/></a></li>
    <li><a href="http://www.drugs.com/" title="Drugs.com" target="_blank"	><img src="icons/drugs.png" alt="Drugs" height="35" width="35"/></a></li>
     <li><a href="http://upin.ecare.com//" title="E-Care Online" target="_blank"	><img src="icons/e-care.png" alt="Drugs" height="35" width="35"/></a></li>
<?
}
?>  
<? 
if(isset($_SESSION['ES-MLS']))
{ 
}
?>   
<? 
if(isset($_SESSION['ES-EDITOR']))
{ 
}
?>   
</ul>

<ul class="menu_r" >
    <li><a onClick="window.location = window.location.href;" title="Refresh"><img src="menu/button-synchronize_sticker.png" alt="Refresh" height="35" width="35"/></a></li>
    <li><br /></li>
    <li><a href="logout.php" title="Logout"><img src="menu/button-power_sticker.png" alt="Logout" height="35" width="35"/></a></li>
    <li><br /></li>
<?
if(isset($_SESSION['EDITOR']))
{
	if($_SESSION['EDITOR']=="B2KER003" || $_SESSION['EDITOR']=="B2KER004")
	{
	?>
		<li><a href="todaystatus.php" title="Today Status" ><img src="menu/addattn.png" alt="Drugs" height="35" width="35"/></a></li>
		<li><br /></li>
		<li><a href="weeklymlsreport.php" title="Weekly report" ><img src="menu/addstatus.png" alt="Drugs" height="35" width="35"/></a></li>
        <li><br /></li>
		<li><a href="viewmlsprofile.php" title="Weekly report" ><img src="menu/accnts.png" alt="Drugs" height="35" width="35"/></a></li>
	<?
	}
}
?>
</ul>
</div>
<div id="footer">
<center>
<br />
       Copyright © 2012 <a href="http://www.b2klinecount.com" target="_blank">B2K Medical Transcription</a><br /><table><tr><td>Developed by</td><td><img src="images/praveen.png" height="31" width="180" /></td></tr></table>
</center>
</div> <!-- end of footer -->	

<?php
if(!isset($_SESSION['Admin']))
{
echo "<script>dhtmlx.message(\"For any Support contact <br />Administrator @ <b>0424-2277069</b>\"	);</script>";
}
?>
<?php include_once("analyticstracking.php") ?>
<script src="js/jquery-1.3.1.min.js" language="javascript"></script>
<script src="js/menu.js" language="javascript"></script>
<script src="js/jquery/jquery-1.8.3.js"></script>
<script src="js/jquery/jquery.validationEngine.js"></script>
<script src="js/jquery/jquery.validationEngine-en.js"></script>
<script src="js/jquery/ui/jquery-ui.custom.js"></script>
<script src="js/jquery/globaljq.js"></script>
<script src="codebase/message.js" type="text/javascript"></script>
<script type="text/javascript" src="js/ddimgtooltip.js"></script>
<!--<script type="text/javascript" src="js/staticlogo.js"></script>-->
<!--<script type="text/javascript" src="js/chat.js"></script>-->
<script>
function initMenu() {
  $('#drmenu ul').hide();
  $('#drmenu li a').click(
    function() {
      var checkElement = $(this).next();
	 var checkElement1 = $(this).prev();
      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
		checkElement.slideUp('normal');
        return false;
        }
      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
        checkElement.slideDown('normal');
        return false;
        }
      }
    );
  }
$(document).ready(function() {initMenu();});
$(function() {
    $( "#accordion" ).accordion({
      collapsible: true
    });
  });
</script>
<script language="javascript" type="text/javascript">

function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=250,left = 147,top = 214');");
}

function highlight_row(the_element, checkedcolor) 
{
	
	if(the_element.parentNode.parentNode.style.backgroundColor != checkedcolor) 
	{
		the_element.parentNode.parentNode.style.backgroundColor = checkedcolor;
		
	}
	else 
	{
		the_element.parentNode.parentNode.style.backgroundColor = '';
	} 
	confirmDelete();
}
</script>

