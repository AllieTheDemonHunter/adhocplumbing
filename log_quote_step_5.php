<?php require_once('Connections/adhocConn.php'); 
if ($_POST['street'] == "add") {
	$addstreet = 1;
}
?>
<?php require_once('inc_before.php'); ?>
<table width="100%" border="1" cellpadding="10" cellspacing="10" bordercolor="#1FA2D0">
  <tr>
    <td valign="top" nowrap="nowrap">
    
    
    <?php if ($addstreet == 0) { ?>
    <p align="center">Search by Address:</p>
        <form name="streetno" name="streetno" method="post" action="log_quote_step_7.php">
          <div align="center"><?php echo $_POST['street']; ?> - Street No:
          <select name="streetno" class="maintext" id="streetno">
            <?php
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_suburbs = sprintf("SELECT distinct streetno FROM addresses WHERE street = '%s' AND suburb = %s ORDER BY streetno ASC", $_POST['street'], $_POST['suburb']);
			$suburbs = mysql_query($query_suburbs, $adhocConn) or die(mysql_error());
			$row_suburbs = mysql_fetch_assoc($suburbs);
			$totalRows_suburbs = mysql_num_rows($suburbs);
			$extra = " WHERE street = '" . $_POST['street'] . "' AND suburb = " . $_POST['suburb'];
			if ($totalRows_suburbs > 0) {
				do {  
					?>
					<option value="<?php echo $row_suburbs['streetno']?>"><?php echo $row_suburbs['streetno']?></option>
					<?php
				} while ($row_suburbs = mysql_fetch_assoc($suburbs));
				$rows = mysql_num_rows($suburbs);
				if($rows > 0) {
				  mysql_data_seek($suburbs, 0);
				  $row_suburbs = mysql_fetch_assoc($suburbs);
				}
			}
			mysql_free_result($suburbs);
			?>
            <option value="add">ADD</option>
          </select>
          <br />
          <input type="hidden" name="typeID" id="typeID" value="<?php echo $_POST['typeID']; ?>" />
          <input type="hidden" name="call_status" id="call_status" value="<?php echo $_POST['call_status']; ?>" />
          <input type="hidden" name="province" id="province" value="<?php echo $_POST['province']; ?>" />
          <input type="hidden" name="region" id="region" value="<?php echo $_POST['region']; ?>" />
          <input type="hidden" name="street" id="street" value="<?php echo $_POST['street']; ?>" />
          <input type="hidden" name="suburb" id="suburb" value="<?php echo $_POST['suburb']; ?>" />
          <input name="button4" type="submit" class="maintext" id="button3" value="GO" />
        </div>
        </form>
		<?php
        mysql_select_db($database_adhocConn, $adhocConn);
        $query_complexes = sprintf("SELECT distinct complex FROM addresses WHERE street = '%s' AND suburb = %s ORDER BY complex ASC", $_POST['street'], $_POST['suburb']);
        $complexes = mysql_query($query_complexes, $adhocConn) or die(mysql_error());
        $row_complexes = mysql_fetch_assoc($complexes);
        $totalRows_complexes = mysql_num_rows($complexes);
        if ($totalRows_complexes > 0) {
			?>
			  <div align="center">
			OR<br />
			<form name="complex" name="complex" method="post" action="log_quote_step_7.php">Complex:
			  <select name="complex" class="maintext" id="complex">
				<?php
					do {  
						?>
						<option value="<?php echo $row_complexes['complex']?>"><?php echo $row_complexes['complex']?></option>
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
              <input type="hidden" name="typeID" id="typeID" value="<?php echo $_POST['typeID']; ?>" />
              <input type="hidden" name="call_status" id="call_status" value="<?php echo $_POST['call_status']; ?>" />
              <input type="hidden" name="province" id="province" value="<?php echo $_POST['province']; ?>" />
			  <input type="hidden" name="region" id="region" value="<?php echo $_POST['region']; ?>" />
			  <input type="hidden" name="suburb" id="suburb" value="<?php echo $_POST['suburb']; ?>" />
              <input type="hidden" name="street" id="street" value="<?php echo $_POST['street']; ?>" />
			  <input name="button5" type="submit" class="maintext" id="button3" value="GO" />
			</div>
			</form>
			<?php
			}
			mysql_free_result($complexes);
	?>
    <?php } ?>
    
    
    <?php if ($addstreet == 1) { ?>
        <p align="center">Add a Street:</p>
        <form id="form1" name="form1" method="post" action="add_street.php">
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
                  <td><input name="street" type="text" class="maintext" id="street" size="15" /></td>
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
    <?php if ($addstreet != 1) { ?>
  <tr>
    <td colspan="3" valign="top" nowrap="nowrap" class="smalltext"><p>Recent:</p>
      <?php require_once('_recent.php'); ?></td>
  </tr>
    <?php } ?>
</table>
<?php require_once('inc_after.php'); ?>
