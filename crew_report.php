<?php require_once('Connections/adhocConn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) 
{
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

?>
<?php require_once('inc_before.php'); ?>
&nbsp;
<p>Crew Report:</p> 
<?
mysql_select_db($database_adhocConn, $adhocConn);
$query_crewname = sprintf("SELECT * FROM crews WHERE crewID = %s", $_GET['crewID']);
$crewname = mysql_query($query_crewname, $adhocConn) or die(mysql_error());
$row_crewname = mysql_fetch_assoc($crewname);
$totalRows_crewname = mysql_num_rows($crewname);
echo $row_crewname['crew'];
mysql_free_result($crewname);
?>

<?php
$sd = getdate(time()); 
$sd_d = $sd[mday];
$sd_m = $sd[mon];
$sd_y = $sd[year];
$sdate = mktime(1,0,0,$sd_m,$sd_d,$sd_y);

$starttime = $sdate - (60*60*24);
$endtime = $sdate - 3600;

mysql_select_db($database_adhocConn, $adhocConn);
$query_calls = sprintf("SELECT * FROM call_log WHERE (v1crew1 = %s OR v1crew2 = %s) AND despatched < %s AND call_status <= 5 AND comeback = 1 ORDER BY despatched DESC", $_GET['crewID'], $_GET['crewID'], $starttime);
$calls = mysql_query($query_calls, $adhocConn) or die(mysql_error());
$row_calls = mysql_fetch_assoc($calls);
$totalRows_calls = mysql_num_rows($calls);
?>
<p>Comebacks:</p>

<?php if ($totalRows_calls > 0) { // Show if recordset not empty ?>
<?php
//set counter variable
$counter = 1

?>
<table border="1" cellpadding="3" cellspacing="0" align="center" width="100%">
    <tr>
		<td class="smalltext"><div align="left">&nbsp;</div></td>
        <td class="smalltext"><div align="left">ID</div></td>
        <td class="smalltext"><div align="left">address</div></td>
        <td class="smalltext"><div align="left">client</div></td>
        <td class="smalltext"><div align="left">condition</div></td>
        <td class="smalltext"><div align="left">vehicle</div></td>
        <td class="smalltext"><div align="left">status</div></td>
        <td class="smalltext"><div align="left">despatched</div></td>
        <td class="smalltext">&nbsp;</td>
        <td class="smalltext">&nbsp;</td>
    </tr>
    <?php do { 
	if ($row_calls['jobcard_checked'] == 1) { 
		$font = "greytext";
	} else {
		$font = "smalltext"; 
	}
	?>
    <tr>
		<td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo $counter++;?></div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo $row_calls['logID']; ?></div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_calls['addressID']);
            $address = mysql_query($query_address, $adhocConn) or die(mysql_error());
            $row_address = mysql_fetch_assoc($address);
            $totalRows_address = mysql_num_rows($address);
            if ($row_address['unitno']) {
                echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
            }
            echo $row_address['streetno'] . " " . $row_address['street'];
            mysql_free_result($address);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_client = sprintf("SELECT * FROM clients WHERE clientID = %s", $row_calls['clientID']);
            $client = mysql_query($query_client, $adhocConn) or die(mysql_error());
            $row_client = mysql_fetch_assoc($client);
            $totalRows_client = mysql_num_rows($client);
            echo $row_client['cname'] . " " . $row_client['surname'];
            mysql_free_result($client);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo $row_calls['condition']; ?></div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_vehicle = sprintf("SELECT * FROM vehicles WHERE vehicleID = %s", $row_calls['vehicle1']);
            $vehicle = mysql_query($query_vehicle, $adhocConn) or die(mysql_error());
            $row_vehicle = mysql_fetch_assoc($vehicle);
            $totalRows_vehicle = mysql_num_rows($vehicle);
            echo $row_vehicle['vehicle'];
            mysql_free_result($vehicle);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_status = sprintf("SELECT * FROM call_statuses WHERE statusID = %s", $row_calls['call_status']);
            $status = mysql_query($query_status, $adhocConn) or die(mysql_error());
            $row_status = mysql_fetch_assoc($status);
            $totalRows_status = mysql_num_rows($status);
            echo $row_status['status'];
            mysql_free_result($status);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo date("d M Y H:i", $row_calls['despatched']); ?></div></td>
        <td valign="top" class="<?php echo $font; ?>" nowrap="nowrap"><div align="center" class="subtext"><a href="case_search.php?caseno=<?php echo $row_calls['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" /></a><a href="info.php?caseno=<?php echo $row_calls['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" /></a><a href="print_jobcard.php?caseno=<?php echo $row_calls['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" /></a>
            <?php if ($row_calls['jobcard_checked'] == 1) { ?>
            <a href="mark_unchecked.php?caseno=<?php echo $row_calls['logID']; ?>&crewID=<?php echo $_GET['crewID']; ?>"><img src="images/checked.jpg" border="0" alt="MARK UNCHECKED" title="MARK UNCHECKED" hspace="1" /></a>
			<?php } else { ?>
            <a href="mark_checked.php?caseno=<?php echo $row_calls['logID']; ?>&crewID=<?php echo $_GET['crewID']; ?>"><img src="images/unchecked.jpg" border="0" alt="MARK CHECKED" title="MARK CHECKED" hspace="1" /></a>
			<?php } ?>
        </div></td>
        <td nowrap="nowrap" valign="top">
            <form id="form<?php echo $row_calls['logID']; ?>" name="form<?php echo $row_calls['logID']; ?>" method="post" action="enter_time_spent.php">
              <input name="time_spent" type="text" id="time_spent" value="<?php echo $row_calls['time_spent']; ?>" size="1" maxlength="5" class="largelink" />
              <input name="time_spent_ot" type="text" id="time_spent_ot" value="<?php echo $row_calls['time_spent_ot']; ?>" size="1" maxlength="5" class="largelinkred" />
              <input type="hidden" name="logID" id="logID" value="<?php echo $row_calls['logID']; ?>" />
              <input type="hidden" name="crewID" id="crewID" value="<?php echo $_GET['crewID']; ?>" />
              <input type="submit" name="button" id="button" value="GO" class="largelink" />
            </form>
        </td>
    </tr>
    <?php } while ($row_calls = mysql_fetch_assoc($calls)); ?>
</table>
<?php } else { echo "<div align=\"center\">No comebacks</div>"; } ?>
<!--end comebacks-->

<!--start today's calls-->
<?php
mysql_free_result($calls);

$sd = getdate(time()); 
$sd_d = $sd[mday];
$sd_m = $sd[mon];
$sd_y = $sd[year];
$sdate = mktime(1,0,0,$sd_m,$sd_d,$sd_y);

$starttime = $sdate;
$endtime = $sdate + (60*60*24) - 3600;

mysql_select_db($database_adhocConn, $adhocConn);
$query_calls = sprintf("SELECT * FROM call_log WHERE (v1crew1 = %s OR v1crew2 = %s) AND despatched > %s AND call_status <= 5 ORDER BY despatched DESC", $_GET['crewID'], $_GET['crewID'], $starttime);
$calls = mysql_query($query_calls, $adhocConn) or die(mysql_error());
$row_calls = mysql_fetch_assoc($calls);
$totalRows_calls = mysql_num_rows($calls);
?>
<p>Today's Calls:</p>

<?php if ($totalRows_calls > 0) { // Show if recordset not empty ?>
<?php
//set counter variable
$counter = 1;
?>
<table border="1" cellpadding="3" cellspacing="0" align="center" width="100%">
    <tr>
		<td class="smalltext"><div align="left">&nbsp;</div></td>
        <td class="smalltext"><div align="left">ID</div></td>
        <td class="smalltext"><div align="left">address</div></td>
        <td class="smalltext"><div align="left">client</div></td>
        <td class="smalltext"><div align="left">condition</div></td>
        <td class="smalltext"><div align="left">vehicle</div></td>
        <td class="smalltext"><div align="left">status</div></td>
        <td class="smalltext"><div align="left">despatched</div></td>
        <td class="smalltext">&nbsp;</td>
        <td class="smalltext">&nbsp;</td>
    </tr>
    <?php do { 
	if ($row_calls['jobcard_checked'] == 1) { 
		$font = "greytext";
	} else {
		$font = "smalltext"; 
	}
	?>
    <tr>
		<td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo $counter++;?></div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo $row_calls['logID']; ?></div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_calls['addressID']);
            $address = mysql_query($query_address, $adhocConn) or die(mysql_error());
            $row_address = mysql_fetch_assoc($address);
            $totalRows_address = mysql_num_rows($address);
            if ($row_address['unitno']) {
                echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
            }
            echo $row_address['streetno'] . " " . $row_address['street'];
            mysql_free_result($address);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_client = sprintf("SELECT * FROM clients WHERE clientID = %s", $row_calls['clientID']);
            $client = mysql_query($query_client, $adhocConn) or die(mysql_error());
            $row_client = mysql_fetch_assoc($client);
            $totalRows_client = mysql_num_rows($client);
            echo $row_client['cname'] . " " . $row_client['surname'];
            mysql_free_result($client);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo $row_calls['condition']; ?></div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_vehicle = sprintf("SELECT * FROM vehicles WHERE vehicleID = %s", $row_calls['vehicle1']);
            $vehicle = mysql_query($query_vehicle, $adhocConn) or die(mysql_error());
            $row_vehicle = mysql_fetch_assoc($vehicle);
            $totalRows_vehicle = mysql_num_rows($vehicle);
            echo $row_vehicle['vehicle'];
            mysql_free_result($vehicle);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_status = sprintf("SELECT * FROM call_statuses WHERE statusID = %s", $row_calls['call_status']);
            $status = mysql_query($query_status, $adhocConn) or die(mysql_error());
            $row_status = mysql_fetch_assoc($status);
            $totalRows_status = mysql_num_rows($status);
            echo $row_status['status'];
            mysql_free_result($status);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo date("d M Y H:i", $row_calls['despatched']); ?></div></td>
        <td valign="top" class="<?php echo $font; ?>" nowrap="nowrap"><div align="center" class="subtext"><a href="case_search.php?caseno=<?php echo $row_calls['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" /></a><a href="info.php?caseno=<?php echo $row_calls['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" /></a><a href="print_jobcard.php?caseno=<?php echo $row_calls['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" /></a>
            <?php if ($row_calls['jobcard_checked'] == 1) { ?>
            <a href="mark_unchecked.php?caseno=<?php echo $row_calls['logID']; ?>&crewID=<?php echo $_GET['crewID']; ?>"><img src="images/checked.jpg" border="0" alt="MARK UNCHECKED" title="MARK UNCHECKED" hspace="1" /></a>
			<?php } else { ?>
            <a href="mark_checked.php?caseno=<?php echo $row_calls['logID']; ?>&crewID=<?php echo $_GET['crewID']; ?>"><img src="images/unchecked.jpg" border="0" alt="MARK CHECKED" title="MARK CHECKED" hspace="1" /></a>
			<?php } ?>
        </div></td>
        <td nowrap="nowrap" valign="top">
            <form id="form<?php echo $row_calls['logID']; ?>" name="form<?php echo $row_calls['logID']; ?>" method="post" action="enter_time_spent.php">
              <input name="time_spent" type="text" id="time_spent" value="<?php echo $row_calls['time_spent']; ?>" size="1" maxlength="5" class="largelink" />
              <input name="time_spent_ot" type="text" id="time_spent_ot" value="<?php echo $row_calls['time_spent_ot']; ?>" size="1" maxlength="5" class="largelinkred" />
              <input type="hidden" name="logID" id="logID" value="<?php echo $row_calls['logID']; ?>" />
              <input type="hidden" name="crewID" id="crewID" value="<?php echo $_GET['crewID']; ?>" />
              <input type="submit" name="button" id="button" value="GO" class="largelink" />
            </form>
        </td>
    </tr>
    <?php } while ($row_calls = mysql_fetch_assoc($calls)); ?>
</table>
<?php } else { echo "<div align=\"center\">No calls today</div>"; } ?>
<?php
$sd = getdate(time()); 
$sd_d = $sd[mday];
$sd_m = $sd[mon];
$sd_y = $sd[year];
$sdate = mktime(1,0,0,$sd_m,$sd_d,$sd_y);

