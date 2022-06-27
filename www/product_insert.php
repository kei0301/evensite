<?php require_once 'inc/config.php'; $template['header']=''; 
$product_name = $_POST['product_name'];
$product_arabic = $_POST['product_arabic'];
$product_price = $_POST['product_price'];
$product_qty = $_POST['product_qty'];
$lenses_ids = $_POST['lenses_ids'];
$checkbox = $_POST['checkbox'];

$product_insert = "INSERT INTO products (product_name, product_arabic, product_price, product_qty, ischecked) VALUES ('".$product_name."', '".$product_arabic."', '".$product_price."', '".$product_qty."', '".$checkbox."')";
$product_insert_query = mysql_query($product_insert);	
if($product_insert_query)
{
	$productid = mysql_insert_id();
	if(!empty($lenses_ids))
	{
		foreach($lenses_ids as $lens_id)
		{
			mysql_query("INSERT INTO lens_relation (product_id, lens_id) VALUES('".$productid."', 
				'".$lens_id."')");
		}
	}
	echo true;
}
else
	echo false; 
 
exit();
?>
