<?php require_once('Connections/adhocConn.php'); ?>
<?php require_once('inc_before.php'); ?>
<table width="100%" border="1" cellpadding="10" cellspacing="10" bordercolor="#1FA2D0">
  <tr>
    <td valign="top" nowrap="nowrap"><p align="center">Search by Category:</p>
            <?php
			$extra = " WHERE category = " . $_POST['category'];
			?>
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top" nowrap="nowrap" class="smalltext"><p>Recent:</p>
      <?php require_once('_recent2.php'); ?></td>
  </tr>
</table>
<?php require_once('inc_after.php'); ?>
