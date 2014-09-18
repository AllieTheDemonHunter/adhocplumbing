<?php
if ($_COOKIE['MM_UserGroup'] < 5) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>

<?php require_once('inc_before.php'); ?>
              <p>Fleet Management</p>
              <p>Monthly Summary</p>
              <p align="center">Under Construction</p>
              <?php require_once('inc_after.php'); ?>

</body>
</html>
