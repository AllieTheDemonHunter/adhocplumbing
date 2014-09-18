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
 
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
 $condition = $_POST['nature'] . " - " . $_POST['naturedetail'];
 $updateSQL = sprintf("UPDATE call_log SET service=%s, jobcard_no=%s, ins_receipt_no=%s, actual_job=%s, patch_work=%s, notes=%s, capturer=%s, job_complete=%s,call_status=6 WHERE logID=%s",
                       GetSQLValueString($_POST['service'], "text"),
                       GetSQLValueString($_POST['jobcard_no'], "text"),
                       GetSQLValueString($_POST['ins_receipt_no'], "text"),
                       GetSQLValueString($condition, "text"),
                       GetSQLValueString($_POST['notes'], "text"),
                       GetSQLValueString($_POST['capturer'], "int"),
        GetSQLValueString($_POST['patch_work'], "text"),
        GetSQLValueString($_POST['job_complete'], "int"),
                       GetSQLValueString($_POST['logID'], "int"));
 
  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
  
  $updateGoTo = "control_panel_jobs.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
 
$colname_call = "-1";
if (isset($_GET['caseno'])) {
  $colname_call = $_GET['caseno'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_call = sprintf("SELECT * FROM call_log WHERE logID = %s", GetSQLValueString($colname_call, "int"));
$call = mysql_query($query_call, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_call = mysql_fetch_assoc($call);
$totalRows_call = mysql_num_rows($call);
 
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
<SCRIPT LANGUAGE="JavaScript">
function setOptions(chosen) 
{ 
 var naturedetail = document.form2.naturedetail.value; 
 var selbox = document.form2.naturedetail; 
 selbox.options.length = 0; 
 if (chosen == " ") { 
  selbox.options[selbox.options.length] = new Option('Please select one of the options above first',' '); 
 } 
 if (chosen == "Geyser Replacements") { 
  selbox.options[selbox.options.length] = new Option('50 litre','50 litre');
  selbox.options[selbox.options.length] = new Option('100 litre','100 litre');
  selbox.options[selbox.options.length] = new Option('150 litre','150 litre');
  selbox.options[selbox.options.length] = new Option('200 litre','200 litre');
  selbox.options[selbox.options.length] = new Option('250 litre','250 litre');
  selbox.options[selbox.options.length] = new Option('Other','Other');
 } 
 if (chosen == "Solar Geyser") { 
  selbox.options[selbox.options.length] = new Option('150 litre','150 litre');
  selbox.options[selbox.options.length] = new Option('200 litre','200 litre');
  selbox.options[selbox.options.length] = new Option('250 litre','250 litre');
  selbox.options[selbox.options.length] = new Option('Other','Other');
 } 
 if (chosen == "Blockages") { 
  selbox.options[selbox.options.length] = new Option('Drains Commercial');
  selbox.options[selbox.options.length] = new Option('Industrial');
  selbox.options[selbox.options.length] = new Option('Urinal Blocked');
  selbox.options[selbox.options.length] = new Option('Toilet Blocked');
  selbox.options[selbox.options.length] = new Option('Gulley Blocked');
  selbox.options[selbox.options.length] = new Option('Storm Water Blocked');
  selbox.options[selbox.options.length] = new Option('Sink');
  selbox.options[selbox.options.length] = new Option('Basin');
  selbox.options[selbox.options.length] = new Option('Bath');
  selbox.options[selbox.options.length] = new Option('Shower');
  selbox.options[selbox.options.length] = new Option('Other','Other');
 } 
 if (chosen == "Geyser Repairs") { 
  selbox.options[selbox.options.length] = new Option('Replaced Element');
  selbox.options[selbox.options.length] = new Option('Replaced Thermostat');
  selbox.options[selbox.options.length] = new Option('Replaced Safety Valve');
  selbox.options[selbox.options.length] = new Option('Replaced Thermostat & Safety Valve');
  selbox.options[selbox.options.length] = new Option('No Hot Water');
  selbox.options[selbox.options.length] = new Option('Leaking Geyser');
  selbox.options[selbox.options.length] = new Option('Vacuum Breakers');
  selbox.options[selbox.options.length] = new Option('PRV Master Flow Valve');
  selbox.options[selbox.options.length] = new Option('Calefi 200kpa');
  selbox.options[selbox.options.length] = new Option('Calefi 300kpa');
  selbox.options[selbox.options.length] = new Option('Calefi 400kpa');
  selbox.options[selbox.options.length] = new Option('Calefi 600kpa');
  selbox.options[selbox.options.length] = new Option('Other','Other');
 } 
 if (chosen == "Burst Pipes") { 
  selbox.options[selbox.options.length] = new Option('Commercial');
  selbox.options[selbox.options.length] = new Option('Industrial');
 } 
 if (chosen == "Construction") { 
  selbox.options[selbox.options.length] = new Option('Basin');
  selbox.options[selbox.options.length] = new Option('Bath');
  selbox.options[selbox.options.length] = new Option('Urinal');
  selbox.options[selbox.options.length] = new Option('Repipe');
  selbox.options[selbox.options.length] = new Option('Shower');
  selbox.options[selbox.options.length] = new Option('Complete Bathroom');
  selbox.options[selbox.options.length] = new Option('Other','Other');
 } 
 if (chosen == "Seeping Water") { 
  selbox.options[selbox.options.length] = new Option('Tiles');
  selbox.options[selbox.options.length] = new Option('Wall');
  selbox.options[selbox.options.length] = new Option('Floor');
  selbox.options[selbox.options.length] = new Option('Ground');
  selbox.options[selbox.options.length] = new Option('Paving');
  selbox.options[selbox.options.length] = new Option('Other','Other');
 } 
 if (chosen == "Service Toilet") { 
  selbox.options[selbox.options.length] = new Option('Replace Ball Valve');
  selbox.options[selbox.options.length] = new Option('Replace Flexi Connectors');
  selbox.options[selbox.options.length] = new Option('Putty Joint');
  selbox.options[selbox.options.length] = new Option('Replace Handle');
  selbox.options[selbox.options.length] = new Option('Replace Arm');
  selbox.options[selbox.options.length] = new Option('Replace Rubber Cone');
  selbox.options[selbox.options.length] = new Option('Other','Other');
 } 
 if (chosen == "Toilet/Urinal Flushmaster") { 
  selbox.options[selbox.options.length] = new Option('Service');
  selbox.options[selbox.options.length] = new Option('Repl Push Button');
  selbox.options[selbox.options.length] = new Option('Repl Piston');
  selbox.options[selbox.options.length] = new Option('Handle Kit');
  selbox.options[selbox.options.length] = new Option('Replace');
 } 
 if (chosen == "Industrial Work") { 
  selbox.options[selbox.options.length] = new Option('Install Pump');
  selbox.options[selbox.options.length] = new Option('Boiler Problems');
  selbox.options[selbox.options.length] = new Option('Basement Floods');
  selbox.options[selbox.options.length] = new Option('Pump Out');
  selbox.options[selbox.options.length] = new Option('Premises without water');
  selbox.options[selbox.options.length] = new Option('Big Re-Pipe');
 } 
 if (chosen == "General Maintenance") { 
  selbox.options[selbox.options.length] = new Option('Leaking Taps');
  selbox.options[selbox.options.length] = new Option('Leaking Shower');
  selbox.options[selbox.options.length] = new Option('Other','Other');
 } 
} 
--> 
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
<p align="center" class="logbutton">Case No: <?php echo $row_call['logID']; ?></p> <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
   <table border="0" align="center" cellpadding="1" cellspacing="0">
     <tr valign="baseline">
       <td nowrap="nowrap" align="right">Service:</td>
       <td><select name="service" class="maintext">
         <option value="Service" <?php if (!(strcmp("Service", $row_call['service']))) {echo "selected=\"selected\"";} ?>>Service</option>
         <option value="No Service - Cancelled in route" <?php if (!(strcmp("No Service", $row_call['service']))) {echo "selected=\"selected\"";} ?>>No Service - Cancelled in route</option>
         <option value="No Service - Other" <?php if (!(strcmp("No Service", $row_call['service']))) {echo "selected=\"selected\"";} ?>>No Service - Other</option>
       </select></td>
                  </tr>
                  
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Jobcard No:</td>
                    <td><input type="text" name="jobcard_no" value="<?php echo htmlentities($row_call['jobcard_no'], ENT_COMPAT, 'utf-8'); ?>" size="12" class="maintext" />                    
                    - <a href="upload.php?case_no=<?php echo $colname_call; ?>" target="_blank">upload jobcard</a> (new window)</td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Insurance Receipt No:</td>
                    <td><input type="text" name="ins_receipt_no" value="<?php echo htmlentities($row_call['ins_receipt_no'], ENT_COMPAT, 'utf-8'); ?>" size="12" class="maintext" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap">Job Completed:</td>
                    <td><input <?php if (!(strcmp($row_call['job_complete'],1))) {echo "checked=\"checked\"";} ?> name="job_complete" type="checkbox" id="job_complete" value="1" /></td>
                  </tr>
                  <tr valign="baseline">
                      <td><div align="right">
                        <div align="right">Actual Job Done:</div>
                      </div></td>
                      <td><select name="nature" class="maintext" id="nature" onchange="setOptions(document.form2.nature.options[document.form2.nature.selectedIndex].value);">
                        <option>same as on jobcard</option>
                        <option value="Blockages">Blockages</option>
                        <option value="Burst Pipes">Burst Pipes</option>
                        <option value="Construction">Construction</option>
                        <option value="General Maintenance">General Maintenance</option>
                        <option value="Geyser Repairs">Geyser Repairs</option>
                        <option value="Geyser Replacements">Geyser Replacements</option>
                        <option value="Industrial Work">Industrial Work</option>
                        <option value="Seeping Water">Seeping Water</option>
                        <option value="Service Toilet">Service Toilet</option>
                        <option value="Solar Geyser">Solar Geyser</option>
                        <option value="Toilet/Urinal Flushmaster">Toilet/Urinal Flushmaster</option>
                      </select>
                        <br />
                          <select name="naturedetail" class="maintext" id="naturedetail">
                          </select></td>
                    </tr>
                   
                     <tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap">Patchwork:</td>
                    <td>
                      <select name="patch_work" class="maintext">
                        <option value="No" <?php if (!(strcmp("No", ""))) {echo "SELECTED";} ?>>No</option>
                        <option value="Yes" <?php if (!(strcmp("Yes", ""))) {echo "SELECTED";} ?>>Yes</option>
                      </select></td>
                    
                    </tr>
                     <tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap">Notes:</td>
                    <td><textarea name="notes" cols="40" rows="3" class="maintext"><?php echo htmlentities($row_call['notes'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <!--<tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap">Consequential Damage:</td>
                    <td><select name="Consequential Damage" class="maintext">
                    <option value="">select ....</option>
                      <option value="Consequential Damage" <?php //if (!(strcmp("yes", $row_call['Yes']))) {echo "selected=\"selected\"";} ?>>Yes</option>
                      <option value="No" <?php //if (!(strcmp("No", $row_call['no']))) {echo "selected=\"selected\"";} ?>>No</option>
                      
                    </select></td>
                    </tr>-->
                    <!-- <tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap">Note:</td>
                    <td><textarea name="notes" cols="40" rows="3" class="maintext"><?php //echo htmlentities($row_call['patch_work'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
                    </tr>-->
                    <tr><td>&nbsp;</td></tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><div align="right">
                      <input type="submit" class="maintext" value="Update record" />
                    </div></td>
                    </tr>
                </table>
<input type="hidden" name="capturer" value="<?php echo $_COOKIE['MM_userID']; ?>" />
                <input type="hidden" name="MM_update" value="form2" />
                <input type="hidden" name="logID" value="<?php echo $row_call['logID']; ?>" />
              </form>
              <?php require_once('inc_after.php'); ?>
 
</body>
</html>
<?php
//mysql_free_result($call);
?>
