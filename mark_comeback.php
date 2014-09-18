<?php require_once('Connections/adhocConn.php'); ?>
<?php require_once('inc_before.php'); ?>
<?php
mysql_select_db($database_adhocConn, $adhocConn);
$query_oldjob = sprintf("SELECT * FROM call_log WHERE logID = %s", $_GET['logID']);
$oldjob = mysql_query($query_oldjob, $adhocConn) or die(mysql_error());
$row_oldjob = mysql_fetch_assoc($oldjob);
$totalRows_oldjob = mysql_num_rows($oldjob);
?>
<div align="center">
  <p class="logintextbox">MARK AS COMEBACK</p>
  <p>&nbsp;</p>
  <form id="form1" name="form1" method="post" action="log_quote_step_8.php">
    Is this a 
      <input name="button" type="submit" class="redtext2" id="button" value="PAID COMEBACK?" />
      <input name="caller" type="hidden" id="caller" value="<?php echo $row_oldjob['caller']; ?>" />
      <input name="telno1" type="hidden" id="telno1" value="<?php echo $row_oldjob['telno1']; ?>" />
      <input name="addressID" type="hidden" id="addressID" value="<?php echo $row_oldjob['addressID']; ?>" />
      <input name="calltype" type="hidden" id="calltype" value="<?php echo $row_oldjob['calltype']; ?>" />
      <input name="call_status" type="hidden" id="call_status" value="4" />
      <input name="order_no" type="hidden" id="order_no" value="<?php echo $row_oldjob['order_no']; ?>" />
      <input name="policy_no" type="hidden" id="policy_no" value="<?php echo $row_oldjob['policy_no']; ?>" />
      <input name="claim_no" type="hidden" id="claim_no" value="<?php echo $row_oldjob['claim_no']; ?>" />
      <input name="reference_no" type="hidden" id="reference_no" value="<?php echo $row_oldjob['reference_no']; ?>" />
      <input name="access_amt" type="hidden" id="access_amt" value="<?php echo $row_oldjob['access_amt']; ?>" />
      <input name="comeback" type="hidden" id="comeback" value="1" />
      <br />
(Should the customer be charged again?)
    </form>
    <?php 
mysql_free_result($oldjob);
	?>
  <p>&nbsp;</p>
  <p>or</p>
  <p>Is this a  <a href="free_comeback.php?logID=<?php echo $_GET['logID']; ?>c1=<?php echo $_GET['c1']; ?>c2=<?php echo $_GET['c2']; ?>v1=<?php echo $_GET['v1']; ?>" class="greentext">FREE COMEBACK</a>?<br />
  (Repaired free of charge)</p>
  </div>
<?php require_once('inc_after.php'); ?>
