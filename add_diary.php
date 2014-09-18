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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$sdate = mktime($_POST['sd_h'],$_POST['sd_i'],0,$_POST['sd_m'],$_POST['sd_d'],$_POST['sd_y']);
	$insertSQL = sprintf("INSERT INTO call_log (logtime, caller, telno1, notes, diary, `read`) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($sdate, "int"),
                       GetSQLValueString($_POST['caller'], "text"),
                       GetSQLValueString($_POST['telno1'], "text"),
                       GetSQLValueString($_POST['notes'], "text"),
                       GetSQLValueString($_POST['diary'], "int"),
                       GetSQLValueString($_POST['read'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());

  $insertGoTo = "diary.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php require_once('inc_before.php'); ?>
              <p>Add Diary Entry
              </p>
              
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Date &amp; Time:</td>
                    <td><?php 
						$sd = getdate(time()); 
						$sd_d = $sd[mday];
						$sd_m = $sd[mon];
						$sd_y = $sd[year];
						$sd_h = $sd[hours];
						$sd_i = $sd[minutes];
						?>
                        <select name="sd_d" class="Maintext" id="sd_d">
                          <option <?php if ($sd_d == 1) { echo "SELECTED"; } ?>>1</option>
                          <option <?php if ($sd_d == 2) { echo "SELECTED"; } ?>>2</option>
                          <option <?php if ($sd_d == 3) { echo "SELECTED"; } ?>>3</option>
                          <option <?php if ($sd_d == 4) { echo "SELECTED"; } ?>>4</option>
                          <option <?php if ($sd_d == 5) { echo "SELECTED"; } ?>>5</option>
                          <option <?php if ($sd_d == 6) { echo "SELECTED"; } ?>>6</option>
                          <option <?php if ($sd_d == 7) { echo "SELECTED"; } ?>>7</option>
                          <option <?php if ($sd_d == 8) { echo "SELECTED"; } ?>>8</option>
                          <option <?php if ($sd_d == 9) { echo "SELECTED"; } ?>>9</option>
                          <option <?php if ($sd_d == 10) { echo "SELECTED"; } ?>>10</option>
                          <option <?php if ($sd_d == 11) { echo "SELECTED"; } ?>>11</option>
                          <option <?php if ($sd_d == 12) { echo "SELECTED"; } ?>>12</option>
                          <option <?php if ($sd_d == 13) { echo "SELECTED"; } ?>>13</option>
                          <option <?php if ($sd_d == 14) { echo "SELECTED"; } ?>>14</option>
                          <option <?php if ($sd_d == 15) { echo "SELECTED"; } ?>>15</option>
                          <option <?php if ($sd_d == 16) { echo "SELECTED"; } ?>>16</option>
                          <option <?php if ($sd_d == 17) { echo "SELECTED"; } ?>>17</option>
                          <option <?php if ($sd_d == 18) { echo "SELECTED"; } ?>>18</option>
                          <option <?php if ($sd_d == 19) { echo "SELECTED"; } ?>>19</option>
                          <option <?php if ($sd_d == 20) { echo "SELECTED"; } ?>>20</option>
                          <option <?php if ($sd_d == 21) { echo "SELECTED"; } ?>>21</option>
                          <option <?php if ($sd_d == 22) { echo "SELECTED"; } ?>>22</option>
                          <option <?php if ($sd_d == 23) { echo "SELECTED"; } ?>>23</option>
                          <option <?php if ($sd_d == 24) { echo "SELECTED"; } ?>>24</option>
                          <option <?php if ($sd_d == 25) { echo "SELECTED"; } ?>>25</option>
                          <option <?php if ($sd_d == 26) { echo "SELECTED"; } ?>>26</option>
                          <option <?php if ($sd_d == 27) { echo "SELECTED"; } ?>>27</option>
                          <option <?php if ($sd_d == 28) { echo "SELECTED"; } ?>>28</option>
                          <option <?php if ($sd_d == 29) { echo "SELECTED"; } ?>>29</option>
                          <option <?php if ($sd_d == 30) { echo "SELECTED"; } ?>>30</option>
                          <option <?php if ($sd_d == 31) { echo "SELECTED"; } ?>>31</option>
                        </select>
                        <select name="sd_m" class="Maintext" id="sd_m">
                          <option <?php if ($sd_m == 1) { echo "SELECTED"; } ?> value="1">January</option>
                          <option <?php if ($sd_m == 2) { echo "SELECTED"; } ?> value="2">February</option>
                          <option <?php if ($sd_m == 3) { echo "SELECTED"; } ?> value="3">March</option>
                          <option <?php if ($sd_m == 4) { echo "SELECTED"; } ?> value="4">April</option>
                          <option <?php if ($sd_m == 5) { echo "SELECTED"; } ?> value="5">May</option>
                          <option <?php if ($sd_m == 6) { echo "SELECTED"; } ?> value="6">June</option>
                          <option <?php if ($sd_m == 7) { echo "SELECTED"; } ?> value="7">July</option>
                          <option <?php if ($sd_m == 8) { echo "SELECTED"; } ?> value="8">August</option>
                          <option <?php if ($sd_m == 9) { echo "SELECTED"; } ?> value="9">September</option>
                          <option <?php if ($sd_m == 10) { echo "SELECTED"; } ?> value="10">October</option>
                          <option <?php if ($sd_m == 11) { echo "SELECTED"; } ?> value="11">November</option>
                          <option <?php if ($sd_m == 12) { echo "SELECTED"; } ?> value="12">December</option>
                        </select>
                        <select name="sd_y" class="Maintext" id="sd_y">
                          <option <?php if ($sd_y == "2012") {echo "SELECTED";} ?>>2012</option>
                          <option <?php if ($sd_y == "2013") {echo "SELECTED";} ?>>2013</option>
                          <option <?php if ($sd_y == "2014") {echo "SELECTED";} ?>>2014</option>
                        </select>
                        <br />
                      at
                        <select name="sd_h" class="Maintext" id="sd_h">
                            <option <?php if ($sd_h == 0) { echo "SELECTED"; } ?>>0</option>
                            <option <?php if ($sd_h == 1) { echo "SELECTED"; } ?>>1</option>
                            <option <?php if ($sd_h == 2) { echo "SELECTED"; } ?>>2</option>
                            <option <?php if ($sd_h == 3) { echo "SELECTED"; } ?>>3</option>
                            <option <?php if ($sd_h == 4) { echo "SELECTED"; } ?>>4</option>
                            <option <?php if ($sd_h == 5) { echo "SELECTED"; } ?>>5</option>
                            <option <?php if ($sd_h == 6) { echo "SELECTED"; } ?>>6</option>
                            <option <?php if ($sd_h == 7) { echo "SELECTED"; } ?>>7</option>
                            <option <?php if ($sd_h == 8) { echo "SELECTED"; } ?>>8</option>
                            <option <?php if ($sd_h == 9) { echo "SELECTED"; } ?>>9</option>
                            <option <?php if ($sd_h == 10) { echo "SELECTED"; } ?>>10</option>
                            <option <?php if ($sd_h == 11) { echo "SELECTED"; } ?>>11</option>
                            <option <?php if ($sd_h == 12) { echo "SELECTED"; } ?>>12</option>
                            <option <?php if ($sd_h == 13) { echo "SELECTED"; } ?>>13</option>
                            <option <?php if ($sd_h == 14) { echo "SELECTED"; } ?>>14</option>
                            <option <?php if ($sd_h == 15) { echo "SELECTED"; } ?>>15</option>
                            <option <?php if ($sd_h == 16) { echo "SELECTED"; } ?>>16</option>
                            <option <?php if ($sd_h == 17) { echo "SELECTED"; } ?>>17</option>
                            <option <?php if ($sd_h == 18) { echo "SELECTED"; } ?>>18</option>
                            <option <?php if ($sd_h == 19) { echo "SELECTED"; } ?>>19</option>
                            <option <?php if ($sd_h == 20) { echo "SELECTED"; } ?>>20</option>
                            <option <?php if ($sd_h == 21) { echo "SELECTED"; } ?>>21</option>
                            <option <?php if ($sd_h == 22) { echo "SELECTED"; } ?>>22</option>
                            <option <?php if ($sd_h == 23) { echo "SELECTED"; } ?>>23</option>
                          </select>
                          <input name="sd_i" type="text" size="2" maxlength="2" class="Maintext" value="<?php echo $sd_i; ?>" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Contact Person:</td>
                    <td><input name="caller" type="text" id="caller" value="" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Tel no:</td>
                    <td><input type="text" name="telno1" value="" size="32" /></td>
                  </tr>

                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Notes:</td>
                    <td><textarea name="notes" cols="32" rows="5"></textarea></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><input type="submit" value="Insert record" /></td>
                  </tr>
                </table>
                <input type="hidden" name="diary" value="1" />
                <input type="hidden" name="read" value="0" />
                <input type="hidden" name="MM_insert" value="form1" />
              </form>
              <p>&nbsp;</p>
              <?php require_once('inc_after.php'); ?>
