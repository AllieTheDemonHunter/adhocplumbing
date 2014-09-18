<?php require_once('inc_before.php'); ?>
&nbsp;History<br />
<br />
<?php 
$extra = " WHERE call_log.clientID = " . $_GET['clientID'];
?>
<?php require_once('_recent.php'); ?>
<?php require_once('inc_after.php'); ?>
