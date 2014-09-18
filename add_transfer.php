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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	$tfrtime = mktime($_POST['sd_h'],$_POST['sd_i'],0,$_POST['sd_m'],$_POST['sd_d'],$_POST['sd_y']);
	$insertSQL = sprintf("INSERT INTO call_log (logtime, casename, caller, dispatcher, telno1, `location`, `condition`, medaid, medaidno, `notes`, calltype, tfrtime, medauthno, medauthperson, tfrfrom, fromother, wardfrom, drfrom, drfromtelno, tfrto, toother, wardto, drto, drtotelno, patient, carelevel, `priority`, call_status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['logtime'], "text"),
                       GetSQLValueString($_POST['casename'], "text"),
                       GetSQLValueString($_POST['caller'], "text"),
                       GetSQLValueString($_POST['dispatcher'], "int"),
                       GetSQLValueString($_POST['telno1'], "text"),
                       GetSQLValueString($_POST['location'], "int"),
                       GetSQLValueString($_POST['condition'], "text"),
                       GetSQLValueString($_POST['medaid'], "int"),
                       GetSQLValueString($_POST['medaidno'], "text"),
                       GetSQLValueString($_POST['notes'], "text"),
                       GetSQLValueString($_POST['calltype'], "int"),
                       GetSQLValueString($tfrtime, "text"),
                       GetSQLValueString($_POST['medauthno'], "text"),
                       GetSQLValueString($_POST['medauthperson'], "text"),
                       GetSQLValueString($_POST['tfrfrom'], "int"),
                       GetSQLValueString($_POST['fromother'], "text"),
                       GetSQLValueString($_POST['wardfrom'], "text"),
                       GetSQLValueString($_POST['drfrom'], "text"),
                       GetSQLValueString($_POST['drfromtelno'], "text"),
                       GetSQLValueString($_POST['tfrto'], "int"),
                       GetSQLValueString($_POST['toother'], "text"),
                       GetSQLValueString($_POST['wardto'], "text"),
                       GetSQLValueString($_POST['drto'], "text"),
                       GetSQLValueString($_POST['drtotelno'], "text"),
                       GetSQLValueString($_POST['patient'], "text"),
                       GetSQLValueString($_POST['carelevel'], "int"),
                       GetSQLValueString($_POST['priority'], "int"),
                       GetSQLValueString($_POST['call_status'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($insertSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());

  $insertGoTo = "control_panel.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_adhocConn, $adhocConn);
$query_tfrom = "SELECT * FROM hospitals ORDER BY hospital ASC";
$tfrom = mysql_query($query_tfrom, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_tfrom = mysql_fetch_assoc($tfrom);
$totalRows_tfrom = mysql_num_rows($tfrom);

mysql_select_db($database_adhocConn, $adhocConn);
$query_tto = "SELECT * FROM hospitals ORDER BY hospital ASC";
$tto = mysql_query($query_tto, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_tto = mysql_fetch_assoc($tto);
$totalRows_tto = mysql_num_rows($tto);

mysql_select_db($database_adhocConn, $adhocConn);
$query_locs = "SELECT * FROM locations ORDER BY location ASC";
$locs = mysql_query($query_locs, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_locs = mysql_fetch_assoc($locs);
$totalRows_locs = mysql_num_rows($locs);

mysql_select_db($database_adhocConn, $adhocConn);
$query_clevel = "SELECT * FROM care_levels ORDER BY levelID ASC";
$clevel = mysql_query($query_clevel, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_clevel = mysql_fetch_assoc($clevel);
$totalRows_clevel = mysql_num_rows($clevel);

mysql_select_db($database_adhocConn, $adhocConn);
$query_priorities = "SELECT * FROM priorities ORDER BY pID ASC";
$priorities = mysql_query($query_priorities, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_priorities = mysql_fetch_assoc($priorities);
$totalRows_priorities = mysql_num_rows($priorities);

mysql_select_db($database_adhocConn, $adhocConn);
$query_medaids = "SELECT * FROM med_aids ORDER BY aidname ASC";
$medaids = mysql_query($query_medaids, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_medaids = mysql_fetch_assoc($medaids);
$totalRows_medaids = mysql_num_rows($medaids);

if (!($_COOKIE['MM_UserGroup'])) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ad Hoc Plumbers Admin Panel</title>

<script type="text/javascript" language="javascript">
    function convertEnterToTab() {
      if(event.keyCode==13) {
        event.keyCode = 9;
      }
    }
    document.onkeydown = convertEnterToTab;    
</script>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MM_preloadImages('design/mouseovers_r1_c1.jpg','design/mouseovers_r3_c1.jpg','design/mouseovers_r2_c1.jpg','design/maintenance_over.jpg')">
<?php require_once('inc_before.php'); ?>
              <span class="logbutton">Log Transfer Call</span><br /><br />
              <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                <table align="center" cellpadding="0" cellspacing="0">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Case Name:</td>
                    <td colspan="4"><input name="casename" type="text" class="maintext" id="casename" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Date &amp; Time:</td>
                    <td colspan="2"><?php 
			$sd = getdate(time()+86400); 
			$sd_d = $sd[mday];
			$sd_m = $sd[mon];
			$sd_y = $sd[year];
			$sd_h = "9";
			$sd_i = "00";
			?>
            <select name="sd_d" class="maintext" id="sd_d">
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
            <select name="sd_m" class="maintext" id="sd_m">
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
            <select name="sd_y" class="maintext" id="sd_y">
              <option <?php if ($sd_y == "2012") {echo "SELECTED";} ?>>2012</option>
              <option <?php if ($sd_y == "2013") {echo "SELECTED";} ?>>2013</option>
              <option <?php if ($sd_y == "2014") {echo "SELECTED";} ?>>2014</option>
            </select>
            <br />
            <select name="sd_h" class="maintext" id="sd_h">
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
            </select>
            :
            <select name="sd_i" class="maintext" id="sd_i">
                <option <?php if ($sd_i == "00") {echo "SELECTED";} ?>>00</option>
                <option <?php if ($sd_i == "10") {echo "SELECTED";} ?>>10</option>
                <option <?php if ($sd_i == "20") {echo "SELECTED";} ?>>20</option>
                <option <?php if ($sd_i == "30") {echo "SELECTED";} ?>>30</option>
                <option <?php if ($sd_i == "40") {echo "SELECTED";} ?>>40</option>
                <option <?php if ($sd_i == "50") {echo "SELECTED";} ?>>50</option>
            </select></td>
                    <td><div align="right">Patient Name:</div></td>
                    <td><input type="text" name="patient" value="" class="maintext" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Caller:</td>
                    <td colspan="2"><input type="text" name="caller" value="" class="maintext" size="10" /></td>
                    <td><div align="right">Tel no:</div></td>
                    <td><input type="text" name="telno1" value="" class="maintext" size="10" /></td>
                  </tr>

                  
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Transfer from:</td>
                    <td colspan="2"><select name="tfrfrom" class="maintext">
                      <?php 
do {  
?>
                      <option value="<?php echo $row_tfrom['hospitalID']?>" ><?php echo $row_tfrom['hospital']?></option>
                      <?php
} while ($row_tfrom = mysql_fetch_assoc($tfrom));
?>
                    </select></td>
                    <td><div align="right">Other:</div></td>
                    <td><input name="fromother" type="text" class="maintext" id="fromother" value="" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ward:</td>
                    <td colspan="2"><input type="text" name="wardfrom" value="" class="maintext" size="10" /></td>
                    <td><div align="right">Dr sending:</div></td>
                    <td><input type="text" name="drfrom" value="" class="maintext" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Medical aid:</td>
                    <td colspan="2"><select name="medaid" class="maintext" id="medaid">
                      <?php
do {  
?>
                      <option value="<?php echo $row_medaids['aidID']?>"><?php echo substr($row_medaids['aidname'],0,20)?></option>
                      <?php
} while ($row_medaids = mysql_fetch_assoc($medaids));
  $rows = mysql_num_rows($medaids);
  if($rows > 0) {
      mysql_data_seek($medaids, 0);
	  $row_medaids = mysql_fetch_assoc($medaids);
  }
?>
                    </select></td>
                    <td><div align="right">Med aid no:</div></td>
                    <td><input type="text" name="medaidno" value="" class="maintext" size="10" /></td>
                  </tr>

                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Auth no:</td>
                    <td colspan="2"><input type="text" name="medauthno" value="" class="maintext" size="10" /></td>
                    <td><div align="right">Auth person:</div></td>
                    <td><input type="text" name="medauthperson" value="" class="maintext" size="10" /></td>
                  </tr>

                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Transfer to:</td>
                    <td colspan="2"><select name="tfrto" class="maintext">
                      <?php 
do {  
?>
                      <option value="<?php echo $row_tto['hospitalID']?>" ><?php echo $row_tto['hospital']?></option>
                      <?php
} while ($row_tto = mysql_fetch_assoc($tto));
?>
                    </select></td>
                    <td><div align="right">Other:</div></td>
                    <td><input name="toother" type="text" class="maintext" id="toother" value="" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Ward:</td>
                    <td colspan="2"><input type="text" name="wardto" value="" class="maintext" size="10" /></td>
                    <td><div align="right">Dr receiving:</div></td>
                    <td><input type="text" name="drto" value="" class="maintext" size="10" /></td>
                  </tr>
                  
                  
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Condition:</td>
                    <td colspan="2"><select name="condition" class="maintext">
                      <option value="Medical" <?php if (!(strcmp("Medical", ""))) {echo "SELECTED";} ?>>Medical</option>
                      <option value="Trauma" <?php if (!(strcmp("Trauma", ""))) {echo "SELECTED";} ?>>Trauma</option>
                    </select></td>
                    <td><div align="right">Branch:</div></td>
                    <td><select name="location" class="maintext">
                      <?php 
do {  
?>
                      <option value="<?php echo $row_locs['locationID']?>" ><?php echo $row_locs['location']?></option>
                      <?php
} while ($row_locs = mysql_fetch_assoc($locs));
?>
                    </select></td>
                  </tr>

                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Level of Care:</td>
                    <td><select name="carelevel" class="maintext">
                        <?php 
do {  
?>
                        <option value="<?php echo $row_clevel['levelID']?>" ><?php echo $row_clevel['carelevel']?></option>
                        <?php
} while ($row_clevel = mysql_fetch_assoc($clevel));
?>
                      </select>                    </td>
                    <td align="right" nowrap="nowrap">Priority:</td>
                    <td><select name="priority" class="maintext">
                        <?php 
do {  
?>
                        <option value="<?php echo $row_priorities['pID']?>" ><?php echo $row_priorities['priority']?></option>
                        <?php
} while ($row_priorities = mysql_fetch_assoc($priorities));
?>
                      </select>                    </td>
                    <td>&nbsp;</td>
                  </tr>
                  
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right" valign="top">Notes:</td>
                    <td colspan="3"><textarea name="notes2" cols="25" rows="3" class="maintext"></textarea></td>
                    <td><input type="submit" class="logbutton" value="LOG CALL" /></td>
                  </tr>
                </table>
                <input type="hidden" name="logtime" value="<?php echo time(); ?>" />
                <input type="hidden" name="dispatcher" value="<?php echo $_COOKIE['MM_userID']; ?>" />
                <input type="hidden" name="calltype" value="2" />
                <input type="hidden" name="call_status" value="1" />
                <input type="hidden" name="MM_insert" value="form2" />
              </form>
              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($tfrom);

mysql_free_result($tto);

mysql_free_result($locs);

mysql_free_result($clevel);

mysql_free_result($priorities);

mysql_free_result($medaids);
?>
