<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
include_once 'mysql.php';
$hostname_koneksi = "localhost";
$database_koneksi = "u7995957_inventory";
$username_koneksi = "u7995957_inventory";
$password_koneksi = "s4lludinG";
$koneksi = mysql_pconnect($hostname_koneksi, $username_koneksi, $password_koneksi) or trigger_error(mysql_error(),E_USER_ERROR); 
?>