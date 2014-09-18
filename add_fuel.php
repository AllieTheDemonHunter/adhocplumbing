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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
	$tfrtime = mktime($_POST['sd_h'],$_POST['sd_i'],0,$_POST['sd_m'],$_POST['sd_d'],$_POST['sd_y']);
	$insertSQL = sprintf("INSERT INTO fuelman (`timestamp`, ob_no, vehicleID, person, km, card_no, litres, oil, `value`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($tfrtime, "int"),
                       GetSQLValueString($_POST['ob_no'], "text"),
                       GetSQLValueString($_POST['vehicleID'], "int"),
                       GetSQLValueString($_POST['person'], "text"),
                       GetSQLValueString($_POST['km'], "int"),
                       GetSQLValueString($_POST['card_no'], "text"),
                       GetSQLValueString($_POST['litres'], "double"),
                       GetSQLValueString($_POST['oil'], "int"),
                       GetSQLValueString($_POST['value'], "double"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());

  $insertGoTo = "report_fleet_management.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_adhocConn, $adhocConn);
$query_vehicles = "SELECT * FROM vehicles ORDER BY vehicle ASC";
$vehicles = mysql_query($query_vehicles, $adhocConn) or die(mysql_error());
$row_vehicles = mysql_fetch_assoc($vehicles);
$totalRows_vehicles = mysql_num_rows($vehicles);

if ($_COOKIE['MM_UserGroup'] < 5) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>

<?php require_once('inc_before.php'); ?>
              <p>Fleet Management:</p>
              <p>Add Fuel Entry:              </p>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                <table align="center">
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
            </select>
</td>
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
                    <td nowrap="nowrap" align="right">OB No:</td>
                    <td><input name="ob_no" type="text" class="maintext" value="" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Vehicle:</td>
                    <td><select name="vehicleID" class="maintext">
                        <?php 
do {  
?>
                        <option value="<?php echo $row_vehicles['vehicleID']?>" ><?php echo $row_vehicles['vehicle']?> - <?php echo $row_vehicles['regno']?></option>
                        <?php
} while ($row_vehicles = mysql_fetch_assoc($vehicles));
?>
                      </select>                    </td>
                  </tr>
                  <tr> </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Person:</td>
                    <td><input name="person" type="text" class="maintext" value="" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Odometer:</td>
                    <td><input name="km" type="text" class="maintext" value="" size="5" maxlength="7" />
                      km</td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Card No:</td>
                    <td><input name="card_no" type="text" class="maintext" value="" size="10" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Fuel:</td>
                    <td><input name="litres" type="text" class="maintext" value="" size="6" />
                      litres</td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Oil:</td>
                    <td><input name="oil" type="text" class="maintext" value="" size="6" />
                      ml</td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Value:</td>
                    <td>R
                      <input name="value" type="text" class="maintext" value="" size="6" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><input type="submit" class="maintext" value="ADD" /></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form2" />
              </form>
              <p align="center"><a href="report_fleet_management.php">Back to Fleet Management</a></p>
              <?php require_once('inc_after.php'); ?>

</body>
</html>
<?php
mysql_free_result($vehicles);
?>
