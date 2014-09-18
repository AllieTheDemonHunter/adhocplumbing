<?php require_once('inc_before.php'); ?>
&nbsp;Expired Quotes<br />
<br />
<?php
$time30days = time() - 2592000;
$extra = " WHERE call_status = 3 AND region = " . $myregionID . " AND logtime < " . $time30days;
?>
<?php require_once('_recent.php'); ?>
<?php require_once('inc_after.php'); ?>
