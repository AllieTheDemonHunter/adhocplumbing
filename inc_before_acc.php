<?php require_once('Connections/adhocConn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
  $insertSQL = sprintf("INSERT INTO log (userID, `timestamp`, page) VALUES (%s, %s, %s)",
                       GetSQLValueString($_COOKIE['MM_userID'], "int"),
                       GetSQLValueString(time(), "int"),
                       GetSQLValueString($_SERVER['REQUEST_URI'], "text"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($insertSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ad Hoc</title>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td height="195" background="design/adhoc_r1_c1.jpg">
    	<table align="center" cellpadding="3" cellspacing="0" border="0">
    	  <tr>
    	    <td>&nbsp;</td>
    	    <td>&nbsp;</td>
  	    </tr>
    	  <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td></tr><tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td></tr><tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td></tr><tr>
                <td width="150">&nbsp;</td>
                <td class="branch"><?php
					if ($_COOKIE['MM_userID']) {
                		mysql_select_db($database_adhocConn, $adhocConn);
						$query_my_region = sprintf("SELECT * FROM users WHERE userID = %s", $_COOKIE['MM_userID']);
						$my_region = mysql_query($query_my_region, $adhocConn) or die(mysql_error());
						$row_my_region = mysql_fetch_assoc($my_region);
						$totalRows_my_region = mysql_num_rows($my_region);
						if ($row_my_region['region']) {
							$myregionID = $row_my_region['region'];
						} else {
							$myregionID = -1;
						}
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_regionname = sprintf("SELECT * FROM regions WHERE regionID = %s", $myregionID);
						$regionname = mysql_query($query_regionname, $adhocConn) or die(mysql_error());
						$row_regionname = mysql_fetch_assoc($regionname);
						$totalRows_regionname = mysql_num_rows($regionname);
						echo $row_regionname['region'];
						mysql_free_result($regionname);

						mysql_free_result($my_region);
					}
				?></td>
    	</tr></table>
    </td>
</tr>
  <tr>
    <td>
        <ul id="MenuBar1" class="MenuBarHorizontal">
          <li><a href="control_panel_accounts.php">ACCOUNTS</a></li>
          <li><a href="log_quote_step_1.php?typeID=2&call_status=4.php">SEARCH</a></li>
          <li><a href="logout.php">LOG OUT</a></li>
          <li><a href="select_screen.php">HOME SCREEN</a></li>
        </ul>
	</td>
  </tr>
  <tr>
    <td>
        <table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td height="400" valign="top">