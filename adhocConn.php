<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
#$hostname_adhocConn = "localhost";
$hostname_adhocConn = "localhost";
$database_adhocConn = "adhoc_adhocpanmv_db1";
$username_adhocConn = "adhoc_usr";
$password_adhocConn = "W@gp0s9";
$adhocConn = mysql_connect($hostname_adhocConn, $username_adhocConn, $password_adhocConn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>