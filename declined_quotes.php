<?php require_once('inc_before.php'); ?>
&nbsp;Declined Quotes<br />
<br />
<?php
$extra = " WHERE call_status = 9 AND region = " . $myregionID . " ";
?>
<?php require_once('_recent.php'); ?>
<?php require_once('inc_after.php'); ?>
