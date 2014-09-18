<SCRIPT LANGUAGE="JavaScript">
function validate() 
{ 
	document.update_client.button3.disabled = false;
	document.update_client.errmsg.value = "";
	var paymethod = document.update_client.paymethod.value; 
	if (paymethod == "Electronic") { 
		var idno = document.update_client.idno.value; 
		if (idno == "") {
			document.update_client.button3.disabled = true;
			document.update_client.errmsg.value = "ID No is required";
		}
	} 
	if (paymethod == "Cheque") { 
		var idno = document.update_client.idno.value; 
		if (idno == "") {
			document.update_client.button3.disabled = true;
			document.update_client.errmsg.value = "ID No is required";
		}
	} 
} 
--> 
</script> 
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
mysql_select_db($database_adhocConn, $adhocConn);
$query_client = sprintf("SELECT * FROM clients WHERE clientID = %s", $_GET['clientID']);
$client = mysql_query($query_client, $adhocConn) or die($query_client);
$row_client = mysql_fetch_assoc($client);
$totalRows_client = mysql_num_rows($client);

mysql_select_db($database_adhocConn, $adhocConn);
$query_categories = "SELECT * FROM categories ORDER BY category ASC";
$categories = mysql_query($query_categories, $adhocConn) or die(mysql_error());
$row_categories = mysql_fetch_assoc($categories);
$totalRows_categories = mysql_num_rows($categories);
?>
<?php require_once('inc_before.php'); ?>
&nbsp;<p>The Client: </p>
        <form id="update_client" name="update_client" method="post" action="update_client2.php">
          <table width="95%" border="1" align="center" cellpadding="3" cellspacing="0">
            <tr>
              <td><div align="right">Flag this customer:</div></td>
              <td><input <?php if (!(strcmp($row_client['flagged'],1))) {echo "checked=\"checked\"";} ?> name="flagged" type="checkbox" id="flagged" value="1" /></td>
            </tr>
            <tr>
              <td><div align="right">Reason for flagging:</div></td>
              <td><input name="flagdetail" type="text" class="maintext" id="flagdetail" value="<?php echo $row_client['flagdetail']; ?>" size="15" /></td>
            </tr>
            <tr>
              <td><div align="right">Client Code:</div></td>
              <td><input name="clientno" type="text" class="maintext" id="clientno" value="<?php echo $row_client['clientno']; ?>" size="15" /></td>
            </tr>
            <tr>
              <td><div align="right">Name:</div></td>
              <td><input name="cname" type="text" class="maintext" id="cname" value="<?php echo $row_client['cname']; ?>" size="15" /></td>
            </tr>
            <tr>
              <td><div align="right">Surname:</div></td>
              <td><input name="surname" type="text" class="maintext" id="surname" value="<?php echo $row_client['surname']; ?>" size="15" /></td>
            </tr>
            <tr>
              <td><div align="right">Category:</div></td>
              <td><select name="category" class="maintext" id="category">
                  <?php
do {  
?>
                  <option value="<?php echo $row_categories['catID']?>"<?php if (!(strcmp($row_categories['catID'], $row_client['category']))) {echo "selected=\"selected\"";} ?>><?php echo $row_categories['category']?></option>
                  <?php
} while ($row_categories = mysql_fetch_assoc($categories));
  $rows = mysql_num_rows($categories);
  if($rows > 0) {
      mysql_data_seek($categories, 0);
	  $row_categories = mysql_fetch_assoc($categories);
  }
