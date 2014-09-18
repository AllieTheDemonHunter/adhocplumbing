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

    if (((strrchr($_FILES["file"]["name"],".") == ".doc") || (strrchr($_FILES["file"]["name"],".") == ".docx") || (strrchr($_FILES["file"]["name"],".") == ".jpg") || (strrchr($_FILES["file"]["name"],".") == ".tif") || (strrchr($_FILES["file"]["name"],".") == ".pdf")) && ($_FILES["file"]["size"] < 1024000)) {
		$filename = $_POST['case_no'] . "_jobcard";
		$new_filename = ereg_replace("[^A-Za-z0-9]", "", $filename );
        $docexists = 'docs/' . $new_filename . ".doc"; 
        $docxexists = 'docs/' . $new_filename . ".docx"; 
        $pdfexists = 'docs/' . $new_filename . ".pdf"; 
        $tiffexists = 'docs/' . $new_filename . ".tif"; 
        $jpegexists = 'docs/' . $new_filename . ".jpg"; 
        if (file_exists($docexists)) {
            $del1 = unlink($docexists);
        }
        if (file_exists($docxexists)) {
            $del1 = unlink($docxexists);
        }
        if (file_exists($pdfexists)) {
            $del1 = unlink($pdfexists);
        }
        if (file_exists($tiffexists)) {
            $del1 = unlink($tiffexists);
        }
        if (file_exists($jpegexists)) {
            $del1 = unlink($jpegexists);
        }
        if ($_FILES["file"]["error"] > 0) {
			$msg = "ERROR: Your file must be .tif, .jpg, .doc, .docx or .pdf format, and less than 1MB in size.<br /><br /><input type=\"button\" value=\"Back\" onclick=\"goBack()\"";
        } else {
			$msg = "Thanks for uploading your file. You may close this window.";
			$display = "thanks";
			$displaythanks = 1;
            move_uploaded_file($_FILES['file']['tmp_name'], "docs/".$new_filename.strrchr($_FILES["file"]["name"],"."));
            ?>
      <?php
          }
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
              <?php echo $msg; ?>
              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($call);
?>
