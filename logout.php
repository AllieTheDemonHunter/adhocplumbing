<?php
// *** Logout the current user.
$logoutGoTo = "index.php";
session_start();
//unset($_COOKIE['MM_Username']);
//unset($_COOKIE['MM_UserGroup']);
//unset($_COOKIE['MM_userID']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
//session_unregister('MM_Username');
//session_unregister('MM_UserGroup');
//session_unregister('MM_userID');
setcookie("MM_Username", $loginUsername, time()-7200);
setcookie("MM_UserGroup", $loginStrGroup, time()-7200);
setcookie("MM_userID", $loginUserID, time()-7200);
setcookie("MM_expiry", $expiry, time()-7200);

exit;
}
?>
