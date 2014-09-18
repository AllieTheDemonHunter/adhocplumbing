<?php require_once('Connections/adhocConn.php'); ?>
<?php require_once('inc_before.php'); ?>
<table width="100%" border="1" cellpadding="10" cellspacing="10" bordercolor="#1FA2D0">
  <tr>
    <td valign="top" nowrap="nowrap">
    <?php if ($_POST['searchby'] == "clientsurname") { ?>
        <p align="center">Search by Client Surname:</p>
    <?php } ?>
    <?php if ($_POST['searchby'] == "contact") { ?>
        <p align="center">Search by Contact Person:</p>
    <?php } ?>
    <?php if ($_POST['searchby'] == "contacttel") { ?>
        <p align="center">Search by Telephone Number:</p>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top" nowrap="nowrap" class="smalltext"><p>Recent:</p>
      <?php require_once('_recent4.php'); ?></td>
  </tr>
</table>
<?php require_once('inc_after.php'); ?>