?>
              </select></td>
            </tr>
            <tr>
              <td><div align="right">Email:</div></td>
              <td><input name="cemail" type="text" class="maintext" id="cemail" value="<?php echo $row_client['cemail']; ?>" size="15" /></td>
            </tr>
            <tr>
              <td><div align="right">Tel No:</div></td>
              <td><input name="telno" type="text" class="maintext" id="telno" value="<?php echo $row_client['telno']; ?>" size="15" /></td>
            </tr>
            <tr>
              <td><div align="right">Cell No:</div></td>
              <td><input name="cellno" type="text" class="maintext" id="cellno" value="<?php echo $row_client['cellno']; ?>" size="15" /></td>
            </tr>
            <tr>
              <td><div align="right">Postal:</div></td>
              <td><textarea name="postal" cols="15" class="maintext" id="postal"><?php echo $row_client['postal']; ?></textarea></td>
            </tr>
            <tr>
              <td><div align="right">Payment Method:</div></td>
              <td><select name="paymethod" class="maintext" id="paymethod" onChange="validate()">
                  <option value="Cash" <?php if (!(strcmp("Cash", $row_client['paymethod']))) {echo "selected=\"selected\"";} ?>>Cash</option>
                  <option value="Cheque" <?php if (!(strcmp("Cheque", $row_client['paymethod']))) {echo "selected=\"selected\"";} ?>>Cheque</option>
                  <option value="Electronic" <?php if (!(strcmp("Electronic", $row_client['paymethod']))) {echo "selected=\"selected\"";} ?>>Electronic</option>
                  <option value="Account" <?php if (!(strcmp("Account", $row_client['paymethod']))) {echo "selected=\"selected\"";} ?>>Account</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><div align="right">ID No:</div></td>
              <td><input name="idno" type="text" class="maintext" id="idno" value="<?php echo $row_client['idno']; ?>" size="15" onKeyUp="validate()" /></td>            </tr>
            <tr>
              <td><div align="right">Where did they hear of Ad Hoc?</div></td>
              <td><select name="whereheard" class="maintext" id="whereheard">
                  <option value="Dustbins" <?php if (!(strcmp("Dustbins", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Dustbins</option>
                  <option value="Fixed" <?php if (!(strcmp("Fixed", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Fixed</option>
                  <option value="Referrals" <?php if (!(strcmp("Referrals", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Referrals</option>
                  <option value="Website" <?php if (!(strcmp("Website", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Website</option>
                  <option value="Vehicles" <?php if (!(strcmp("Vehicles", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Vehicles</option>
                  <option value="Fridge magnet - home" <?php if (!(strcmp("Fridge magnet - home", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Fridge magnet - home</option>
                  <option value="Fridge magnet - postbox" <?php if (!(strcmp("Fridge magnet - postbox", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Fridge magnet - postbox</option>
                  <option value="1023" <?php if (!(strcmp("1023", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>1023</option>
                  <option value="Assist 24" <?php if (!(strcmp("Assist 24", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Assist 24</option>
                  <option value="Atterbury Wall" <?php if (!(strcmp("Atterbury Wall", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Atterbury Wall</option>
                  <option value="Centre Point Advertising" <?php if (!(strcmp("Centre Point Advertising", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Centre Point Advertising</option>
                  <option value="Estate in Africa - Fridge magnets" <?php if (!(strcmp("Estate in Africa - Fridge magnets", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Estate in Africa - Fridge magnets</option>
                  <option value="Yellow Pages" <?php if (!(strcmp("Yellow Pages", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Yellow Pages</option>
                  <option value="Yellow Pages Website" <?php if (!(strcmp("Yellow Pages Website", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Yellow Pages Website</option>
                  <option value="Hello Peter" <?php if (!(strcmp("Hello Peter", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Hello Peter</option>
                  <option value="SA Find It Website" <?php if (!(strcmp("SA Find It Website", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>SA Find It Website</option>
                  <option value="Old Clients" <?php if (!(strcmp("Old Clients", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Old Clients</option>
                  <option value="Online" <?php if (!(strcmp("Online", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Online</option>
                  <option value="Plumbcon" <?php if (!(strcmp("Plumbcon", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Plumbcon</option>
                  <option value="Record" <?php if (!(strcmp("Record", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Record</option>
                  <option value="Rietmark Centurion" <?php if (!(strcmp("Rietmark Centurion", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Rietmark Centurion</option>
                  <option value="Rietmark Moot" <?php if (!(strcmp("Rietmark Moot", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Rietmark Moot</option>
                  <option value="Rietmark Noord" <?php if (!(strcmp("Rietmark Noord", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Rietmark Noord</option>
                  <option value="Rietmark Oos" <?php if (!(strcmp("Rietmark Oos", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Rietmark Oos</option>
                  <option value="Radio Rippel" <?php if (!(strcmp("Radio Rippel", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Radio Rippel</option>
                </select>              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="addressID" type="hidden" id="addressID" value="<?php echo $_GET['addressID']; ?>" />
                  <input name="clientID" type="hidden" id="clientID" value="<?php echo $_GET['clientID']; ?>" />
                  <input type="hidden" name="MM_update" value="update_client" />
                  <input type="hidden" name="typeID" id="typeID" value="<?php echo $typeID; ?>" />
                  <input name="button3" type="submit" class="maintext" id="button3" value="UPDATE" onmouseover="validate()" />
                    <input name="errmsg" type="text" class="errbox" id="errmsg" value="" size="15" />
                  </td>
            </tr>
          </table>
        </form>
<?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($categories);

mysql_free_result($client);
?>