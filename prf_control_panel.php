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
$query_prfs = "SELECT distinct prf_no, medaid FROM call_log where call_status < 4 ORDER BY prf_no ASC";
$prfs = mysql_query($query_prfs, $adhocConn) or die(mysql_error());
$row_prfs = mysql_fetch_assoc($prfs);
$totalRows_prfs = mysql_num_rows($prfs);

if (($_COOKIE['MM_UserGroup'] != 2) && ($_COOKIE['MM_UserGroup'] < 5)) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ad Hoc Plumbers Admin Panel</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<body><table width="950" border="3" align="center" cellpadding="0" cellspacing="0">
<tr>
    <td height="613" valign="top" bgcolor="#FFFFFF"><table width="950" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="15">
          <tr>
            <td valign="top">
              <p>PRF Control Panel</p>
                <table border="1" cellpadding="3" cellspacing="0" align="center">
                  <?php 
				  	do { 
						if ($row_prfs['prf_no']) {
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_get_case_no = sprintf("SELECT * FROM call_log WHERE prf_no = '%s'", $row_prfs['prf_no']);
							$get_case_no = mysql_query($query_get_case_no, $adhocConn) or die(mysql_error());
							$row_get_case_no = mysql_fetch_assoc($get_case_no);
							$totalRows_get_case_no = mysql_num_rows($get_case_no);
							$case_no = $row_get_case_no['logID'];
							mysql_free_result($get_case_no);
							
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_exists = sprintf("SELECT * FROM prf WHERE prfID = '%s'", $row_prfs['prf_no']);
							$exists = mysql_query($query_exists, $adhocConn) or die(mysql_error());
							$row_exists = mysql_fetch_assoc($exists);
							$totalRows_exists = mysql_num_rows($exists);
							mysql_free_result($exists);
							
							if ($totalRows_exists > 0) {
								
								?>
								<tr>
								  <td valign="top" rowspan="2"><a href="edit_prf.php?prf_no=<?php echo $row_prfs['prf_no']; ?>&case_no=<?php echo $case_no; ?>"><?php echo $row_prfs['prf_no']; ?></a><?php if ($row_prfs['medaid'] == 142) { ?><br /><br /><a href="accident_report.php?case_no=<?php echo $case_no; ?>"><img src="images/accident_report.jpg" /></a><?php } ?></td>
                                  <td valign="top">
									<?php
                                    mysql_select_db($database_adhocConn, $adhocConn);
                                    $query_drugs = sprintf("SELECT * FROM drugs WHERE prf_no = '%s' ORDER BY drugID ASC", $row_prfs['prf_no']);
                                    $drugs = mysql_query($query_drugs, $adhocConn) or die(mysql_error());
                                    $row_drugs = mysql_fetch_assoc($drugs);
                                    $totalRows_drugs = mysql_num_rows($drugs);
                                    ?>
                                    <table border="1" cellpadding="3" cellspacing="0" bgcolor="#66FFCC" width="100%">
                                      <tr>
                                        <td class="formtext">drug</td>
                                        <td class="formtext">dose</td>
                                        <td class="formtext">route</td>
                                        <td class="formtext">time</td>
                                        <td class="formtext">hpcsa_no</td>
                                      </tr>
                                      <?php do { ?>
                                        <tr>
                                          <td class="formtext"><?php echo $row_drugs['drug']; ?></td>
                                          <td class="formtext"><?php echo $row_drugs['dose']; ?></td>
                                          <td class="formtext"><?php echo $row_drugs['route']; ?></td>
                                          <td class="formtext"><?php echo $row_drugs['time']; ?></td>
                                          <td class="formtext"><?php echo $row_drugs['hpcsa_no']; ?></td>
                                        </tr>
                                        <?php } while ($row_drugs = mysql_fetch_assoc($drugs)); ?>
                                    </table>
                                    <?php 
                                    mysql_free_result($drugs);
                                    ?>
                                  <a href="add_drug.php?prf_no=<?php echo $row_prfs['prf_no']; ?>" class="formtext">ADD</a></td>
                                  <td valign="top">
									<?php
                                    mysql_select_db($database_adhocConn, $adhocConn);
                                    $query_fluids = sprintf("SELECT * FROM fluids WHERE prf_no = '%s' ORDER BY fluidID ASC", $row_prfs['prf_no']);
                                    $fluids = mysql_query($query_fluids, $adhocConn) or die(mysql_error());
                                    $row_fluids = mysql_fetch_assoc($fluids);
                                    $totalRows_fluids = mysql_num_rows($fluids);
                                    ?>
                                    <table border="1" cellpadding="3" cellspacing="0" bgcolor="#CCFFFF" width="100%">
                                      <tr>
                                        <td class="formtext">fluid</td>
                                        <td class="formtext">needle</td>
                                        <td class="formtext">site</td>
                                        <td class="formtext">volume</td>
                                      </tr>
                                      <?php do { ?>
                                        <tr>
                                          <td class="formtext"><?php echo $row_fluids['fluid']; ?></td>
                                          <td class="formtext"><?php echo $row_fluids['needle']; ?></td>
                                          <td class="formtext"><?php echo $row_fluids['site']; ?></td>
                                          <td class="formtext"><?php echo $row_fluids['volume']; ?></td>
                                        </tr>
                                        <?php } while ($row_fluids = mysql_fetch_assoc($fluids)); ?>
                                    </table>
                                    <?php
                                    mysql_free_result($fluids);
                                    ?>
                                  <a href="add_fluid.php?prf_no=<?php echo $row_prfs['prf_no']; ?>" class="formtext">ADD</a>
                                  </td></tr>
                                  <tr>
                                  <td valign="top" colspan="2">
									<?php
                                    mysql_select_db($database_adhocConn, $adhocConn);
                                    $query_vitals = sprintf("SELECT * FROM vitals WHERE prf_no = '%s' ORDER BY `timestamp` ASC", $row_prfs['prf_no']);
                                    $vitals = mysql_query($query_vitals, $adhocConn) or die(mysql_error());
                                    $row_vitals = mysql_fetch_assoc($vitals);
                                    $totalRows_vitals = mysql_num_rows($vitals);
                                    ?>
                                    <table border="1" cellpadding="3" cellspacing="0" bgcolor="#FFFFCC">
                                      <tr>
                                        <td class="formtext">time</td>
                                        <td class="formtext" colspan="4" align="center">breath</td>
                                        <td class="formtext" colspan="5" align="center">circ</td>
                                        <td class="formtext" align="center">gcs</td>
                                        <td class="formtext" colspan="4" align="center">pupil</td>
                                        <td class="formtext" align="center">glucose</td>
                                        <td class="formtext" align="center">pain_score</td>
                                      </tr>
                                      <tr>
                                        <td class="formtext">timestamp</td>
                                        <td class="formtext">rate_min</td>
                                        <td class="formtext">rhythm</td>
                                        <td class="formtext">air_entry</td>
                                        <td class="formtext">sao2</td>
                                        <td class="formtext">heartrate</td>
                                        <td class="formtext">rhythm</td>
                                        <td class="formtext">perfusion</td>
                                        <td class="formtext">bp</td>
                                        <td class="formtext">ecg</td>
                                        <td class="formtext">gcs</td>
                                        <td class="formtext">size_l</td>
                                        <td class="formtext">size_r</td>
                                        <td class="formtext">reaction_l</td>
                                        <td class="formtext">reaction_r</td>
                                        <td class="formtext">glucose</td>
                                        <td class="formtext">pain_score</td>
                                      </tr>
                                      <?php do { ?>
                                        <tr>
                                          <td class="formtext"><?php echo $row_vitals['timestamp']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['breath_rate_min']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['breath_rhythm']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['breath_air_entry']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['breath_sao2']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['circ_heartrate']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['circ_rhythm']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['circ_perfusion']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['circ_bp']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['circ_ecg']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['gcs']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['pupil_size_l']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['pupil_size_r']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['pupil_reaction_l']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['pupil_reaction_r']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['glucose']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['pain_score']; ?></td>
                                        </tr>
                                        <?php } while ($row_vitals = mysql_fetch_assoc($vitals)); ?>
                                    </table>
                                    <?php
                                    mysql_free_result($vitals);
                                    ?>
                                  <a href="add_vital.php?prf_no=<?php echo $row_prfs['prf_no']; ?>" class="formtext">ADD</a></td>
                                  </td>
					  </tr>
								<?php 
							} else {
								?>
								<tr>
								  <td rowspan="2" valign="top"><a href="capture_prf.php?prf_no=<?php echo $row_prfs['prf_no']; ?>&case_no=<?php echo $case_no; ?>"><?php echo $row_prfs['prf_no']; ?></a><?php if ($row_prfs['medaid'] == 142) { ?><br /><br /><a href="accident_report.php?case_no=<?php echo $case_no; ?>"><img src="images/accident_report.jpg" /></a><?php } ?></td>
                                  <td valign="top">
									<?php
                                    mysql_select_db($database_adhocConn, $adhocConn);
                                    $query_drugs = sprintf("SELECT * FROM drugs WHERE prf_no = '%s' ORDER BY drugID ASC", $row_prfs['prf_no']);
                                    $drugs = mysql_query($query_drugs, $adhocConn) or die(mysql_error());
                                    $row_drugs = mysql_fetch_assoc($drugs);
                                    $totalRows_drugs = mysql_num_rows($drugs);
                                    ?>
                                    <table border="1" cellpadding="3" cellspacing="0" bgcolor="#66FFCC" width="100%">
                                      <tr>
                                        <td class="formtext">drug</td>
                                        <td class="formtext">dose</td>
                                        <td class="formtext">route</td>
                                        <td class="formtext">time</td>
                                        <td class="formtext">hpcsa_no</td>
                                      </tr>
                                      <?php do { ?>
                                        <tr>
                                          <td class="formtext"><?php echo $row_drugs['drug']; ?></td>
                                          <td class="formtext"><?php echo $row_drugs['dose']; ?></td>
                                          <td class="formtext"><?php echo $row_drugs['route']; ?></td>
                                          <td class="formtext"><?php echo $row_drugs['time']; ?></td>
                                          <td class="formtext"><?php echo $row_drugs['hpcsa_no']; ?></td>
                                        </tr>
                                        <?php } while ($row_drugs = mysql_fetch_assoc($drugs)); ?>
                                    </table>
                                    <?php 
                                    mysql_free_result($drugs);
                                    ?>
                                  <a href="add_drug.php?prf_no=<?php echo $row_prfs['prf_no']; ?>" class="formtext">ADD</a></td>
                                  <td valign="top">
									<?php
                                    mysql_select_db($database_adhocConn, $adhocConn);
                                    $query_fluids = sprintf("SELECT * FROM fluids WHERE prf_no = '%s' ORDER BY fluidID ASC", $row_prfs['prf_no']);
                                    $fluids = mysql_query($query_fluids, $adhocConn) or die(mysql_error());
                                    $row_fluids = mysql_fetch_assoc($fluids);
                                    $totalRows_fluids = mysql_num_rows($fluids);
                                    ?>
                                    <table border="1" cellpadding="3" cellspacing="0" bgcolor="#CCFFFF" width="100%">
                                      <tr>
                                        <td class="formtext">fluid</td>
                                        <td class="formtext">needle</td>
                                        <td class="formtext">site</td>
                                        <td class="formtext">volume</td>
                                      </tr>
                                      <?php do { ?>
                                        <tr>
                                          <td class="formtext"><?php echo $row_fluids['fluid']; ?></td>
                                          <td class="formtext"><?php echo $row_fluids['needle']; ?></td>
                                          <td class="formtext"><?php echo $row_fluids['site']; ?></td>
                                          <td class="formtext"><?php echo $row_fluids['volume']; ?></td>
                                        </tr>
                                        <?php } while ($row_fluids = mysql_fetch_assoc($fluids)); ?>
                                    </table>
                                    <?php
                                    mysql_free_result($fluids);
                                    ?>
                                  <a href="add_fluid.php?prf_no=<?php echo $row_prfs['prf_no']; ?>" class="formtext">ADD</a>
                                  </td></tr>
                                  <tr>
                                  <td valign="top" colspan="2">
									<?php
                                    mysql_select_db($database_adhocConn, $adhocConn);
                                    $query_vitals = sprintf("SELECT * FROM vitals WHERE prf_no = '%s' ORDER BY `timestamp` ASC", $row_prfs['prf_no']);
                                    $vitals = mysql_query($query_vitals, $adhocConn) or die(mysql_error());
                                    $row_vitals = mysql_fetch_assoc($vitals);
                                    $totalRows_vitals = mysql_num_rows($vitals);
                                    ?>
                                    <table border="1" cellpadding="3" cellspacing="0" bgcolor="#FFFFCC">
                                      <tr>
                                        <td class="formtext">time</td>
                                        <td class="formtext" colspan="4" align="center">breath</td>
                                        <td class="formtext" colspan="5" align="center">circ</td>
                                        <td class="formtext" align="center">gcs</td>
                                        <td class="formtext" colspan="4" align="center">pupil</td>
                                        <td class="formtext" align="center">glucose</td>
                                        <td class="formtext" align="center">pain_score</td>
                                      </tr>
                                      <tr>
                                        <td class="formtext">timestamp</td>
                                        <td class="formtext">rate_min</td>
                                        <td class="formtext">rhythm</td>
                                        <td class="formtext">air_entry</td>
                                        <td class="formtext">sao2</td>
                                        <td class="formtext">heartrate</td>
                                        <td class="formtext">rhythm</td>
                                        <td class="formtext">perfusion</td>
                                        <td class="formtext">bp</td>
                                        <td class="formtext">ecg</td>
                                        <td class="formtext">gcs</td>
                                        <td class="formtext">size_l</td>
                                        <td class="formtext">size_r</td>
                                        <td class="formtext">reaction_l</td>
                                        <td class="formtext">reaction_r</td>
                                        <td class="formtext">glucose</td>
                                        <td class="formtext">pain_score</td>
                                      </tr>
                                      <?php do { ?>
                                        <tr>
                                          <td class="formtext"><?php echo $row_vitals['timestamp']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['breath_rate_min']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['breath_rhythm']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['breath_air_entry']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['breath_sao2']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['circ_heartrate']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['circ_rhythm']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['circ_perfusion']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['circ_bp']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['circ_ecg']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['gcs']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['pupil_size_l']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['pupil_size_r']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['pupil_reaction_l']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['pupil_reaction_r']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['glucose']; ?></td>
                                          <td class="formtext"><?php echo $row_vitals['pain_score']; ?></td>
                                        </tr>
                                        <?php } while ($row_vitals = mysql_fetch_assoc($vitals)); ?>
                                    </table>
                                    <?php
                                    mysql_free_result($vitals);
                                    ?>
                                  <a href="add_vital.php?prf_no=<?php echo $row_prfs['prf_no']; ?>" class="formtext">ADD</a></td>
                                  </td>
								</tr>
								<?php 
							}
						}
					} while ($row_prfs = mysql_fetch_assoc($prfs)); ?>
                </table>
            </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($prfs);
?>
