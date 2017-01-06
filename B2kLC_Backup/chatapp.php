<?php
session_start();
if(isset($_SESSION['Admin']))
{ 
	$chatname=$_SESSION['Admin'];
}
elseif(isset($_SESSION['MLS']))
{ 
	$chatname=$_SESSION['MLS'];
}
elseif(isset($_SESSION['EDITOR']))
{ 
	$chatname=$_SESSION['EDITOR'];
}
else
{ 
	$loginas=$chatname;
	$token=$_SESSION['token'];
	$key=md5($loginas."_B2K");
	if($token==$key)
	{ 
		header( 'Content-Type: text/html; charset=utf-8' );
		include('dbconfig.php');
		include('include_dir.php');
		include('global.php');
	}
	else
	{ 
		header("location:index.php"); 
	}
}
$_SESSION['username']=$chatname;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>B2k Medical Transcription</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/fisheye.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="css/menu.css" rel="stylesheet" />
<script src="js/jquery.js" language="javascript"></script>
<script src="js/jquery.easing.js" language="javascript"></script>
<script src="js/jquery.lavalamp.js" language="javascript"></script>
<script src="js/menu.js" language="javascript"></script>
<script type="text/javascript">
  function getPage(page, id) {
    var xmlhttp=false; //Clear our fetching variable
    try {
      //Try the first kind of active x object	
      xmlhttp = new ActiveXObject('Msxml2.XMLHTTP'); 
    } catch (e) {    
      try {
        //Try the second kind of active x object
        xmlhttp = new ActiveXObject('Microsoft.XMLHTTP'); 
      } catch (E) {
        xmlhttp = false;
      }
    }
   
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
      xmlhttp = new XMLHttpRequest();
    }
    var file = page; 
    xmlhttp.open('GET', file, true);   
    xmlhttp.onreadystatechange=function() {
      //Check if it is ready to recieve data
      if (xmlhttp.readyState==4) { 
        var content = xmlhttp.responseText;
        if( content ) { 
          document.getElementById(id).innerHTML = content; 
        }
      }
    }
    xmlhttp.send(null) //Nullify the XMLHttpRequest
    return;
  }

  function chat() {  
    var user     = document.getElementById('user').value;
    var message  = document.getElementById('message').value;
  
    getPage("chat.content.php?user=" + user + "&message=" + message,"screen");
	document.getElementById('message').value = "";
  
  }
  
  function getMessage() {
  	getPage("chat.content.php","screen");
  }
  
</script>
</head>
<style type="text/css">
body {
  font:12px arial;
}
	
#panel {
  border:1px solid #333333; 
  height:380px; 
  width:510px;
  padding:5px;
  background-color:#e3e6e6;
}
	
#title {
  margin-bottom:5px;
}
	
#screen {
  width:500px; 
  height:260px; 
  border:1px solid #333333;
  margin-bottom:5px;
  overflow-x:hidden;
  overflow-y:auto;
  text-align:left;
  background-color:#FFFFFF;
}
	
#input {
  float:left; 
  margin-right:15px;
  padding-top:7px;
  padding-left:5px;
}
	
#send {
  float:left;
  padding-top:10px;
}
	
#user {
  border:1px solid #333333; 
  width:150px;
}
	
#message {
  height:80px; 
  width:380px; 
  border:1px solid #000000;
}
	
#post {
  height:80px; 
  width:100px;
}
</style>
<body> 

<div id="outer_wrapper">
  <div id="wrapper">
	<?php 
    include('main_top.php');
    ?>
    <div id="main"><br />
		<script type="text/javascript">
        	process = setInterval("getMessage()", 100);
        </script>
        <center>
        <h1>Chat</h1>
        <div id="panel"> 
            <div id="title">
                <span><?php echo "<b>".$chatname."</b>";?></span>
                <span><input type="hidden" name="user" id="user" maxlength="15" value="<?php echo $chatname;?>" readonly="readonly"></span>
            </div>
            <div id="screen"></div>
            <div>
                <div id="input">
               	 	<textarea name="message" id="message"></textarea>
                </div>
                <div id="send">
                	<input type="button" name="post" id="post" maxlength="500" value="Send" onClick="javascript:chat();" />
                </div>
            </div> 
        </div>
        </center>
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