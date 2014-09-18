<?php require_once('Connections/adhocConn.php'); ?>
<?php require_once('inc_before.php'); ?>
<table width="100%" border="1" cellpadding="10" cellspacing="10" bordercolor="#1FA2D0">
  <tr>
    <td valign="top" nowrap="nowrap"><p align="center">Search by Address:</p>
        <form name="street" name="street" method="post" action="log_quote_step_5.php">
          <div align="center">Street:
          <select name="street" class="maintext" id="street">
            <?php
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_suburbs = sprintf("SELECT distinct street FROM addresses WHERE suburb = %s ORDER BY street ASC", $_POST['suburb']);
			$suburbs = mysql_query($query_suburbs, $adhocConn) or die(mysql_error());
			$row_suburbs = mysql_fetch_assoc($suburbs);
			$totalRows_suburbs = mysql_num_rows($suburbs);
			$extra = " WHERE suburb = " . $_POST['suburb'];
			if ($totalRows_suburbs > 0) {
				do {  
					?>
					<option value="<?php echo $row_suburbs['street']?>"><?php echo $row_suburbs['street']?></option>
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
          <input type="hidden" name="suburb" id="suburb" value="<?php echo $_POST['suburb']; ?>" />
          <input name="button4" type="submit" class="maintext" id="button3" value="GO" />
        </div>
        </form>
		<?php
        mysql_select_db($database_adhocConn, $adhocConn);
        $query_complexes = sprintf("SELECT distinct complex FROM addresses WHERE complex is not null AND complex <> '' AND suburb = %s ORDER BY complex ASC", $_POST['suburb']);
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
			  </select>
			  <br />
              <input type="hidden" name="typeID" id="typeID" value="<?php echo $_POST['typeID']; ?>" />
              <input type="hidden" name="call_status" id="call_status" value="<?php echo $_POST['call_status']; ?>" />
              <input type="hidden" name="province" id="province" value="<?php echo $_POST['province']; ?>" />
			  <input type="hidden" name="region" id="region" value="<?php echo $_POST['region']; ?>" />
			  <input type="hidden" name="suburb" id="suburb" value="<?php echo $_POST['suburb']; ?>" />
			  <input name="button5" type="submit" class="maintext" id="button3" value="GO" />
			</div>
			</form>
			<?php
			}
			mysql_free_result($complexes);
	?>
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top" nowrap="nowrap" class="smalltext"><p>Recent:</p>
      <?php require_once('_recent.php'); ?></td>
  </tr>
</table>
<?php require_once('inc_after.php'); ?>
