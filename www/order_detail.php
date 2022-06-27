<?php require_once 'inc/config.php'; ?>
<?php 
	$now = new DateTime();
	$pageTitle = "Order details";
	$order  = array();
	if(isset($_GET["id"])){
		$res = db_query("SELECT * FROM `order` WHERE id={$_GET["id"]}");
		$order = db_fetch_row($res);

		$vat_select = "SELECT * FROM vat";
		$result = mysql_query($vat_select);

		$vat_fetch = mysql_fetch_assoc($result);

		$per_vat = $vat_fetch["vat"];
	}
	if(!isset($order["id"])){
		exit;
	}

?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
		<center><?php echo getArabic('VatNo')?>
		<hr>
		<br/>
		<?php echo getArabic('ShopNo')?></center>
<style>
table {
    border-collapse: collapse;
    border-spacing: 0;
}
* {color: #000000; }
	.print-table { width: 100%; }
	.print-table td{ border: 1px solid; padding: 10px 5px; }
	.print-table th{ border: 1px solid; padding: 10px 15px; }
	.print-table td.noborder, .print-table th.noborder { border: none; }
	.print-table table { width: 100%; }
	.print-table table td { border: none; padding: 0; }
	.print-table .tc{ text-align: center; }
	.print-table .form-control { padding: 2px 3px; }
	.rtl { direction: rtl; }
.auto-style1 {
	direction: rtl;
	color: #000000;
}
.auto-style2 {
	color: #000000;
}
</style>
    </head>
    <body>
	<table class="print-table">
		<tr>
			<td colspan="3" class="auto-style2"><span style="float: left; color: black; font-size: 2em; line-height: 12px;"><?php echo ($order["bill_number"]); ?></span></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Date & Time</td>
			<td class="tc" style="color: #000000"><?php echo (formatDateTime($order["order_date"])); ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Date')?></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Tel.:</td>
			<td class="tc" style="color: #000000"><?php echo ($order["client_phone"]); ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Tel')?>:</td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Name:</td>
			<td class="tc" style="color: #000000"><?php echo ($order["client_name"]); ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Name')?>:</td>
		</tr>
		<?php if(isset($order["price_full"]) && $order["price_total"] < $order["price_full"]) { ?>
		<tr>
			<td style="width: 25%;" class="auto-style2">Amount</td>
			<td class="tc" style="color: #000000"><?php echo $order["price_full"]+(($per_vat*$order["price_full"])/100); ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Amount')?></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Disc price</td>
			<td class="tc" style="color: #000000"><?php echo $order["price_total"]; ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Discounted price')?></td>
		</tr>
		<?php }else{ ?>
		<tr>
			<td style="width: 25%;" class="auto-style2">Disc price</td>
				<td class="tc" style="color: #000000"><?php echo $order["price_total"]; ?></td>
				<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Discounted price')?>
			</td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Amount Before VAT</td>
			<td class="tc" style="color: #000000"><?php echo $order["price_full"]; ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Total Amount Before VAT'); ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td style="width: 25%;" class="auto-style2">Amount After VAT</td>
			<td class="tc" style="color: #000000"><?php echo $order["price_full_vat"]; ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Total Amount After VAT'); ?></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">VAT (%)</td>
			<td class="tc" style="color: #000000"><?php echo $per_vat; ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('VAT')?></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Paid</td>
			<td class="tc" style="color: #000000"><?php echo $order["price_paid"]; ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Paid')?></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Balance</td>
			<td class="tc" style="color: #000000"><?php echo  ($order["price_total"]-$order["price_paid"]); ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Balance')?></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Frames</td>
			<td class="tc" style="color: #000000">
				<?php 
				$resitems = db_query("SELECT * FROM `order_items` WHERE order_id={$_GET["id"]}");
				$order_items = db_fetch_array($resitems);
				$frameArr = array();
				if(!empty($order_items))
				{
					foreach($order_items as $frame)
					{
						$frameQuery = mysql_query("SELECT product_arabic FROM products WHERE id =".$frame['frame_id']);
						$framesFetch = mysql_fetch_row($frameQuery);
						if($framesFetch[0] != '')
						    array_push($frameArr, $framesFetch[0]);
					}
				}

				if(!empty($frameArr))
					echo implode('، ', $frameArr);
				else
					echo '';
				?>
			</td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Frame')?></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Lenses</td>
			<td class="tc" style="color: #000000">
				<?php 
				$resitems = db_query("SELECT * FROM `order_items` WHERE order_id={$_GET["id"]}");
				$order_items = db_fetch_array($resitems);
				$lensArr = array();
				if(!empty($order_items))
				{
					foreach($order_items as $lens)
					{
						$lensQuery = mysql_query("SELECT lens_arabic FROM lenses WHERE id =".$lens['lense_id']);
						$lensFetch = mysql_fetch_row($lensQuery);
						if($lensFetch[0] != '')
						    array_push($lensArr, $lensFetch[0]);
					}
				}
                
                if(!empty($lensArr))
					echo implode('، ', $lensArr);
				else
					echo '';
				?>
			</td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Lenses')?></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Note</td>
			<td class="tc" style="color: #000000"><?php echo ($order["note"]); ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('note')?></td>
		</tr>
	</table>
	<hr>
	<center><?php echo getArabic('ReturnTerms')?></center>
</body>
</html>