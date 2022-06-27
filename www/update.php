<?php require_once 'inc/config.php'; $template['header']='';

 $vat_id = $_POST['id'];
$post_value = $_POST['wat'];
$post_number_value = $_POST['number'];
// $vat_update = "UPDATE vat SET vat='".$post_value."', registeraion_number =".$post_number_value." WHERE id='".$vat_id."'";
$vat_update = "UPDATE vat SET registeraion_number= ".$post_number_value.", vat='".$post_value."' WHERE id='".$vat_id."'";
$result = mysql_query($vat_update);
if($result)
	echo true;
else
	echo false;
exit;

?>