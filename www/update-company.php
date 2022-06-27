<?php require_once 'inc/config.php'; $template['header']='';

 $vat_id = $_POST['id'];
$post_value = $_POST['wat'];
$vat_update = "UPDATE vat SET company_name='".$post_value."'WHERE id='".$vat_id."'";
$result = mysql_query($vat_update);
if($result)
	echo true;
else
	echo false;
exit;

?>