<?php
require 'inc/common.php';
require 'inc/mailer.php';
require 'inc/db.php';


$password = $_POST['password'];
$password2 = '"'.mysql_real_escape_string($password, $link).'"';

// Register MAC address
$mac = find_mac();
if ($mac)
	$mac2 = ', mac = "'.sha1('salT'.$mac).'"';
else
	$mac2 = '';

mysql_query('UPDATE members.Users SET count = count + 1'.$mac2." WHERE CURDATE() <= paid AND password = $password2", $link)
	or mail_and_die('mysql_query UPDATE error', __FILE__);

if (mysql_affected_rows($link) != 1)
{
	header('Location: accessdenied.html', true, 303);
}
else
{
	open_door();
}
mysql_close($link);
unset($link);

