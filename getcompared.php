<?php
	include('dbconfig.php');
	include('include_dir.php');
	include('global.php');
	
	$file_no=$_GET['fileno'].".doc";
	$c_date=$_GET['date'];
	$third=$_GET['third'];
	
	$year=date('Y', strtotime($c_date));
	$month=date('F-Y', strtotime($c_date));
	$date=$c_date;
	$uploaddir = $main_dir."/".$year."/".$month."/".$c_date;
	
	if($third=="no")
	{
		$filename1=$uploaddir."/Mls/".$file_no;
		$filename2=$uploaddir."/Edit/".$file_no;
	}
	if($third=="yes")
	{
		$filename1=$uploaddir."/Edit/".$file_no;
		$filename2=$uploaddir."/Third/".$file_no;
	}
	
	
	if ( file_exists($filename1) && file_exists($filename2)) 
	{
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=".$file_no."_Compared.doc");
		echo "<html>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
		echo "<body>";
		if ( file_exists($filename1) ) 
		{
			if ( ($fh = fopen($filename1, 'r')) !== false ) 
			{
			
				$headers = fread($fh, 0xA00);
				
				# 1 = (ord(n)*1) ; Document has from 0 to 255 characters
				$n1 = ( ord($headers[0x21C]) - 1 );
				
				# 1 = ((ord(n)-8)*256) ; Document has from 256 to 63743 characters
				$n2 = ( ( ord($headers[0x21D]) - 8 ) * 256 );
				
				# 1 = ((ord(n)*256)*256) ; Document has from 63744 to 16775423 characters
				$n3 = ( ( ord($headers[0x21E]) * 256 ) * 256 );
							
				# (((ord(n)*256)*256)*256) ; Document has from 16775424 to 4294965504 characters
				$n4 = ( ( ( ord($headers[0x21F]) * 256 ) * 256 ) * 256 );
				
				# Total length of text in the document
				$textLength = ($n1 + $n2 + $n3 + $n4);
				# if you want the plain text with no formatting, do this
				$extracted_plaintext1 = fread($fh, $textLength);
				//echo $extracted_plaintext1;
			}
		}
		if ( file_exists($filename2) ) 
		{
			if ( ($fh = fopen($filename2, 'r')) !== false ) 
			{
			
				$headers = fread($fh, 0xA00);
				
				# 1 = (ord(n)*1) ; Document has from 0 to 255 characters
				$n1 = ( ord($headers[0x21C]) - 1 );
				
				# 1 = ((ord(n)-8)*256) ; Document has from 256 to 63743 characters
				$n2 = ( ( ord($headers[0x21D]) - 8 ) * 256 );
				
				# 1 = ((ord(n)*256)*256) ; Document has from 63744 to 16775423 characters
				$n3 = ( ( ord($headers[0x21E]) * 256 ) * 256 );
							
				# (((ord(n)*256)*256)*256) ; Document has from 16775424 to 4294965504 characters
				$n4 = ( ( ( ord($headers[0x21F]) * 256 ) * 256 ) * 256 );
				
				# Total length of text in the document
				$textLength = ($n1 + $n2 + $n3 + $n4);
				# if you want the plain text with no formatting, do this
				$extracted_plaintext2 = fread($fh, $textLength);
				//echo $extracted_plaintext2;
			}
		}
		
		
		function diff($old, $new){
			$maxlen='';
			foreach($old as $oindex => $ovalue){
				$nkeys = array_keys($new, $ovalue);
				foreach($nkeys as $nindex){
					$matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
						$matrix[$oindex - 1][$nindex - 1] + 1 : 1;
					if($matrix[$oindex][$nindex] > $maxlen){
						$maxlen = $matrix[$oindex][$nindex];
						$omax = $oindex + 1 - $maxlen;
						$nmax = $nindex + 1 - $maxlen;
					}
				}   
			}
			if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
			return array_merge(
				diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
				array_slice($new, $nmax, $maxlen),
				diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
		}
		
		function htmlDiff($old, $new){
			$ret='';
			$diff = diff(explode(' ', $old), explode(' ', $new));
			foreach($diff as $k){
				if(is_array($k))
					$ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":'').
						(!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":'');
				else $ret .= $k . ' ';
			}
			return $ret;
		}
		echo "<style>del{background:#fcc}ins{background:#a2f594}</style>".htmlDiff($extracted_plaintext1,$extracted_plaintext2);
		echo "</body>";
		echo "</html>";
	}
	else
	{
		echo "<script> alert('File is missing');</script>";
	}
?>