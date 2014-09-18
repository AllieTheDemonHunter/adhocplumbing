<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//  End -->
</script>
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
$query_provs = "SELECT * FROM provinces ORDER BY province ASC";
$provs = mysql_query($query_provs, $adhocConn) or die(mysql_error());
$row_provs = mysql_fetch_assoc($provs);
$totalRows_provs = mysql_num_rows($provs);
?>
<?php require_once('inc_before.php'); ?>
Add User
<blockquote>
  <p>Select Province: </p>
  <form name="form" id="form">
    <blockquote>
      <p id="jumpMenu" name="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
        <select name="jumpMenu" class="maintext" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
          <option value="">please select...</option>
          <?php
do {  
?>
          <option value="add_user.php?provID=<?php echo $row_provs['provinceID']?>"><?php echo $row_provs['province']?></option>
          <?php
} while ($row_provs = mysql_fetch_assoc($provs));
  $rows = mysql_num_rows($provs);
  if($rows > 0) {
      mysql_data_seek($provs, 0);
	  $row_provs = mysql_fetch_assoc($provs);
  }
?>
                </select>
        </p>
    </blockquote>
  </form>
  <p>&nbsp;</p>
</blockquote><?php require_once('inc_after.php'); ?>
<?php
mysql_free_result($provs);
?>
