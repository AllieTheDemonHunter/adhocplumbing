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
  $insertSQL = sprintf("INSERT INTO acc_vehicle (accID, regno, make, colour, dname, dtelno, dcellno, dliquor, passengers, relationship, `position`, safety_belt) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['accID'], "int"),
                       GetSQLValueString($_POST['regno'], "text"),
                       GetSQLValueString($_POST['make'], "text"),
                       GetSQLValueString($_POST['colour'], "text"),
                       GetSQLValueString($_POST['dname'], "text"),
                       GetSQLValueString($_POST['dtelno'], "text"),
                       GetSQLValueString($_POST['dcellno'], "text"),
                       GetSQLValueString($_POST['dliquor'], "int"),
                       GetSQLValueString($_POST['passengers'], "int"),
                       GetSQLValueString($_POST['relationship'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['safety_belt'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());

  $insertGoTo = "accident_report.php?case_no=" . $_POST['case_no'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
              <p>Add Vehicle to Accident Report              </p>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Reg no:</td>
                    <td><input name="regno" type="text" class="maintext" value="" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Make:</td>
                    <td><input type="text" name="make" class="maintext" value="" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Colour:</td>
                    <td><input type="text" name="colour" class="maintext" value="" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Driver name:</td>
                    <td><input type="text" name="dname" class="maintext" value="" size="20" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Driver tel no:</td>
                    <td><input type="text" name="dtelno" class="maintext" value="" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Driver cell no:</td>
                    <td><input type="text" name="dcellno" class="maintext" value="" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Liquor suspected:</td>
                    <td><select name="dliquor" class="maintext">
                        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Yes</option>
                        <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>No</option>
                      </select>
                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Passengers:</td>
                    <td><select name="passengers" class="maintext">
                        <option  >1</option>
                        <option  >2</option>
                        <option  >3</option>
                        <option  >4</option>
                        <option  >5</option>
                        <option  >6</option>
                        <option  >7</option>
                        <option  >8</option>
                        <option  >9</option>
                        <option  >10</option>
                        <option  >11</option>
                        <option  >12</option>
                        <option  >13</option>
                        <option  >14</option>
                        <option  >15</option>
                        <option  >16</option>
                        <option  >17</option>
                        <option  >18</option>
                        <option  >19</option>
                        <option  >20</option>
                        <option  >21</option>
                        <option  >22</option>
                        <option  >23</option>
                        <option  >24</option>
                        <option  >25</option>
                        <option  >26</option>
                        <option  >27</option>
                        <option  >28</option>
                        <option  >29</option>
                        <option  >30</option>
                        <option  >31</option>
                        <option  >32</option>
                        <option  >33</option>
                        <option  >34</option>
                        <option  >35</option>
                        <option  >36</option>
                        <option  >37</option>
                        <option  >38</option>
                        <option  >39</option>
                        <option  >40</option>
                        <option  >41</option>
                        <option  >42</option>
                        <option  >43</option>
                        <option  >44</option>
                        <option  >45</option>
                        <option  >46</option>
                        <option  >47</option>
                        <option  >48</option>
                        <option  >49</option>
                        <option  >50</option>
                        <option  >51</option>
                        <option  >52</option>
                        <option  >53</option>
                        <option  >54</option>
                        <option  >55</option>
                        <option  >56</option>
                        <option  >57</option>
                        <option  >58</option>
                        <option  >59</option>
                        <option  >60</option>
                      </select>
                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Relationship to driver:</td>
                    <td><input type="text" name="relationship" class="maintext" value="" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Position of seating:</td>
                    <td><input type="text" name="position" class="maintext" value="" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Did passenger wear a safety belt:</td>
                    <td><select name="safety_belt" class="maintext">
                        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Yes</option>
                        <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>No</option>
                      </select>
                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><input type="submit" value="Insert record" class="maintext" /></td>
                  </tr>
                </table>
                <input type="hidden" name="case_no" value="<?php echo $_GET['case_no']; ?>" />
                <input type="hidden" name="accID" value="<?php echo $_GET['accID']; ?>" />
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
mysql_free_result($prio);

mysql_free_result($medaids);
?>
