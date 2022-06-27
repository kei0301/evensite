<?php require_once 'inc/config.php'; $template['header']=''; 
parse_str($_POST['data'],$myArray);

$lense_name = $myArray['lense_name'];
$lense_arabic = $myArray['lense_arabic'];
$lense_price = $myArray['lense_price'];
$lense_quantity = $myArray['lense_quantity'];

$lense_insert = "INSERT INTO lenses (lens_name, lens_arabic, lens_price, lens_quantity) VALUES ('".$lense_name."', '".$lense_arabic."', '".$lense_price."', '".$lense_quantity."')";
$lense_insert_query = mysql_query($lense_insert);	
if($lense_insert_query) 
	echo true;
else
	echo false;
exit();
?>
