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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
 	$tfrtime = mktime($_POST['sd_h'],$_POST['sd_i'],0,$_POST['sd_m'],$_POST['sd_d'],$_POST['sd_y']);
 $insertSQL = sprintf("INSERT INTO accident (case_no, acc_type, `timestamp`, location, street, extention, town, saps, traffic, notes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['case_no'], "text"),
                       GetSQLValueString($_POST['acc_type'], "text"),
                       GetSQLValueString($tfrtime, "int"),
                       GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['street'], "text"),
                       GetSQLValueString($_POST['extention'], "text"),
                       GetSQLValueString($_POST['town'], "int"),
                       GetSQLValueString($_POST['saps'], "text"),
                       GetSQLValueString($_POST['traffic'], "text"),
                       GetSQLValueString($_POST['notes'], "text"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());

  $insertGoTo = "accident_report.php?case_no=" . $_POST['case_no'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_adhocConn, $adhocConn);
$query_towns = "SELECT * FROM locations ORDER BY location ASC";
$towns = mysql_query($query_towns, $adhocConn) or die(mysql_error());
$row_towns = mysql_fetch_assoc($towns);
$totalRows_towns = mysql_num_rows($towns);

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
              <p>Add Accident Report              </p>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Accident type:</td>
                    <td><select name="acc_type" class="maintext">
                        <option value="MVA" <?php if (!(strcmp("MVA", ""))) {echo "SELECTED";} ?>>MVA</option>
                        <option value="MBA" <?php if (!(strcmp("MBA", ""))) {echo "SELECTED";} ?>>MBA</option>
                        <option value="PVA" <?php if (!(strcmp("PVA", ""))) {echo "SELECTED";} ?>>PVA</option>
                        <option value="OTHER" <?php if (!(strcmp("OTHER", ""))) {echo "SELECTED";} ?>>OTHER</option>
                      </select>                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Date:</td>
                    <td><?php 
			$sd = getdate(time()); 
			$sd_d = $sd[mday];
			$sd_m = $sd[mon];
			$sd_y = $sd[year];
			$sd_h = $sd[hours];
			$sd_i = $sd[minutes];
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
                        </select>                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Time:</td>
                    <td><select name="sd_h" class="maintext" id="sd_h">
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
                        <option <?php if ($sd_i == "01") {echo "SELECTED";} ?>>01</option>
                        <option <?php if ($sd_i == "02") {echo "SELECTED";} ?>>02</option>
                        <option <?php if ($sd_i == "03") {echo "SELECTED";} ?>>03</option>
                        <option <?php if ($sd_i == "04") {echo "SELECTED";} ?>>04</option>
                        <option <?php if ($sd_i == "05") {echo "SELECTED";} ?>>05</option>
                        <option <?php if ($sd_i == "06") {echo "SELECTED";} ?>>06</option>
                        <option <?php if ($sd_i == "07") {echo "SELECTED";} ?>>07</option>
                        <option <?php if ($sd_i == "08") {echo "SELECTED";} ?>>08</option>
                        <option <?php if ($sd_i == "09") {echo "SELECTED";} ?>>09</option>
                        <option <?php if ($sd_i == "10") {echo "SELECTED";} ?>>10</option>
                        <option <?php if ($sd_i == "11") {echo "SELECTED";} ?>>11</option>
                        <option <?php if ($sd_i == "12") {echo "SELECTED";} ?>>12</option>
                        <option <?php if ($sd_i == "13") {echo "SELECTED";} ?>>13</option>
                        <option <?php if ($sd_i == "14") {echo "SELECTED";} ?>>14</option>
                        <option <?php if ($sd_i == "15") {echo "SELECTED";} ?>>15</option>
                        <option <?php if ($sd_i == "16") {echo "SELECTED";} ?>>16</option>
                        <option <?php if ($sd_i == "17") {echo "SELECTED";} ?>>17</option>
                        <option <?php if ($sd_i == "18") {echo "SELECTED";} ?>>18</option>
                        <option <?php if ($sd_i == "19") {echo "SELECTED";} ?>>19</option>
                        <option <?php if ($sd_i == "20") {echo "SELECTED";} ?>>20</option>
                        <option <?php if ($sd_i == "21") {echo "SELECTED";} ?>>21</option>
                        <option <?php if ($sd_i == "22") {echo "SELECTED";} ?>>22</option>
                        <option <?php if ($sd_i == "23") {echo "SELECTED";} ?>>23</option>
                        <option <?php if ($sd_i == "24") {echo "SELECTED";} ?>>24</option>
                        <option <?php if ($sd_i == "25") {echo "SELECTED";} ?>>25</option>
                        <option <?php if ($sd_i == "26") {echo "SELECTED";} ?>>26</option>
                        <option <?php if ($sd_i == "27") {echo "SELECTED";} ?>>27</option>
                        <option <?php if ($sd_i == "28") {echo "SELECTED";} ?>>28</option>
                        <option <?php if ($sd_i == "29") {echo "SELECTED";} ?>>29</option>
                        <option <?php if ($sd_i == "30") {echo "SELECTED";} ?>>30</option>
                        <option <?php if ($sd_i == "31") {echo "SELECTED";} ?>>31</option>
                        <option <?php if ($sd_i == "32") {echo "SELECTED";} ?>>32</option>
                        <option <?php if ($sd_i == "33") {echo "SELECTED";} ?>>33</option>
                        <option <?php if ($sd_i == "34") {echo "SELECTED";} ?>>34</option>
                        <option <?php if ($sd_i == "35") {echo "SELECTED";} ?>>35</option>
                        <option <?php if ($sd_i == "36") {echo "SELECTED";} ?>>36</option>
                        <option <?php if ($sd_i == "37") {echo "SELECTED";} ?>>37</option>
                        <option <?php if ($sd_i == "38") {echo "SELECTED";} ?>>38</option>
                        <option <?php if ($sd_i == "39") {echo "SELECTED";} ?>>39</option>
                        <option <?php if ($sd_i == "40") {echo "SELECTED";} ?>>40</option>
                        <option <?php if ($sd_i == "41") {echo "SELECTED";} ?>>41</option>
                        <option <?php if ($sd_i == "42") {echo "SELECTED";} ?>>42</option>
                        <option <?php if ($sd_i == "43") {echo "SELECTED";} ?>>43</option>
                        <option <?php if ($sd_i == "44") {echo "SELECTED";} ?>>44</option>
                        <option <?php if ($sd_i == "45") {echo "SELECTED";} ?>>45</option>
                        <option <?php if ($sd_i == "46") {echo "SELECTED";} ?>>46</option>
                        <option <?php if ($sd_i == "47") {echo "SELECTED";} ?>>47</option>
                        <option <?php if ($sd_i == "48") {echo "SELECTED";} ?>>48</option>
                        <option <?php if ($sd_i == "49") {echo "SELECTED";} ?>>49</option>
                        <option <?php if ($sd_i == "50") {echo "SELECTED";} ?>>50</option>
                        <option <?php if ($sd_i == "51") {echo "SELECTED";} ?>>51</option>
                        <option <?php if ($sd_i == "52") {echo "SELECTED";} ?>>52</option>
                        <option <?php if ($sd_i == "53") {echo "SELECTED";} ?>>53</option>
                        <option <?php if ($sd_i == "54") {echo "SELECTED";} ?>>54</option>
                        <option <?php if ($sd_i == "55") {echo "SELECTED";} ?>>55</option>
                        <option <?php if ($sd_i == "56") {echo "SELECTED";} ?>>56</option>
                        <option <?php if ($sd_i == "57") {echo "SELECTED";} ?>>57</option>
                        <option <?php if ($sd_i == "58") {echo "SELECTED";} ?>>58</option>
                        <option <?php if ($sd_i == "59") {echo "SELECTED";} ?>>59</option>
                      </select></td>
                  </tr>

                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Location:</td>
                    <td><input name="location" type="text" class="maintext" value="" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Street:</td>
                    <td><input type="text" name="street" class="maintext" value="" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Extention:</td>
                    <td><input type="text" name="extention" class="maintext" value="" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Town:</td>
                    <td><select name="town" class="maintext">
                      <?php
do {  
?>
                      <option value="<?php echo $row_towns['locationID']?>"><?php echo $row_towns['location']?></option>
                      <?php
} while ($row_towns = mysql_fetch_assoc($towns));
  $rows = mysql_num_rows($towns);
  if($rows > 0) {
      mysql_data_seek($towns, 0);
	  $row_towns = mysql_fetch_assoc($towns);
  }
?>
                                          </select>                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">SAPS officer on scene:</td>
                    <td><input type="text" name="saps" class="maintext" value="" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Was traffic on scene:</td>
                    <td><input type="text" name="traffic" class="maintext" value="" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right" valign="top">Extra notes:</td>
                    <td><textarea name="notes" cols="50" class="maintext" rows="5"></textarea>                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><input type="submit" value="Insert record" class="maintext" /></td>
                  </tr>
                </table>
                <input type="hidden" name="case_no" value="<?php echo $_GET['case_no']; ?>" />
                <input type="hidden" name="MM_insert" value="form1" />
              </form>
              <p>&nbsp;</p></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($towns);

mysql_free_result($prio);

mysql_free_result($medaids);
?>
