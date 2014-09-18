<?php require_once('Connections/adhocConn.php'); ?>
<?php
if ($_COOKIE['MM_UserGroup'] < 5) {
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_users = 50;
$pageNum_users = 0;
if (isset($_GET['pageNum_users'])) {
  $pageNum_users = $_GET['pageNum_users'];
}
$startRow_users = $pageNum_users * $maxRows_users;

if ($_COOKIE['MM_UserGroup'] < 5) {
	$extra = "AND accesslevel <= 4";
} else {
	$extra = "";
}
?>
<?php require_once('inc_before.php'); ?>
<?php
mysql_select_db($database_adhocConn, $adhocConn);
$query_users = sprintf("SELECT * FROM users WHERE region = %s %s ORDER BY uname ASC", $myregionID, $extra);
$query_limit_users = sprintf("%s LIMIT %d, %d", $query_users, $startRow_users, $maxRows_users);
$users = mysql_query($query_limit_users, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
$row_users = mysql_fetch_assoc($users);

if (isset($_GET['totalRows_users'])) {
  $totalRows_users = $_GET['totalRows_users'];
} else {
  $all_users = mysql_query($query_users);
  $totalRows_users = mysql_num_rows($all_users);
}
$totalPages_users = ceil($totalRows_users/$maxRows_users)-1;

$queryString_users = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_users") == false && 
        stristr($param, "totalRows_users") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_users = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_users = sprintf("&totalRows_users=%d%s", $totalRows_users, $queryString_users);
?>
              <p>Users</p>
              <blockquote>
                <div align="center">
                  <?php if ($totalRows_users > 0) { // Show if recordset not empty ?>
                    <table border="1" cellpadding="3" cellspacing="0">
                          <tr>
                            <td class="subtext">ID</td>
                            <td class="subtext">name</td>
                            <td class="subtext">username</td>
                            <td class="subtext">email</td>
                            <td class="subtext">cell</td>
                            <td class="subtext">access</td>
                            <td class="subtext">status</td>
                            <td class="subtext">region</td>
                            <td class="subtext">&nbsp;</td>
                          </tr>
                          <?php do { ?>
                            <tr>
                              <td class="subtext"><?php echo $row_users['userID']; ?></td>
                              <td class="subtext"><?php echo $row_users['fullname']; ?></td>
                              <td class="subtext"><?php echo $row_users['uname']; ?></td>
                              <td class="subtext"><a href="mailto:<?php echo $row_users['uemail']; ?>"><?php echo $row_users['uemail']; ?></a></td>
                              <td class="subtext"><?php echo $row_users['ucell']; ?></td>
                              <td class="subtext"><?php
									mysql_select_db($database_adhocConn, $adhocConn);
									$query_alevel = sprintf("SELECT * FROM accesslevels WHERE accesslevelID = %s", $row_users['accesslevel']);
									$alevel = mysql_query($query_alevel, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
									$row_alevel = mysql_fetch_assoc($alevel);
									$totalRows_alevel = mysql_num_rows($alevel);
									echo $row_alevel['accesslevel'];
									mysql_free_result($alevel);
							  ?></td>
                              <td class="subtext"><?php
									mysql_select_db($database_adhocConn, $adhocConn);
									$query_status = sprintf("SELECT * FROM statuses WHERE statusID = %s", $row_users['status']);
									$status = mysql_query($query_status, $adhocConn) or die("LINE ".__LINE__.": ".mysql_error());
									$row_status = mysql_fetch_assoc($status);
									$totalRows_status = mysql_num_rows($status);
									echo $row_status['status'];
									mysql_free_result($status);
							  ?></td>
                              <td class="subtext"><?php
									mysql_select_db($database_adhocConn, $adhocConn);
									$query_rname = sprintf("SELECT * FROM regions WHERE regionID = %s", $row_users['region']);
									$rname = mysql_query($query_rname, $adhocConn) or die(mysql_error());
									$row_rname = mysql_fetch_assoc($rname);
									$totalRows_rname = mysql_num_rows($rname);
									echo $row_rname['region'];
									mysql_free_result($rname);
							  ?></td>
                              <td class="subtext"><a href="edit_user.php?userID=<?php echo $row_users['userID']; ?>">edit</a></td>
                            </tr>
                            <?php } while ($row_users = mysql_fetch_assoc($users)); ?>
                                                      </table>
            <table border="0">
                          <tr>
                            <td><?php if ($pageNum_users > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_users=%d%s", $currentPage, 0, $queryString_users); ?>">First</a>
                                <?php } // Show if not first page ?>                        </td>
                            <td><?php if ($pageNum_users > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_users=%d%s", $currentPage, max(0, $pageNum_users - 1), $queryString_users); ?>">Previous</a>
                                <?php } // Show if not first page ?>                        </td>
                            <td><?php if ($pageNum_users < $totalPages_users) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_users=%d%s", $currentPage, min($totalPages_users, $pageNum_users + 1), $queryString_users); ?>">Next</a>
                                <?php } // Show if not last page ?>                        </td>
                            <td><?php if ($pageNum_users < $totalPages_users) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_users=%d%s", $currentPage, $totalPages_users, $queryString_users); ?>">Last</a>
                                <?php } // Show if not last page ?>                        </td>
                          </tr>
                        </table>
                    <?php } // Show if recordset not empty ?>
</div>
                
                <?php if ($totalRows_users == 0) { // Show if recordset empty ?>
                  <p align="center">No records found</p>
                  <?php } // Show if recordset empty ?>
<p align="center"><a href="add_user.php">Add a User</a></p>
              </blockquote>              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($users);
?>
