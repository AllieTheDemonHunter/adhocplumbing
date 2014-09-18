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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "logcall")) {
		$edate = time() + ($_POST['minutes'] * 60);
		$updateSQL = sprintf("UPDATE call_log SET est_fin_time=%s WHERE logID=%s",
						   GetSQLValueString($edate, "int"),
						   GetSQLValueString($_POST['caseno'], "int"));
	
		mysql_select_db($database_adhocConn, $adhocConn);
		$Result1 = mysql_query($updateSQL, $adhocConn) or die(__LINE__.mysql_error());
		
		$updateSQL = sprintf("UPDATE crews SET booked_until=%s WHERE crewID=%s",
						   GetSQLValueString($edate, "int"),
						   GetSQLValueString($_POST['c1'], "int"));
		
		mysql_select_db($database_adhocConn, $adhocConn);
		$Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());
	  
		$updateSQL = sprintf("UPDATE crews SET booked_until=%s WHERE crewID=%s",
						   GetSQLValueString($edate, "int"),
						   GetSQLValueString($_POST['c2'], "int"));
		
		mysql_select_db($database_adhocConn, $adhocConn);
		$Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());
	  
		$updateSQL = sprintf("UPDATE vehicles SET booked_until=%s WHERE vehicleID=%s",
						   GetSQLValueString($edate, "int"),
						   GetSQLValueString($_POST['v1'], "int"));
		
		mysql_select_db($database_adhocConn, $adhocConn);
		$Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());
		$insertGoTo = "control_screen_jobs.php";
		header(sprintf("Location: %s", $insertGoTo));
	}
?>
<?php require_once('inc_before.php'); ?>
              <p>ADD TIME</p>
              <form id="form1" name="form1" method="post" action="add_time.php">
                <div align="center">
                  <p><br />
                  <input name="caseno" type="hidden" id="caseno" value="<?php echo $_GET['caseno']; ?>" />
                  <input type="hidden" name="c1" id="c1" value="<?php echo $_GET['c1']; ?>" />
                  <input type="hidden" name="c2" id="c2" value="<?php echo $_GET['c2']; ?>" />
                  <input type="hidden" name="v1" id="v1" value="<?php echo $_GET['v1']; ?>" />
                  <input type="hidden" name="MM_update" value="logcall" />
                  Add another 
                  <br />
                  <select name="minutes" class="maintext" id="minutes">
                    <option value="5">5 minutes</option>
                    <option value="10">10 minutes</option>
                    <option value="15">15 minutes</option>
                    <option value="20">20 minutes</option>
                    <option value="25">25 minutes</option>
                    <option value="30">30 minutes</option>
                    <option value="45">45 minutes</option>
                    <option value="60">1 hour</option>
                    <option value="90">1.5 hours</option>
                    <option value="120">2 hours</option>
                    <option value="150">2.5 hours</option>
                    <option value="180">3 hours</option>
                    <option value="240">4 hours</option>
                    <option value="300">5 hours</option>
                  </select>
                  </p>
                  <p>
                    <input name="button" type="submit" class="maintext" id="button" value="ADD" />
</p>
                </div>
              </form>
              <p>&nbsp;</p>
<?php require_once('inc_after.php'); ?>
