<?php require_once('Connections/adhocConn.php'); ?>
<?php require_once('inc_before.php'); ?>
<table width="100%" border="1" cellpadding="10" cellspacing="10" bordercolor="#1FA2D0">
  <tr>
    <td valign="top" nowrap="nowrap"><p align="center">Search by Address:</p>
        <form name="streetno" name="streetno" method="post" action="log_quote_step_6.php">
          <div align="center"><?php echo $_POST['street']; ?> - Street No:
          <select name="streetno" class="maintext" id="streetno">
            <?php
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_suburbs = sprintf("SELECT distinct streetno FROM addresses WHERE street = '%s' AND suburb = %s ORDER BY street ASC", $_POST['street'], $_POST['suburb']);
			$suburbs = mysql_query($query_suburbs, $adhocConn) or die(mysql_error());
			$row_suburbs = mysql_fetch_assoc($suburbs);
			$totalRows_suburbs = mysql_num_rows($suburbs);
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
              <input type="hidden" name="street" id="street" value="<?php echo $_POST['street']; ?>" />
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
      <table width="100%" border="1" cellspacing="0" cellpadding="3">
        <tr>
          <td class="fineprint">Client</td>
          <td class="fineprint">Address</td>
          <td class="fineprint">Contact</td>
          <td class="fineprint">Type</td>
          <td class="fineprint">Status</td>
          <td class="fineprint">Added</td>
          <td class="fineprint">Category</td>
          <td class="fineprint">&nbsp;</td>
          </tr>
        <tr>
          <td valign="top" class="fineprint">Huurkor</td>
          <td valign="top" class="fineprint">25 Main Place<br />
            1 Sullivan Street, Lyttelton</td>
          <td valign="top" class="fineprint">Michael Kabini<br />
            082 345 6789</td>
          <td valign="top" class="fineprint">Geyser</td>
          <td valign="top" bgcolor="#FF0000" class="fineprint">&nbsp;</td>
          <td valign="top" class="fineprint">12:15</td>
          <td valign="top" class="fineprint">Huurkor</td>
          <td valign="top" class="fineprint"><a href="#">edit</a></td>
          </tr>
        <tr>
          <td valign="top" class="fineprint">Cobus Swartz</td>
          <td valign="top" class="fineprint">45 Glover Street, Wierda Park</td>
          <td valign="top" class="fineprint">Cobus Swartz<br />
            012 987 6543</td>
          <td valign="top" class="fineprint">Burst pipe</td>
          <td valign="top" bgcolor="#FF0000" class="fineprint">&nbsp;</td>
          <td valign="top" class="fineprint">12:01</td>
          <td valign="top" class="fineprint">Insurance</td>
          <td valign="top" class="fineprint"><a href="#">edit</a></td>
        </tr>
        <tr>
          <td valign="top" class="fineprint">Janine Geldenhuys</td>
          <td valign="top" class="fineprint">2 Villa Toscana<br />
            56 South Street, Die Hoewes</td>
          <td valign="top" class="fineprint">Janine<br />
            083 214 56778</td>
          <td valign="top" class="fineprint">Geyser</td>
          <td valign="top" bgcolor="#FFFF00" class="fineprint">&nbsp;</td>
          <td valign="top" class="fineprint">11:36</td>
          <td valign="top" class="fineprint">Private</td>
          <td valign="top" class="fineprint"><a href="#">edit</a></td>
        </tr>
        <tr>
          <td valign="top" class="fineprint">Huurkor</td>
          <td valign="top" class="fineprint">312 The Towers<br />
            33 Cantonments Rd, Lyttelton</td>
          <td valign="top" class="fineprint">Werner Bronkhorst<br />
            084 567 8901</td>
          <td valign="top" class="fineprint">Toilet</td>
          <td valign="top" bgcolor="#FFFF00" class="fineprint">&nbsp;</td>
          <td valign="top" class="fineprint">10:48</td>
          <td valign="top" class="fineprint">Huurkor</td>
          <td valign="top" class="fineprint"><a href="#">edit</a></td>
        </tr>
        <tr>
          <td valign="top" class="fineprint">Thabo Mokoena</td>
          <td valign="top" class="fineprint">12 River Street, Highveld</td>
          <td valign="top" class="fineprint">Lettie Mokoena<br />
            082 558 8996</td>
          <td valign="top" class="fineprint">Water leak</td>
          <td valign="top" bgcolor="#FFFF00" class="fineprint">&nbsp;</td>
          <td valign="top" class="fineprint">10:41</td>
          <td valign="top" class="fineprint">Insurance</td>
          <td valign="top" class="fineprint"><a href="#">edit</a></td>
        </tr>
        <tr>
          <td valign="top" class="fineprint">Carel de Wet</td>
          <td valign="top" class="fineprint">435 West Street, Clubview</td>
          <td valign="top" class="fineprint">Carel<br />
            012 667 8965</td>
          <td valign="top" class="fineprint">Geyser</td>
          <td valign="top" bgcolor="#FFFF00" class="fineprint">&nbsp;</td>
          <td valign="top" class="fineprint">10:13</td>
          <td valign="top" class="fineprint">Insurance</td>
          <td valign="top" class="fineprint"><a href="#">edit</a></td>
        </tr>
        <tr>
          <td valign="top" class="fineprint">Danie Bouwer</td>
          <td valign="top" class="fineprint">12 Klip Street, Zwartkops</td>
          <td valign="top" class="fineprint">Danie<br />
            072 245 8965</td>
          <td valign="top" class="fineprint">Geyser</td>
          <td valign="top" bgcolor="#FFFF00" class="fineprint">&nbsp;</td>
          <td valign="top" class="fineprint">09:50</td>
          <td valign="top" class="fineprint">Insurance</td>
          <td valign="top" class="fineprint"><a href="#">edit</a></td>
        </tr>
        <tr>
          <td valign="top" class="fineprint">Peter Christensen</td>
          <td valign="top" class="fineprint">76 El Devino<br />
            Sullivan Street, Die Hoewes</td>
          <td valign="top" class="fineprint">Jenny Burger<br />
            076 654 3211</td>
          <td valign="top" class="fineprint">Burst pipe</td>
          <td valign="top" bgcolor="#FFFF00" class="fineprint">&nbsp;</td>
          <td valign="top" class="fineprint">09:41</td>
          <td valign="top" class="fineprint">Private</td>
          <td valign="top" class="fineprint"><a href="#">edit</a></td>
        </tr>
        <tr>
          <td valign="top" class="fineprint">Joan de Oliveira</td>
          <td valign="top" class="fineprint">812 Jean Ave, Doringkloof</td>
          <td valign="top" class="fineprint">Joan<br />
            0833 667 7889</td>
          <td valign="top" class="fineprint">Geyser</td>
          <td valign="top" bgcolor="#FFFF00" class="fineprint">&nbsp;</td>
          <td valign="top" class="fineprint">09:24</td>
          <td valign="top" class="fineprint">Insurance</td>
          <td valign="top" class="fineprint"><a href="#">edit</a></td>
        </tr>
        <tr>
          <td valign="top" class="fineprint">Huurkor</td>
          <td valign="top" class="fineprint">214 Villa Lucca<br />
            1 South Street, Die Hoewes</td>
          <td valign="top" class="fineprint">Lesego Zulu<br />
            084 444 7777</td>
          <td valign="top" class="fineprint">Toilet</td>
          <td valign="top" bgcolor="#33FF00" class="fineprint">&nbsp;</td>
          <td valign="top" class="fineprint">08:34</td>
          <td valign="top" class="fineprint">Huurkor</td>
          <td valign="top" class="fineprint"><a href="#">edit</a></td>
        </tr>
      </table>      
      </td>
    </tr>
</table>
<?php require_once('inc_after.php'); ?>
