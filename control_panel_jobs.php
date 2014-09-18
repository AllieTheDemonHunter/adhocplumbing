<?php require_once('Connections/adhocConn.php'); ?>
<?php
if (!($_COOKIE['MM_UserGroup'])) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}

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
?>
<?php require_once('inc_before_ops.php'); ?>
<?php
mysql_select_db($database_adhocConn, $adhocConn);
$query_red = sprintf("SELECT * FROM call_log INNER JOIN addresses using (addressID) WHERE call_status = 1 AND logtime <= %s AND region = %s ORDER BY calltype ASC, logtime DESC", time(), $myregionID);
$red = mysql_query($query_red, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_red = mysql_fetch_assoc($red);
$totalRows_red = mysql_num_rows($red);
if ($totalRows_red > 0) {
	do { 
		$logtime = $row_red['logtime'];
		if ($logtime >= time() - 172800) {
			// nothing
		} else {
			if ($row_red['sms_sent'] == 0) {
				// send sms
				$msg = "ALERT: Quote not logged in allocated 48 hours: Case No " . $row_red['logID'] . ".";
				$cellno = 0;
				// send otp
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'http://www.mymobileapi.com/api5/http5.aspx');
				curl_setopt ($ch, CURLOPT_POST, 1);
				$post_fields = "Type=sendparam&username=adhoc&password=admin1&numto=" . $cellno . "&data1=" . $msg;
				curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_fields);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$response_string = curl_exec($ch);
				curl_close($ch);
				// update call log
				$updateSQL = sprintf("UPDATE call_log SET sms_sent=1 WHERE logID=%s", $row_red['logID']);
				mysql_select_db($database_adhocConn, $adhocConn);
				$Result1 = mysql_query($updateSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
			}
		}
	} while ($row_red = mysql_fetch_assoc($red)); 
}
mysql_free_result($red);

