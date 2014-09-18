<?php require_once('Connections/adhocConn.php'); ?>
<?php
// *** Validate request to login to this site.
session_start();

$loginFormAction = $_SERVER['PHP_SELF'];

if ((isset($_POST['uname'])) && (!($_POST['otp']))){
	$loginUsername=$_POST['uname'];
	$password=$_POST['pword'];
	$MM_fldUserAuthorization = "accesslevel";
	$MM_redirectLoginSuccess = "control_panel_jobs.php";
	$MM_redirectLoginFailed = "index.php?msg=Login failed.";
	$MM_redirecttoReferrer = false;
	mysql_select_db($database_adhocConn, $adhocConn);
	
	$LoginRS__query=sprintf("SELECT * FROM users WHERE uname='%s' AND pword='%s'",
	get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
	
	$LoginRS = mysql_query($LoginRS__query, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
	$loginFoundUser = mysql_num_rows($LoginRS);
	if ($loginFoundUser) {
    
		$loginStrGroup  = mysql_result($LoginRS,0,'accesslevel');
		$loginUsername=$_POST['uname'];
		
		$colname_getUserID = $loginUsername;
		mysql_select_db($database_adhocConn, $adhocConn);
		$query_getUserID = sprintf("SELECT * FROM users WHERE uname = '%s'", $colname_getUserID);
		$getUserID = mysql_query($query_getUserID, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
		$row_getUserID = mysql_fetch_assoc($getUserID);
		$totalRows_getUserID = mysql_num_rows($getUserID);
		$loginUserID = $row_getUserID['userID'];
		$userstatus = $row_getUserID['status'];
		$expdate = $row_getUserID['expdate'];
		$cellno =  $row_getUserID['ucell'];
		mysql_free_result($getUserID);
		
		if ($userstatus != 2) {
			header("Location: ". $MM_redirectLoginFailed );
		} else {
			$my_t=getdate(time());
			$my_wday = $my_t[wday];
			$my_hour = $my_t[hours];
			if ($my_wday == 0) { $field1 = "su_"; }
			if ($my_wday == 1) { $field1 = "mo_"; }
			if ($my_wday == 2) { $field1 = "tu_"; }
			if ($my_wday == 3) { $field1 = "we_"; }
			if ($my_wday == 4) { $field1 = "th_"; }
			if ($my_wday == 5) { $field1 = "fr_"; }
			if ($my_wday == 6) { $field1 = "sa_"; }
			$field2 = $field1 . "t";
			$field1 = $field1 . "f";
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_getUserID = sprintf("SELECT * FROM users WHERE uname = '%s'", $colname_getUserID);
			$getUserID = mysql_query($query_getUserID, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
			$row_getUserID = mysql_fetch_assoc($getUserID);
			$totalRows_getUserID = mysql_num_rows($getUserID);
			$fromtime = $row_getUserID[$field1]; 
			$totime = $row_getUserID[$field2]; 
			mysql_free_result($getUserID);
			if (($fromtime != 25) && ($fromtime <= $my_hour) && ($totime > $my_hour)) {
				// set otp, otpexpiry + 5 min
				$setotp = rand(100000,999999);
				$msg = "Your one-time pin is " . $setotp . " and will expire in 5 minutes at " . date("H:i:s",time()+300) . ".";
				$updateSQL = sprintf("UPDATE users SET otp=%s, otpexpiry=%s WHERE userID=%s", $setotp, time()+300, $loginUserID);
				
				mysql_select_db($database_adhocConn, $adhocConn);
				$Result1 = mysql_query($updateSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
				// send otp
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://www.mymobileapi.com/api5/http5.aspx');
				curl_setopt ($ch, CURLOPT_POST, 1);
				$post_fields = "Type=sendparam&username=adhoc&password=admin1&numto=" . $cellno . "&data1=" . $msg;
				curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_fields);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$response_string = curl_exec($ch);
				curl_close($ch);
			} else {
				header("Location: no_access.php?ft=" . $fromtime . "&tt=" . $totime);
			}
			
		}
	} else {
		header("Location: ". $MM_redirectLoginFailed );
	}
}

// *** Validate request to login to this site.
session_start();

$loginFormAction = $_SERVER['PHP_SELF'];

if (isset($_POST['otp'])) {
	$loginUsername=$_POST['uname'];
	$password=$_POST['pword'];
	$otp=$_POST['otp'];
	$MM_fldUserAuthorization = "accesslevel";
	$MM_redirectLoginSuccess = "select_screen.php";
	$MM_redirectLoginFailed = "index.php?msg=Login failed.";
	$MM_redirecttoReferrer = false;
	mysql_select_db($database_adhocConn, $adhocConn);
	
	$LoginRS__query=sprintf("SELECT * FROM users WHERE uname='%s' AND pword='%s' AND otp='%s' AND otpexpiry >='%s'",$loginUsername, $password, $otp, time()); 
	
	$LoginRS = mysql_query($LoginRS__query, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
	$loginFoundUser = mysql_num_rows($LoginRS);
	if ($loginFoundUser) {
		
		$loginStrGroup  = mysql_result($LoginRS,0,'accesslevel');
		
		$colname_getUserID = $loginUsername;
		$my_t=getdate(time());
		$my_wday = $my_t[wday];
		$my_hour = $my_t[hours];
		if ($my_wday == 0) { $field1 = "su_"; }
		if ($my_wday == 1) { $field1 = "mo_"; }
		if ($my_wday == 2) { $field1 = "tu_"; }
		if ($my_wday == 3) { $field1 = "we_"; }
		if ($my_wday == 4) { $field1 = "th_"; }
		if ($my_wday == 5) { $field1 = "fr_"; }
		if ($my_wday == 6) { $field1 = "sa_"; }
		$field2 = $field1 . "t";
		$field1 = $field1 . "f";
		mysql_select_db($database_adhocConn, $adhocConn);
		$query_getUserID = sprintf("SELECT * FROM users WHERE uname = '%s'", $colname_getUserID);
		$getUserID = mysql_query($query_getUserID, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
		$row_getUserID = mysql_fetch_assoc($getUserID);
		$totalRows_getUserID = mysql_num_rows($getUserID);
		$loginUserID = $row_getUserID['userID'];
		$userstatus = $row_getUserID['status'];
		$fromtime = $row_getUserID[$field1]; 
		$totime = $row_getUserID[$field2]; 
		mysql_free_result($getUserID);

		if ($userstatus != 2) {
			header("Location: ". $MM_redirectLoginFailed );
		} else {
			$expiry = 43200;
			if (($fromtime != 25) && ($fromtime <= $my_hour) && ($totime > $my_hour)) {
				$sd = getdate(time()); 
				$sd_d = $sd[mday];
				$sd_m = $sd[mon];
				$sd_y = $sd[year];
				$sd_h = $sd[hours];
				$sd_i = $sd[minutes];
				$sdate = mktime($totime,0,0,$sd_m,$sd_d,$sd_y);
				$expiry = $sdate - time();
				setcookie("MM_Username", $loginUsername, time()+$expiry);
				setcookie("MM_UserGroup", $loginStrGroup, time()+$expiry);
				setcookie("MM_userID", $loginUserID, time()+$expiry);
				setcookie("MM_expiry", $expiry, time()+$expiry);
				
				
				header("Location: select_screen.php");
			} else {
				header("Location: no_access.php");
			}
		}
	} else {
		header("Location: ". $MM_redirectLoginFailed );
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ad Hoc Plumbers Admin</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body onload="document.forms[0].otp.focus();">
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="613" valign="top" background="design/index_otp.jpg"><form id="form1" name="form1" method="post" action="index_otp.php">
      <table width="950" border="00" cellspacing="0" cellpadding="0">
        <tr>
          <td width="57" height="340">&nbsp;</td>
          <td width="27">&nbsp;</td>
          <td width="34">&nbsp;</td>
          <td width="161">&nbsp;</td>
          <td width="671">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td rowspan="2"><input name="button" type="submit" class="loginbutton" id="button" value="Enter" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td valign="top"><input name="otp" type="text" class="logintextbox" id="otp" size="12" /></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input name="pword" type="hidden" id="pword" value="<?php echo $_POST['pword']; ?>" />
            <input name="uname" type="hidden" id="uname" value="<?php echo $_POST['uname']; ?>" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
</body>
</html>
