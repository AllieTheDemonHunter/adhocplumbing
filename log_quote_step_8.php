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
function validate2() 
{ 
	document.logcall.button.disabled = false;
	document.logcall.errmsg2.value = "";
	var naturedetail = document.logcall.naturedetail.value; 
	if (naturedetail == "Other") { 
		var other = document.logcall.other.value; 
		if (other == "") {
			document.logcall.button.disabled = true;
			document.logcall.errmsg2.value = "Other details required";
		}
	} 
} 
function setOptions(chosen) 
{ 
	document.logcall.button.disabled = false;
	document.logcall.errmsg2.value = "";
	var naturedetail = document.logcall.naturedetail.value; 
	if (naturedetail == "Other") { 
		var other = document.logcall.other.value; 
		if (other == "") {
			document.logcall.button.disabled = true;
			document.logcall.errmsg2.value = "Other details required";
		}
	} 
	var selbox = document.logcall.naturedetail; 
	selbox.options.length = 0; 
	if (chosen == " ") { 
		selbox.options[selbox.options.length] = new Option('Please select one of the options above first',' '); 
	} 
	if (chosen == "Geyser Replacements") { 
		selbox.options[selbox.options.length] = new Option('50 litre','50 litre');
		selbox.options[selbox.options.length] = new Option('100 litre','100 litre');
		selbox.options[selbox.options.length] = new Option('150 litre','150 litre');
		selbox.options[selbox.options.length] = new Option('200 litre','200 litre');
		selbox.options[selbox.options.length] = new Option('250 litre','250 litre');
		selbox.options[selbox.options.length] = new Option('Other','Other');
	} 
	if (chosen == "Solar Geyser") { 
		selbox.options[selbox.options.length] = new Option('150 litre','150 litre');
		selbox.options[selbox.options.length] = new Option('200 litre','200 litre');
		selbox.options[selbox.options.length] = new Option('250 litre','250 litre');
		selbox.options[selbox.options.length] = new Option('Other','Other');
	} 
	if (chosen == "Blockages") { 
		selbox.options[selbox.options.length] = new Option('Drains Commercial');
		selbox.options[selbox.options.length] = new Option('Industrial');
		selbox.options[selbox.options.length] = new Option('Urinal Blocked');
		selbox.options[selbox.options.length] = new Option('Toilet Blocked');
		selbox.options[selbox.options.length] = new Option('Gulley Blocked');
		selbox.options[selbox.options.length] = new Option('Storm Water Blocked');
		selbox.options[selbox.options.length] = new Option('Sink');
		selbox.options[selbox.options.length] = new Option('Basin');
		selbox.options[selbox.options.length] = new Option('Bath');
		selbox.options[selbox.options.length] = new Option('Shower');
		selbox.options[selbox.options.length] = new Option('Other','Other');
	} 
	if (chosen == "Geyser Repairs") { 
		selbox.options[selbox.options.length] = new Option('Replaced Element');
		selbox.options[selbox.options.length] = new Option('Replaced Thermostat');
		selbox.options[selbox.options.length] = new Option('Replaced Safety Valve');
		selbox.options[selbox.options.length] = new Option('Replaced Thermostat & Safety Valve');
		selbox.options[selbox.options.length] = new Option('No Hot Water');
		selbox.options[selbox.options.length] = new Option('Leaking Geyser');
		selbox.options[selbox.options.length] = new Option('Vacuum Breakers');
		selbox.options[selbox.options.length] = new Option('PRV Master Flow Valve');
		selbox.options[selbox.options.length] = new Option('Calefi 200kpa');
		selbox.options[selbox.options.length] = new Option('Calefi 300kpa');
		selbox.options[selbox.options.length] = new Option('Calefi 400kpa');
		selbox.options[selbox.options.length] = new Option('Calefi 600kpa');
		selbox.options[selbox.options.length] = new Option('Other','Other');
	} 
	if (chosen == "Burst Pipes") { 
		selbox.options[selbox.options.length] = new Option('Commercial');
		selbox.options[selbox.options.length] = new Option('Industrial');
	} 
	if (chosen == "Construction") { 
		selbox.options[selbox.options.length] = new Option('Basin');
		selbox.options[selbox.options.length] = new Option('Bath');
		selbox.options[selbox.options.length] = new Option('Urinal');
		selbox.options[selbox.options.length] = new Option('Repipe');
		selbox.options[selbox.options.length] = new Option('Shower');
		selbox.options[selbox.options.length] = new Option('Complete Bathroom');
		selbox.options[selbox.options.length] = new Option('Other','Other');
	} 
	if (chosen == "Seeping Water") { 
		selbox.options[selbox.options.length] = new Option('Tiles');
		selbox.options[selbox.options.length] = new Option('Wall');
		selbox.options[selbox.options.length] = new Option('Floor');
		selbox.options[selbox.options.length] = new Option('Ground');
		selbox.options[selbox.options.length] = new Option('Paving');
		selbox.options[selbox.options.length] = new Option('Other','Other');
	} 
	if (chosen == "Service Toilet") { 
		selbox.options[selbox.options.length] = new Option('Replace Ball Valve');
		selbox.options[selbox.options.length] = new Option('Replace Flexi Connectors');
		selbox.options[selbox.options.length] = new Option('Putty Joint');
		selbox.options[selbox.options.length] = new Option('Replace Handle');
		selbox.options[selbox.options.length] = new Option('Replace Arm');
		selbox.options[selbox.options.length] = new Option('Replace Rubber Cone');
		selbox.options[selbox.options.length] = new Option('Other','Other');
	} 
	if (chosen == "Toilet/Urinal Flushmaster") { 
		selbox.options[selbox.options.length] = new Option('Service');
		selbox.options[selbox.options.length] = new Option('Repl Push Button');
		selbox.options[selbox.options.length] = new Option('Repl Piston');
		selbox.options[selbox.options.length] = new Option('Handle Kit');
		selbox.options[selbox.options.length] = new Option('Replace');
	} 
	if (chosen == "Industrial Work") { 
		selbox.options[selbox.options.length] = new Option('Install Pump');
		selbox.options[selbox.options.length] = new Option('Boiler Problems');
		selbox.options[selbox.options.length] = new Option('Basement Floods');
		selbox.options[selbox.options.length] = new Option('Pump Out');
		selbox.options[selbox.options.length] = new Option('Premises without water');
		selbox.options[selbox.options.length] = new Option('Big Re-Pipe');
	} 
	if (chosen == "General Maintenance") { 
		selbox.options[selbox.options.length] = new Option('Leaking Taps');
		selbox.options[selbox.options.length] = new Option('Leaking Shower');
		selbox.options[selbox.options.length] = new Option('Other','Other');
	} 
} 
function changedate() 
{ 
	document.logcall.button.disabled = true;
	document.logcall.errmsg2.value = "Select time";
} 
function changetime() 
{ 
	document.logcall.button.disabled = false;
	document.logcall.errmsg2.value = "";
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

if ($_POST['typeID']) {
	$typeID = $_POST['typeID'];
} else {
	$typeID = $_GET['typeID'];
}
if ($_POST['call_status']) {
	$call_status = $_POST['call_status'];
} else {
	$call_status = $_GET['call_status'];
}

$colname_address = "-1";
if (isset($_GET['addressID'])) {
	$colname_address = $_GET['addressID'];
} else {
	$colname_address = $_POST['addressID'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", GetSQLValueString($colname_address, "int"));
$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
$row_address = mysql_fetch_assoc($address);
$totalRows_address = mysql_num_rows($address);

mysql_select_db($database_adhocConn, $adhocConn);
$query_categories = "SELECT * FROM categories ORDER BY category ASC";
$categories = mysql_query($query_categories, $adhocConn) or die(mysql_error());
$row_categories = mysql_fetch_assoc($categories);
$totalRows_categories = mysql_num_rows($categories);

mysql_select_db($database_adhocConn, $adhocConn);
$query_lastcall_client = sprintf("SELECT * FROM call_log WHERE clientID = %s ORDER BY logID DESC", $row_address['clientID']);
$lastcall_client = mysql_query($query_lastcall_client, $adhocConn) or die(mysql_error());
$row_lastcall_client = mysql_fetch_assoc($lastcall_client);
$totalRows_lastcall_client = mysql_num_rows($lastcall_client);

mysql_select_db($database_adhocConn, $adhocConn);
$query_lastcall_address = sprintf("SELECT * FROM call_log WHERE addressID = %s ORDER BY logID DESC", $row_address['addressID']);
$lastcall_address = mysql_query($query_lastcall_address, $adhocConn) or die(mysql_error());
$row_lastcall_address = mysql_fetch_assoc($lastcall_address);
$totalRows_lastcall_address = mysql_num_rows($lastcall_address);

mysql_select_db($database_adhocConn, $adhocConn);
$query_client = sprintf("SELECT * FROM clients WHERE clientID = %s", $row_address['clientID']);
$client = mysql_query($query_client, $adhocConn) or die($query_client);
$row_client = mysql_fetch_assoc($client);
$totalRows_client = mysql_num_rows($client);
?>
<?php require_once('inc_before.php'); ?>
<?php if (!($_GET['edit'])) { ?>
              <p>Log <?php if ($_GET['typeID'] == 1) { echo "Quote"; } ?><?php if ($_GET['typeID'] == 2) { echo "Job"; } ?><?php if ($_GET['typeID'] == 3) { echo "Patch"; } ?></p><?php } else { ?>
              <p>Edit</p>
              <?php } ?>
<blockquote>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="60%" valign="top"><p>The Address:</p>
        <form id="update_address" name="update_address" method="post" action="update_address.php">
          <table width="95%" border="1" align="center" cellpadding="3" cellspacing="0">
            <tr>
              <td><div align="right">Unit No:</div></td>
              <td><input name="unitno" type="text" class="maintext" id="unitno" value="<?php echo $row_address['unitno']; ?>" size="2" />              </td>
            </tr>
            <tr>
              <td><div align="right">Complex:</div></td>
              <td><input name="complex" type="text" class="maintext" id="complex" value="<?php echo $row_address['complex']; ?>" size="15" /></td>
            </tr>
            <tr>
              <td><div align="right">Street No:</div></td>
              <td><input name="streetno" type="text" class="maintext" id="streetno" value="<?php echo $row_address['streetno']; ?>" size="2" /></td>
            </tr>
            <tr>
              <td><div align="right">Street Name:</div></td>
              <td><input name="street" type="text" class="maintext" id="street" value="<?php echo $row_address['street']; ?>" size="15" /></td>
            </tr>
            <tr>
              <td><div align="right">Suburb:</div></td>
              <td><?php
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_sname = sprintf("SELECT * FROM suburbs WHERE suburbID = %s", $row_address['suburb']);
			$sname = mysql_query($query_sname, $adhocConn) or die(mysql_error());
			$row_sname = mysql_fetch_assoc($sname);
			$totalRows_sname = mysql_num_rows($sname);
			echo $row_sname['suburb'];
			mysql_free_result($sname);
	  ?></td>
            </tr>
            <tr>
              <td><div align="right">Region:</div></td>
              <td><?php
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_rname = sprintf("SELECT * FROM regions WHERE regionID = %s", $row_address['region']);
			$rname = mysql_query($query_rname, $adhocConn) or die(mysql_error());
			$row_rname = mysql_fetch_assoc($rname);
			$totalRows_rname = mysql_num_rows($rname);
			echo $row_rname['region'];
			mysql_free_result($rname);
	  ?></td>
            </tr>
            <tr>
              <td><div align="right">Province:</div></td>
              <td><?php
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_pname = sprintf("SELECT * FROM provinces WHERE provinceID = %s", $row_address['province']);
			$pname = mysql_query($query_pname, $adhocConn) or die(mysql_error());
			$row_pname = mysql_fetch_assoc($pname);
			$totalRows_pname = mysql_num_rows($pname);
			echo $row_pname['province'];
			mysql_free_result($pname);
	  ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="addressID" type="hidden" id="addressID" value="<?php echo $_GET['addressID']; ?>" />
                  <input type="hidden" name="MM_update" value="update_address" />
                  <input type="hidden" name="typeID" id="typeID" value="<?php echo $typeID; ?>" />
                  <input type="hidden" name="call_status" id="call_status" value="<?php echo $call_status; ?>" />
                  <input name="button2" type="submit" class="maintext" id="button2" value="UPDATE" /></td>
            </tr>
          </table>
        </form>
        <p>The Client: </p>
        <form id="update_client" name="update_client" method="post" action="update_client.php">
          <table width="95%" border="1" align="center" cellpadding="3" cellspacing="0">
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
              <td><select name="paymethod" class="maintext" id="paymethod" onchange="validate()">
                  <option value="Cash" <?php if (!(strcmp("Cash", $row_client['paymethod']))) {echo "selected=\"selected\"";} ?>>Cash</option>
                  <option value="Cheque" <?php if (!(strcmp("Cheque", $row_client['paymethod']))) {echo "selected=\"selected\"";} ?>>Cheque</option>
                  <option value="Electronic" <?php if (!(strcmp("Electronic", $row_client['paymethod']))) {echo "selected=\"selected\"";} ?>>Electronic</option>
                  <option value="Account" <?php if (!(strcmp("Account", $row_client['paymethod']))) {echo "selected=\"selected\"";} ?>>Account</option>
                </select>              </td>
            </tr>
            <tr>
              <td><div align="right">ID No:</div></td>
              <td><input name="idno" type="text" class="maintext" id="idno" value="<?php echo $row_client['idno']; ?>" size="15" onKeyUp="validate()" /></td>
            </tr>
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
                  <option value="Corporate Account" <?php if (!(strcmp("Corporate Account", $row_client['whereheard']))) {echo "selected=\"selected\"";} ?>>Corporate Account</option>
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
                  <input name="clientID" type="hidden" id="clientID" value="<?php echo $row_address['clientID']; ?>" />
                  <input type="hidden" name="MM_update" value="update_client" />
                  <input type="hidden" name="typeID" id="typeID" value="<?php echo $typeID; ?>" />
                  <input type="hidden" name="call_status" id="call_status" value="<?php echo $call_status; ?>" />
                  <input name="button3" type="submit" class="maintext" id="button3" value="UPDATE" onmouseover="validate()" />
                    <input name="errmsg" type="text" class="errbox" id="errmsg" value="" size="15" /></td>
            </tr>
          </table>
        </form>
        <?php if (!($_GET['edit'])) { ?>
        <p>The Details: </p>
        <form id="logcall" name="logcall" method="post" action="log_call.php">
          <table width="95%" border="1" align="center" cellpadding="3" cellspacing="0">
            <tr>
              <td>Type of Quote:</td>
              <td><select name="typeID" class="maintext" id="typeID">
                <option value="2" <?php if (!(strcmp(2, $typeID))) {echo "selected=\"selected\"";} ?>>Job</option>
                <option value="3" <?php if (!(strcmp(3, $typeID))) {echo "selected=\"selected\"";} ?>>Patch</option>
              </select></td>
            </tr>
            <tr>
              <td>Nature of Call:</td>
              <td><select name="nature" class="maintext" id="nature" onchange="setOptions(document.logcall.nature.options[document.logcall.nature.selectedIndex].value);">
                  <option>please select...</option>
                  <option value="Blockages">Blockages</option>
                  <option value="Burst Pipes">Burst Pipes</option>
                  <option value="Construction">Construction</option>
                  <option value="General Maintenance">General Maintenance</option>
                  <option value="Geyser Repairs">Geyser Repairs</option>
                  <option value="Geyser Replacements">Geyser Replacements</option>
                  <option value="Industrial Work">Industrial Work</option>
                  <option value="Seeping Water">Seeping Water</option>
                  <option value="Service Toilet">Service Toilet</option>
                  <option value="Solar Geyser">Solar Geyser</option>
                  <option value="Toilet/Urinal Flushmaster">Toilet/Urinal Flushmaster</option>
                </select>
                  <br />
                  <select name="naturedetail" class="maintext" id="naturedetail" onchange="validate2()">
                  </select>              </td>
            </tr>
            <tr>
              <td><div align="right">Other:</div></td>
              <td><input name="other" type="text" class="maintext" id="other" size="25" onKeyUp="validate2()" /></td>
            </tr>
            <tr>
              <td>Contact Person:</td>
              <td><input name="caller" type="text" class="maintext" id="caller" value="<?php echo $_POST['caller']; ?>" size="15" /></td>
            </tr>
            <tr>
              <td>Contact Number:</td>
              <td><input name="telno1" type="text" class="maintext" id="telno1" value="<?php echo $_POST['telno1']; ?>" size="15" /></td>
            </tr>
            <tr>
              <td>Access Amount:</td>
              <td><input name="access_amt" type="text" class="maintext" id="access_amt" value="<?php echo $_POST['access_amt']; ?>" value="0.00" size="15" maxlength="15" /></td>
            </tr>
            <tr>
              <td>Payment Method:</td>
              <td><select name="access_pmt_method" class="maintext" id="access_pmt_method">
                  <option value="">n/a</option>
                  <option value="Cash">Cash</option>
                  <option value="Cheque">Cheque</option>
                  <option value="Electronic">Electronic</option>
                  <option value="Account">Account</option>
                </select>              </td>
            </tr>
            <tr>
              <td>Order No:</td>
              <td><input name="order_no" type="text" class="maintext" id="order_no" value="<?php echo $_POST['order_no']; ?>" size="15" maxlength="15" /></td>
            </tr>
            <tr>
              <td>Policy No:</td>
              <td><input name="policy_no" type="text" class="maintext" id="policy_no" value="<?php echo $_POST['policy_no']; ?>" size="15" maxlength="15" /></td>
            </tr>
            <tr>
              <td>Claim No:</td>
              <td><input name="claim_no" type="text" class="maintext" id="claim_no" value="<?php echo $_POST['claim_no']; ?>" size="15" maxlength="15" /></td>
            </tr>
            <tr>
              <td>Reference No:</td>
              <td><input name="reference_no" type="text" class="maintext" id="reference_no" value="<?php echo $_POST['reference_no']; ?>" size="15" maxlength="15" /></td>
            </tr>
            <tr>
              <td>Schedule Job:</td>
              <td><?php 
			$sd = getdate(time()); 
			$sd_d = $sd[mday];
			$sd_m = $sd[mon];
			$sd_y = $sd[year];
			$sd_h = $sd[hours];
			$sd_i = $sd[minutes];
			?>
          <select name="sd_d" class="Maintext" id="sd_d" onchange="changedate()">
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
          <select name="sd_m" class="Maintext" id="sd_m" onchange="changedate()">
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
          <select name="sd_y" class="Maintext" id="sd_y" onchange="changedate()">
            <option <?php if ($sd_y == "2012") {echo "SELECTED";} ?>>2012</option>
            <option <?php if ($sd_y == "2013") {echo "SELECTED";} ?>>2013</option>
            <option <?php if ($sd_y == "2014") {echo "SELECTED";} ?>>2014</option>
          </select>
          at
          <select name="sd_h" class="Maintext" id="sd_h" onchange="changetime()">
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
          </select><?php /*
          <select name="sd_i" class="Maintext" id="sd_i">
            <option <?php if ($sd_i == "00") {echo "SELECTED";} ?>>00</option>
            <option <?php if ($sd_i == "05") {echo "SELECTED";} ?>>05</option>
            <option <?php if ($sd_i == "10") {echo "SELECTED";} ?>>10</option>
            <option <?php if ($sd_i == "15") {echo "SELECTED";} ?>>15</option>
            <option <?php if ($sd_i == "20") {echo "SELECTED";} ?>>20</option>
            <option <?php if ($sd_i == "25") {echo "SELECTED";} ?>>25</option>
            <option <?php if ($sd_i == "30") {echo "SELECTED";} ?>>30</option>
            <option <?php if ($sd_i == "35") {echo "SELECTED";} ?>>35</option>
            <option <?php if ($sd_i == "40") {echo "SELECTED";} ?>>40</option>
            <option <?php if ($sd_i == "45") {echo "SELECTED";} ?>>45</option>
            <option <?php if ($sd_i == "50") {echo "SELECTED";} ?>>50</option>
            <option <?php if ($sd_i == "55") {echo "SELECTED";} ?>>55</option>
          </select>*/ ?><input name="sd_i" type="text" size="2" maxlength="2" class="Maintext" value="<?php echo $sd_i; ?>" onchange="changetime()" /></td>
            </tr>
            <tr>
              <td>Notes:</td>
              <td><textarea name="comment" cols="30" rows="5" class="smalltext"><?php echo $_POST['comment']; ?></textarea></td>
            </tr>
            <tr>
              <td>Add to Diary:</td>
              <td><input name="diary" type="checkbox" id="diary" value="1" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input name="addressID" type="hidden" id="addressID" value="<?php echo $colname_address; ?>" />
                  <input name="clientID" type="hidden" id="clientID" value="<?php echo $row_address['clientID']; ?>" />
                  <input name="comeback" type="hidden" id="comeback" value="<?php echo $_POST['comeback']; ?>" />
                  <input type="hidden" name="MM_update" value="logcall" />
                  <input type="hidden" name="call_status" id="call_status" value="<?php echo $call_status; ?>" />
                  <input name="button" type="submit" class="maintext" id="button" value="SUBMIT" onmousover="validate2()" />
                  <input name="errmsg2" type="text" class="errbox" id="errmsg2" value="" size="15" /></td>
            </tr>
          </table>
        </form>
        <?php } ?>
        </td>
      <td width="40%" valign="top" bgcolor="#C9ECF8"><p>Previous Call for this ADDRESS:</p>
        
        <?php if ($totalRows_lastcall_address > 0) { // Show if recordset not empty ?>
          <table width="90%" border="1" align="center" cellpadding="3" cellspacing="0">
            <tr>
              <td class="smalltext">Log No:</td>
              <td><?php echo $row_lastcall_address['logID']; ?></td>
            </tr>
              <tr>
                <td class="smalltext">Details:</td>
                <td class="smalltext"><?php echo $row_lastcall_address['condition']; ?></td>
              </tr>
              <tr>
                <td class="smalltext">Date:</td>
                <td class="smalltext"><?php echo date("d M Y", $row_lastcall_address['logtime']); ?></td>
              </tr>
              <tr>
                <td class="smalltext">Status:</td>
                <td class="smalltext"><?php
					mysql_select_db($database_adhocConn, $adhocConn);
					$query_cstatus = sprintf("SELECT * FROM call_statuses WHERE statusID = %s", $row_lastcall_address['call_status']);
					$cstatus = mysql_query($query_cstatus, $adhocConn) or die(mysql_error());
					$row_cstatus = mysql_fetch_assoc($cstatus);
					$totalRows_cstatus = mysql_num_rows($cstatus);
					echo $row_cstatus['status'];
					mysql_free_result($cstatus);
				?></td>
              </tr>
              <tr>
                <td class="smalltext">Invoice No:</td>
                <td class="smalltext"><?php if ($row_lastcall_address['invoice_no']) { echo $row_lastcall_address['invoice_no']; } else { echo "&nbsp;"; } ?></td>
              </tr>
              <tr>
                <td class="smalltext">Paid:</td>
				<?php if (($row_lastcall_address['paid']) && ($row_lastcall_address['paid'] == 1)) { ?>
                    <td class="smalltext">YES</td>
                <?php } else { ?>
                    <td class="smalltext" bgcolor="#FF0000">NO</td>
				<?php } ?>
              </tr>
              <tr>
                <td class="smalltext">Paid Date:</td>
                <td class="smalltext"><?php if ($row_lastcall_address['paiddate']) { echo date("d M Y", $row_lastcall_address['paiddate']); } else { echo "&nbsp;"; } ?></td>
              </tr>
                  </table><?php if ($totalRows_lastcall_address > 1) { // Show if recordset not empty ?>
          <p align="center"><a href="history_address.php?addressID=<?php echo $row_address['addressID']; ?>" class="smalltext">view full history</a></p>
          <?php } ?>
          <?php } // Show if recordset not empty ?>
        <?php if ($totalRows_lastcall_address == 0) { // Show if recordset empty ?>
          <p align="center">no previous call found</p>
          <?php } // Show if recordset empty ?>
<p align="center">&nbsp;</p>
        <p align="left">Previous Call for this CLIENT:</p>
        
        <?php if ($totalRows_lastcall_client > 0) { // Show if recordset not empty ?>
          <table width="90%" border="1" align="center" cellpadding="3" cellspacing="0">
            <tr>
              <td class="smalltext">Log No:</td>
              <td><?php echo $row_lastcall_client['logID']; ?></td>
            </tr>
            <tr>
              <td class="smalltext">Details:</td>
              <td class="smalltext"><?php echo $row_lastcall_client['condition']; ?></td>
            </tr>
            <tr>
              <td class="smalltext">Address:</td>
              <td class="smalltext"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_lastcall_client['addressID']);
						$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
						$row_address = mysql_fetch_assoc($address);
						$totalRows_address = mysql_num_rows($address);
						if (($row_address['unitno']) || ($row_address['complex'])) {
							echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
						}
						echo $row_address['streetno'] . " " . $row_address['street'];
						mysql_free_result($address);
				  ?></td>
            </tr>
            <tr>
              <td class="smalltext">Date:</td>
              <td class="smalltext"><?php echo date("d M Y", $row_lastcall_client['logtime']); ?></td>
            </tr>
            <tr>
              <td class="smalltext">Status:</td>
              <td class="smalltext"><?php
					mysql_select_db($database_adhocConn, $adhocConn);
					$query_cstatus = sprintf("SELECT * FROM call_statuses WHERE statusID = %s", $row_lastcall_client['call_status']);
					$cstatus = mysql_query($query_cstatus, $adhocConn) or die(mysql_error());
					$row_cstatus = mysql_fetch_assoc($cstatus);
					$totalRows_cstatus = mysql_num_rows($cstatus);
					echo $row_cstatus['status'];
					mysql_free_result($cstatus);
				?></td>
            </tr>
              <tr>
                <td class="smalltext">Invoice No:</td>
                <td class="smalltext"><?php if ($row_lastcall_client['invoice_no']) { echo $row_lastcall_client['invoice_no']; } else { echo "&nbsp;"; } ?></td>
              </tr>
              <tr>
                <td class="smalltext">Paid:</td>
				<?php if (($row_lastcall_client['paid']) && ($row_lastcall_client['paid'] == 1)) { ?>
                    <td class="smalltext">YES</td>
                <?php } else { ?>
                    <td class="smalltext" bgcolor="#FF0000">NO</td>
				<?php } ?>
              </tr>
            <tr>
              <td class="smalltext">Paid Date:</td>
              <td class="smalltext"><?php if ($row_lastcall_client['paiddate']) { echo date("d M Y", $row_lastcall_client['paiddate']); } else { echo "&nbsp;"; } ?></td>
            </tr>
          </table><?php if ($totalRows_lastcall_client > 1) { // Show if recordset not empty ?>
          <p align="center"><a href="history_client.php?clientID=<?php echo $row_address['clientID']; ?>" class="smalltext">view full history</a></p>
          <?php } ?>
          <?php } // Show if recordset not empty ?>
        <?php if ($totalRows_lastcall_client == 0) { // Show if recordset empty ?>
          <p align="center">no previous call found</p>
          <?php } // Show if recordset empty ?>
</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  </blockquote>
<?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($address);

mysql_free_result($categories);

mysql_free_result($lastcall_client);

mysql_free_result($lastcall_address);

mysql_free_result($client);
?>
