<?php
if ($_COOKIE['MM_UserGroup'] < 5) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>

<?php require_once('inc_before.php'); ?>
              <p>Fleet Management</p>
              <ul>
                <li><a href="add_fuel.php">Add Fuel Entry</a></li>
                <li><a href="view_fuel.php">View / Edit Fuel Entries</a></li>
                <li>Reports
                  <ul>
                    <li><a href="report_fuel_summary.php">Monthly Summary</a></li>
                    <li><a href="report_detail_per_vehicle.php">Detail Per Vehicle</a></li>
                  </ul>
                </li>
                </ul>              
              <?php require_once('inc_after.php'); ?>

</body>
</html>
