<?php require_once('Connections/adhocConn.php'); ?>
<?php
if (!($_COOKIE['MM_UserGroup'])) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
$colname_call = "-1";
if (isset($_GET['caseno'])) {
  $colname_call = $_GET['caseno'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_call = sprintf("SELECT * FROM call_log WHERE logID = %s", $colname_call);
$call = mysql_query($query_call, $adhocConn) or die(__LINE__.mysql_error());
$row_call = mysql_fetch_assoc($call);
$totalRows_call = mysql_num_rows($call);
?>

<?php require_once('inc_before.php'); ?>
              <p>CONFIRM DESPATCH</p>
                <p align="center" class="logbutton">CASE NUMBER: <?php echo $row_call['logID']; ?></p>
              <blockquote>
                <table border="1" align="center" bordercolor="#FFFFFF">
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" bordercolor="#F7AD6C">Despatcher:</td>
                    <td colspan="4" bordercolor="#F7AD6C"><?php
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_despatcher = sprintf("SELECT * FROM users WHERE userID = %s", $_COOKIE['MM_userID']);
							$despatcher = mysql_query($query_despatcher, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
							$row_despatcher = mysql_fetch_assoc($despatcher);
							$totalRows_despatcher = mysql_num_rows($despatcher);
							echo $row_despatcher['fullname'];
							mysql_free_result($despatcher);
					  ?></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" bordercolor="#F7AD6C">Address:</td>
                    <td colspan="4" bordercolor="#F7AD6C"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_call['addressID']);
						$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
						$row_address = mysql_fetch_assoc($address);
						$totalRows_address = mysql_num_rows($address);
						if ($row_address['unitno']) {
							echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
						}
						echo $row_address['streetno'] . " " . $row_address['street'] . "<br>";
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_suburb = sprintf("SELECT * FROM suburbs WHERE suburbID = %s", $row_address['suburb']);
						$suburb = mysql_query($query_suburb, $adhocConn) or die(mysql_error());
						$row_suburb = mysql_fetch_assoc($suburb);
						$totalRows_suburb = mysql_num_rows($suburb);
						echo $row_suburb['suburb'];
						mysql_free_result($suburb);
						mysql_free_result($address);
					  ?></td>
                  </tr>
                  
                  <tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap" bordercolor="#F7AD6C">Notes:</td>
                    <td colspan="4" bordercolor="#F7AD6C"><?php echo htmlentities($row_call['notes'], ENT_COMPAT, 'utf-8'); ?></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" bordercolor="#F7AD6C" class="maintext">Vehicle:</td>
                    <td colspan="4" bordercolor="#F7AD6C" class="maintext"><?php
					if ($row_call['vehicle1']) {
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_vehicle = sprintf("SELECT * FROM vehicles WHERE vehicleID = %s", $row_call['vehicle1']);
						$vehicle = mysql_query($query_vehicle, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_vehicle = mysql_fetch_assoc($vehicle);
						$totalRows_vehicle = mysql_num_rows($vehicle);
						echo $row_vehicle['vehicle'] . "<br>" . $row_vehicle['regno'] . "<br> [" . $row_vehicle['cellno'] . " ]";
						mysql_free_result($vehicle);
					}
					?></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" bordercolor="#FFFFFF">&nbsp;</td>
                    <td colspan="4" bordercolor="#FFFFFF">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="2" align="right" nowrap="nowrap" bordercolor="#FFFFFF">&nbsp;</td>
                    <td bordercolor="#FFFFFF">&nbsp;</td>
                    <td colspan="2" bordercolor="#FFFFFF"><div align="right" class="logbutton">
                      <div align="center"><a href="control_panel.php">CONFIRM</a></div>
                    </div></td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                </blockquote>              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($call);
?>