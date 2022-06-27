<?php 
	require_once 'inc/config.php'; 
	$template['header']='';
	if(isset($_POST['productid']))
	{
		$productid = $_POST['productid'];
		$orderid = $_POST['orderid'];
		$vat = $_POST['vat'];
		$getPreviousPriceQuery = mysql_query("SELECT `products`.`product_price` as `prevFramePrice`, `lenses`.`lens_price` as `preLensPrice` FROM `order` LEFT JOIN `products` ON `order`.`frame` = `products`.`id` LEFT JOIN `lenses` ON `order`.`lenses` = `lenses`.`id` WHERE `order`.`id` = '".$orderid."' ");
		$getPreviousPrice = mysql_fetch_row($getPreviousPriceQuery);
		$prevFramePrice = 0;
		$preLensPrice = 0;
		if($getPreviousPrice[0] != '' && $getPreviousPrice[1] != '')
		{
			$prevFramePrice = $getPreviousPrice[0] + (($getPreviousPrice[0]*$vat)/100);
			$preLensPrice = $getPreviousPrice[1] + (($getPreviousPrice[1]*$vat)/100);
		}
		$lenses_select = mysql_query("SELECT lenses.* FROM lens_relation INNER JOIN lenses ON lens_relation.lens_id = lenses.id WHERE lens_relation.product_id = '".$productid."' ");
		$lenseArray = array();

		while($lenseList = mysql_fetch_assoc($lenses_select))
		{
			if($lenseList['lens_quantity']>0)
			{
				$lenseArray[]=array('id'=> $lenseList['id'], 'lens_name' => $lenseList['lens_name'], 'lens_price' => $lenseList['lens_price'], 'lens_quantity' => $lenseList['lens_quantity']);
			}

		}
		$product_select = mysql_query("SELECT product_price FROM products WHERE id = '".$productid."' ");
		$productPrice = mysql_fetch_row($product_select);
		echo json_encode(array('lensesArray'=> $lenseArray, 'productPrice'=> $productPrice[0], 'prevFramePrice' => $prevFramePrice, 'preLensPrice' => $preLensPrice));
		exit;
	}