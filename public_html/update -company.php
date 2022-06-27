<?php require_once 'inc/config.php'; $template['header']='';

$post_value = $_POST['wat'];
$post_number_value = $_POST['number'];
$vat_update = "UPDATE vat SET company_name='".$post_value" WHERE id='".$vat_id."'";
$result = mysql_query($vat_update);
if($result)
	echo true;
else
	echo false;
exit;

?>