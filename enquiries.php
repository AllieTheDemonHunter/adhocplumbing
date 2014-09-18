<?php
if ($_COOKIE['MM_UserGroup'] < 5) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>

<?php require_once('inc_before.php'); ?>
              <p>Enquiries &amp; Reports</p>
              <ul>
                <li><a href="report_primary.php">Primary Calls - Detail</a></li>
                <li><a href="report_transfer.php">Transfer Calls - Detail</a></li>
                <li><a href="report_pri_trf_summary.php">Primary / Transfer Calls Summary</a></li>
                <li><a href="report_service.php">Service / No Service</a></li>
                <li><a href="report_give_away.php">Give Aways</a></li>
                <li><a href="report_calls_p_area.php">Calls per Area</a></li>
                <li><a href="report_als_ils_bls.php">ALS / ILS / BLS ratio</a></li>
                <li><a href="report_med_trauma.php">Medical / Trauma ratio</a></li>
                <li><a href="report_med_aid_private.php">Medical Aid / Private Call ratio</a></li>
                <li><a href="report_fleet_management.php">Fleet Management</a></li>
              </ul>              <?php require_once('inc_after.php'); ?>

</body>
</html>
