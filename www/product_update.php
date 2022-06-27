<?php 
	require_once 'inc/config.php'; 
	$template['header']=''; 
	
	$product_id = $_POST['id'];
	$product_name = $_POST['product_name'];
	$product_arabic = $_POST['product_arabic'];
	$product_price = $_POST['product_price'];
	$product_qty = $_POST['product_qty'];
	$lenses_ids = $_POST['lenses_ids'];
	$checkbox = $_POST['checkbox'];

	$product_update = "UPDATE products SET product_name = '".$product_name."', product_arabic = '".$product_arabic."', product_price = '".$product_price."', product_qty = '".$product_qty."', ischecked = '".$checkbox."' WHERE id = '".$product_id."'";
	$result = mysql_query($product_update);

	if($result)
	{
		mysql_query("DELETE FROM lens_relation WHERE product_id = '".$product_id."' ");
		if(!empty($lenses_ids))
		{
			foreach($lenses_ids as $lens_id)
			{
				mysql_query("INSERT INTO lens_relation (product_id, lens_id) VALUES('".$product_id."','".$lens_id."')");
			}
		}
		echo true;
	}
	else
		echo false;
	exit();
?>