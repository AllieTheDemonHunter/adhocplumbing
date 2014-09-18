<?php require_once('Connections/adhocConn.php'); ?>
<?php
if(isset($_FILES['files'])){
    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$index = time() + $key;
		$logID = $_POST['logID'];
		$file_name = $logID."_".$index.".jpg";
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
        if($file_size > 2097152){
			$errors[]='File size must be less than 2 MB';
        }		
		mysql_select_db($database_adhocConn, $adhocConn);
		$insertSQL = sprintf("INSERT INTO photos (filename, logID, status) VALUES ('%s', %s, 2)", $file_name, $logID);
	

        if(empty($errors)==true){
			move_uploaded_file($file_tmp,"photos/1000/".$file_name);
			$Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());
			
			
			
			$dir100 = 'photos/100/'; // the directory for the thumbnail image
			$dir600 = 'photos/600/'; // the directory for the original image
			$dir1000 = 'photos/1000/'; // the directory for the original image
			$listingprefix = $file_name;

			$prod_img100 = $dir100.$listingprefix;
			$prod_img600 = $dir600.$listingprefix;
			$prod_img1000 = $dir1000.$listingprefix;

			$maxfile = '2500000';
			$mode = '0666';
			
			$userfile_name = $_FILES['image']['name'][$key];
			$userfile_tmp = $_FILES['image']['tmp_name'][$key];
			$userfile_size = $_FILES['image']['size'][$key];
			$userfile_type = $_FILES['image']['type'][$key];
			$errflag = 0;

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
			echo $userfile_tmp;
			$srcimg=ImageCreateFromJPEG($prod_img1000)
				or die('Problem In opening Source Image');
			$destimg=ImageCreateTrueColor($new_width100,$new_height100)
				or die('Problem In Creating image');
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
			
		
			
        }else{
			print_r($errors);
        }
    }
	if(empty($error)){
		$insertGoTo = "info.php?caseno=" . $_POST['logID'];
		header(sprintf("Location: %s", $insertGoTo));
	}
}
?>


<p>MULTIPLE IMAGE UPLOADER</p>
<form action="" method="POST" enctype="multipart/form-data">
	<p>
  <input type="file" name="files[]" multiple/>
  <input type="hidden" name="logID" value="<?php echo $_GET['logID']; ?>">
	  <input type="submit"/>
</p>
	<p>(Hold down Ctrl when selecting to select multiple images)</p>
</form>