$starttime = $sdate - (60*60*24);
$endtime = $sdate - 3600;

mysql_select_db($database_adhocConn, $adhocConn);
$query_calls = sprintf("SELECT * FROM call_log WHERE (v1crew1 = %s OR v1crew2 = %s) AND despatched > %s and despatched < %s ORDER BY despatched DESC", $_GET['crewID'], $_GET['crewID'], $starttime, $endtime);
$calls = mysql_query($query_calls, $adhocConn) or die(mysql_error());
$row_calls = mysql_fetch_assoc($calls);
$totalRows_calls = mysql_num_rows($calls);
?></p>
<p>Yesterday's Calls:</p>

<?php if ($totalRows_calls > 0) { // Show if recordset not empty ?>
<?php
//set counter variable
$counter = 1;
?>
<table border="1" cellpadding="3" cellspacing="0" align="center" width="100%">
    <tr>
		<td class="smalltext"><div align="left">&nbsp;</div></td>
        <td class="smalltext"><div align="left">ID</div></td>
        <td class="smalltext"><div align="left">address</div></td>
        <td class="smalltext"><div align="left">client</div></td>
        <td class="smalltext"><div align="left">condition</div></td>
        <td class="smalltext"><div align="left">vehicle</div></td>
        <td class="smalltext"><div align="left">status</div></td>
        <td class="smalltext"><div align="left">despatched</div></td>
        <td class="smalltext">&nbsp;</td>
        <td class="smalltext">&nbsp;</td>
    </tr>
    <?php do { 
	if ($row_calls['jobcard_checked'] == 1) { 
		$font = "greytext";
	} else {
		$font = "smalltext"; 
	}
	?>
    <tr>
		<td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo $counter++;?></div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo $row_calls['logID']; ?></div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_calls['addressID']);
            $address = mysql_query($query_address, $adhocConn) or die(mysql_error());
            $row_address = mysql_fetch_assoc($address);
            $totalRows_address = mysql_num_rows($address);
            if ($row_address['unitno']) {
                echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
            }
            echo $row_address['streetno'] . " " . $row_address['street'];
            mysql_free_result($address);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_client = sprintf("SELECT * FROM clients WHERE clientID = %s", $row_calls['clientID']);
            $client = mysql_query($query_client, $adhocConn) or die(mysql_error());
            $row_client = mysql_fetch_assoc($client);
            $totalRows_client = mysql_num_rows($client);
            echo $row_client['cname'] . " " . $row_client['surname'];
            mysql_free_result($client);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo $row_calls['condition']; ?></div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_vehicle = sprintf("SELECT * FROM vehicles WHERE vehicleID = %s", $row_calls['vehicle1']);
            $vehicle = mysql_query($query_vehicle, $adhocConn) or die(mysql_error());
            $row_vehicle = mysql_fetch_assoc($vehicle);
            $totalRows_vehicle = mysql_num_rows($vehicle);
            echo $row_vehicle['vehicle'];
            mysql_free_result($vehicle);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_status = sprintf("SELECT * FROM call_statuses WHERE statusID = %s", $row_calls['call_status']);
            $status = mysql_query($query_status, $adhocConn) or die(mysql_error());
            $row_status = mysql_fetch_assoc($status);
            $totalRows_status = mysql_num_rows($status);
            echo $row_status['status'];
            mysql_free_result($status);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo date("d M Y H:i", $row_calls['despatched']); ?></div></td>
        <td valign="top" class="<?php echo $font; ?>" nowrap="nowrap"><div align="center" class="subtext">
        <a href="case_search.php?caseno=<?php echo $row_calls['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" /></a><a href="info.php?caseno=<?php echo $row_calls['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" /></a><a href="print_jobcard.php?caseno=<?php echo $row_calls['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" /></a>
            <?php if ($row_calls['jobcard_checked'] == 1) { ?>
            <a href="mark_unchecked.php?caseno=<?php echo $row_calls['logID']; ?>&crewID=<?php echo $_GET['crewID']; ?>"><img src="images/checked.jpg" border="0" alt="MARK UNCHECKED" title="MARK UNCHECKED" hspace="1" /></a>
			<?php } else { ?>
            <a href="mark_checked.php?caseno=<?php echo $row_calls['logID']; ?>&crewID=<?php echo $_GET['crewID']; ?>"><img src="images/unchecked.jpg" border="0" alt="MARK CHECKED" title="MARK CHECKED" hspace="1" /></a>
			<?php } ?>
        </div></td>
        <td nowrap="nowrap" valign="top">
            <form id="form<?php echo $row_calls['logID']; ?>" name="form<?php echo $row_calls['logID']; ?>" method="post" action="enter_time_spent.php">
              <input name="time_spent" type="text" id="time_spent" value="<?php echo $row_calls['time_spent']; ?>" size="1" maxlength="5" class="largelink" />
              <input name="time_spent_ot" type="text" id="time_spent_ot" value="<?php echo $row_calls['time_spent_ot']; ?>" size="1" maxlength="5" class="largelinkred" />
              <input type="hidden" name="logID" id="logID" value="<?php echo $row_calls['logID']; ?>" />
              <input type="hidden" name="crewID" id="crewID" value="<?php echo $_GET['crewID']; ?>" />
              <input type="submit" name="button" id="button" value="GO" class="largelink" />
            </form>
        </td>
    </tr>
    <?php } while ($row_calls = mysql_fetch_assoc($calls)); ?>
