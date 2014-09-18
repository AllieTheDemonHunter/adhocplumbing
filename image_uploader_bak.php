<?php require_once('Connections/adhocConn.php'); ?>
<?php
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<link href="styles.css" rel="stylesheet" type="text/css">
              <table width="700" border="3" align="center" cellpadding="10" cellspacing="0">
                <tr>
                  <td bgcolor="#FFFFFF"><p class="subhead_4">Upload Image</p>
                    <?php if (($_COOKIE['MM_userID']) && ($_COOKIE['MM_UserGroup'] >= 1)) { ?>
                    <p class="bigger_1">
                      <?php
				
				if(isset($_POST['Submit'])) {
					
					$size = 100; // the thumbnail height

					$dir100 = 'photos/100/'; // the directory for the thumbnail image
					$dir600 = 'photos/600/'; // the directory for the original image
					$dir1000 = 'photos/1000/'; // the directory for the original image
					$listingprefix = $_POST['logID'] . "_" . time();
					$filename = $listingprefix . ".jpg";
				
					$maxfile = '2500000';
					$mode = '0666';
					
					$userfile_name = $_FILES['image']['name'];
					$userfile_tmp = $_FILES['image']['tmp_name'];
					$userfile_size = $_FILES['image']['size'];
					$userfile_type = $_FILES['image']['type'];
					$errflag = 0;
					if ($userfile_size >= $maxfile) {
						$errflag = 1;
						$errmsg = "ERROR: File must be smaller than 2.4MB.<br><br>You can use a program like Microsoft Paint to resize your photo.<br><br>Please <a href=\"Javascript:history.back()\">click here</a> to go back.<br><br>";
					}
					if (($userfile_type != "image/pjpeg") && ($userfile_type != "image/jpeg")) {
						$errflag = 1;
						$errmsg = $errmsg . "ERROR: " . $userfile_type . "File is not a JPEG image.<br><br>Please <a href=\"Javascript:history.back()\">click here</a> to go back.<br><br>";
					}
					if ($errflag != 1) {
						if (isset($_FILES['image']['name'])) 
						{
							mysql_select_db($database_adhocConn, $adhocConn);
							$insertSQL = sprintf("INSERT INTO photos (filename, logID, caption, status) VALUES (%s, %s, %s, 2)",
											   GetSQLValueString($filename, "text"),
											   GetSQLValueString($_POST['logID'], "int"),
											   GetSQLValueString($_POST['caption'], "text"));
						
							$Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());
							$prod_img100 = $dir100.$listingprefix.".jpg";
							$prod_img600 = $dir600.$listingprefix.".jpg";
							$prod_img1000 = $dir1000.$listingprefix.".jpg";

							move_uploaded_file($userfile_tmp, $prod_img1000);
							chmod ($prod_img1000, octdec($mode));
							
							$sizes = getimagesize($prod_img1000);
					
							$aspect_ratio = $sizes[1]/$sizes[0]; 
					
							if ($sizes[0] > $sizes[1]) {
								$new_width100 = 100;
								$new_width600 = 600;
								$new_width1000 = 1000;
								$new_height100 = abs($new_width100*$aspect_ratio);
								$new_height600 = abs($new_width600*$aspect_ratio);
								$new_height1000 = abs($new_width1000*$aspect_ratio);
							} else {	
								$new_height100 = 100;
								$new_height600 = 600;
								$new_height1000 = 1000;
								$new_width100 = abs($new_height100/$aspect_ratio);
								$new_width600 = abs($new_height600/$aspect_ratio);
								$new_width1000 = abs($new_height1000/$aspect_ratio);
							}
					
							// 100 resize
							$destimg=ImageCreateTrueColor($new_width100,$new_height100)
								or die('Problem In Creating image');
							$srcimg=ImageCreateFromJPEG($prod_img1000)
								or die('Problem In opening Source Image');
							if(function_exists('imagecopyresampled'))
							{
								imagecopyresampled($destimg,$srcimg,0,0,0,0,$new_width100,$new_height100,ImageSX($srcimg),ImageSY($srcimg))
								or die('Problem In resizing');
							}else{
								Imagecopyresized($destimg,$srcimg,0,0,0,0,$new_width100,$new_height100,ImageSX($srcimg),ImageSY($srcimg))
								or die('Problem In resizing');
							}
							ImageJPEG($destimg,$prod_img100,100)
								or die('Problem In saving');
							imagedestroy($destimg);

							// 600 resize
							$destimg=ImageCreateTrueColor($new_width600,$new_height600)
								or die('Problem In Creating image');
							$srcimg=ImageCreateFromJPEG($prod_img1000)
								or die('Problem In opening Source Image');
							if(function_exists('imagecopyresampled'))
							{
								imagecopyresampled($destimg,$srcimg,0,0,0,0,$new_width600,$new_height600,ImageSX($srcimg),ImageSY($srcimg))
								or die('Problem In resizing');
							}else{
								Imagecopyresized($destimg,$srcimg,0,0,0,0,$new_width600,$new_height600,ImageSX($srcimg),ImageSY($srcimg))
								or die('Problem In resizing');
							}
							ImageJPEG($destimg,$prod_img600,600)
								or die('Problem In saving');
							imagedestroy($destimg);

							// 1000 resize
							$destimg=ImageCreateTrueColor($new_width1000,$new_height1000)
								or die('Problem In Creating image');
							$srcimg=ImageCreateFromJPEG($prod_img1000)
								or die('Problem In opening Source Image');
							if(function_exists('imagecopyresampled'))
							{
								imagecopyresampled($destimg,$srcimg,0,0,0,0,$new_width1000,$new_height1000,ImageSX($srcimg),ImageSY($srcimg))
								or die('Problem In resizing');
							}else{
								Imagecopyresized($destimg,$srcimg,0,0,0,0,$new_width1000,$new_height1000,ImageSX($srcimg),ImageSY($srcimg))
								or die('Problem In resizing');
							}
							ImageJPEG($destimg,$prod_img1000,1000)
								or die('Problem In saving');
							imagedestroy($destimg);

						}
						echo '
						<img src="'.$prod_img100.'">
						<br><br>
						<img src="'.$prod_img600.'">
						<br><br>
						<a href="info.php?caseno='.$_POST['logID'].'">Return to Job Info</a>';
						echo "<br>Original Image Dimensions:<br>Width: " . $sizes[0] . "<br>Height: " . $sizes[1];
					} else {
						echo $errmsg;
					}
				
				}else{
					
					echo '
					<form method="POST" action="'.$_SERVER['PHP_SELF'].'" enctype="multipart/form-data">
					JPEG Uploader<br><br>
					File Name: (.jpg files only) <input type="file" name="image"> (MAX. 1MB)<br>
					<input type="hidden" name="logID" value='.$_GET['logID'].'>
					Caption: <input name="caption" type="text" id="caption" size="50" maxlength="100">
					<input type="Submit" name="Submit" value="Submit">
					</form>';
				}
				
				?>
                    </p>
                    <p class="mainhead_2">&nbsp;</p>
                    </p>
                    <?php } else { ?>
                    <p class="bigger_2">You must be a registered user and logged in to access this page.</p>
                    <p class="bigger_2">Please <a href="login.php" class="bigger_4">click here</a> to login, or <a href="register.php" class="bigger_4">click here</a> to register.</p>
                  <?php } ?>                  </td>
                </tr>
              </table>
</body>
</html>
              