mysql_select_db($database_adhocConn, $adhocConn);
if ($_GET['subregion']) {
	$query_red = sprintf("SELECT * FROM call_log as a LEFT JOIN addresses as b using (addressID) LEFT JOIN suburbs as c on b.suburb = c.suburbID LEFT JOIN subregions as d on c.subregion = d.subID WHERE a.call_status = 4 AND a.logtime <= %s AND b.region = %s and d.subID = %s and a.calltype = 2 ORDER BY a.calltype ASC, a.logtime DESC", time(), $myregionID, $_GET['subregion']);
} else {
	$query_red = sprintf("SELECT * FROM call_log as a LEFT JOIN addresses as b using (addressID) LEFT JOIN suburbs as c on b.suburb = c.suburbID LEFT JOIN subregions as d on c.subregion = d.subID WHERE a.call_status = 4 AND a.logtime <= %s AND b.region = %s and a.calltype = 2 ORDER BY a.calltype ASC, d.subregion, a.logtime DESC", time(), $myregionID);
}
$red = mysql_query($query_red, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_red = mysql_fetch_assoc($red);
$totalRows_red = mysql_num_rows($red);

mysql_select_db($database_adhocConn, $adhocConn);
if ($_GET['subregion']) {
	$query_orange = sprintf("SELECT * FROM call_log as a LEFT JOIN addresses as b using (addressID) LEFT JOIN suburbs as c on b.suburb = c.suburbID LEFT JOIN subregions as d on c.subregion = d.subID WHERE a.job_complete = 0 AND (a.call_status = 5 OR a.call_status = 6) AND a.logtime <= %s AND b.region = %s and d.subID = %s and a.calltype = 2 ORDER BY a.calltype ASC, a.logtime DESC", time(), $myregionID, $_GET['subregion']);
} else {
	$query_orange = sprintf("SELECT * FROM call_log as a LEFT JOIN addresses as b using (addressID) LEFT JOIN suburbs as c on b.suburb = c.suburbID LEFT JOIN subregions as d on c.subregion = d.subID WHERE a.job_complete = 0 AND (a.call_status = 5 OR a.call_status = 6) AND a.logtime <= %s AND b.region = %s and a.calltype = 2 ORDER BY a.calltype ASC, d.subregion, a.logtime DESC", time(), $myregionID);
}
$orange = mysql_query($query_orange, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_orange = mysql_fetch_assoc($orange);
$totalRows_orange = mysql_num_rows($orange);

mysql_select_db($database_adhocConn, $adhocConn);
$query_green = sprintf("SELECT * FROM call_log as a LEFT JOIN addresses as b using (addressID) LEFT JOIN suburbs as c on b.suburb = c.suburbID LEFT JOIN subregions as d on c.subregion = d.subID WHERE (a.job_complete = 0 OR (a.job_complete = 1 AND jobcard_no is null)) AND a.call_status = 6 AND a.logtime <= %s AND b.region = %s AND a.calltype = 2  ORDER BY a.calltype ASC, d.subregion, a.logtime DESC", time(), $myregionID);
$green = mysql_query($query_green, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_green = mysql_fetch_assoc($green);
$totalRows_green = mysql_num_rows($green);
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
  <?php
//set counter variable
$counter = 1;
?>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr>
      <?php
        	if ($myregionID == 3) { 
			?>
        <?php
			mysql_select_db($database_adhocConn, $adhocConn);
			$query_subregions = "SELECT * FROM subregions";
			$subregions = mysql_query($query_subregions, $adhocConn) or die(mysql_error());
			$row_subregions = mysql_fetch_assoc($subregions);
			$totalRows_subregions = mysql_num_rows($subregions);
			
			do { ?>
      <td align="center" class="maintext" height="40" bgcolor="#66FFCC"><a href="control_panel_jobs.php?subregion=<?php echo $row_subregions['subID']; ?>" class="largelink"><?php echo $row_subregions['subregion']; ?></a></td>
        <?php } while ($row_subregions = mysql_fetch_assoc($subregions));?>
        <?php
		mysql_free_result($subregions);
		?>
    </tr>
  </table>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF">
 <tr>
 <td>  
      <?php
		}
		?>
      <?php 
	if ($totalRows_red > 0) {
	do { 
	$logtime = $row_red['logtime'];
	if ($tempsubregion != $row_red['subregion']) {
?>
   
    <tr>
      <td valign="top" colspan="9"><hr /></td>
    </tr>
    <?php
	}
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td valign="top" width="25"><div align="left"><?php echo $counter++;?></div></td>
        <td width="35" valign="top"><?php if ($row_red['comeback'] == 1) { ?>
          <img src="design/purple.jpg" alt="COMEBACK" title="COMEBACK" width="29" height="29" /></td>
        <?php } else { ?>
        <?php if ($logtime >= time() - 172800) { ?>
          <img src="design/red.jpg" width="29" height="29" />
        <?php } else { ?>
          <img src="design/red.gif" width="29" height="29" />
        <?php } ?>
        <?php } ?>
        <?php if (($row_red['quote_amt']) || ($row_red['quote_no'])) { $bgcolor = "DDDDDD"; } else { $bgcolor = "FCE0E0"; } ?>
        
        <td bgcolor="#<?php echo $bgcolor; ?>" valign="top" width="50"><div align="left">
            <?php if ($row_red['job_no']) { echo $row_red['job_no']; } else { echo $row_red['logID']; } ?>
          </div></td>
          <td bgcolor="#FCE0E0" width="10">&nbsp;</td>
        <td bgcolor="#FCE0E0" valign="top" width="50"><div align="left"><?php echo date("d M Y", $logtime); ?></div>
          <div align="left"><?php echo date("H:i", $logtime); ?></div></td>
          <td bgcolor="#FCE0E0" width="10">&nbsp;</td>
        <td bgcolor="#FCE0E0" valign="top" width="250"><div align="left">
            <?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_red['addressID']);
						$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
						$row_address = mysql_fetch_assoc($address);
						$totalRows_address = mysql_num_rows($address);
						if ($row_address['unitno']) {
							echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
						}
						echo $row_address['streetno'] . " " . $row_address['street'];
						mysql_free_result($address);
				  ?>
          </div>
         <div align="left">  <?php echo $row_red['subregion']; 
				  $tempsubregion = $row_red['subregion']; 
				  ?>       </div> </td>
   
            <?php
				  	if ($row_red['location']) {
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_locs = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_red['location']);
						$locs = mysql_query($query_locs, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_locs = mysql_fetch_assoc($locs);
						$totalRows_locs = mysql_num_rows($locs);
						echo strtoupper(substr($row_locs['location'],0,3));
						mysql_free_result($locs);
					}
				  ?>
      
        <td bgcolor="#FCE0E0" valign="top"><div align="left"><?php echo $row_red['condition']; ?><br />
            <span class="subtext2">
            <?php
				  if ($row_red['v1crew1']) {
					mysql_select_db($database_adhocConn, $adhocConn);
					$query_crew = sprintf("SELECT * FROM crews WHERE crewID = %s", $row_red['v1crew1']);
					$crew = mysql_query($query_crew, $adhocConn) or die(mysql_error());
					$row_crew = mysql_fetch_assoc($crew);
					$totalRows_crew = mysql_num_rows($crew);
					echo $row_crew['crew'];
					mysql_free_result($crew);
				  }
				  if ($row_red['v1crew2']) {
					mysql_select_db($database_adhocConn, $adhocConn);
					$query_crew = sprintf("SELECT * FROM crews WHERE crewID = %s", $row_red['v1crew2']);
					$crew = mysql_query($query_crew, $adhocConn) or die(mysql_error());
					$row_crew = mysql_fetch_assoc($crew);
					$totalRows_crew = mysql_num_rows($crew);
					echo " & " . $row_crew['crew'];
					mysql_free_result($crew);
				  }
				  ?>
            </span></div></td>
        <td bgcolor="#FCE0E0" class="subtext" valign="top" nowrap="nowrap"><div align="right" class="subtext"><a href="case_search.php?caseno=<?php echo $row_red['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" width="40" height="40" /></a><a href="info.php?caseno=<?php echo $row_red['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" width="40" height="40" /></a><a href="print_jobcard.php?caseno=<?php echo $row_red['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" width="40" height="40" /></a></div></td>
        <?php } while ($row_red = mysql_fetch_assoc($red)); 
				  }
				  ?>
      </tr>
    </table>
    <?php
//set counter variable
$counter = 1;
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <?php 
				if ($totalRows_orange > 0) {
				do { 
				$logtime = $row_orange['logtime'];
				if ($tempsubregion != $row_orange['subregion']) {
				?>
      <tr>
        <td valign="top" colspan="9"><hr /></td>
      </tr>
      <?php
				}
				?>
      <tr>
        <td valign="top"><div align="left"><?php echo $counter++;?></div></td>
        <td><?php if ($row_orange['comeback'] == 1) { ?>
          <img src="design/purple.jpg" alt="COMEBACK" title="COMEBACK" width="29" height="29" /></td>
          <?php } else { ?>
          <?php if (($row_orange['est_fin_time'] > time()) || (!($row_orange['est_fin_time']))) { ?>
          <img src="design/amber.jpg" width="29" height="29" />
          <?php } else { ?>
          <img src="design/amber.gif" width="29" height="29" />
        <?php } ?>
        <?php } ?>
        <?php if (($row_orange['quote_amt']) || ($row_orange['quote_no'])) { $bgcolor = "DDDDDD"; } else { $bgcolor = "FFECCC"; } ?>
        <td bgcolor="#<?php echo $bgcolor; ?>" valign="top"><div align="center">
            <?php if ($row_orange['job_no']) { echo $row_orange['job_no']; } else { echo $row_orange['logID']; } ?>
          </div></td>
        <td bgcolor="#FFECCC" valign="top"><div align="center"><?php echo date("d M Y", $logtime); ?></div>
          <div align="center"><?php echo date("H:i", $logtime); ?></div></td>
        <td bgcolor="#FFECCC" valign="top"><div align="left">
            <?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_address = sprintf("SELECT * FROM addresses WHERE addressID = %s", $row_orange['addressID']);
						$address = mysql_query($query_address, $adhocConn) or die(mysql_error());
						$row_address = mysql_fetch_assoc($address);
						$totalRows_address = mysql_num_rows($address);
						if ($row_address['unitno']) {
							echo $row_address['unitno'] . " " . $row_address['complex'] . "<br>";
						}
						echo $row_address['streetno'] . " " . $row_address['street'];
						mysql_free_result($address);
				  ?>
          </div>
    <div align="left">      <?php echo $row_orange['subregion']; 
				  $tempsubregion = $row_orange['subregion']; ?></div></td>
       
            <?php
				  	if ($row_orange['location']) {
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_locs = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_orange['location']);
						$locs = mysql_query($query_locs, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_locs = mysql_fetch_assoc($locs);
						$totalRows_locs = mysql_num_rows($locs);
						echo strtoupper(substr($row_locs['location'],0,3));
						mysql_free_result($locs);
					}
				  ?>
       
        <td bgcolor="#FFECCC"><div align="left"><?php echo $row_orange['condition']; ?><br />
            <span class="subtext2">
            <?php
				  if ($row_orange['v1crew1']) {
					mysql_select_db($database_adhocConn, $adhocConn);
					$query_crew = sprintf("SELECT * FROM crews WHERE crewID = %s", $row_orange['v1crew1']);
					$crew = mysql_query($query_crew, $adhocConn) or die(mysql_error());
					$row_crew = mysql_fetch_assoc($crew);
					$totalRows_crew = mysql_num_rows($crew);
					echo $row_crew['crew'];
					mysql_free_result($crew);
				  }
				  if ($row_orange['v1crew2']) {
					mysql_select_db($database_adhocConn, $adhocConn);
					$query_crew = sprintf("SELECT * FROM crews WHERE crewID = %s", $row_orange['v1crew2']);
					$crew = mysql_query($query_crew, $adhocConn) or die(mysql_error());
					$row_crew = mysql_fetch_assoc($crew);
					$totalRows_crew = mysql_num_rows($crew);
					echo " & " . $row_crew['crew'];
					mysql_free_result($crew);
				  }
				  ?>
            </span></div></td>
        <td bgcolor="#FFECCC" class="subtext" nowrap="nowrap"><div align="center" class="subtext"><a href="job_completed.php?logID=<?php echo $row_orange['logID']; ?>&amp;c1=<?php echo $row_orange['v1crew1']; ?>&amp;c2=<?php echo $row_orange['v1crew2']; ?>&amp;v1=<?php echo $row_orange['vehicle1']; ?>"><img src="images/complete.png" border="0" alt="COMPLETE" title="COMPLETE" hspace="1" height="40" width="40" /></a><a href="case_search.php?caseno=<?php echo $row_orange['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" height="40" width="40" /></a><a href="info.php?caseno=<?php echo $row_orange['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" height="40" width="40" /></a><a href="print_jobcard.php?caseno=<?php echo $row_orange['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" height="40" width="40" /></a></div></td>
        <?php } while ($row_orange = mysql_fetch_assoc($orange)); 
				  }
			  ?>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <?php /*
				if ($totalRows_green > 0) {
				do { 
				$logtime = $row_green['logtime'];
				if ($tempsubregion != $row_green['subregion']) {
				?>
                  <tr>
                  <td valign="top" colspan="9"><hr /></td></tr>
                <?php
				}
				?>
                  <tr>
				  <td valign="top"><div align="left"><?php echo $counter++;?></div></td>
                  <td width="35"><img src="design/green.jpg" width="29" height="29" /></td>
                  <?php if (($row_green['quote_amt']) || ($row_green['quote_no'])) { ?>
                  <td bgcolor="#DDDDDD" valign="top"><div align="center"><?php echo $row_green['logID']; ?></div></td>
                  <?php } else { ?>
                  <td bgcolor="#CBF3CD" valign="top"><div align="center"><?php echo $row_green['logID']; ?></div></td>
                  <?php } ?>
                  <td bgcolor="#CBF3CD"><div align="center"><?php echo date("d M Y", $logtime); ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="center"><?php echo date("H:i", $logtime); ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="left"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_client = sprintf("SELECT * FROM clients WHERE clientID = %s", $row_green['clientID']);
						$client = mysql_query($query_client, $adhocConn) or die(mysql_error());
						$row_client = mysql_fetch_assoc($client);
						$totalRows_client = mysql_num_rows($client);
						echo $row_client['cname'] . " " . $row_client['surname'];
						mysql_free_result($client);
				  ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="center"><?php echo $row_green['subregion']; 
				  $tempsubregion = $row_green['subregion']; ?><br /><span class="subtext2">
                  <td bgcolor="#CBF3CD"><div align="center"><?php
				  	if ($row_green['location']) {
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_locs = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_green['location']);
						$locs = mysql_query($query_locs, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
						$row_locs = mysql_fetch_assoc($locs);
						$totalRows_locs = mysql_num_rows($locs);
						echo strtoupper(substr($row_locs['location'],0,3));
						mysql_free_result($locs);
					}
				  ?></div></td>
                  <td bgcolor="#CBF3CD"><div align="left"><?php echo $row_green['condition']; ?></div></td>
                  <td bgcolor="#CBF3CD" class="subtext"><div align="center" class="subtext"><a href="case_search.php?caseno=<?php echo $row_green['logID']; ?>"><img src="images/more.png" border="0" alt="MORE" title="MORE" hspace="1" /></a><a href="info.php?caseno=<?php echo $row_green['logID']; ?>" target="_blank"><img src="images/info.png" border="0" alt="INFO" title="INFO" hspace="1" /></a><a href="print_jobcard.php?caseno=<?php echo $row_green['logID']; ?>" target="_blank"><img src="images/jobcard.png" border="0" alt="JOBCARD" title="JOBCARD" hspace="1" /></a></div></td>
                </tr>
                  <?php } while ($row_green = mysql_fetch_assoc($green)); 
				  } */
				  ?>
                  </td>
                  </tr>
    </table>
    <p>&nbsp; </p>
    <?php require_once('inc_after.php'); ?>
