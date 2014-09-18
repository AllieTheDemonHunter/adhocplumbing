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

?>
<?php require_once('inc_before.php'); ?>
<h1 class="BlueTextBigTB">Upload Jobcard</h1>
    <form action="upload_jobcard.php" method="post" enctype="multipart/form-data" class="BlueTextBig"><p align="center" class="BlueTextBig">
    <label for="file">Filename:</label>
    <input name="file" type="file" class="BlueTextBig" id="file" /> 
    <br />
    <input name="case_no" type="hidden" id="case_no" value="<?php echo $_GET['case_no']; ?>" />
    <input name="submit" type="submit" class="BlueTextBig" value="Submit" />
    <br />
    <br />
    * Only .tif, .jpg, .pdf, doc and .docx files allowed.
    </p>
      <p align="center" class="BlueTextBig">* Size must be smaller than 1MB.<br />
    <br />
    </p>
    </form>
<?php require_once('inc_after.php'); ?>
