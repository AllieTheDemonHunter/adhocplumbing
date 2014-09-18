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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE call_log SET medauthno=%s, medauthperson=%s WHERE logID=%s",
                       GetSQLValueString($_POST['medauthno'], "text"),
                       GetSQLValueString($_POST['medauthperson'], "text"),
                       GetSQLValueString($_POST['logID'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());

  $updateGoTo = "despatch.php?caseno=" . $_POST['logID'];
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_auth = "-1";
if (isset($_GET['caseno'])) {
  $colname_auth = $_GET['caseno'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_auth = sprintf("SELECT * FROM call_log WHERE logID = %s", GetSQLValueString($colname_auth, "int"));
$auth = mysql_query($query_auth, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_auth = mysql_fetch_assoc($auth);
$totalRows_auth = mysql_num_rows($auth);

if (!($_COOKIE['MM_UserGroup'])) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>

<?php require_once('inc_before.php'); ?>
              <p>ENTER MEDICAL AID AUTHORISATION NUMBER</p>
              <blockquote>
                <p align="center" class="logbutton">CASE NO: <?php echo $row_auth['logID']; ?></p>
                <p align="center">Medical Aid requires an authorisation number!                </p>
                <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                  <table align="center">

                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Authorisation no:</td>
                      <td><input name="medauthno" type="text" class="maintext" value="<?php echo htmlentities($row_auth['medauthno'], ENT_COMPAT, 'utf-8'); ?>" size="10" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Authorisation person:</td>
                      <td><input name="medauthperson" type="text" class="maintext" value="<?php echo htmlentities($row_auth['medauthperson'], ENT_COMPAT, 'utf-8'); ?>" size="20" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">&nbsp;</td>
                      <td><div align="right">
                        <input type="submit" class="logbutton" value="Proceed" />
                      </div></td>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_update" value="form2" />
                  <input type="hidden" name="logID" value="<?php echo $row_auth['logID']; ?>" />
                </form>
                <p align="center"><a href="case_search.php?caseno=<?php echo $row_auth['logID']; ?>" target="_blank">Click here for the details (new window)</a></p>
              </blockquote>              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($auth);
?>
