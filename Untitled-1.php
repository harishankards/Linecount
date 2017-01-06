<?php
if(isset($_POST[md5('username')],$_POST[md5('pass')],$_POST[md5('client')],$_POST[md5('log_as')]))
{	
	set_time_limit(0);
	ini_set("memory_limit","512M");
	ini_set("max_input_time","20000");
	ini_set("max_execution_time","20000");
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
	$myusername = stripslashes($_POST[md5('username')]);
	$mypassword = stripslashes($_POST[md5('pass')]);
	$myclient = stripslashes($_POST[md5('client')]);
	$mystatus = stripslashes($_POST[md5('log_as')]);
	$user = mysqli_real_escape_string($dbC, $myusername);
    $pass = mysqli_real_escape_string($dbC, $mypassword);
	$client = mysqli_real_escape_string($dbC, $myclient);
	$loginas = mysqli_real_escape_string($dbC, $mystatus);
	
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
				session_register("admin");
				session_register("password");
				if($mode=="Full Control")
				{
					$_SESSION['Admin']= ucwords($user);
					$loginas=$_SESSION['Admin'];
					$sess_id=session_id();
					$_SESSION['token']= md5($loginas."_Admin@B2K");
					$up_status="UPDATE `employee` SET `Log_status`='YES' WHERE `Emp_no`='$user'";
					$upstatus=mysqli_query($dbC,$up_status);
					$fp = fopen($log_dir.$loginas.".txt", "at");
					$comment=$loginas." has logged in to Admin page using the System".$host;
					fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
					header("location:admin.php");
				}
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
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
				session_register("admin");
				session_register("password");
				if($mode=="Monitoring")
				{
					$_SESSION['Vendor_Admin']= ucwords($vendor);
					$loginas=$_SESSION['Vendor_Admin'];
					$sess_id=session_id();
					$_SESSION['token']= md5($loginas."_B2K");
					$up_status="UPDATE `employee` SET `Log_status`='YES' WHERE `Emp_no`='$user'";
					$upstatus=mysqli_query($dbC,$up_status);
					$fp = fopen($log_dir.$loginas.".txt", "at");
					$comment=$loginas." has logged in to Vendor Admin page using the System".$host;
					fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
					fclose($fp);
					header("location:monitoring.php");
				}
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
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
		$sql="SELECT `Vendor`,`Emp_desig`,`ID_Status` from `employee` FORCE INDEX (`Emp_no`)  WHERE `Emp_no`='$user' and `Emp_pass`=SHA('$pass')";
		$result=mysqli_query($dbC,$sql);
		if($result)
		{
			$count=mysqli_num_rows($result);
			if($count==1)
			{
				session_register("user");
				session_register("password");
				while($row=mysqli_fetch_array($result))
				{
					if($row['Emp_desig']=="MLS" || $row['Emp_desig']=="HT-MLS")
					{	
						if($row['ID_Status']=="ACTIVE")
						{
							$_SESSION['MLS']= strtoupper($user);
							$loginas=$_SESSION['MLS'];
							$sess_id=session_id();
							$_SESSION['token']= md5($loginas."_B2KIDSIL");
							$_SESSION['Vendorname']=$row['Vendor'];
							$_SESSION['idsilmlsname']=getname($loginas);
							$up_status="UPDATE `employee` SET `Log_status`='YES' WHERE `Emp_no`='$user'";
							$upstatus=mysqli_query($dbC,$up_status);
							$uploadby=getname($loginas);
							$fp = fopen($log_dir.$uploadby.".txt", "at");
							$comment=$loginas." has logged in to IDSIL / PJO using the System".$host;
							fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
							fclose($fp);
							header("location:mls.php");
						}
						else
						{
							header("location:index.php?msg1=Blocked");
						}
					}
				}
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
		}
	}

	//For Checking IDSIL Editor Login
	if($loginas=="QC" && $client=="IDSIL")
	{
		$sql="SELECT `Vendor`,`Emp_desig`,`ID_Status` from `employee` FORCE INDEX (`Emp_no`)  WHERE `Emp_no`='$user' and `Emp_pass`=SHA('$pass')";
		$result=mysqli_query($dbC,$sql);
		if($result)
		{
			$count=mysqli_num_rows($result);
			if($count==1)
			{
				session_register("user");
				session_register("password");
				while($row=mysqli_fetch_array($result))
				{
					if($row['Emp_desig']=="EDITOR" || $row['Emp_desig']=="HT-EDITOR")
					{
						if($row['ID_Status']=="ACTIVE")
						{
							$_SESSION['EDITOR']= strtoupper($user);
							$loginas=$_SESSION['EDITOR'];
							$sess_id=session_id();
							$_SESSION['token']= md5($loginas."_B2KIDSIL");
							$_SESSION['Vendorname']=$row['Vendor'];
							$_SESSION['idsileditorname']=getname($loginas);
							$up_status="UPDATE `employee` SET `Log_status`='YES' WHERE `Emp_no`='$user'";
							$upstatus=mysqli_query($dbC,$up_status);
							$uploadby=getname($loginas);
							$fp = fopen($log_dir.$uploadby.".txt", "at");
							$comment=$loginas." has logged in to IDSIL / PJO using the System".$host;
							fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
							fclose($fp);
							header("location:editor.php");
						}
						else
						{
							header("location:index.php?msg1=Blocked");
						}
					}
				}
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
		}
	}

	// for checking Escription MT Login
	if($loginas=="MT" && $client=="Escription")
	{
		$sql="SELECT `Vendor`,`Emp_desig`,`ID_Status` from `employee` FORCE INDEX (`Emp_no`)  WHERE `Emp_no`='$user' and `Emp_pass`=SHA('$pass')";
		$result=mysqli_query($dbC,$sql);
		if($result)
		{
			$count=mysqli_num_rows($result);
			if($count==1)
			{
				session_register("user");
				session_register("password");
				while($row=mysqli_fetch_array($result))
				{
					if($row['Emp_desig']=="MLS" || $row['Emp_desig']=="HT-MLS")
					{	
						if($row['ID_Status']=="ACTIVE")
						{
							$_SESSION['ES-MLS']=strtoupper($user);
							$loginas=$_SESSION['ES-MLS'];
							$_SESSION['esmlsname']=getname($loginas);
							$sess_id=session_id();
							$_SESSION['token']= md5($loginas."_B2KES");
							$_SESSION['Vendorname']=$row['Vendor'];
							$up_status="UPDATE `employee` SET `Log_status`='YES' WHERE `Emp_no`='$user'";
							$upstatus=mysqli_query($dbC,$up_status);
							$uploadby=getname($loginas);
							$fp = fopen($log_dir.$uploadby.".txt", "at");
							$comment=$loginas." has logged in to Escription using the System".$host;
							fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
							fclose($fp);
							header("location:es-mls.php");
						}
						else
						{
							header("location:index.php?msg1=Blocked");
						}
					}
					
				}
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
		}
	}
	
	//Fro Checking Escription QC Login
	if($loginas=="QC" && $client=="Escription")
	{
		$sql="SELECT `Vendor`,`Emp_desig`,`ID_Status` from `employee` FORCE INDEX (`Emp_no`)  WHERE `Emp_no`='$user' and `Emp_pass`=SHA('$pass')";
		$result=mysqli_query($dbC,$sql);
		if($result)
		{
			$count=mysqli_num_rows($result);
			if($count==1)
			{
				session_register("user");
				session_register("password");
				while($row=mysqli_fetch_array($result))
				{
					if($row['Emp_desig']=="EDITOR" || $row['Emp_desig']=="HT-EDITOR")
					{
						if($row['ID_Status']=="ACTIVE")
						{
							$_SESSION['ES-EDITOR']= strtoupper($user);
							$loginas=$_SESSION['ES-EDITOR'];
							$sess_id=session_id();
							$_SESSION['token']= md5($loginas."_B2KES");
							$_SESSION['Vendorname']=$row['Vendor'];
							$_SESSION['eseditorname']=getname($loginas);
							$up_status="UPDATE `employee` SET `Log_status`='YES' WHERE `Emp_no`='$user'";
							$upstatus=mysqli_query($dbC,$up_status);
							$uploadby=getname($loginas);
							$fp = fopen($log_dir.$uploadby.".txt", "at");
							$comment=$loginas." has logged in to Escription using the System".$host;
							fwrite($fp, PHP_EOL ."\r\n[".date("d-m-Y:g:i:s A")."] : ".$comment."\n");
							fclose($fp);
							header("location:es-editor.php");
						}
						else
						{
							header("location:index.php?msg1=Blocked");
						}
					}
				}
			}
			else
			{
				header("location:index.php?msg=Invalid User");
			}
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