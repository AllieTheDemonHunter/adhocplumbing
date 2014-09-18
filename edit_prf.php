<?php require_once('Connections/adhocConn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $updateSQL = sprintf("UPDATE prf SET inv_no=%s, `primary`=%s, trauma=%s, bls=%s, iht=%s, medical=%s, als=%s, ils=%s, c_name=%s, c_id=%s, c_age=%s, c_sex=%s, c_from=%s, c_to=%s, c_physical=%s, c_postal=%s, c_handoverto=%s, c_receiving=%s, r_id=%s, c_tel=%s, med_aid=%s, med_aid_no=%s, med_principal=%s, med_relationship=%s, employer=%s, emp_tel=%s, emp_address=%s, h_dispatcher=%s, h_dispatch_info=%s, h_on_arrival=%s, h_main_complaint=%s, ph_allergies=%s, ph_medication=%s, ph_med_surg=%s, ph_lastmeal=%s, ps_air_clear=%s, ps_air_maint=%s, ps_air_intub=%s, ps_air_surg=%s, ps_air_ett=%s, ps_air_depth=%s, ps_trachea=%s, ps_air_entry=%s, ps_extra_sounds=%s, ps_mechanics=%s, ps_neck_veins=%s, ps_haemorrhage=%s, ps_perfusion=%s, ps_perf_colour=%s, ps_pulses=%s, ps_initial_gcs_15=%s, ps_initial_e_4=%s, ps_initial_m_6=%s, ps_initial_v_5=%s, ps_spinal_motor=%s, ps_spinal_sensory=%s, ss_head_neck=%s, ss_chest=%s, ss_cvs=%s, ss_abdomen=%s, ss_pelvis=%s, ss_extremities=%s, ss_spine=%s, ss_icd_10=%s, ss_diagnosis=%s, ss_priority=%s, management=%s, fluid_blood=%s, fluid_secretions=%s, fluid_enteric=%s, fluid_drains=%s, fluid_urine=%s, fluid_total=%s, ecg_analysis=%s, ecg_defib=%s, ecg_pacing=%s, ecg_time1=%s, ecg_joules1=%s, ecg_time2=%s, ecg_joules2=%s, ecg_time3=%s, ecg_joules3=%s, ecg_time=%s, ecg_rate=%s, ecg_ma=%s, al_logroll=%s, al_veh_ex=%s, al_spineboard=%s, al_scoop=%s, al_cerv_collar=%s, al_headblocks=%s, al_spider=%s, al_ked=%s, air_suction=%s, air_oro=%s, air_oral=%s, air_nasal=%s, air_surgical=%s, br_oxygen=%s, br_60=%s, br_neb=%s, br_nasal=%s, br_chest=%s, br_underwater=%s, br_heimlich=%s, cir_ecg=%s, cir_iv=%s, cir_io=%s, cir_hicap=%s, cir_pacing=%s, cir_cpr=%s, cir_colloids=%s, cir_dial=%s, oth_urine=%s, oth_gastric=%s, oth_stretcher=%s, oth_wheelchair=%s, personnel_items=%s WHERE prfID=%s",
                       GetSQLValueString($_POST['inv_no'], "text"),
                       GetSQLValueString($_POST['primary'], "int"),
                       GetSQLValueString($_POST['trauma'], "int"),
                       GetSQLValueString($_POST['bls'], "int"),
                       GetSQLValueString($_POST['iht'], "int"),
                       GetSQLValueString($_POST['medical'], "int"),
                       GetSQLValueString($_POST['als'], "int"),
                       GetSQLValueString($_POST['ils'], "int"),
                       GetSQLValueString($_POST['c_name'], "text"),
                       GetSQLValueString($_POST['c_id'], "text"),
                       GetSQLValueString($_POST['c_age'], "text"),
                       GetSQLValueString($_POST['c_sex'], "text"),
                       GetSQLValueString($_POST['c_from'], "text"),
                       GetSQLValueString($_POST['c_to'], "text"),
                       GetSQLValueString($_POST['c_physical'], "text"),
                       GetSQLValueString($_POST['c_postal'], "text"),
                       GetSQLValueString($_POST['c_handoverto'], "text"),
                       GetSQLValueString($_POST['c_receiving'], "text"),
                       GetSQLValueString($_POST['r_id'], "text"),
                       GetSQLValueString($_POST['c_tel'], "text"),
                       GetSQLValueString($_POST['med_aid'], "text"),
                       GetSQLValueString($_POST['med_aid_no'], "text"),
                       GetSQLValueString($_POST['med_principal'], "text"),
                       GetSQLValueString($_POST['med_relationship'], "text"),
                       GetSQLValueString($_POST['employer'], "text"),
                       GetSQLValueString($_POST['emp_tel'], "text"),
                       GetSQLValueString($_POST['emp_address'], "text"),
                       GetSQLValueString($_POST['h_dispatcher'], "text"),
                       GetSQLValueString($_POST['h_dispatch_info'], "text"),
                       GetSQLValueString($_POST['h_on_arrival'], "text"),
                       GetSQLValueString($_POST['h_main_complaint'], "text"),
                       GetSQLValueString($_POST['ph_allergies'], "text"),
                       GetSQLValueString($_POST['ph_medication'], "text"),
                       GetSQLValueString($_POST['ph_med_surg'], "text"),
                       GetSQLValueString($_POST['ph_lastmeal'], "text"),
                       GetSQLValueString($_POST['ps_air_clear'], "int"),
                       GetSQLValueString($_POST['ps_air_maint'], "int"),
                       GetSQLValueString($_POST['ps_air_intub'], "int"),
                       GetSQLValueString($_POST['ps_air_surg'], "int"),
                       GetSQLValueString($_POST['ps_air_ett'], "text"),
                       GetSQLValueString($_POST['ps_air_depth'], "int"),
                       GetSQLValueString($_POST['ps_trachea'], "text"),
                       GetSQLValueString($_POST['ps_air_entry'], "text"),
                       GetSQLValueString($_POST['ps_extra_sounds'], "text"),
                       GetSQLValueString($_POST['ps_mechanics'], "text"),
                       GetSQLValueString($_POST['ps_neck_veins'], "text"),
                       GetSQLValueString($_POST['ps_haemorrhage'], "text"),
                       GetSQLValueString($_POST['ps_perfusion'], "text"),
                       GetSQLValueString($_POST['ps_perf_colour'], "text"),
                       GetSQLValueString($_POST['ps_pulses'], "text"),
                       GetSQLValueString($_POST['ps_initial_gcs_15'], "text"),
                       GetSQLValueString($_POST['ps_initial_e_4'], "text"),
                       GetSQLValueString($_POST['ps_initial_m_6'], "text"),
                       GetSQLValueString($_POST['ps_initial_v_5'], "text"),
                       GetSQLValueString($_POST['ps_spinal_motor'], "text"),
                       GetSQLValueString($_POST['ps_spinal_sensory'], "text"),
                       GetSQLValueString($_POST['ss_head_neck'], "text"),
                       GetSQLValueString($_POST['ss_chest'], "text"),
                       GetSQLValueString($_POST['ss_cvs'], "text"),
                       GetSQLValueString($_POST['ss_abdomen'], "text"),
                       GetSQLValueString($_POST['ss_pelvis'], "text"),
                       GetSQLValueString($_POST['ss_extremities'], "text"),
                       GetSQLValueString($_POST['ss_spine'], "text"),
                       GetSQLValueString($_POST['ss_icd_10'], "text"),
                       GetSQLValueString($_POST['ss_diagnosis'], "text"),
                       GetSQLValueString($_POST['ss_priority'], "int"),
                       GetSQLValueString($_POST['management'], "text"),
                       GetSQLValueString($_POST['fluid_blood'], "text"),
                       GetSQLValueString($_POST['fluid_secretions'], "text"),
                       GetSQLValueString($_POST['fluid_enteric'], "text"),
                       GetSQLValueString($_POST['fluid_drains'], "text"),
                       GetSQLValueString($_POST['fluid_urine'], "text"),
                       GetSQLValueString($_POST['fluid_total'], "text"),
                       GetSQLValueString($_POST['ecg_analysis'], "text"),
                       GetSQLValueString($_POST['ecg_defib'], "text"),
                       GetSQLValueString($_POST['ecg_pacing'], "text"),
                       GetSQLValueString($_POST['ecg_time1'], "text"),
                       GetSQLValueString($_POST['ecg_joules1'], "text"),
                       GetSQLValueString($_POST['ecg_time2'], "text"),
                       GetSQLValueString($_POST['ecg_joules2'], "text"),
                       GetSQLValueString($_POST['ecg_time3'], "text"),
                       GetSQLValueString($_POST['ecg_joules3'], "text"),
                       GetSQLValueString($_POST['ecg_time'], "text"),
                       GetSQLValueString($_POST['ecg_rate'], "text"),
                       GetSQLValueString($_POST['ecg_ma'], "text"),
                       GetSQLValueString($_POST['al_logroll'], "text"),
                       GetSQLValueString($_POST['al_veh_ex'], "text"),
                       GetSQLValueString($_POST['al_spineboard'], "text"),
                       GetSQLValueString($_POST['al_scoop'], "text"),
                       GetSQLValueString($_POST['al_cerv_collar'], "text"),
                       GetSQLValueString($_POST['al_headblocks'], "text"),
                       GetSQLValueString($_POST['al_spider'], "text"),
                       GetSQLValueString($_POST['al_ked'], "text"),
                       GetSQLValueString($_POST['air_suction'], "text"),
                       GetSQLValueString($_POST['air_oro'], "text"),
                       GetSQLValueString($_POST['air_oral'], "text"),
                       GetSQLValueString($_POST['air_nasal'], "text"),
                       GetSQLValueString($_POST['air_surgical'], "text"),
                       GetSQLValueString($_POST['br_oxygen'], "text"),
                       GetSQLValueString($_POST['br_60'], "text"),
                       GetSQLValueString($_POST['br_neb'], "text"),
                       GetSQLValueString($_POST['br_nasal'], "text"),
                       GetSQLValueString($_POST['br_chest'], "text"),
                       GetSQLValueString($_POST['br_underwater'], "text"),
                       GetSQLValueString($_POST['br_heimlich'], "text"),
                       GetSQLValueString($_POST['cir_ecg'], "text"),
                       GetSQLValueString($_POST['cir_iv'], "text"),
                       GetSQLValueString($_POST['cir_io'], "text"),
                       GetSQLValueString($_POST['cir_hicap'], "text"),
                       GetSQLValueString($_POST['cir_pacing'], "text"),
                       GetSQLValueString($_POST['cir_cpr'], "text"),
                       GetSQLValueString($_POST['cir_colloids'], "text"),
                       GetSQLValueString($_POST['cir_dial'], "text"),
                       GetSQLValueString($_POST['oth_urine'], "text"),
                       GetSQLValueString($_POST['oth_gastric'], "text"),
                       GetSQLValueString($_POST['oth_stretcher'], "text"),
                       GetSQLValueString($_POST['oth_wheelchair'], "text"),
                       GetSQLValueString($_POST['personnel_items'], "text"),
                       GetSQLValueString($_POST['prfID'], "int"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($updateSQL, $adhocConn) or die(mysql_error());

  $insertGoTo = "prf_control_panel.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_adhocConn, $adhocConn);
$query_prio = "SELECT * FROM priorities ORDER BY pID ASC";
$prio = mysql_query($query_prio, $adhocConn) or die(mysql_error());
$row_prio = mysql_fetch_assoc($prio);
$totalRows_prio = mysql_num_rows($prio);

if (($_COOKIE['MM_UserGroup'] != 2) && ($_COOKIE['MM_UserGroup'] < 5)) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}

if ($_GET['prf_no']) {
	$prf_no = $_GET['prf_no'];
} else {
	$prf_no = $_POST['prf_no'];
}
mysql_select_db($database_adhocConn, $adhocConn);
$query_prf = sprintf("SELECT * FROM prf WHERE prfID = '%s'", $prf_no);
$prf = mysql_query($query_prf, $adhocConn) or die(mysql_error());
$row_prf = mysql_fetch_assoc($prf);
$totalRows_prf = mysql_num_rows($prf);

mysql_select_db($database_adhocConn, $adhocConn);
$query_call = sprintf("SELECT * FROM call_log WHERE prf_no = '%s'", $prf_no);
$call = mysql_query($query_call, $adhocConn) or die(mysql_error());
$row_call = mysql_fetch_assoc($call);
$totalRows_call = mysql_num_rows($call);
?>

<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<body onLoad="MM_preloadImages('design/mouseovers_r3_c1.jpg','design/mouseovers_r2_c1.jpg','design/mouseovers_r1_c1.jpg','design/home_screen_over.jpg','design/launch_r.jpg','design/forms_over.jpg')"><table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
    <td height="613" valign="top"><table width="950" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="613" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="15">
          <tr>
            <td valign="top" bgcolor="#FFFFFF">
              <p>&nbsp;</p>
              <?php if ($totalRows_prf > 0) { ?>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                <table border="1" align="center" cellpadding="1" cellspacing="0">
                  <tr valign="baseline">
                    <td colspan="3" rowspan="4" align="right" nowrap="nowrap" class="formtext"><div align="center"><img src="images/logo.jpg" /></div></td>
                    <td align="right" nowrap="nowrap" class="formtext"><div align="right">PRF No:</div></td>
                    <td class="formtext"><?php echo $prf_no; ?>
                      <input type="hidden" name="prfID" value="<?php echo $row_prf['prfID']; ?>" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td class="formtext">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td class="formtext"><div align="right">Ambulance</div></td>
                    <td class="formtext"><?php
						mysql_select_db($database_adhocConn, $adhocConn);
						$query_aname = sprintf("SELECT * FROM vehicles WHERE vehicleID = %s", $row_call['vehicle1']);
						$aname = mysql_query($query_aname, $adhocConn) or die(mysql_error());
						$row_aname = mysql_fetch_assoc($aname);
						$totalRows_aname = mysql_num_rows($aname);
						echo $row_aname['vehicle'];
						$regno = $row_aname['regno'];
						mysql_free_result($aname);
					?></td>
                    <td align="right" nowrap="nowrap" class="formtext">Inv_no:</td>
                    <td class="formtext"><input type="text" class="formtext" name="inv_no" value="<?php echo $row_prf['inv_no']; ?>" size="8" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td class="formtext"><div align="right">Date</div></td>
                    <td class="formtext"><?php echo date("d M Y H:i", $row_call['logtime']); ?></td>
                    <td class="formtext"><div align="right">Case No</div></td>
                    <td class="formtext"><?php echo $row_call['logID']; ?></td>
                  </tr>
                  <tr valign="baseline">
                    <td valign="top" class="formtext"><div align="right">Car Reg</div></td>
                    <td valign="top" class="formtext"><?php echo $regno; ?></td>
                    <td colspan="2" rowspan="2" class="formtext"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td class="formtext"><div align="right">Primary:
                          <input name="primary" <?php if (!(strcmp($row_prf['primary'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="primary" value="1" />
                        </div></td>
                        <td class="formtext"><div align="right">Trauma:
                          <input name="trauma" <?php if (!(strcmp($row_prf['trauma'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="trauma" value="1" />
                        </div></td>
                        <td class="formtext"><div align="right">BLS:
                            <input name="bls" <?php if (!(strcmp($row_prf['bls'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="bls" value="1" />
                        </div></td>
                      </tr>
                      <tr>
                        <td class="formtext"><div align="right">IHT:
                            <input name="iht" <?php if (!(strcmp($row_prf['iht'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="iht" value="1" />
                        </div></td>
                        <td class="formtext"><div align="right">Medical:
                          <input name="medical" <?php if (!(strcmp($row_prf['medical'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="medical" value="1" />
                        </div></td>
                        <td class="formtext"><div align="right">ALS:
                            <input name="als" <?php if (!(strcmp($row_prf['als'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="als" value="1" />
                        </div></td>
                      </tr>
                      <tr>
                        <td class="formtext"><div align="right"></div></td>
                        <td class="formtext"><div align="right"></div></td>
                        <td class="formtext"><div align="right">ILS:
                            <input name="ils" <?php if (!(strcmp($row_prf['ils'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="ils" value="1" />
                        </div></td>
                      </tr>
                    </table></td>
                    </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td colspan="4" align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Client's name:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_name" value="<?php echo $row_prf['c_name']; ?>" size="32" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Client's age:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_age" value="<?php echo $row_prf['c_age']; ?>" size="2" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Transported from:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_from" value="<?php echo $row_prf['c_from']; ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Client's ID:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_id" value="<?php echo $row_prf['c_id']; ?>" size="32" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Sex:</td>
                    <td class="formtext"><select name="c_sex" class="formtext" id="c_sex">
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                      </select>                    </td>
                    <td align="right" nowrap="nowrap" class="formtext">Transported to:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_to" value="<?php echo $row_prf['c_to']; ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Physical address:</td>
                    <td colspan="3" class="formtext"><input type="text" class="formtext" name="c_physical" value="<?php echo $row_prf['c_physical']; ?>" size="60" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Handover to:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_handoverto" value="<?php echo $row_prf['c_handoverto']; ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Postal address:</td>
                    <td colspan="3" class="formtext"><input type="text" class="formtext" name="c_postal" value="<?php echo $row_prf['c_postal']; ?>" size="60" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Person receiving client:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_receiving" value="<?php echo $row_prf['c_receiving']; ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Responsible person's ID:</td>
                    <td class="formtext"><input type="text" class="formtext" name="r_id" value="<?php echo $row_prf['r_id']; ?>" size="12" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Client's phone no:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_tel" value="<?php echo $row_prf['c_tel']; ?>" size="10" /></td>
                    <td class="formtext">&nbsp;</td>
                    <td class="formtext">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Medical aid:</td>
                    <td class="formtext"><input type="text" class="formtext" name="med_aid" value="<?php echo $row_prf['med_aid']; ?>" size="32" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Medical Aid no:</td>
                    <td class="formtext"><input type="text" class="formtext" name="med_aid_no" value="<?php echo $row_prf['med_aid_no']; ?>" size="10" /></td>
                    <td class="formtext">&nbsp;</td>
                    <td class="formtext">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Principal member:</td>
                    <td class="formtext"><input type="text" class="formtext" name="med_principal" value="<?php echo $row_prf['med_principal']; ?>" size="32" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Relationship:</td>
                    <td class="formtext"><input type="text" class="formtext" name="med_relationship" value="<?php echo $row_prf['med_relationship']; ?>" size="15" /></td>
                    <td class="formtext">&nbsp;</td>
                    <td class="formtext">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Employer:</td>
                    <td class="formtext"><input type="text" class="formtext" name="employer" value="<?php echo $row_prf['employer']; ?>" size="32" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Employer's phone no:</td>
                    <td class="formtext"><input type="text" class="formtext" name="emp_tel" value="<?php echo $row_prf['emp_tel']; ?>" size="10" /></td>
                    <td class="formtext">&nbsp;</td>
                    <td class="formtext">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" valign="top" nowrap="nowrap" class="formtext">Employer's address:</td>
                    <td colspan="3" class="formtext"><textarea class="formtext" name="emp_address" cols="50" rows="5"><?php echo $row_prf['emp_address']; ?></textarea>                    </td>
                    <td class="formtext">&nbsp;</td>
                    <td class="formtext">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="4" align="right" nowrap="nowrap" bgcolor="#CCCCCC"><div align="center">HISTORY &amp; EXAMINATION</div></td>
                    <td colspan="3" align="right" valign="top" nowrap="nowrap" bgcolor="#CCCCCC"><div align="center">PAST HISTORY</div></td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="4" align="right" valign="top" nowrap="nowrap"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Dispatcher:</span></div></td>
                        <td class="formtext"><?php
							mysql_select_db($database_adhocConn, $adhocConn);
							$query_dname = sprintf("SELECT * FROM users WHERE userID = %s", $row_call['dispatcher']);
							$dname = mysql_query($query_dname, $adhocConn) or die(mysql_error());
							$row_dname = mysql_fetch_assoc($dname);
							$totalRows_dname = mysql_num_rows($dname);
							echo $row_dname['fullname'];
							mysql_free_result($dname);
						?></td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Dispatch info:</span></div></td>
                        <td><span class="formtext">
                          <input type="text" class="formtext" name="h_dispatch_info" value="<?php echo $row_prf['h_dispatch_info']; ?>" size="32" />
                        </span></td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">On arrival:</span></div></td>
                        <td><span class="formtext">
                          <textarea class="formtext" name="h_on_arrival" cols="50" rows="5"><?php echo $row_prf['h_on_arrival']; ?></textarea>
                        </span></td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Main complaint:</span></div></td>
                        <td><span class="formtext">
                          <textarea class="formtext" name="h_main_complaint" cols="50" rows="6"><?php echo $row_prf['h_main_complaint']; ?></textarea>
                        </span></td>
                      </tr>

                    </table></td>
                    <td colspan="3" align="right" valign="top" nowrap="nowrap"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Allergies:</span></div></td>
                        <td><span class="formtext">
                          <textarea class="formtext" name="ph_allergies" cols="50" rows="2"><?php echo $row_prf['ph_allergies']; ?></textarea>
                        </span></td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Medication:</span></div></td>
                        <td><span class="formtext">
                          <textarea class="formtext" name="ph_medication" cols="50" rows="5"><?php echo $row_prf['ph_medication']; ?></textarea>
                        </span></td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Past Medical / Surgical History:</span></div></td>
                        <td><span class="formtext">
                          <textarea class="formtext" name="ph_med_surg" cols="50" rows="4"><?php echo $row_prf['ph_med_surg']; ?></textarea>
                        </span></td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Last meal:</span></div></td>
                        <td><span class="formtext">
                          <textarea class="formtext" name="ph_lastmeal" cols="50" rows="2"><?php echo $row_prf['ph_lastmeal']; ?></textarea>
                        </span></td>
                      </tr>

                    </table></td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="4" align="right" nowrap="nowrap" bgcolor="#CCCCCC"><div align="center">PRIMARY SURVEY:</div></td>
                    <td colspan="3" bgcolor="#CCCCCC"><div align="center">SECONDARY SURVEY:</div></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">A</td>
                    <td align="right" nowrap="nowrap" class="formtext">Airway:</td>
                    <td colspan="2" nowrap="nowrap" class="formtext">Clear
                      <input name="ps_air_clear" <?php if (!(strcmp($row_prf['ps_air_clear'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="ps_air_clear" value="1" />
                      | Maintainable 
                      <input name="ps_air_maint" <?php if (!(strcmp($row_prf['ps_air_maint'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="ps_air_maint" value="1" />
                      | Intubated 
                      <input name="ps_air_intub" <?php if (!(strcmp($row_prf['ps_air_intub'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="ps_air_intub" value="1" />
                      | Surgical 
                      <input name="ps_air_surg" <?php if (!(strcmp($row_prf['ps_air_surg'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="ps_air_surg" value="1" />
                      | ETT Size 
                      <input type="text" class="formtext" name="ps_air_ett" value="<?php echo $row_prf['ps_air_ett']; ?>" size="3" />
                      | Depth
                      <input name="ps_air_depth" <?php if (!(strcmp($row_prf['ps_air_depth'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="ps_air_depth" value="1" /></td>
                    <td colspan="3" rowspan="13" class="formtext"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Head and Neck:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_head_neck" cols="50" rows="2"><?php echo $row_prf['ss_head_neck']; ?></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Chest:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_chest" cols="50" rows="2"><?php echo $row_prf['ss_chest']; ?></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">CVS:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_cvs" cols="50" rows="1"><?php echo $row_prf['ss_cvs']; ?></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Abdomen:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_abdomen" cols="50" rows="2"><?php echo $row_prf['ss_abdomen']; ?></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Pelvis:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_pelvis" cols="50" rows="1"><?php echo $row_prf['ss_pelvis']; ?></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Extremities:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_extremities" cols="50" rows="2"><?php echo $row_prf['ss_extremities']; ?></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Spine:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_spine" cols="50" rows="1"><?php echo $row_prf['ss_spine']; ?></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">ICD - 10 code:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_icd_10" cols="50" rows="1"><?php echo $row_prf['ss_icd_10']; ?></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Diagnosis:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_diagnosis" cols="50" rows="2"><?php echo $row_prf['ss_diagnosis']; ?></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" nowrap="nowrap" class="formtext">Priority:</td>
                        <td class="formtext"><select name="ss_priority" class="formtext">
                            <?php
do {  
?><option value="<?php echo $row_prio['pID']?>"<?php if (!(strcmp($row_prio['pID'], $row_prf['ss_priority']))) {echo "selected=\"selected\"";} ?>><?php echo $row_prio['priority']?></option>
                            <?php
} while ($row_prio = mysql_fetch_assoc($prio));
  $rows = mysql_num_rows($prio);
  if($rows > 0) {
      mysql_data_seek($prio, 0);
	  $row_prio = mysql_fetch_assoc($prio);
  }
?>
                          </select>                        </td>
                        </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Management:</td>
                        <td class="formtext"><textarea class="formtext" name="management" cols="50" rows="3"><?php echo $row_prf['management']; ?></textarea>                        </td>
                      </tr>

                    </table></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">B</td>
                    <td align="right" nowrap="nowrap" class="formtext">Trachea:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_trachea" value="<?php echo $row_prf['ps_trachea']; ?>" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Air entry:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_air_entry" value="<?php echo $row_prf['ps_air_entry']; ?>" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Extra sounds:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_extra_sounds" value="<?php echo $row_prf['ps_extra_sounds']; ?>" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Mechanics:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_mechanics" value="<?php echo $row_prf['ps_mechanics']; ?>" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Neck veins:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_neck_veins" value="<?php echo $row_prf['ps_neck_veins']; ?>" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">C</td>
                    <td align="right" nowrap="nowrap" class="formtext">Haemorrhage:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_haemorrhage" value="<?php echo $row_prf['ps_haemorrhage']; ?>" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Perfusion:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_perfusion" value="<?php echo $row_prf['ps_perfusion']; ?>" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Perf colour:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_perf_colour" value="<?php echo $row_prf['ps_perf_colour']; ?>" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Pulses:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_pulses" value="<?php echo $row_prf['ps_pulses']; ?>" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">D</td>
                    <td align="right" nowrap="nowrap" class="formtext">Initial:</td>
                    <td colspan="2" class="formtext">GCS
                      <input type="text" class="formtext" name="ps_initial_gcs_15" value="<?php echo $row_prf['ps_initial_gcs_15']; ?>" size="2" />
                      /15 
                      | E 
                      <input type="text" class="formtext" name="ps_initial_e_4" value="<?php echo $row_prf['ps_initial_e_4']; ?>" size="2" />
                      /4 | M 
                      <input type="text" class="formtext" name="ps_initial_m_6" value="<?php echo $row_prf['ps_initial_m_6']; ?>" size="2" />
                      /6 | V 
                      <input type="text" class="formtext" name="ps_initial_v_5" value="<?php echo $row_prf['ps_initial_v_5']; ?>" size="2" />
                      /5</td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">SPINAL: Motor function:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_spinal_motor" value="<?php echo $row_prf['ps_spinal_motor']; ?>" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">SPINAL: Sensory level:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_spinal_sensory" value="<?php echo $row_prf['ps_spinal_sensory']; ?>" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td colspan="7" align="right" nowrap="nowrap"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                          <tr>
                            <td colspan="2" align="right" valign="baseline" nowrap="nowrap" class="formtext"><div align="center">Fluid loss</div>                              <div align="center"></div></td>
                            <td colspan="3" rowspan="4" valign="top" class="formtext"><div align="center">ECG Analysis:
                              <br />
                                <textarea class="formtext" name="ecg_analysis" cols="35" rows="3"><?php echo $row_prf['ecg_analysis']; ?></textarea>
                            </div></td>
                            <td colspan="2" align="right" valign="baseline" nowrap="nowrap" class="formtext"><div align="center">Alignment</div></td>
                            <td colspan="2" align="right" valign="baseline" nowrap="nowrap" class="formtext"><div align="center">Airway</div></td>
                            <td colspan="4" align="right" valign="baseline" nowrap="nowrap" class="formtext"><div align="center">Breathing</div></td>
                            <td colspan="2" align="right" valign="baseline" nowrap="nowrap" class="formtext"><div align="center">Circulation</div></td>
                            <td colspan="2" align="right" valign="baseline" nowrap="nowrap" class="formtext"><div align="center">Others</div></td>
                            </tr>
                          <tr>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Blood:</td>
                        <td valign="baseline" class="formtext"><input type="text" class="formtext" name="fluid_blood" value="<?php echo $row_prf['fluid_blood']; ?>" size="4" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Logroll:</td>
                        <td valign="baseline" class="formtext"><input name="al_logroll" <?php if (!(strcmp($row_prf['al_logroll'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="al_logroll" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Suction:</td>
                        <td valign="baseline" class="formtext"><input name="air_suction" <?php if (!(strcmp($row_prf['air_suction'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="air_suction" value="1" /></td>
                        <td colspan="3" align="right" valign="baseline" nowrap="nowrap" class="formtext">Oxygen:</td>
                        <td valign="baseline" class="formtext"><input name="br_oxygen" <?php if (!(strcmp($row_prf['br_oxygen'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="br_oxygen" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">ECG:</td>
                        <td valign="baseline" class="formtext"><input name="cir_ecg" <?php if (!(strcmp($row_prf['cir_ecg'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="cir_ecg" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Urine:</td>
                        <td valign="baseline" class="formtext"><input name="oth_urine" <?php if (!(strcmp($row_prf['oth_urine'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="oth_urine" value="1" /></td>
                        </tr>
                      <tr>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Secretions:</td>
                        <td valign="baseline" class="formtext"><input type="text" class="formtext" name="fluid_secretions" value="<?php echo $row_prf['fluid_secretions']; ?>" size="4" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Veh_ex:</td>
                        <td valign="baseline" class="formtext"><input name="al_veh_ex" <?php if (!(strcmp($row_prf['al_veh_ex'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="al_veh_ex" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Oro:</td>
                        <td valign="baseline" class="formtext"><input name="air_oro" <?php if (!(strcmp($row_prf['air_oro'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="air_oro" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">60%
                          <input name="br_60" <?php if (!(strcmp($row_prf['br_60'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="br_60" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">NEB
                          <input name="br_neb" <?php if (!(strcmp($row_prf['br_neb'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="br_neb" value="1" /></td>
                        <td colspan="2" align="right" valign="baseline" nowrap="nowrap" class="formtext">Nasal
                          <input name="br_nasal" <?php if (!(strcmp($row_prf['br_nasal'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="br_nasal" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">IV:</td>
                        <td valign="baseline" class="formtext"><input name="cir_iv" <?php if (!(strcmp($row_prf['cir_iv'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="cir_iv" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Gastric:</td>
                        <td valign="baseline" class="formtext"><input name="oth_gastric" <?php if (!(strcmp($row_prf['oth_gastric'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="oth_gastric" value="1" /></td>
                        </tr>
                      <tr>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Enteric:</td>
                        <td valign="baseline" class="formtext"><input type="text" class="formtext" name="fluid_enteric" value="<?php echo $row_prf['fluid_enteric']; ?>" size="4" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Spineboard:</td>
                        <td valign="baseline" class="formtext"><input name="al_spineboard" <?php if (!(strcmp($row_prf['al_spineboard'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="al_spineboard" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Oral:</td>
                        <td valign="baseline" class="formtext"><input name="air_oral" <?php if (!(strcmp($row_prf['air_oral'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="air_oral" value="1" /></td>
                        <td colspan="3" align="right" valign="baseline" nowrap="nowrap" class="formtext">Chest:</td>
                        <td valign="baseline" class="formtext"><input name="br_chest" <?php if (!(strcmp($row_prf['br_chest'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="br_chest" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">IO:</td>
                        <td valign="baseline" class="formtext"><input name="cir_io" <?php if (!(strcmp($row_prf['cir_io'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="cir_io" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Stretcher:</td>
                        <td valign="baseline" class="formtext"><input name="oth_stretcher" <?php if (!(strcmp($row_prf['oth_stretcher'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="oth_stretcher" value="1" /></td>
                        </tr>
                      <tr>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Drains:</td>
                        <td valign="baseline" class="formtext"><input type="text" class="formtext" name="fluid_drains" value="<?php echo $row_prf['fluid_drains']; ?>" size="4" /></td>
                        <td colspan="2" class="formtext"><div align="center">Defib/Cardio version:
                            <input type="text" class="formtext" name="ecg_defib" value="<?php echo $row_prf['ecg_defib']; ?>" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center">Pacing
                          <input type="text" class="formtext" name="ecg_pacing" value="<?php echo $row_prf['ecg_pacing']; ?>" size="3" />
                        </div></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Scoop:</td>
                        <td valign="baseline" class="formtext"><input name="al_scoop" <?php if (!(strcmp($row_prf['al_scoop'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="al_scoop" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Nasal:</td>
                        <td valign="baseline" class="formtext"><input name="air_nasal" <?php if (!(strcmp($row_prf['air_nasal'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="air_nasal" value="1" /></td>
                        <td colspan="3" align="right" valign="baseline" nowrap="nowrap" class="formtext">Underwater:</td>
                        <td valign="baseline" class="formtext"><input name="br_underwater" <?php if (!(strcmp($row_prf['br_underwater'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="br_underwater" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Hi Cap Line:</td>
                        <td valign="baseline" class="formtext"><input name="cir_hicap" <?php if (!(strcmp($row_prf['cir_hicap'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="cir_hicap" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Wheelchair:</td>
                        <td valign="baseline" class="formtext"><input name="oth_wheelchair" <?php if (!(strcmp($row_prf['oth_wheelchair'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="oth_wheelchair" value="1" /></td>
                        </tr>
                      <tr>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Urine:</td>
                        <td valign="baseline" class="formtext"><input type="text" class="formtext" name="fluid_urine" value="<?php echo $row_prf['fluid_urine']; ?>" size="4" /></td>
                        <td class="formtext"><div align="center">Time</div></td>
                        <td class="formtext"><div align="center">Joules</div></td>
                        <td class="formtext"><div align="center">Time
                          <input type="text" class="formtext" name="ecg_time" value="<?php echo $row_prf['ecg_time']; ?>" size="3" />
                        </div></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Cerv_collar:</td>
                        <td valign="baseline" class="formtext"><input name="al_cerv_collar" <?php if (!(strcmp($row_prf['al_cerv_collar'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="al_cerv_collar" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Surgical:</td>
                        <td valign="baseline" class="formtext"><input name="air_surgical" <?php if (!(strcmp($row_prf['air_surgical'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="air_surgical" value="1" /></td>
                        <td colspan="3" align="right" valign="baseline" nowrap="nowrap" class="formtext">Heimlich:</td>
                        <td valign="baseline" class="formtext"><input name="br_heimlich" <?php if (!(strcmp($row_prf['br_heimlich'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="br_heimlich" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Pacing:</td>
                        <td valign="baseline" class="formtext"><input name="cir_pacing" <?php if (!(strcmp($row_prf['cir_pacing'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="cir_pacing" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        </tr>
                      <tr>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Total:</td>
                        <td valign="baseline" class="formtext"><input type="text" class="formtext" name="fluid_total" value="<?php echo $row_prf['fluid_total']; ?>" size="4" /></td>
                        <td class="formtext"><div align="center">
                          <input type="text" class="formtext" name="ecg_time1" value="<?php echo $row_prf['ecg_time1']; ?>" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center">
                          <input type="text" class="formtext" name="ecg_joules1" value="<?php echo $row_prf['ecg_joules1']; ?>" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center">Rate
                          <input type="text" class="formtext" name="ecg_rate" value="<?php echo $row_prf['ecg_rate']; ?>" size="3" />
                        </div></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Headblocks:</td>
                        <td valign="baseline" class="formtext"><input name="al_headblocks" <?php if (!(strcmp($row_prf['al_headblocks'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="al_headblocks" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        <td colspan="3" align="right" valign="baseline" nowrap="nowrap" class="formtext">&nbsp;</td>
                        <td valign="baseline" class="formtext">&nbsp;</td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">CPR:</td>
                        <td valign="baseline" class="formtext"><input name="cir_cpr" <?php if (!(strcmp($row_prf['cir_cpr'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="cir_cpr" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        </tr>
                      <tr>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext"><div align="center">
                          <input type="text" class="formtext" name="ecg_time2" value="<?php echo $row_prf['ecg_time2']; ?>" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center">
                          <input type="text" class="formtext" name="ecg_joules2" value="<?php echo $row_prf['ecg_joules2']; ?>" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center">mA
                          <input type="text" class="formtext" name="ecg_ma" value="<?php echo $row_prf['ecg_ma']; ?>" size="3" />
                        </div></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Spider:</td>
                        <td valign="baseline" class="formtext"><input name="al_spider" <?php if (!(strcmp($row_prf['al_spider'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="al_spider" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        <td colspan="3" align="right" valign="baseline" nowrap="nowrap" class="formtext">&nbsp;</td>
                        <td valign="baseline" class="formtext">&nbsp;</td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Colloids:</td>
                        <td valign="baseline" class="formtext"><input name="cir_colloids" <?php if (!(strcmp($row_prf['cir_colloids'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="cir_colloids" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        </tr>
                      <tr>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext"><div align="center">
                          <input type="text" class="formtext" name="ecg_time3" value="<?php echo $row_prf['ecg_time3']; ?>" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center">
                          <input type="text" class="formtext" name="ecg_joules3" value="<?php echo $row_prf['ecg_joules3']; ?>" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center"></div></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">KED:</td>
                        <td valign="baseline" class="formtext"><input name="al_ked" <?php if (!(strcmp($row_prf['al_ked'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="al_ked" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        <td colspan="3" class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Dial:</td>
                        <td valign="baseline" class="formtext"><input name="cir_dial" <?php if (!(strcmp($row_prf['cir_dial'],1))) {echo "checked=\"checked\"";} ?> type="checkbox" id="cir_dial" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        </tr>
                    </table></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right" valign="top">&nbsp;</td>
                    <td align="right" valign="top" nowrap="nowrap" class="formtext">Personnel items:</td>
                    <td><textarea class="formtext" name="personnel_items" cols="50" rows="5"><?php echo $row_prf['personnel_items']; ?></textarea>                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><input type="submit" value="Update record" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form1" />
              </form>
              <p>
			  <?php
				mysql_select_db($database_adhocConn, $adhocConn);
				$query_drugs = sprintf("SELECT * FROM drugs WHERE prf_no = %s ORDER BY drugID ASC", $prf_no);
				$drugs = mysql_query($query_drugs, $adhocConn) or die(mysql_error());
				$row_drugs = mysql_fetch_assoc($drugs);
				$totalRows_drugs = mysql_num_rows($drugs);
				?>
				<table border="1" cellpadding="3" cellspacing="0" bgcolor="#66FFCC" width="100%">
				  <tr>
					<td class="formtext">drug</td>
					<td class="formtext">dose</td>
					<td class="formtext">route</td>
					<td class="formtext">time</td>
					<td class="formtext">hpcsa_no</td>
				  </tr>
				  <?php do { ?>
					<tr>
					  <td class="formtext"><?php echo $row_drugs['drug']; ?></td>
					  <td class="formtext"><?php echo $row_drugs['dose']; ?></td>
					  <td class="formtext"><?php echo $row_drugs['route']; ?></td>
					  <td class="formtext"><?php echo $row_drugs['time']; ?></td>
					  <td class="formtext"><?php echo $row_drugs['hpcsa_no']; ?></td>
					</tr>
					<?php } while ($row_drugs = mysql_fetch_assoc($drugs)); ?>
				</table>
				<?php 
				mysql_free_result($drugs);
				?>
				<?php
				mysql_select_db($database_adhocConn, $adhocConn);
				$query_fluids = sprintf("SELECT * FROM fluids WHERE prf_no = %s ORDER BY fluidID ASC", $prf_no);
				$fluids = mysql_query($query_fluids, $adhocConn) or die(mysql_error());
				$row_fluids = mysql_fetch_assoc($fluids);
				$totalRows_fluids = mysql_num_rows($fluids);
				?>
				<table border="1" cellpadding="3" cellspacing="0" bgcolor="#CCFFFF" width="100%">
				  <tr>
					<td class="formtext">fluid</td>
					<td class="formtext">needle</td>
					<td class="formtext">site</td>
					<td class="formtext">volume</td>
				  </tr>
				  <?php do { ?>
					<tr>
					  <td class="formtext"><?php echo $row_fluids['fluid']; ?></td>
					  <td class="formtext"><?php echo $row_fluids['needle']; ?></td>
					  <td class="formtext"><?php echo $row_fluids['site']; ?></td>
					  <td class="formtext"><?php echo $row_fluids['volume']; ?></td>
					</tr>
					<?php } while ($row_fluids = mysql_fetch_assoc($fluids)); ?>
				</table>
				<?php
				mysql_free_result($fluids);
				?>
				<?php
				mysql_select_db($database_adhocConn, $adhocConn);
				$query_vitals = sprintf("SELECT * FROM vitals WHERE prf_no = %s ORDER BY `timestamp` ASC", $prf_no);
				$vitals = mysql_query($query_vitals, $adhocConn) or die(mysql_error());
				$row_vitals = mysql_fetch_assoc($vitals);
				$totalRows_vitals = mysql_num_rows($vitals);
				?>
				<table border="1" cellpadding="3" cellspacing="0" bgcolor="#FFFFCC">
				  <tr>
					<td class="formtext">time</td>
					<td class="formtext" colspan="4" align="center">breath</td>
					<td class="formtext" colspan="5" align="center">circ</td>
					<td class="formtext" align="center">gcs</td>
					<td class="formtext" colspan="4" align="center">pupil</td>
					<td class="formtext" align="center">glucose</td>
					<td class="formtext" align="center">pain_score</td>
				  </tr>
				  <tr>
					<td class="formtext">timestamp</td>
					<td class="formtext">rate_min</td>
					<td class="formtext">rhythm</td>
					<td class="formtext">air_entry</td>
					<td class="formtext">sao2</td>
					<td class="formtext">heartrate</td>
					<td class="formtext">rhythm</td>
					<td class="formtext">perfusion</td>
					<td class="formtext">bp</td>
					<td class="formtext">ecg</td>
					<td class="formtext">gcs</td>
					<td class="formtext">size_l</td>
					<td class="formtext">size_r</td>
					<td class="formtext">reaction_l</td>
					<td class="formtext">reaction_r</td>
					<td class="formtext">glucose</td>
					<td class="formtext">pain_score</td>
				  </tr>
				  <?php do { ?>
					<tr>
					  <td class="formtext"><?php echo $row_vitals['timestamp']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['breath_rate_min']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['breath_rhythm']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['breath_air_entry']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['breath_sao2']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['circ_heartrate']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['circ_rhythm']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['circ_perfusion']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['circ_bp']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['circ_ecg']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['gcs']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['pupil_size_l']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['pupil_size_r']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['pupil_reaction_l']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['pupil_reaction_r']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['glucose']; ?></td>
					  <td class="formtext"><?php echo $row_vitals['pain_score']; ?></td>
					</tr>
					<?php } while ($row_vitals = mysql_fetch_assoc($vitals)); ?>
				</table>
				<?php
				mysql_free_result($vitals);
				?>                
                </p>
              <?php } else { ?>
              	<p align="center" class="logbutton">Not found.</p>
              	<form id="form1" name="form1" method="post" action="edit_prf.php">
                        <div align="center">
                          PRF No: <input name="prf_no" type="text" id="prf_no" size="8" maxlength="8" class="maintext" />
                          <input type="submit" name="button" id="button" value="SEARCH AGAIN" />
                        </div>
                      </form> 
              <?php } ?>
			  </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($prio);

mysql_free_result($call);
?>
