<?php require_once('Connections/adhocConn.php'); 
$addcomplex = 0;
$addstreetno = 0;
$addunitno = 0;
$addressfound = 0;
$addaddress = 0;
$complex = 2;
if ($_POST['complex'] == "add") {
	$addcomplex = 1;
}
if (($_POST['streetno']) && ($_POST['streetno'] == "add")) {
	$addstreetno = 1;
} else {
	if ($_POST['streetno']) {
		$addressfound = 1;
		$complex = 0;
	}
}
if (($_POST['unitno']) && ($_POST['unitno'] == "add")) {
	$addunitno = 1;
} else {
	if ($_POST['unitno']) {
		$addressfound = 1;
		$complex = 1;
	}
}
if ($addressfound == 1) {
	mysql_select_db($database_adhocConn, $adhocConn);
	if ($complex == 1) {
		$query_address = sprintf("SELECT * FROM addresses WHERE suburb = %s AND street = '%s' AND complex = '%s' AND unitno = %s", $_POST['suburb'], $_POST['street'], $_POST['complex'], $_POST['unitno']);
	}
	if ($complex == 0) {
		$query_address = sprintf("SELECT * FROM addresses WHERE suburb = %s AND street = '%s' AND streetno = '%s'", $_POST['suburb'], $_POST['street'], $_POST['streetno']);
	}
	$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
	$row_address = mysql_fetch_assoc($address);
	$totalRows_address = mysql_num_rows($address);
	$addressID = $row_address['addressID'];
	$clientID = $row_address['clientID'];
	mysql_free_result($address);
	
	$foundGoTo = "log_quote_step_8.php?addressID=" . $addressID . "&typeID=" . $_POST['typeID'] . "&call_status=" . $_POST['call_status'];
	header(sprintf("Location: %s", $foundGoTo));
} else {
	if ($complex != 2) {
		$addaddress = 1;
	}
}
?>
<?php require_once('inc_before.php'); ?>
<table width="100%" border="1" cellpadding="10" cellspacing="10" bordercolor="#1FA2D0">
  <tr>
    <td valign="top" nowrap="nowrap">
    
    
    <?php if ($addstreet + $addcomplex + $addstreetno + $addunitno == 0) { ?>
    <p align="center">Search by Address:</p>
        <form name="unitno" name="unitno" method="post" action="log_quote_step_7.php">
          <div align="center"><?php echo $_POST['complex']; ?> - Unit No: 
            <select name="unitno" class="maintext" id="unitno">
				<?php
				mysql_select_db($database_adhocConn, $adhocConn);
				if ($_POST['region']) {
					$query_complexes = sprintf("SELECT distinct unitno FROM addresses WHERE complex = '%s' AND region = %s ORDER BY complex ASC", $_POST['complex'], $_POST['region']);
					$extra = " WHERE complex = '" . $_POST['complex'] . "' AND region = " . $_POST['region'];
				} else {
					if ($_POST['suburb']) {
						$query_complexes = sprintf("SELECT distinct unitno FROM addresses WHERE complex = '%s' AND suburb = %s ORDER BY complex ASC", $_POST['complex'], $_POST['suburb']);
						$extra = " WHERE complex = '" . $_POST['complex'] . "' AND suburb = " . $_POST['suburb'];
					} else {
						$query_complexes = sprintf("SELECT distinct unitno FROM addresses WHERE complex = '%s' AND street = '%s' ORDER BY complex ASC", $_POST['complex'], $_POST['street']);
						$extra = " WHERE complex = '" . $_POST['complex'] . "' AND street = '" . $_POST['street'] . "'";
					}
				}
				$complexes = mysql_query($query_complexes, $adhocConn) or die(mysql_error());
				$row_complexes = mysql_fetch_assoc($complexes);
				$totalRows_complexes = mysql_num_rows($complexes);
				if ($totalRows_complexes > 0) {
					do {  
						?>
						<option value="<?php echo $row_complexes['unitno']?>"><?php echo $row_complexes['unitno']?></option>
						<?php
					} while ($row_complexes = mysql_fetch_assoc($complexes));
					$rows = mysql_num_rows($complexes);
					if($rows > 0) {
					  mysql_data_seek($complexes, 0);
					  $row_complexes = mysql_fetch_assoc($complexes);
					}
				?>
                <option value="add">ADD</option>
			  </select>
			  <br />
              <input type="hidden" name="province" id="province" value="<?php echo $_POST['province']; ?>" />
              <input type="hidden" name="region" id="region" value="<?php echo $_POST['region']; ?>" />
              <input type="hidden" name="street" id="street" value="<?php
						if ($_POST['street']) {
							echo $_POST['street']; 
							$streetname = $_POST['street'];
						} else {
							// find street
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_street = sprintf("SELECT * FROM addresses WHERE suburb = %s AND complex = '%s'", $_POST['suburb'], $_POST['complex']);
							$street = mysql_query($query_street, $adhocConn) or die(mysql_error());
							$row_street = mysql_fetch_assoc($street);
							$totalRows_street = mysql_num_rows($street);
							echo $row_street['street'];
							$streetname = $row_street['street'];
							mysql_free_result($street);
						}
			  ?>" />
              <input type="hidden" name="suburb" id="suburb" value="<?php echo $_POST['suburb']; ?>" />
              <input type="hidden" name="complex" id="complex" value="<?php echo $_POST['complex']; ?>" />
              <input type="hidden" name="typeID" id="typeID" value="<?php echo $_POST['typeID']; ?>" />
              <input type="hidden" name="call_status" id="call_status" value="<?php echo $_POST['call_status']; ?>" />
			  <input name="button5" type="submit" class="maintext" id="button3" value="GO" />
			</div>
			</form>
			<?php
			}
			mysql_free_result($complexes);
	?>
    <?php } ?>
    
    
    <?php if ($addstreetno == 1) { ?>
        <p align="center">Add a Street Number:</p>
        <form id="form1" name="form1" method="post" action="add_street_no.php">
        <p align="center">
              <table border="0" align="center" cellpadding="3" cellspacing="0">
                <tr>
                  <td><div align="right">Suburb:</div></td>
                  <td><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_subname = sprintf("SELECT * FROM suburbs WHERE suburbID = %s", $_POST['suburb']);
						$subname = mysql_query($query_subname, $adhocConn) or die(mysql_error());
						$row_subname = mysql_fetch_assoc($subname);
						$totalRows_subname = mysql_num_rows($subname);
						echo $row_subname['suburb'];
						mysql_free_result($subname);
				  ?><input type="hidden" name="suburb" id="suburb" value="<?php echo $_POST['suburb'];?>" />
                    <input type="hidden" name="province" id="province" value="<?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_prov = sprintf("SELECT * FROM regions WHERE regionID = %s", $_POST['region']);
						$prov = mysql_query($query_prov, $adhocConn) or die(mysql_error());
						$row_prov = mysql_fetch_assoc($prov);
						$totalRows_prov = mysql_num_rows($prov);
						echo $row_prov['provinceID'];
						mysql_free_result($prov);
				  ?>" />
                    <input type="hidden" name="region" id="region" value="<?php echo $_POST['region']; ?>" />
				  </td>
                </tr>
                <tr>
                  <td><div align="right">Enter street name:</div></td>
                  <td><input type="hidden" name="street" id="street" value="<?php echo $_POST['street']; ?>" /><?php echo $_POST['street']; ?></td>
                </tr>
                <tr>
                  <td><div align="right">Enter street no:</div></td>
                  <td><input name="streetno" type="text" class="maintext" id="streetno" size="2" /></td>
                </tr>
                <tr>
                  <td><div align="right">Enter complex:</div></td>
                  <td><input name="complex" type="text" class="maintext" id="complex" size="15" /> 
                    (optional)</td>
                </tr>
                <tr>
                  <td><div align="right">Enter unit no:</div></td>
                  <td><input name="unitno" type="text" class="maintext" id="unitno" size="2" /> 
                    (optional)</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>
                  <input type="hidden" name="MM_insert" value="form1" />
                  <input type="hidden" name="typeID" id="typeID" value="<?php echo $_POST['typeID']; ?>" />
                  <input type="hidden" name="call_status" id="call_status" value="<?php echo $_POST['call_status']; ?>" />
                  <input name="button" type="submit" class="maintext" id="button" value="ADD" /></td>
                </tr>
              </table>
        </form>
        </p>
    <?php } ?>
    
    
    <?php if ($addcomplex == 1) { ?>
        <p align="center">Add a Complex:</p>
        <form id="form1" name="form1" method="post" action="add_complex.php">
        <p align="center">
              <table border="0" align="center" cellpadding="3" cellspacing="0">
                <tr>
                  <td><div align="right">Suburb:</div></td>
                  <td><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_subname = sprintf("SELECT * FROM suburbs WHERE suburbID = %s", $_POST['suburb']);
						$subname = mysql_query($query_subname, $adhocConn) or die(mysql_error());
						$row_subname = mysql_fetch_assoc($subname);
						$totalRows_subname = mysql_num_rows($subname);
						echo $row_subname['suburb'];
						mysql_free_result($subname);
				  ?><input type="hidden" name="suburb" id="suburb" value="<?php echo $_POST['suburb'];?>" />
                    <input type="hidden" name="province" id="province" value="<?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_prov = sprintf("SELECT * FROM regions WHERE regionID = %s", $_POST['region']);
						$prov = mysql_query($query_prov, $adhocConn) or die(mysql_error());
						$row_prov = mysql_fetch_assoc($prov);
						$totalRows_prov = mysql_num_rows($prov);
						echo $row_prov['provinceID'];
						mysql_free_result($prov);
				  ?>" />
                    <input type="hidden" name="region" id="region" value="<?php echo $_POST['region']; ?>" />
				  </td>
                </tr>
                <tr>
                  <td><div align="right">Enter street name:</div></td>
                  <td><input type="hidden" name="street" id="street" value="<?php echo $_POST['street']; ?>" /><?php echo $_POST['street']; ?></td>
                </tr>
                <tr>
                  <td><div align="right">Enter street no:</div></td>
                  <td><input name="streetno" type="text" class="maintext" id="streetno" size="2" /></td>
                </tr>
                <tr>
                  <td><div align="right">Enter complex:</div></td>
                  <td><input name="complex" type="text" class="maintext" id="complex" size="15" /> 
                    </td>
                </tr>
                <tr>
                  <td><div align="right">Enter unit no:</div></td>
                  <td><input name="unitno" type="text" class="maintext" id="unitno" size="2" /> 
                    </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>
                  <input type="hidden" name="typeID" id="typeID" value="<?php echo $_POST['typeID']; ?>" />
                  <input type="hidden" name="call_status" id="call_status" value="<?php echo $_POST['call_status']; ?>" />
                  <input type="hidden" name="MM_insert" value="form1" />
                  <input name="button" type="submit" class="maintext" id="button" value="ADD" /></td>
                </tr>
              </table>
        </form>
        </p>
    <?php } ?>
    
    
    <?php if ($addunitno == 1) { ?>
        <p align="center">Add a Unit Number:</p>
        <form id="form1" name="form1" method="post" action="add_unit_no.php">
        <p align="center">
              <table border="0" align="center" cellpadding="3" cellspacing="0">
                <tr>
                  <td><div align="right">Suburb:</div></td>
                  <td><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_subname = sprintf("SELECT * FROM suburbs WHERE suburbID = %s", $_POST['suburb']);
						$subname = mysql_query($query_subname, $adhocConn) or die(mysql_error());
						$row_subname = mysql_fetch_assoc($subname);
						$totalRows_subname = mysql_num_rows($subname);
						echo $row_subname['suburb'];
						mysql_free_result($subname);
				  ?><input type="hidden" name="suburb" id="suburb" value="<?php echo $_POST['suburb'];?>" />
                    <input type="hidden" name="province" id="province" value="<?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_prov = sprintf("SELECT * FROM regions WHERE regionID = %s", $_POST['region']);
						$prov = mysql_query($query_prov, $adhocConn) or die(mysql_error());
						$row_prov = mysql_fetch_assoc($prov);
						$totalRows_prov = mysql_num_rows($prov);
						echo $row_prov['provinceID'];
						mysql_free_result($prov);
				  ?>" />
                    <input type="hidden" name="region" id="region" value="<?php echo $_POST['region']; ?>" />
				  </td>
                </tr>
                <tr>
                  <td><div align="right">Street name:</div></td>
                  <td><input type="hidden" name="street" id="street" value="<?php
						if ($_POST['street']) {
							echo $_POST['street']; 
							$streetname = $_POST['street'];
						} else {
							// find street
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_street = sprintf("SELECT * FROM addresses WHERE suburb = %s AND complex = '%s'", $_POST['suburb'], $_POST['complex']);
							$street = mysql_query($query_street, $adhocConn) or die(mysql_error());
							$row_street = mysql_fetch_assoc($street);
							$totalRows_street = mysql_num_rows($street);
							echo $row_street['street'];
							$streetname = $row_street['street'];
							//$streetnum = $row_street['streetno'];
							mysql_free_result($street);
						}
				   ?>" /><?php echo $streetname; ?></td>
                </tr>
                <tr>
                  <td><div align="right">Street no:</div></td>
                  <td><input type="hidden" name="streetno" id="streetno" value="<?php 
						if ($_POST['streetno']) {
							echo $_POST['streetno']; 
							$streetnum = $_POST['streetno'];
						} else {
							// find streetno
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_streetno = sprintf("SELECT * FROM addresses WHERE suburb = %s AND street = '%s'", $_POST['suburb'], $streetname);
							$streetno = mysql_query($query_streetno, $adhocConn) or die(mysql_error());
							$row_streetno = mysql_fetch_assoc($streetno);
							$totalRows_streetno = mysql_num_rows($streetno);
							echo $row_streetno['streetno'];
							$streetnum = $row_streetno['streetno'];
							mysql_free_result($streetno);
						}
				  ?>" /><?php echo $streetnum; ?></td>
                </tr>
                <tr>
                  <td><div align="right">Complex:</div></td>
                  <td><input type="hidden" name="complex" id="complex" value="<?php echo $_POST['complex']; ?>" /><?php echo $_POST['complex']; ?> 
                    </td>
                </tr>
                <tr>
                  <td><div align="right">Enter unit no:</div></td>
                  <td><input name="unitno" type="text" class="maintext" id="unitno" size="2" /> 
                    </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>
                  <input type="hidden" name="typeID" id="typeID" value="<?php echo $_POST['typeID']; ?>" />
                  <input type="hidden" name="call_status" id="call_status" value="<?php echo $_POST['call_status']; ?>" />
                  <input type="hidden" name="MM_insert" value="form1" />
                  <input name="button" type="submit" class="maintext" id="button" value="ADD" /></td>
                </tr>
              </table>
        </form>
        </p>
    <?php } ?>
    </td>
  </tr>
    <?php if ($addstreet + $addcomplex + $addstreetno + $addunitno == 0) { ?>
  <tr>
    <td valign="top" nowrap="nowrap" class="smalltext"><p>Recent:</p>
      <?php require_once('_recent.php'); ?></td>
  </tr>
    <?php } ?>
</table>
<?php require_once('inc_after.php'); ?>
