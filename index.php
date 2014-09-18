<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ad Hoc Plumbers Admin</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>

<body onload="document.forms[0].uname.focus();">
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="613" valign="top" background="design/index.jpg"><form id="form1" name="form1" method="post" action="index_otp.php">
      <table width="950" border="00" cellspacing="0" cellpadding="0">
        <tr>
          <td width="200" height="343">&nbsp;</td>
          <td width="159">&nbsp;</td>
          <td width="434">&nbsp;</td>
          <td width="119">&nbsp;</td>
          <td width="29">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="uname" type="text" class="logintextbox" id="uname" size="12" /></td>
          <td rowspan="2"><input name="button" type="submit" class="loginbutton" id="button" value="Enter" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="60">&nbsp;</td>
          <td><input name="pword" type="password" class="logintextbox" id="pword" size="12" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="60">&nbsp;</td>
          <td colspan="2" class="redtext"><?php if ($_GET['msg']) { echo $_GET['msg']; } ?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
        </form>
    </td>
  </tr>
</table>
</body>
</html>
