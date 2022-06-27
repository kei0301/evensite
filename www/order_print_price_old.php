<?php require_once 'inc/config.php'; ?>
<?php 
	if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
		exit;
	}
	$pageTitle = "Order details";
	$order  = array();
	if(isset($_GET["id"])){
		$res = db_query("SELECT * FROM `order` WHERE id={$_GET["id"]}");
		$order = db_fetch_row($res);
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
<style>
table {
    border-collapse: collapse;
    border-spacing: 0;
}
* {color: #096b77; }
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
    <body onload="window.print()">
	<table class="print-table">
		<tr>
			<td colspan="3" class="auto-style2"><span style="float: left; color: red; font-size: 2em; line-height: 12px;"><?php echo ($order["bill_number"]); ?></span></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Date</td>
			<td class="tc" style="color: #000000"><?php echo (formatDate($order["order_date"])); ?></td>
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
			<td class="tc" style="color: #000000"><?php echo ($order["price_full"]); ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Amount')?></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Disc price</td>
			<td class="tc" style="color: #000000"><?php echo ($order["price_total"]); ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Discounted price')?></td>
		</tr>
		<?php }else{ ?>
		<tr>
			<td style="width: 25%;" class="auto-style2">Amount</td>
			<td class="tc" style="color: #000000"><?php echo ($order["price_total"]); ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Amount')?></td>
		</tr>
		<?php } ?>
		<tr>
			<td style="width: 25%;" class="auto-style2">Paid</td>
			<td class="tc" style="color: #000000"><?php echo ($order["price_total"]-$order["price_paid"]); ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Paid')?></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Balance</td>
			<td class="tc" style="color: #000000"><?php echo $order["price_total"]-$order["price_paid"]; ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Balance')?></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Frame</td>
			<td class="tc" style="color: #000000"><?php echo ($order["frame"]); ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Frame')?></td>
		</tr>
		<tr>
			<td style="width: 25%;" class="auto-style2">Lenses</td>
			<td class="tc" style="color: #000000"><?php echo ($order["lenses"]); ?></td>
			<td class="auto-style1" style="width: 25%;"><?php echo getArabic('Lenses')?></td>
		</tr>
	</table>
</body>
</html>