<?php
session_cache_limiter('private');
$cache_limiter = session_cache_limiter();
session_cache_expire(500);
$cache_expire = session_cache_expire();
session_start();
set_time_limit(0);
ini_set("memory_limit","512M");
ini_set("upload_max_filesize", "256M");
ini_set("post_max_size", "200M");
ini_set("max_input_time","20000");
ini_set("max_execution_time","20000");
header('Cache-control: private'); 
header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT'); 
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', false); 
header('Pragma: no-cache');
if(isset($_POST['username'],$_POST['pass'],$_POST['client'],$_POST['log_as']))
{	
	include('dbconfig.php');
	include('global.php');
	include('include_dir.php');
	ob_start();
	function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	$proxy=@getRealIpAddr();
 	$host =$proxy;
	$login_time=$datetime;
	$logout="";
	$myusername = stripslashes($_POST['username']);
	$mypassword = stripslashes($_POST['pass']);
	$myclient = stripslashes($_POST['client']);
	$mystatus = stripslashes($_POST['log_as']);
	$user = mysqli_real_escape_string($dbC, strtoupper($myusername));
    $pass = mysqli_real_escape_string($dbC, $mypassword);
	$client = mysqli_real_escape_string($dbC, $myclient);
	$loginas = mysqli_real_escape_string($dbC, $mystatus);
	$enc_user = base64_encode ($user);
	$enc_pass = base64_encode ($pass);
	$enc_client = base64_encode ($client);
	$enc_loginas = base64_encode ($loginas);
	//$dec = base64_decode ($enc);
	$post_autologin = $_POST['autologin'];
	if($post_autologin == 1)
	{
		setcookie("cook_username", $enc_user, time()+60*60*24*365);
		setcookie("cook_password", $enc_pass, time()+60*60*24*365);
		setcookie("cook_client", $enc_client, time()+60*60*24*365);
		setcookie("cook_loginas", $enc_loginas, time()+60*60*24*365);
		setcookie("lastvisit", date("F jS - g:i a"), time()+60*60*24*365);
	}
	//For Checking Admin Login
	if($loginas=="Admin")
	{
		$sql="SELECT `Rights`,`Vendor` from `admin` WHERE `username`='$user' and `password`=SHA('$pass') ";
		$result=mysqli_query($dbC,$sql);
		if($result)
		{
			$count=mysqli_num_rows($result);
			if($count==1)
			{
				while($row=mysqli_fetch_array($result))
				{
					$mode=mysqli_real_escape_string($dbC, $row['Rights']);
					$vendor=mysqli_real_escape_string($dbC, $row['Vendor']);
				}
				if($mode=="Full Control")
				{
					session_register("admin");
					session_register("password");
					$_SESSION['Admin']= ucwords($user);
					$loginas=$_SESSION['Admin'];
					$sess_id=session_id();
					$_SESSION['token']= md5($loginas."_Admin@B2K");
					$_SESSION['EMP_NAME_ONLY']=$loginas;
					$_SESSION['username']=$loginas;
					$_SESSION['Vendorname']=$vendor;
					$fp = fopen($log_dir.$loginas.".txt", "at");
					$comment=$loginas." has logged in to Admin page using the System ".$host;
					fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
					header("location:admin.php");
				}
				else
				{
					header("location:index.php?msg5=Invalid Selection Please check");
				}
				
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
		}
		else
		{
			header("location:index.php?msg5=Please Contact Administrator Fatal Error!!!");
		}	
	}
	
	// For Checking Vendor Admin
	if($loginas=="Vendoradmin")
	{
		$sql="SELECT `Rights`,`Vendor` from `admin` WHERE `username`='$user' and `password`=SHA('$pass') ";
		$result=mysqli_query($dbC,$sql);
		if($result)
		{
			$count=mysqli_num_rows($result);
			if($count==1)
			{
				while($row=mysqli_fetch_array($result))
				{
					$mode=mysqli_real_escape_string($dbC, $row['Rights']);
					$vendor=mysqli_real_escape_string($dbC, $row['Vendor']);
				}
				if($mode=="Monitoring")
				{
					session_register("vendoradmin");
					session_register("password");
					$_SESSION['Vendor_Admin']= ucwords($vendor);
					$loginas=$_SESSION['Vendor_Admin'];
					$_SESSION['EMP_NAME_ONLY']=$loginas;
					$_SESSION['username']=$loginas;
					$_SESSION['Vendorname']=$vendor;
					$sess_id=session_id();
					$_SESSION['token']= md5($loginas."_B2K");
					$up_status="UPDATE `employee` SET `Log_status`='YES' WHERE `Emp_no`='$user'";
					$upstatus=mysqli_query($dbC,$up_status);
					$fp = fopen($log_dir.$loginas.".txt", "at");
					$comment=$loginas." has logged in to Vendor Admin page using the System ".$host;
					fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
					header("location:monitoring.php");
				}
				else
				{
					header("location:index.php?msg5=Invalid Selection Please check");
				}
				
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
		}
		else
		{
			header("location:index.php?msg5=Please Contact Administrator Fatal Error!!!");
		}
	}
	
	
	// For Checking Super Admin Login
	if($loginas=="Superadmin")
	{
		$sql="SELECT `username` from `super_admin` WHERE `username`='$user' and `password`=SHA('$pass') ";
		$result=mysqli_query($dbC,$sql);
		if($result)
		{
			$count=mysqli_num_rows($result);
			if($count==1)
			{
				session_register("super_admin");
				session_register("password");
				$_SESSION['Super_Admin']= ucwords($user);
				$loginas=$_SESSION['Super_Admin'];
				$_SESSION['EMP_NAME_ONLY']=$loginas;
				$_SESSION['username']=$loginas;
				$sess_id=session_id();
				$_SESSION['token_sa']= md5($loginas."_B2KSA");
				$up_status="UPDATE `employee` SET `Log_status`='YES' WHERE `Emp_no`='$user'";
				$upstatus=mysqli_query($dbC,$up_status);
				header("location:superadmin.php");
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
		}
	}
	
	//For Checking IDSIL MT Login
	if($loginas=="MT" && $client=="IDSIL")
	{
		$sql="SELECT `Emp_no`,`Emp_name`,`Vendor`,`Emp_desig`,`ID_Status` from `employee` FORCE INDEX (`Emp_no`)  WHERE `Emp_no`='$user' AND `Emp_pass`=SHA('$pass') ";
		$result=mysqli_query($dbC,$sql);
		if($result)
		{
			$count=mysqli_num_rows($result);
			if($count==1)
			{
				while($row=mysqli_fetch_array($result))
				{
					if($row['Emp_desig']=="MLS" || $row['Emp_desig']=="HT-MLS")
					{	
						if($row['ID_Status']=="ACTIVE")
						{
							session_register("mls");
							session_register("password");
							$sess_id=session_id();
							$_SESSION['MLS']= strtoupper($user);
							$loginas=$_SESSION['MLS'];
							$emp_name_only=$row['Emp_name'];
							$emp_name_id=$emp_name_only."-".$row['Emp_no'];
							$_SESSION['EMP_NAME_ONLY']=strtoupper($emp_name_only);
							$_SESSION['username']=$loginas;
							$_SESSION['EMP_NAME_ID']=strtoupper($emp_name_id);
							$_SESSION['token']= md5($loginas."_B2KIDSIL");
							$_SESSION['Vendorname']=$row['Vendor'];
							$_SESSION['idsilmlsname']=strtoupper($emp_name_id);
							$up_status="UPDATE `employee` SET `Log_status`='YES' WHERE `Emp_no`='$user'";
							$upstatus=mysqli_query($dbC,$up_status);
							$uploadby=$_SESSION['idsilmlsname'];
							$fp = fopen($log_dir.$uploadby.".txt", "at");
							$comment=$loginas." has logged in to IDSIL / PJO using the System ".$host;
							fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
							fclose($fp);
							header("location:mls.php");
							
						}
						else
						{
							header("location:index.php?msg1=Blocked");
						}
					}
					else
					{
						header("location:index.php?msg5=Invalid Selection Please check");
					}
				}
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
		}
		else
		{
			header("location:index.php?msg5=Please Contact Administrator Fatal Error!!!");
		}
	}

	//For Checking IDSIL Editor Login
	if($loginas=="QC" && $client=="IDSIL")
	{
		$sql="SELECT `Emp_no`,`Emp_name`,`Vendor`,`Emp_desig`,`ID_Status` from `employee` FORCE INDEX (`Emp_no`)  WHERE `Emp_no`='$user' and `Emp_pass`=SHA('$pass')";
		$result=mysqli_query($dbC,$sql);
		if($result)
		{
			$count=mysqli_num_rows($result);
			if($count==1)
			{
				while($row=mysqli_fetch_array($result))
				{
					if($row['Emp_desig']=="EDITOR" || $row['Emp_desig']=="HT-EDITOR")
					{
						if($row['ID_Status']=="ACTIVE")
						{
							session_register("editor");
							session_register("password");
							$sess_id=session_id();
							$_SESSION['EDITOR']= strtoupper($user);
							$loginas=$_SESSION['EDITOR'];
							$emp_name_only=$row['Emp_name'];
							$emp_name_id=$emp_name_only."-".$row['Emp_no'];
							$_SESSION['EMP_NAME_ONLY']=strtoupper($emp_name_only);
							$_SESSION['username']=$loginas;
							$_SESSION['EMP_NAME_ID']=strtoupper($emp_name_id);
							$_SESSION['token']= md5($loginas."_B2KIDSIL");
							$_SESSION['Vendorname']=$row['Vendor'];
							$_SESSION['idsileditorname']=strtoupper($emp_name_id);
							$up_status="UPDATE `employee` SET `Log_status`='YES' WHERE `Emp_no`='$user'";
							$upstatus=mysqli_query($dbC,$up_status);
							$uploadby=$_SESSION['idsileditorname'];
							$fp = fopen($log_dir.$uploadby.".txt", "at");
							$comment=$loginas." has logged in to IDSIL / PJO using the System ".$host;
							fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
							fclose($fp);
							header("location:editor.php");
						}
						else
						{
							header("location:index.php?msg1=Blocked");
						}
					}
					else
					{
						header("location:index.php?msg5=Invalid Selection Please check");
					}
				}
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
		}
		else
		{
			header("location:index.php?msg5=Please Contact Administrator Fatal Error!!!");
		}
	}

	// for checking Escription MT Login
	if($loginas=="MT" && $client=="Escription")
	{
		$sql="SELECT `Emp_no`,`Emp_name`,`Vendor`,`Emp_desig`,`ID_Status` from `es_employee` FORCE INDEX (`Emp_no`)  WHERE `Emp_no`='$user' and `Emp_pass`=SHA('$pass')";
		$result=mysqli_query($dbC,$sql);
		if($result)
		{
			$count=mysqli_num_rows($result);
			if($count==1)
			{
				while($row=mysqli_fetch_array($result))
				{
					if($row['Emp_desig']=="MLS" || $row['Emp_desig']=="HT-MLS")
					{
						if($row['ID_Status']=="ACTIVE")
						{
							session_register("MLS");
							session_register("MLSPASS");
							$sess_id=session_id();
							$_SESSION['ES-MLS']=strtoupper($user);
							$loginas=$_SESSION['ES-MLS'];
							$emp_name_only=$row['Emp_name'];
							$emp_name_id=$emp_name_only."-".$row['Emp_no'];
							$_SESSION['EMP_NAME_ONLY']=strtoupper($emp_name_only);
							$_SESSION['username']=$loginas;
							$_SESSION['EMP_NAME_ID']=strtoupper($emp_name_id);
							$_SESSION['esmlsname']=strtoupper($emp_name_id);
							$_SESSION['token']= md5($loginas."_B2KES");
							$_SESSION['Vendorname']=$row['Vendor'];
							$up_status="UPDATE `employee` SET `Log_status`='YES' WHERE `Emp_no`='$user'";
							$upstatus=mysqli_query($dbC,$up_status);
							$uploadby=$_SESSION['esmlsname'];
							$fp = fopen($log_dir.$uploadby.".txt", "at");
							$comment=$loginas." has logged in to Escription using the System ".$host;
							fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
							fclose($fp);
							header("location:es-mls.php");
						}
						else
						{
							header("location:index.php?msg1=Blocked");
						}
					}
					else
					{
						header("location:index.php?msg5=Invalid Selection Please check");
					}
				}
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
		}
		else
		{
			header("location:index.php?msg5=Please Contact Administrator Fatal Error!!!");
		}
	}
	
	//Fro Checking Escription QC Login
	if($loginas=="QC" && $client=="Escription")
	{
		$sql="SELECT `Emp_no`,`Emp_name`,`Vendor`,`Emp_desig`,`ID_Status` from `es_employee` FORCE INDEX (`Emp_no`)  WHERE `Emp_no`='$user' and `Emp_pass`=SHA('$pass')";
		$result=mysqli_query($dbC,$sql);
		if($result)
		{
			$count=mysqli_num_rows($result);
			if($count==1)
			{
				while($row=mysqli_fetch_array($result))
				{
					if($row['Emp_desig']=="EDITOR" || $row['Emp_desig']=="HT-EDITOR")
					{
						if($row['ID_Status']=="ACTIVE")
						{
							session_register("eseditor");
							session_register("password");
							$sess_id=session_id();
							$_SESSION['ES-EDITOR']= strtoupper($user);
							$loginas=$_SESSION['ES-EDITOR'];
							$emp_name_only=$row['Emp_name'];
							$emp_name_id=$emp_name_only."-".$row['Emp_no'];
							$_SESSION['EMP_NAME_ONLY']=strtoupper($emp_name_only);
							$_SESSION['username']=$loginas;
							$_SESSION['EMP_NAME_ID']=strtoupper($emp_name_id);
							$_SESSION['eseditorname']=strtoupper($emp_name_id);
							$_SESSION['token']= md5($loginas."_B2KES");
							$_SESSION['Vendorname']=$row['Vendor'];
							$up_status="UPDATE `employee` SET `Log_status`='YES' WHERE `Emp_no`='$user'";
							$upstatus=mysqli_query($dbC,$up_status);
							$uploadby=$_SESSION['eseditorname'];
							$fp = fopen($log_dir.$uploadby.".txt", "at");
							$comment=$loginas." has logged in to Escription using the System ".$host;
							fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
							fclose($fp);
							header("location:es-editor.php");
						}
						else
						{
							header("location:index.php?msg1=Blocked");
						}
					}
					else
					{
						header("location:index.php?msg5=Invalid Selection Please check");
					}
				}
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
		}
		else
		{
			header("location:index.php?msg5=Please Contact Administrator Fatal Error!!!");
		}
	}
ob_end_flush();
mysql_close($dbC);
}
else
{
	header("location:index.php?msg4=NotAllowed");
}
?>