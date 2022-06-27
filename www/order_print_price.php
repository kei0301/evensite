<?php require_once 'inc/config.php'; ?>
<?php 
	include('./lib/phpqrcode/qrlib.php');
	if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
		exit;
	}
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
	$tempDir = dirname(__FILE__)."/qrcode/";
    // $codeContents = "https://www.eyen.site/?companay_name=Kowat&Vat_Registration_number=123456789&Date/Time_stamp=".urlencode(formatDateTime($order["order_date"]))."&Invoice_total(+15%Vat)=".urlencode($order["price_full_vat"])."&TOTAL_VAT=".urlencode(($per_vat*$order["price_full_vat"]/100))."&id=".urlencode($order["id"]);
    // $codeContents = `Kowat:اسم الشركة \n123456789:رقم ضريبة القيمة المضافة \n123321: التاريخ / الوقت \ntest123: إجمالي الفاتورة (+ ضريبة القيمة المضافة) \n123321: إجمالي ضريبة القيمة المضافة
    // `;

    $codeContents = "https://www.eyen.site/"."?id=".urlencode($order["id"])."\n"
    .$vat_fetch["company_name"].": اسم الشركة\n"
    .$vat_fetch["registeraion_number"].": رقم التسجيل الضريبي\n"
    .formatDateTime($order["order_date"]).": التاريخ / الوقت:  \n"
    ."إجمالي الفاتورة (+ ضريبة القيمة المضافة): ".$order["price_full_vat"]
    ."\nإجمالي ضريبة القيمة المضافة: ".$order["price_full"] * ($vat_fetch["vat"]/100);
    $fileName = '005_file_'.md5($codeContents).'.png';
    $pngAbsoluteFilePath = $tempDir.$fileName;
    $urlRelativeFilePath = './qrcode/'. $fileName;
      if (!file_exists($pngAbsoluteFilePath)) {
        QRcode::png($codeContents, $pngAbsoluteFilePath);
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
    <body onload="window.print()">
	<table style="height: 100px;" class="print-table">

		<tr>
			<td colspan="3" class="auto-style2"><span style="float: left; color: black; font-size: 2em; line-height: 12px;"><?php echo ($order["bill_number"]); ?></span></td>
		</tr>
		
		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">Date & Time</td>
			<td class="tc" style="color: #000000; font-size: 1em;"><?php echo (formatDateTime($order["order_date"])); ?></td>
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('Date')?></td>
		</tr>

		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">Name:</td>
			<td class="tc" style="color: #000000; font-size: 1em;"><?php echo ($order["client_name"]); ?></td>
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('Name')?>:</td>
		</tr>

		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">Tel.:</td>
			<td class="tc" style="color: #000000; font-size: 1em;"><?php echo ($order["client_phone"]); ?></td>
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('Tel')?>:</td>
		</tr>

		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">Frames</td>
			<td class="tc" style="color: #000000; font-size: 1em;">
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
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('Frame')?></td>
		</tr>

		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">Lenses</td>
			<td class="tc" style="color: #000000; font-size: 1em;">
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
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('Lenses')?></td>
		</tr>

		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">Note</td>
			<td class="tc" style="color: #000000; font-size: 1em;"><?php echo ($order["note"]); ?></td>
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('note')?></td>
		</tr>

		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">Amount Before VAT</td>
			<td class="tc" style="color: #000000; font-size: 1em;"><?php echo $order["price_full"]; ?></td>
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('Total Amount Before VAT'); ?></td>
		</tr>

		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">Amount After VAT</td>
			<td class="tc" style="color: #000000; font-size: 1em;"><?php echo $order["price_full_vat"]; ?></td>
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('Total Amount After VAT'); ?></td>
		</tr>

		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">VAT (%)</td>
			<td class="tc" style="color: #000000; font-size: 1em;"><?php echo $per_vat; ?></td>
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('VAT')?></td>
		</tr>

		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">TOTAL VAT</td>
			<td class="tc" style="color: #000000; font-size: 1em;"><?php echo $per_vat*$order["price_full_vat"]/100 ?></td>
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('VAT')?></td>
		</tr>

		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">Disc price</td>
			<td class="tc" style="color: #000000; font-size: 1em;"><?php echo $order["price_total"]; ?></td>
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('Discounted price')?></td>
		</tr>

		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">Paid</td>
			<td class="tc" style="color: #000000; font-size: 1em;"><?php echo $order["price_paid"]; ?></td>
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('Paid')?></td>
		</tr>

		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">Balance</td>
			<td class="tc" style="color: #000000; font-size: 1em;"><?php echo  ($order["price_total"]-$order["price_paid"]); ?></td>
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('Balance')?></td>
		</tr>

		<?php if(isset($order["price_full"]) && $order["price_total"] < $order["price_full"]) { ?>
		<tr>
			<td style="width: 25%; font-size: 1em;" class="auto-style2">Amount</td>
			<td class="tc" style="color: #000000; font-size: 1em;"><?php echo $order["price_full"]+(($per_vat*$order["price_full"])/100); ?></td>
			<td class="auto-style1" style="width: 25%; font-size: 1em;"><?php echo getArabic('Amount')?></td>
		</tr>
		<?php }else{ ?>
		<?php } ?>
	</table>
	<hr>
	<center><?php echo getArabic('ReturnTerms')?></center>
	<hr>
	<center ><?php echo '<img src="'.$urlRelativeFilePath.'" />';?></center>
</body>
</html>