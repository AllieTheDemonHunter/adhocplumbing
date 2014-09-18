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
  $insertSQL = sprintf("INSERT INTO prf (prfID, inv_no, `primary`, trauma, bls, iht, medical, als, ils, c_name, c_id, c_age, c_sex, c_from, c_to, c_physical, c_postal, c_handoverto, c_receiving, r_id, c_tel, med_aid, med_aid_no, med_principal, med_relationship, employer, emp_tel, emp_address, h_dispatcher, h_dispatch_info, h_on_arrival, h_main_complaint, ph_allergies, ph_medication, ph_med_surg, ph_lastmeal, ps_air_clear, ps_air_maint, ps_air_intub, ps_air_surg, ps_air_ett, ps_air_depth, ps_trachea, ps_air_entry, ps_extra_sounds, ps_mechanics, ps_neck_veins, ps_haemorrhage, ps_perfusion, ps_perf_colour, ps_pulses, ps_initial_gcs_15, ps_initial_e_4, ps_initial_m_6, ps_initial_v_5, ps_spinal_motor, ps_spinal_sensory, ss_head_neck, ss_chest, ss_cvs, ss_abdomen, ss_pelvis, ss_extremities, ss_spine, ss_icd_10, ss_diagnosis, ss_priority, management, fluid_blood, fluid_secretions, fluid_enteric, fluid_drains, fluid_urine, fluid_total, ecg_analysis, ecg_defib, ecg_pacing, ecg_time1, ecg_joules1, ecg_time2, ecg_joules2, ecg_time3, ecg_joules3, ecg_time, ecg_rate, ecg_ma, al_logroll, al_veh_ex, al_spineboard, al_scoop, al_cerv_collar, al_headblocks, al_spider, al_ked, air_suction, air_oro, air_oral, air_nasal, air_surgical, br_oxygen, br_60, br_neb, br_nasal, br_chest, br_underwater, br_heimlich, cir_ecg, cir_iv, cir_io, cir_hicap, cir_pacing, cir_cpr, cir_colloids, cir_dial, oth_urine, oth_gastric, oth_stretcher, oth_wheelchair, personnel_items) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['prfID'], "int"),
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
                       GetSQLValueString($_POST['med_aid'], "int"),
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
                       GetSQLValueString($_POST['personnel_items'], "text"));

  mysql_select_db($database_adhocConn, $adhocConn);
  $Result1 = mysql_query($insertSQL, $adhocConn) or die(mysql_error());

  $insertGoTo = "prf_control_panel.php";
  if ($_POST['med_aid'] == 142) {
	  $insertGoTo = "accident_report.php?case_no=" . $_POST['case_no'];
  }
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

mysql_select_db($database_adhocConn, $adhocConn);
$query_medaids = "SELECT * FROM med_aids ORDER BY aidname ASC";
$medaids = mysql_query($query_medaids, $adhocConn) or die(mysql_error());
$row_medaids = mysql_fetch_assoc($medaids);
$totalRows_medaids = mysql_num_rows($medaids);