</table>
<?php } else { echo "<div align=\"center\">No calls for yesterday</div>"; }?>

<?php mysql_free_result($calls);

$sd = getdate(time()); 
$sd_d = $sd[mday];
$sd_m = $sd[mon];
$sd_y = $sd[year];
$sdate = mktime(1,0,0,$sd_m,$sd_d,$sd_y);

$starttime = $sdate - (60*60*24);
$endtime = $sdate - 3600;

mysql_select_db($database_adhocConn, $adhocConn);
$query_calls = sprintf("SELECT * FROM call_log WHERE (v1crew1 = %s OR v1crew2 = %s) AND despatched < %s AND call_status <= 5 ORDER BY despatched DESC", $_GET['crewID'], $_GET['crewID'], $starttime);
$calls = mysql_query($query_calls, $adhocConn) or die(mysql_error());
$row_calls = mysql_fetch_assoc($calls);
$totalRows_calls = mysql_num_rows($calls);
?>
<p>Other Outstanding Calls:</p>

<?php if ($totalRows_calls > 0) { // Show if recordset not empty ?>
<?php
//set counter variable
$counter = 1;
?>
<table border="1" cellpadding="3" cellspacing="0" align="center" width="100%">
    <tr>
		<td class="smalltext"><div align="left">&nbsp;</div></td>
        <td class="smalltext"><div align="left">ID</div></td>
        <td class="smalltext"><div align="left">address</div></td>
        <td class="smalltext"><div align="left">client</div></td>
        <td class="smalltext"><div align="left">condition</div></td>
        <td class="smalltext"><div align="left">vehicle</div></td>
        <td class="smalltext"><div align="left">status</div></td>
        <td class="smalltext"><div align="left">despatched</div></td>
        <td class="smalltext">&nbsp;</td>
        <td class="smalltext">&nbsp;</td>
    </tr>
    <?php do { 
	if ($row_calls['jobcard_checked'] == 1) { 
		$font = "greytext";
	} else {
		$font = "smalltext"; 
	}
	?>
    <tr>
		<td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo $counter++;?></div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo $row_calls['logID']; ?></div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_calls['addressID']);
            $address = mysql_query($query_address, $adhocConn) or die(mysql_error());
            $row_address = mysql_fetch_assoc($address);
            $totalRows_address = mysql_num_rows($address);
            if ($row_address['unitno']) {
                echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
            }
            echo $row_address['streetno'] . " " . $row_address['street'];
            mysql_free_result($address);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_client = sprintf("SELECT * FROM clients WHERE clientID = %s", $row_calls['clientID']);
            $client = mysql_query($query_client, $adhocConn) or die(mysql_error());
            $row_client = mysql_fetch_assoc($client);
            $totalRows_client = mysql_num_rows($client);
            echo $row_client['cname'] . " " . $row_client['surname'];
            mysql_free_result($client);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo $row_calls['condition']; ?></div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_vehicle = sprintf("SELECT * FROM vehicles WHERE vehicleID = %s", $row_calls['vehicle1']);
            $vehicle = mysql_query($query_vehicle, $adhocConn) or die(mysql_error());
            $row_vehicle = mysql_fetch_assoc($vehicle);
            $totalRows_vehicle = mysql_num_rows($vehicle);
            echo $row_vehicle['vehicle'];
            mysql_free_result($vehicle);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left">
          <?php
            mysql_select_db($database_adhocConn, $adhocConn);
            $query_status = sprintf("SELECT * FROM call_statuses WHERE statusID = %s", $row_calls['call_status']);
            $status = mysql_query($query_status, $adhocConn) or die(mysql_error());
            $row_status = mysql_fetch_assoc($status);
            $totalRows_status = mysql_num_rows($status);
            echo $row_status['status'];
            mysql_free_result($status);
        ?>
        </div></td>
        <td valign="top" class="<?php echo $font; ?>"><div align="left"><?php echo date("d M Y H:i", $row_calls['despatched']); ?></div></td>
        <td valign="top" class="<?php echo $font; ?>" nowrap="nowrap">
        <div align="center" class="subtext">
            <a href="case_search.php?caseno=<?php echo $row_calls['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" /></a>
            <a href="info.php?caseno=<?php echo $row_calls['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" /></a>
            <a href="print_jobcard.php?caseno=<?php echo $row_calls['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" /></a>
            <?php if ($row_calls['jobcard_checked'] == 1) { ?>
            <a href="mark_unchecked.php?caseno=<?php echo $row_calls['logID']; ?>&crewID=<?php echo $_GET['crewID']; ?>"><img src="images/checked.jpg" border="0" alt="MARK UNCHECKED" title="MARK UNCHECKED" hspace="1" /></a>
			<?php } else { ?>
            <a href="mark_checked.php?caseno=<?php echo $row_calls['logID']; ?>&crewID=<?php echo $_GET['crewID']; ?>"><img src="images/unchecked.jpg" border="0" alt="MARK CHECKED" title="MARK CHECKED" hspace="1" /></a>
			<?php } ?>
        </div></td>
        <td nowrap="nowrap" valign="top">
            <form id="form<?php echo $row_calls['logID']; ?>" name="form<?php echo $row_calls['logID']; ?>" method="post" action="enter_time_spent.php">
              <input name="time_spent" type="text" id="time_spent" value="<?php echo $row_calls['time_spent']; ?>" size="1" maxlength="5" class="largelink" />
              <input name="time_spent_ot" type="text" id="time_spent_ot" value="<?php echo $row_calls['time_spent_ot']; ?>" size="1" maxlength="5" class="largelinkred" />
              <input type="hidden" name="logID" id="logID" value="<?php echo $row_calls['logID']; ?>" />
              <input type="hidden" name="crewID" id="crewID" value="<?php echo $_GET['crewID']; ?>" />
              <input type="submit" name="button" id="button" value="GO" class="largelink" />
            </form>
        </td>
    </tr>
    <?php } while ($row_calls = mysql_fetch_assoc($calls)); ?>
</table>
<?php } else { echo "<div align=\"center\">No other outstanding calls</div>"; } ?>

<p align="center"><a href="crews.php">Back to Crews</a></p>
<?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($calls);
?>
