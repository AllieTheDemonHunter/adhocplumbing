<?php require_once('Connections/adhocConn.php'); ?>
<?php require_once('inc_before.php'); ?>
<table width="100%" border="1" cellpadding="10" cellspacing="10" bordercolor="#1FA2D0">
  <tr>
    <td valign="top" nowrap="nowrap">
    <?php if ($_POST['searchby'] == "clientsurname") { ?>
        <p align="center">Search by Client Surname:</p>
		<?php $extra = " WHERE surname = '" . $_POST['searchfor'] . "'"; ?>
    <?php } ?>
    <?php if ($_POST['searchby'] == "idno") { ?>
        <p align="center">Search by Client ID No:</p>
		<?php $extra = " WHERE idno = '" . $_POST['searchfor'] . "'"; ?>
    <?php } ?>
    <?php if ($_POST['searchby'] == "contact") { ?>
        <p align="center">Search by Contact Person:</p>
		<?php $extra = " WHERE caller = '" . $_POST['searchfor'] . "'"; ?>
    <?php } ?>
    <?php if ($_POST['searchby'] == "caseno") { ?>
        <p align="center">Search by Case Number:</p>
		<?php $extra = " WHERE logID = '" . $_POST['searchfor'] . "'"; ?>
    <?php } ?>
    <?php if ($_POST['searchby'] == "newcaseno") { ?>
        <p align="center">Search by Jobcard Number:</p>
		<?php $extra = " WHERE jobcard_no = '" . $_POST['searchfor'] . "'"; ?>
    <?php } ?>
    <?php if ($_POST['searchby'] == "claimno") { ?>
        <p align="center">Search by Claim Number:</p>
		<?php $extra = " WHERE claim_no = '" . $_POST['searchfor'] . "'"; ?>
    <?php } ?>
    <?php if ($_POST['searchby'] == "refno") { ?>
        <p align="center">Search by Reference Number:</p>
		<?php $extra = " WHERE reference_no = '" . $_POST['searchfor'] . "'"; ?>
    <?php } ?>
    <?php if ($_POST['searchby'] == "policyno") { ?>
        <p align="center">Search by Policy Number:</p>
		<?php $extra = " WHERE policy_no = '" . $_POST['searchfor'] . "'"; ?>
    <?php } ?>
    <?php if ($_POST['searchby'] == "orderno") { ?>
        <p align="center">Search by Order Number:</p>
		<?php $extra = " WHERE order_no = '" . $_POST['searchfor'] . "'"; ?>
    <?php } ?>
    <?php if ($_POST['searchby'] == "contacttel") { ?>
        <p align="center">Search by Telephone Number:</p>
		<?php $extra = " WHERE telno1 = '" . $_POST['searchfor'] . "' OR telno2 = '" . $_POST['searchfor'] . "' OR telno3 = '" . $_POST['searchfor'] . "'"; ?>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top" nowrap="nowrap" class="smalltext"><p>Recent:</p>
      <?php require_once('_recent3.php'); ?></td>
  </tr>
</table>
<?php require_once('inc_after.php'); ?>
