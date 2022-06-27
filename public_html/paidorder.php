<?php 
require_once 'inc/config.php'; 
$template['header']='';
if(isset($_POST['orderid']) && isset($_POST['amount']))
{
	$update = mysql_query("UPDATE `order` SET `price_paid` = '".$_POST['amount']."' WHERE `id` ='".$_POST['orderid']."' ");
	if($update)
		echo true;
	else
		echo false;
	exit;
}