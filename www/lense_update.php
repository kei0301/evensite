<?php require_once 'inc/config.php'; $template['header']=''; ?>
<?php
	$lense_id = $_POST['id'];
	$lense_name = $_POST['lense_name'];
	$lense_arabic = $_POST['lense_arabic'];
	$lense_price = $_POST['lense_price'];
	$lense_quantity = $_POST['lense_quantity'];

	$lense_update = "UPDATE lenses SET lens_name = '".$lense_name."', lens_arabic = '".$lense_arabic."', lens_price = '".$lense_price."', lens_quantity = '".$lense_quantity." ' WHERE id = '".$lense_id."'";
	$result = mysql_query($lense_update);
	if($result)
		echo true;
	else
		echo false;
	exit;
?>