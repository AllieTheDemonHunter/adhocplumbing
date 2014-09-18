<?php require_once('Connections/adhocConn.php'); ?>
<?php require_once('inc_before.php'); ?>
<table width="100%" border="1" cellpadding="10" cellspacing="10" bordercolor="#1FA2D0">
  <tr>
    <td valign="top" nowrap="nowrap">Search by Address:<br /><br />
    <?php
		mysql_select_db($database_adhocConn, $adhocConn);
		$query_my_region = sprintf("SELECT * FROM users WHERE userID = %s", $_COOKIE['MM_userID']);
		$my_region = mysql_query($query_my_region, $adhocConn) or die(mysql_error());
		$row_my_region = mysql_fetch_assoc($my_region);
		$totalRows_my_region = mysql_num_rows($my_region);
		if ($row_my_region['region']) {
			$extra = " WHERE region = " . $row_my_region['region'];
	?>
        <form name="suburb" name="suburb" method="post" action="log_quote_step_4.php">
          <div align="right">Suburb:
          <select name="suburb" class="maintext" id="suburb">
            <?php
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_provID = sprintf("SELECT * FROM regions WHERE regionID = %s", $row_my_region['region']);
			$provID = mysql_query($query_provID, $adhocConn) or die(mysql_error());
			$row_provID = mysql_fetch_assoc($provID);
			$totalRows_provID = mysql_num_rows($provID);
			$province = $row_provID['provinceID'];
			mysql_free_result($provID);

			mysql_select_db($database_adhocConn, $adhocConn);
			$query_suburbs = sprintf("SELECT * FROM suburbs WHERE regionID = %s ORDER BY suburb ASC", $row_my_region['region']);
			$suburbs = mysql_query($query_suburbs, $adhocConn) or die(mysql_error());
			$row_suburbs = mysql_fetch_assoc($suburbs);
			$totalRows_suburbs = mysql_num_rows($suburbs);
			
			do {  
				?>
				<option value="<?php echo $row_suburbs['suburbID']?>"><?php echo $row_suburbs['suburb']?></option>
				<?php
			} while ($row_suburbs = mysql_fetch_assoc($suburbs));
			$rows = mysql_num_rows($suburbs);
			if($rows > 0) {
			  mysql_data_seek($suburbs, 0);
			  $row_suburbs = mysql_fetch_assoc($suburbs);
			}
			mysql_free_result($suburbs);
			?>
          </select>
          <br />
          <input type="hidden" name="typeID" id="typeID" value="<?php echo $_GET['typeID']; ?>" />
          <input type="hidden" name="call_status" id="call_status" value="<?php echo $_GET['call_status']; ?>" />
          <input type="hidden" name="region" id="region" value="<?php echo $row_my_region['region']; ?>" />
          <input type="hidden" name="province" id="province" value="<?php echo $province; ?>" />
          <input name="button4" type="submit" class="maintext" id="button3" value="GO" />
        </div>
        </form>
		<?php
		} else {
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_provs = "SELECT distinct provinceID, province FROM provinces INNER JOIN regions using (provinceID) WHERE active = 1 ORDER BY province ASC";
			$provs = mysql_query($query_provs, $adhocConn) or die(mysql_error());
			$row_provs = mysql_fetch_assoc($provs);
			$totalRows_provs = mysql_num_rows($provs);
			$extra = " WHERE region = " . $myregionID;
		?>
		  <form id="province" name="province" method="post" action="log_quote_step_2.php">
			<div align="right">Province: 
			<select name="province" id="province" class="maintext">
			  <?php
				do {  
				?>
				  <option value="<?php echo $row_provs['provinceID']?>"><?php echo $row_provs['province']?></option>
				  <?php
				} while ($row_provs = mysql_fetch_assoc($provs));
				$rows = mysql_num_rows($provs);
				if($rows > 0) {
				  mysql_data_seek($provs, 0);
				  $row_provs = mysql_fetch_assoc($provs);
				}
				?>
                </select>
                <br />
              <input type="hidden" name="typeID" id="typeID" value="<?php echo $_GET['typeID']; ?>" />
              <input type="hidden" name="call_status" id="call_status" value="<?php echo $_GET['call_status']; ?>" />
              <input name="button3" type="submit" class="maintext" id="button3" value="GO" />
            </div>
          </form>
    <?php 
			mysql_free_result($provs);
		}
		mysql_free_result($my_region);
	?>
    </td>
    <td valign="top" nowrap="nowrap">Search by Category:<br /><br />
    <?php
	mysql_select_db($database_adhocConn, $adhocConn);
	$query_categories = "SELECT * FROM categories ORDER BY category ASC";
	$categories = mysql_query($query_categories, $adhocConn) or die(mysql_error());
	$row_categories = mysql_fetch_assoc($categories);
	$totalRows_categories = mysql_num_rows($categories);
	?>	
      <form id="category" name="category" method="post" action="log_quote_category.php">
        <div align="right">Category:
          <select name="category" class="maintext" id="category">
            <?php
do {  
?>
            <option value="<?php echo $row_categories['catID']?>"><?php echo substr($row_categories['category'],0,20) ?></option>
            <?php
} while ($row_categories = mysql_fetch_assoc($categories));
  $rows = mysql_num_rows($categories);
  if($rows > 0) {
      mysql_data_seek($categories, 0);
	  $row_categories = mysql_fetch_assoc($categories);
  }
?>
            </select>
          <br />
          <input type="hidden" name="typeID" id="typeID" value="<?php echo $_GET['typeID']; ?>" />
          <input type="hidden" name="call_status" id="call_status" value="<?php echo $_GET['call_status']; ?>" />
          <input name="button2" type="submit" class="maintext" id="button2" value="GO" />
        </div>
      </form>      </td>
    <td valign="top" nowrap="nowrap"><form id="client" name="client" method="post" action="log_quote_client.php"><div align="right">Search by 
      <select name="searchby" class="maintext" id="searchby">
        <option value="clientsurname">Client Surname</option>
        <option value="contact">Contact Person</option>
        <option value="contacttel">Contact Tel No</option>
        <option value="caseno">Case No</option>
        <option value="newcaseno">Jobcard No</option>
        <option value="orderno">Order No</option>
        <option value="refno">Ref No</option>
        <option value="claimno">Claim No</option>
        <option value="policyno">Policy No</option>
        <option value="idno">ID No</option>
      </select>
        </div>
      <br />
        <div align="right">Search for:
          <input type="hidden" name="typeID" id="typeID" value="<?php echo $_GET['typeID']; ?>" />
          <input type="hidden" name="call_status" id="call_status" value="<?php echo $_GET['call_status']; ?>" />
          <input name="searchfor" type="text" class="maintext" id="searchfor" size="8" />
          <br />
          <input name="button" type="submit" class="maintext" id="button" value="GO" />
        </div>
      </form>
    <?php
	mysql_free_result($categories);
	?>
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top" nowrap="nowrap" class="smalltext"><p>Recent:
      <?php require_once('_recent.php'); ?>
</p>
      </td>
  </tr>
</table>
<?php require_once('inc_after.php'); ?>
