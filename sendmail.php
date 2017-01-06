<?php include('top.php');?>
<script language="javascript" type="text/javascript">
function clearText(field)
{
    if (field.defaultValue == field.value) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}

function check(thisform)
{
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if(thisform.mail_to.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a mail Id"});
      return false;
    }
	if(reg.test(thisform.mail_to.value) == false)
	{
       dhtmlx.alert({title:"Warning!!!", text:"Please Enter a valid mail Id"});
      return false;
 	}
	if(thisform.mail_cc.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Cc"});
      return false;
    }
	if(reg.test(thisform.mail_cc.value) == false)
	{
       dhtmlx.alert({title:"Warning!!!", text:"Please Enter a valid CC mail Id"});
      return false;
 	}
	if(thisform.mail_bcc.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a BCc"});
      return false;
    }
	if(reg.test(thisform.mail_bcc.value) == false)
	{
       dhtmlx.alert({title:"Warning!!!", text:"Please Enter a valid BCC mail Id"});
      return false;
 	}
	if(thisform.mail_sub.value==='')
    {
      dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Subject"});
      return false;
    }
	
	if(thisform.mail_mes.value==='')
    {
	  dhtmlx.alert({title:"Warning!!!", text:"Please Enter a Message"});
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
          
          <form name="Mail" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
          <center><h2>Send Mail</h2></center>
          <table cellpadding="5" align="center" cellspacing="10" width="600">
          
          <tr>
          <td>To </td>
          <td>:</td>
          <td><input type="text" name="mail_to" id="mail_to" size="60"  /></td>
          </tr>
          
          <tr>
          <td>Cc</td>
          <td>:</td>
          <td><input type="text" name="mail_cc" id="mail_cc" size="60"  /></td>
          </tr>
          
          <tr>
          <td>Bcc</td>
          <td>:</td>
          <td><input type="text" name="mail_bcc" id="mail_bcc" size="60"  /></td>
          </tr>
          
          <tr>
          <td>Subject</td>
          <td>:</td>
          <td><input type="text" name="mail_sub" id="mail_sub" size="60"  /></td>
          </tr>
          
           <tr>
          <td>Message</td>
          <td>:</td>
          <td><textarea name="mail_mes" id="mail_mes" cols="70" rows="15"></textarea></td>
          </tr>
          
          </table>
          <table cellpadding="10" align="center" cellspacing="30">
          <tr><td><input type="button" value="Send" name="sub" class="button" onClick="check(this.form)"/></td><td><input type="reset" value="Reset" name="res" class="button" height="27" width="100" /></td></tr>
          </table>
          </form>
    </div> <!-- end of main -->
    <div id="main_bottom"></div>
    <?php include('footer.php');?>
    
  </div> 
	<!-- end of wrapper -->

</div> <!-- end of outter wrapper -->
<?php
include('dbconfig.php');
if(isset($_POST['mail_to'],$_POST['mail_cc'],$_POST['mail_bcc'],$_POST['mail_sub'],$_POST['mail_mes']))
{
$to  = $_POST['mail_to'];
// subject
$subject = $_POST['mail_sub'];
//cc
$cc=$_POST['mail_cc'];

//bcc
$bcc=$_POST['mail_bcc'];


// message
$message = $_POST['mail_mes'];

// To send HTML mail, the Content-type header must be set
//$headers  = 'MIME-Version: 1.0' . "\r\n";
//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$to.'' . "\r\n";
$headers .= 'From: Admin B2K <admin@b2klinecount.com>' . "\r\n";
$headers .= 'Cc: '.$cc.'' . "\r\n";
$headers .= 'Bcc: '.$bcc.'' . "\r\n";

// Mail it
$sql=mail($to, $subject, $message, $headers);
if($sql)
{
	echo "<script> dhtmlx.alert({
				title:\"Success !!!\",
				ok:\"Ok\",
				text:\"Mail sent successfully\",
				callback:function(){
				setTimeout(function(){ window.location = \"sendmail.php\";}, 0);
				}
			});
			
			</script>";
}
else
{
	echo "<script> dhtmlx.alert({
				title:\"Error !!!\",
				ok:\"Ok\",
				text:\"We Encounter a problem while sending your message\",
				callback:function(){
				setTimeout(function(){ window.location = \"sendmail.php\";}, 0);
				}
			});
			
			</script>";


}
}

?>
</body>
<script src="js/element.js"></script>
</html>
