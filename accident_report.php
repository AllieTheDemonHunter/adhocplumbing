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

$maxRows_accrep = 10;
$pageNum_accrep = 0;
if (isset($_GET['pageNum_accrep'])) {
  $pageNum_accrep = $_GET['pageNum_accrep'];
}
$startRow_accrep = $pageNum_accrep * $maxRows_accrep;

$colname_accrep = "-1";
if (isset($_GET['case_no'])) {
  $colname_accrep = $_GET['case_no'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_accrep = sprintf("SELECT * FROM accident WHERE case_no = %s", GetSQLValueString($colname_accrep, "text"));
$query_limit_accrep = sprintf("%s LIMIT %d, %d", $query_accrep, $startRow_accrep, $maxRows_accrep);
$accrep = mysql_query($query_limit_accrep, $adhocConn) or die(mysql_error());
$row_accrep = mysql_fetch_assoc($accrep);

if (isset($_GET['totalRows_accrep'])) {
  $totalRows_accrep = $_GET['totalRows_accrep'];
} else {
  $all_accrep = mysql_query($query_accrep);
  $totalRows_accrep = mysql_num_rows($all_accrep);
}
$totalPages_accrep = ceil($totalRows_accrep/$maxRows_accrep)-1;

$colname_accveh = "-1";
if (isset($_GET['accID'])) {
  $colname_accveh = $_GET['accID'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_accveh = sprintf("SELECT * FROM acc_vehicle WHERE accID = %s ORDER BY vehID ASC", GetSQLValueString($colname_accveh, "int"));
$accveh = mysql_query($query_accveh, $adhocConn) or die(mysql_error());
$row_accveh = mysql_fetch_assoc($accveh);
$totalRows_accveh = mysql_num_rows($accveh);

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
<body onLoad="MM_preloadImages('design/mouseovers_r3_c1.jpg','design/mouseovers_r2_c1.jpg','design/mouseovers_r1_c1.jpg','design/home_screen_over.jpg','design/launch_r.jpg','design/forms_over.jpg')"><table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
    <td height="613" valign="top"><table width="950" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="613" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="15">
          <tr>
            <td valign="top" bgcolor="#FFFFFF">
              <p>Accident Report              </p>
              
              <div align="center">
                <?php if ($totalRows_accrep > 0) { // Show if recordset not empty ?>
                  <table border="1" cellpadding="3" cellspacing="0" width="100%">
                        <tr>
                          <td>case_no</td>
                          <td>type</td>
                          <td>date &amp; time</td>
                          <td>location</td>
                          <td>street</td>
                          <td>extention</td>
                          <td>town</td>
                          <td>saps</td>
                          <td>traffic</td>
                          <td>notes</td>
                        </tr>
                          <tr>
                            <td><?php echo $row_accrep['case_no']; ?></td>
                            <td><?php echo $row_accrep['acc_type']; ?></td>
                            <td><?php echo date("d M Y H:i", $row_accrep['timestamp']); ?></td>
                            <td><?php echo $row_accrep['location']; ?></td>
                            <td><?php echo $row_accrep['street']; ?></td>
                            <td><?php echo $row_accrep['extention']; ?></td>
                            <td><?php
								mysql_select_db($database_adhocConn, $adhocConn);
								$query_loc = sprintf("SELECT * FROM locations WHERE locationID = %s", $row_accrep['town']);
								$loc = mysql_query($query_loc, $adhocConn) or die(mysql_error());
								$row_loc = mysql_fetch_assoc($loc);
								$totalRows_loc = mysql_num_rows($loc);
								echo $row_loc['location'];
								mysql_free_result($loc);
							?></td>
                            <td><?php echo $row_accrep['saps']; ?></td>
                            <td><?php echo $row_accrep['traffic']; ?></td>
                            <td><?php echo $row_accrep['notes']; ?></td>
                          </tr>
                                    </table>
                  			<br />
                    <table border="1" cellpadding="3" cellspacing="0" width="100%">
                      <tr>
                        <td>reg no</td>
                              <td>make</td>
                              <td>colour</td>
                              <td>dname</td>
                              <td>dtelno</td>
                              <td>dcellno</td>
                              <td>dliquor</td>
                              <td>passengers</td>
                              <td>relationship</td>
                              <td>position</td>
                              <td>safety_belt</td>
                            </tr>
                            <?php do { ?>
                            <tr>
                              <td><?php echo $row_accveh['regno']; ?></td>
                                <td><?php echo $row_accveh['make']; ?></td>
                                <td><?php echo $row_accveh['colour']; ?></td>
                                <td><?php echo $row_accveh['dname']; ?></td>
                                <td><?php echo $row_accveh['dtelno']; ?></td>
                                <td><?php echo $row_accveh['dcellno']; ?></td>
                                <td><?php echo $row_accveh['dliquor']; ?></td>
                                <td><?php echo $row_accveh['passengers']; ?></td>
                                <td><?php echo $row_accveh['relationship']; ?></td>
                                <td><?php echo $row_accveh['position']; ?></td>
                                <td><?php echo $row_accveh['safety_belt']; ?></td>
                              </tr>
                              <?php } while ($row_accveh = mysql_fetch_assoc($accveh)); ?>
                    </table>
                          <p align="center"><a href="add_accident_vehicle.php?accID=<?php echo $row_accrep['accID']; ?>&case_no=<?php echo $_GET['case_no']; ?>">add a vehicle</a></p>
                          <p>
                            <?php } else { ?>
                            None found - <a href="add_accident_report.php?case_no=<?php echo $_GET['case_no']; ?>">Add Accident Report</a>
                            <?php } ?>
                          </p>
                          <p><a href="prf_control_panel.php">Back to PRF Control Panel</a> </p>
              </div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($accrep);

mysql_free_result($accveh);
?>