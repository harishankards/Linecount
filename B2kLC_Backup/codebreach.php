<?
session_start();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>B2k Medical Transcription</title>
<meta name="keywords" content="B2k Medical Transcription Linecount" />
<meta name="description" content="B2k Medical Transcription Linecount" />
<script src="js/jquery.js" language="javascript"></script>
<script type="text/javascript" src="js/copy.js"></script>
<script type="text/javascript" src="js/RCPCode.js"></script>
<script language=JavaScript>
/*
Source of MainPart: Stefan MÃ¼nz, Selfhtml 7.0, tecb.htm
*/

activ = window.setInterval("Farbe()",100);
i = 0, farbe = 1;
function Farbe() {

if(farbe==1) {
document.bgColor="FFFF00"; farbe=2; }
else {
document.bgColor="FF0000"; farbe=1; }
i = i + 1;

//if you don't want to freeze the browser uncommend the next two lines
//if(i >= 50)
//window.clearInterval(activ);
}

function erneut(){
//window.open(self.location,'');
}
window.onload = erneut;
</script>
</head>
<body>
<center><br>
<br>
<br>
<h2>You Entered a WRONG CODE</h2>
<h1>CODE BREACH ! ! !</h1>
</center></body>
</html>