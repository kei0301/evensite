<?php require_once 'inc/config.php'; ?>
<?php 
	if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
		exit;
	}
	$pageTitle = "Order details";
	$fetchQuery = mysql_query("SELECT COUNT(id) as NoOfSales, SUM(price_total) as AmountDiscounted, SUM(price_paid) as PaidOrders FROM `order` WHERE `order_date` BETWEEN '".$_GET['from']."' AND '".$_GET['to']."' ");
	$fetchData = mysql_fetch_row($fetchQuery);

	if($fetchData[1] != '') { $fetchDataAmount = $fetchData[1]; } else{ $fetchDataAmount = '0.00'; } 
	if($fetchData[2] != '') { $fetchDataPaid = $fetchData[2]; } else{ $fetchDataPaid = '0.00'; } 
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
		<thead>
			<tr>
				<td colspan="2" align="center" style="font-size:20px;">Sales Between <?php echo date("m/d/Y", strtotime($_GET["from"])).' to '.date("m/d/Y", strtotime($_GET["to"])); ?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="width: 25%;" class="auto-style2">Total Sales</td>
				<td class="tc" style="color: #000000"><?php echo $fetchData[0]; ?></td>
			</tr>
			<tr>
				<td style="width: 25%;" class="auto-style2">Total Amount</td>
				<td class="tc" style="color: #000000"><?php echo $fetchDataAmount; ?></td>
			</tr>
			<tr>
				<td style="width: 25%;" class="auto-style2">Total Paid</td>
				<td class="tc" style="color: #000000"><?php echo $fetchDataPaid; ?></td>
			</tr>
		</tbody>
	</table>
</body>
</html>