if (($_COOKIE['MM_UserGroup'] != 2) && ($_COOKIE['MM_UserGroup'] < 5)) {
	$deniedGoTo = "index.php";
	header(sprintf("Location: %s", $deniedGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ad Hoc Plumbers Admin Panel</title>

<script type="text/javascript" language="javascript">
    function convertEnterToTab() {
      if(event.keyCode==13) {
        event.keyCode = 9;
      }
    }
    document.onkeydown = convertEnterToTab;    
</script>
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
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MM_preloadImages('design/mouseovers_r1_c1.jpg','design/mouseovers_r3_c1.jpg','design/mouseovers_r2_c1.jpg','design/maintenance_over.jpg')">
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
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                <table border="1" align="center" cellpadding="1" cellspacing="0">
                  <tr valign="baseline">
                    <td colspan="3" rowspan="4" align="right" nowrap="nowrap" class="formtext"><div align="center"><img src="images/logo.jpg" /></div></td>
                    <td align="right" nowrap="nowrap" class="formtext"><div align="right">PRF No:</div></td>
                    <td class="formtext"><input type="text" class="formtext" name="prfID" value="<?php echo $_GET['prf_no']; ?>" size="6" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td class="formtext">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td class="formtext"><div align="right">Ambulance</div></td>
                    <td class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Inv_no:</td>
                    <td class="formtext"><input type="text" class="formtext" name="inv_no" value="" size="8" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td class="formtext"><div align="right">Date</div></td>
                    <td class="formtext">&nbsp;</td>
                    <td class="formtext"><div align="right">Case No</div></td>
                    <td class="formtext"><?php echo $_GET['case_no']; ?>
                      <input name="case_no" type="hidden" id="case_no" value="<?php echo $_GET['case_no']; ?>" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td valign="top" class="formtext"><div align="right">Car Reg</div></td>
                    <td valign="top" class="formtext">&nbsp;</td>
                    <td colspan="2" rowspan="2" class="formtext"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td class="formtext"><div align="right">Primary:
                          <input name="primary" type="checkbox" id="primary" value="1" />
                        </div></td>
                        <td class="formtext"><div align="right">Trauma:
                          <input name="trauma" type="checkbox" id="trauma" value="1" />
                        </div></td>
                        <td class="formtext"><div align="right">BLS:
                            <input name="bls" type="checkbox" id="bls" value="1" />
                        </div></td>
                      </tr>
                      <tr>
                        <td class="formtext"><div align="right">IHT:
                            <input name="iht" type="checkbox" id="iht" value="1" />
                        </div></td>
                        <td class="formtext"><div align="right">Medical:
                          <input name="medical" type="checkbox" id="medical" value="1" />
                        </div></td>
                        <td class="formtext"><div align="right">ALS:
                            <input name="als" type="checkbox" id="als" value="1" />
                        </div></td>
                      </tr>
                      <tr>
                        <td class="formtext"><div align="right"></div></td>
                        <td class="formtext"><div align="right"></div></td>
                        <td class="formtext"><div align="right">ILS:
                            <input name="ils" type="checkbox" id="ils" value="1" />
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
                    <td class="formtext"><input type="text" class="formtext" name="c_name" value="" size="32" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Client's age:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_age" value="" size="2" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Transported from:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_from" value="" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Client's ID:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_id" value="" size="32" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Sex:</td>
                    <td class="formtext"><select name="c_sex" class="formtext" id="c_sex">
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                      </select>                    </td>
                    <td align="right" nowrap="nowrap" class="formtext">Transported to:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_to" value="" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Physical address:</td>
                    <td colspan="3" class="formtext"><input type="text" class="formtext" name="c_physical" value="" size="60" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Handover to:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_handoverto" value="" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Postal address:</td>
                    <td colspan="3" class="formtext"><input type="text" class="formtext" name="c_postal" value="" size="60" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Person receiving client:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_receiving" value="" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Responsible person's ID:</td>
                    <td class="formtext"><input type="text" class="formtext" name="r_id" value="" size="12" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Client's phone no:</td>
                    <td class="formtext"><input type="text" class="formtext" name="c_tel" value="" size="10" /></td>
                    <td class="formtext">&nbsp;</td>
                    <td class="formtext">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Medical aid:</td>
                    <td class="formtext"><select name="med_aid" id="med_aid" class="formtext">
                      <?php
do {  
?>
                      <option value="<?php echo $row_medaids['aidID']?>"><?php echo $row_medaids['aidname']?></option>
                      <?php
} while ($row_medaids = mysql_fetch_assoc($medaids));
  $rows = mysql_num_rows($medaids);
  if($rows > 0) {
      mysql_data_seek($medaids, 0);
	  $row_medaids = mysql_fetch_assoc($medaids);
  }
?>
                    </select></td>
                    <td align="right" nowrap="nowrap" class="formtext">Medical Aid no:</td>
                    <td class="formtext"><input type="text" class="formtext" name="med_aid_no" value="" size="10" /></td>
                    <td class="formtext">&nbsp;</td>
                    <td class="formtext">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Principal member:</td>
                    <td class="formtext"><input type="text" class="formtext" name="med_principal" value="" size="32" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Relationship:</td>
                    <td class="formtext"><input type="text" class="formtext" name="med_relationship" value="" size="15" /></td>
                    <td class="formtext">&nbsp;</td>
                    <td class="formtext">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Employer:</td>
                    <td class="formtext"><input type="text" class="formtext" name="employer" value="" size="32" /></td>
                    <td align="right" nowrap="nowrap" class="formtext">Employer's phone no:</td>
                    <td class="formtext"><input type="text" class="formtext" name="emp_tel" value="" size="10" /></td>
                    <td class="formtext">&nbsp;</td>
                    <td class="formtext">&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" valign="top" nowrap="nowrap" class="formtext">&nbsp;</td>
                    <td align="right" valign="top" nowrap="nowrap" class="formtext">Employer's address:</td>
                    <td colspan="3" class="formtext"><textarea class="formtext" name="emp_address" cols="50" rows="5"></textarea>                    </td>
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
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Dispatch info:</span></div></td>
                        <td><span class="formtext">
                          <input type="text" class="formtext" name="h_dispatch_info" value="" size="32" />
                        </span></td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">On arrival:</span></div></td>
                        <td><span class="formtext">
                          <textarea class="formtext" name="h_on_arrival" cols="50" rows="5"></textarea>
                        </span></td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Main complaint:</span></div></td>
                        <td><span class="formtext">
                          <textarea class="formtext" name="h_main_complaint" cols="50" rows="6"></textarea>
                        </span></td>
                      </tr>

                    </table></td>
                    <td colspan="3" align="right" valign="top" nowrap="nowrap"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Allergies:</span></div></td>
                        <td><span class="formtext">
                          <textarea class="formtext" name="ph_allergies" cols="50" rows="2"></textarea>
                        </span></td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Medication:</span></div></td>
                        <td><span class="formtext">
                          <textarea class="formtext" name="ph_medication" cols="50" rows="5"></textarea>
                        </span></td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Past Medical / Surgical History:</span></div></td>
                        <td><span class="formtext">
                          <textarea class="formtext" name="ph_med_surg" cols="50" rows="4"></textarea>
                        </span></td>
                      </tr>
                      <tr>
                        <td valign="top"><div align="right"><span class="formtext">Last meal:</span></div></td>
                        <td><span class="formtext">
                          <textarea class="formtext" name="ph_lastmeal" cols="50" rows="2"></textarea>
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
                      <input name="checkbox" type="checkbox" id="checkbox" value="1" />
                      | Maintainable 
                      <input name="ps_air_maint" type="checkbox" id="ps_air_maint" value="1" />
                      | Intubated 
                      <input name="ps_air_intub" type="checkbox" id="ps_air_intub" value="1" />
                      | Surgical 
                      <input name="ps_air_surg" type="checkbox" id="ps_air_surg" value="1" />
                      | ETT Size 
                      <input type="text" class="formtext" name="ps_air_ett" value="" size="3" />
                      | Depth
                      <input name="ps_air_depth" type="checkbox" id="ps_air_depth" value="1" /></td>
                    <td colspan="3" rowspan="13" class="formtext"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Head and Neck:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_head_neck" cols="50" rows="2"></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Chest:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_chest" cols="50" rows="2"></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">CVS:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_cvs" cols="50" rows="1"></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Abdomen:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_abdomen" cols="50" rows="2"></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Pelvis:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_pelvis" cols="50" rows="1"></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Extremities:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_extremities" cols="50" rows="2"></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Spine:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_spine" cols="50" rows="1"></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">ICD - 10 code:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_icd_10" cols="50" rows="1"></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Diagnosis:</td>
                        <td class="formtext"><textarea class="formtext" name="ss_diagnosis" cols="50" rows="2"></textarea>                        </td>
                      </tr>
                      <tr valign="baseline">
                        <td align="right" nowrap="nowrap" class="formtext">Priority:</td>
                        <td class="formtext"><select name="ss_priority" class="formtext">
                            <?php 
do {  
?>
                            <option value="<?php echo $row_prio['pID']?>" ><?php echo $row_prio['priority']?></option>
                            <?php
} while ($row_prio = mysql_fetch_assoc($prio));
?>
                          </select>                        </td>
                        </tr>
                      <tr valign="baseline">
                        <td align="right" valign="top" nowrap="nowrap" class="formtext">Management:</td>
                        <td class="formtext"><textarea class="formtext" name="management" cols="50" rows="3"></textarea>                        </td>
                      </tr>

                    </table></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">B</td>
                    <td align="right" nowrap="nowrap" class="formtext">Trachea:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_trachea" value="" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Air entry:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_air_entry" value="" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Extra sounds:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_extra_sounds" value="" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Mechanics:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_mechanics" value="" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Neck veins:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_neck_veins" value="" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">C</td>
                    <td align="right" nowrap="nowrap" class="formtext">Haemorrhage:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_haemorrhage" value="" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Perfusion:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_perfusion" value="" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Perf colour:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_perf_colour" value="" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">Pulses:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_pulses" value="" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">D</td>
                    <td align="right" nowrap="nowrap" class="formtext">Initial:</td>
                    <td colspan="2" class="formtext">GCS
                      <input type="text" class="formtext" name="ps_initial_gcs_15" value="" size="2" />
                      /15 
                      | E 
                      <input type="text" class="formtext" name="ps_initial_e_4" value="" size="2" />
                      /4 | M 
                      <input type="text" class="formtext" name="ps_initial_m_6" value="" size="2" />
                      /6 | V 
                      <input type="text" class="formtext" name="ps_initial_v_5" value="" size="2" />
                      /5</td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">SPINAL: Motor function:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_spinal_motor" value="" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="formtext">SPINAL: Sensory level:</td>
                    <td colspan="2" class="formtext"><input type="text" class="formtext" name="ps_spinal_sensory" value="" size="32" /></td>
                    </tr>
                  <tr valign="baseline">
                    <td colspan="7" align="right" nowrap="nowrap"><table width="100%" border="1" cellspacing="0" cellpadding="0">
                          <tr>
                            <td colspan="2" align="right" valign="baseline" nowrap="nowrap" class="formtext"><div align="center">Fluid loss</div>                              <div align="center"></div></td>
                            <td colspan="3" rowspan="4" valign="top" class="formtext"><div align="center">ECG Analysis:
                              <br />
                                <textarea class="formtext" name="ecg_analysis" cols="35" rows="3"></textarea>
                            </div></td>
                            <td colspan="2" align="right" valign="baseline" nowrap="nowrap" class="formtext"><div align="center">Alignment</div></td>
                            <td colspan="2" align="right" valign="baseline" nowrap="nowrap" class="formtext"><div align="center">Airway</div></td>
                            <td colspan="4" align="right" valign="baseline" nowrap="nowrap" class="formtext"><div align="center">Breathing</div></td>
                            <td colspan="2" align="right" valign="baseline" nowrap="nowrap" class="formtext"><div align="center">Circulation</div></td>
                            <td colspan="2" align="right" valign="baseline" nowrap="nowrap" class="formtext"><div align="center">Others</div></td>
                            </tr>
                          <tr>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Blood:</td>
                        <td valign="baseline" class="formtext"><input type="text" class="formtext" name="fluid_blood" value="" size="4" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Logroll:</td>
                        <td valign="baseline" class="formtext"><input name="al_logroll" type="checkbox" id="al_logroll" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Suction:</td>
                        <td valign="baseline" class="formtext"><input name="air_suction" type="checkbox" id="air_suction" value="1" /></td>
                        <td colspan="3" align="right" valign="baseline" nowrap="nowrap" class="formtext">Oxygen:</td>
                        <td valign="baseline" class="formtext"><input name="br_oxygen" type="checkbox" id="br_oxygen" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">ECG:</td>
                        <td valign="baseline" class="formtext"><input name="cir_ecg" type="checkbox" id="cir_ecg" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Urine:</td>
                        <td valign="baseline" class="formtext"><input name="oth_urine" type="checkbox" id="oth_urine" value="1" /></td>
                        </tr>
                      <tr>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Secretions:</td>
                        <td valign="baseline" class="formtext"><input type="text" class="formtext" name="fluid_secretions" value="" size="4" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Veh_ex:</td>
                        <td valign="baseline" class="formtext"><input name="al_veh_ex" type="checkbox" id="al_veh_ex" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Oro:</td>
                        <td valign="baseline" class="formtext"><input name="air_oro" type="checkbox" id="air_oro" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">60%
                          <input name="br_60" type="checkbox" id="br_60" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">NEB
                          <input name="br_neb" type="checkbox" id="br_neb" value="1" /></td>
                        <td colspan="2" align="right" valign="baseline" nowrap="nowrap" class="formtext">Nasal
                          <input name="br_nasal" type="checkbox" id="br_nasal" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">IV:</td>
                        <td valign="baseline" class="formtext"><input name="cir_iv" type="checkbox" id="cir_iv" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Gastric:</td>
                        <td valign="baseline" class="formtext"><input name="oth_gastric" type="checkbox" id="oth_gastric" value="1" /></td>
                        </tr>
                      <tr>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Enteric:</td>
                        <td valign="baseline" class="formtext"><input type="text" class="formtext" name="fluid_enteric" value="" size="4" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Spineboard:</td>
                        <td valign="baseline" class="formtext"><input name="al_spineboard" type="checkbox" id="al_spineboard" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Oral:</td>
                        <td valign="baseline" class="formtext"><input name="air_oral" type="checkbox" id="air_oral" value="1" /></td>
                        <td colspan="3" align="right" valign="baseline" nowrap="nowrap" class="formtext">Chest:</td>
                        <td valign="baseline" class="formtext"><input name="br_chest" type="checkbox" id="br_chest" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">IO:</td>
                        <td valign="baseline" class="formtext"><input name="cir_io" type="checkbox" id="cir_io" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Stretcher:</td>
                        <td valign="baseline" class="formtext"><input name="oth_stretcher" type="checkbox" id="oth_stretcher" value="1" /></td>
                        </tr>
                      <tr>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Drains:</td>
                        <td valign="baseline" class="formtext"><input type="text" class="formtext" name="fluid_drains" value="" size="4" /></td>
                        <td colspan="2" class="formtext"><div align="center">Defib/Cardio version:
                            <input type="text" class="formtext" name="ecg_defib" value="" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center">Pacing
                          <input type="text" class="formtext" name="ecg_pacing" value="" size="3" />
                        </div></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Scoop:</td>
                        <td valign="baseline" class="formtext"><input name="al_scoop" type="checkbox" id="al_scoop" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Nasal:</td>
                        <td valign="baseline" class="formtext"><input name="air_nasal" type="checkbox" id="air_nasal" value="1" /></td>
                        <td colspan="3" align="right" valign="baseline" nowrap="nowrap" class="formtext">Underwater:</td>
                        <td valign="baseline" class="formtext"><input name="br_underwater" type="checkbox" id="br_underwater" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Hi Cap Line:</td>
                        <td valign="baseline" class="formtext"><input name="cir_hicap" type="checkbox" id="cir_hicap" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Wheelchair:</td>
                        <td valign="baseline" class="formtext"><input name="oth_wheelchair" type="checkbox" id="oth_wheelchair" value="1" /></td>
                        </tr>
                      <tr>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Urine:</td>
                        <td valign="baseline" class="formtext"><input type="text" class="formtext" name="fluid_urine" value="" size="4" /></td>
                        <td class="formtext"><div align="center">Time</div></td>
                        <td class="formtext"><div align="center">Joules</div></td>
                        <td class="formtext"><div align="center">Time
                          <input type="text" class="formtext" name="ecg_time" value="" size="3" />
                        </div></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Cerv_collar:</td>
                        <td valign="baseline" class="formtext"><input name="al_cerv_collar" type="checkbox" id="al_cerv_collar" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Surgical:</td>
                        <td valign="baseline" class="formtext"><input name="air_surgical" type="checkbox" id="air_surgical" value="1" /></td>
                        <td colspan="3" align="right" valign="baseline" nowrap="nowrap" class="formtext">Heimlich:</td>
                        <td valign="baseline" class="formtext"><input name="br_heimlich" type="checkbox" id="br_heimlich" value="1" /></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Pacing:</td>
                        <td valign="baseline" class="formtext"><input name="cir_pacing" type="checkbox" id="cir_pacing" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        </tr>
                      <tr>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Total:</td>
                        <td valign="baseline" class="formtext"><input type="text" class="formtext" name="fluid_total" value="" size="4" /></td>
                        <td class="formtext"><div align="center">
                          <input type="text" class="formtext" name="ecg_time1" value="" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center">
                          <input type="text" class="formtext" name="ecg_joules1" value="" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center">Rate
                          <input type="text" class="formtext" name="ecg_rate" value="" size="3" />
                        </div></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Headblocks:</td>
                        <td valign="baseline" class="formtext"><input name="al_headblocks" type="checkbox" id="al_headblocks" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        <td colspan="3" align="right" valign="baseline" nowrap="nowrap" class="formtext">&nbsp;</td>
                        <td valign="baseline" class="formtext">&nbsp;</td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">CPR:</td>
                        <td valign="baseline" class="formtext"><input name="cir_cpr" type="checkbox" id="cir_cpr" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        </tr>
                      <tr>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext"><div align="center">
                          <input type="text" class="formtext" name="ecg_time2" value="" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center">
                          <input type="text" class="formtext" name="ecg_joules2" value="" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center">mA
                          <input type="text" class="formtext" name="ecg_ma" value="" size="3" />
                        </div></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Spider:</td>
                        <td valign="baseline" class="formtext"><input name="al_spider" type="checkbox" id="al_spider" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        <td colspan="3" align="right" valign="baseline" nowrap="nowrap" class="formtext">&nbsp;</td>
                        <td valign="baseline" class="formtext">&nbsp;</td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Colloids:</td>
                        <td valign="baseline" class="formtext"><input name="cir_colloids" type="checkbox" id="cir_colloids" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        </tr>
                      <tr>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext"><div align="center">
                          <input type="text" class="formtext" name="ecg_time3" value="" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center">
                          <input type="text" class="formtext" name="ecg_joules3" value="" size="3" />
                        </div></td>
                        <td class="formtext"><div align="center"></div></td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">KED:</td>
                        <td valign="baseline" class="formtext"><input name="al_ked" type="checkbox" id="al_ked" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        <td colspan="3" class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        <td align="right" valign="baseline" nowrap="nowrap" class="formtext">Dial:</td>
                        <td valign="baseline" class="formtext"><input name="cir_dial" type="checkbox" id="cir_dial" value="1" /></td>
                        <td class="formtext">&nbsp;</td>
                        <td class="formtext">&nbsp;</td>
                        </tr>
                    </table></td>
                    </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right" valign="top">&nbsp;</td>
                    <td align="right" valign="top" nowrap="nowrap" class="formtext">Personnel items:</td>
                    <td><textarea class="formtext" name="personnel_items" cols="50" rows="5"></textarea>                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><input type="submit" value="Insert record" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form1" />
              </form>
              <p>&nbsp;</p></td>
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

mysql_free_result($medaids);
?>
