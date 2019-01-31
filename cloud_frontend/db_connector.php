<?php

DEFINE ('DB_SERVER', 'j201s686.jci.com');
DEFINE ('DB_USER', 'pscurek');
DEFINE ('DB_PASSWORD', 'WP3rhpw!');
DEFINE ('DB_DATABASE', 'csp');

$db_connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE)
 or die('Error connecting to MySQL database');
?>