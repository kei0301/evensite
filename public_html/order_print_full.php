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

	text-align: left;

}

.auto-style3 {

	font-family: Verdana, Geneva, Tahoma, sans-serif;

	color: #000000;

	font-weight: normal;

	font-size: small;

}

.auto-style4 {

	font-family: "Microsoft YaHei UI Light";

	color: #000000;

	text-align: center;

	font-size: x-small;

	font-weight: bold;

}

.auto-style5 {

	color: #000000;

}

</style>

    </head>

    <body onload="window.print()">

            <table class="print-table">

				<tr>

					<td class="noborder">

						<span style="float: left; color: red; font-size: 2em; line-height: 12px;"><?php echo ($order["bill_number"]); ?></span>

					</td>

				</tr>

				<tr>

					<td class="noborder">

						<table>

							<tr>

								<td style="width: 25%; text-align: right;">

								<strong class="auto-style3">Tel:</strong></td>

								<td class="auto-style4" style="border-bottom: 1px solid;"><?php echo ($order["client_phone"]); ?></td>

								<td class="auto-style3" style="width: 25%; text-align: left;"><?php echo getArabic('Tel')?>:</td>

							</tr>

						</table>

					</td>

				</tr>

				<tr>

					<td class="noborder">

						<table>

							<tr>

								<td style="width: 25%; text-align: right;">

								<strong class="auto-style3">Name:</strong></td>

								<td class="auto-style4" style="border-bottom: 1px solid;"><?php echo ($order["client_name"]); ?></td>

								<td class="auto-style3" style="width: 25%; text-align: left;"><?php echo getArabic('Name')?>:</td>

							</tr>

						</table>

					</td>

				</tr>

				<tr>

					<td>

						<table>

							<tr>

								<td style="width: 25%;" class="auto-style3">

								<strong class="auto-style3">Date</strong></td>

								<td class="auto-style3"><?php echo (formatDate($order["order_date"])); ?></td>

								<td class="auto-style3" style="width: 25%;"><?php echo getArabic('Date')?></td>

							</tr>

						</table>

					</td>

				</tr>

				<tr>

					<th class="auto-style1"><span class="auto-style3">Right Eye OD <?php echo getArabic('Right Eye OD')?></span><br class="auto-style3">

					<span class="auto-style3"><span class="auto-style3">

					Distance:

					<?php echo ($order["er_d_sphere"]); ?>/<?php echo ($order["er_d_cylinder"]); ?>

					</span>x<span class="auto-style3"><?php echo ($order["er_d_axis"]); ?></span></span><br class="auto-style3">

					<span class="auto-style3"><span class="auto-style3">Reading:<?php echo ($order["er_r_sphere"]); ?>/<?php echo ($order["er_r_cylinder"]); ?></span>x<span class="auto-style3"><?php echo ($order["er_r_axis"]); ?></span></span><br class="auto-style3">

					<span class="auto-style3"><span class="auto-style3">Add:</span><?php echo ($order["er_add"]); ?><br class="auto-style3">

					---------------------</span><br class="auto-style3"><span class="auto-style3">Left Eye OS <?php echo getArabic('Left Eye OS')?></span><br class="auto-style3">

					<span class="auto-style3"><span class="auto-style3">

					Distance:

					<?php echo ($order["el_d_sphere"]); ?>/<?php echo ($order["el_d_cylinder"]); ?>

					</span>x<span class="auto-style3"><?php echo ($order["el_d_axis"]); ?></span></span><br class="auto-style3">

					<span class="auto-style3"><span class="auto-style3">Reading:<?php echo ($order["el_r_sphere"]); ?>/<?php echo ($order["el_r_cylinder"]); ?></span>x<span class="auto-style3"><?php echo ($order["el_r_axis"]); ?></span></span><br class="auto-style3">

					<span class="auto-style3"><span class="auto-style3">Add:<?php echo ($order["el_add"]); ?></span></span><br class="auto-style3">

					<span class="auto-style3"><span class="auto-style3">IPD:<?php echo ($order["ipd"]); ?></span></span><br class="auto-style3">

					<span class="auto-style3"><span class="auto-style3">Frame:

					<?php 

					$resitems = db_query("SELECT * FROM `order_items` WHERE order_id={$_GET["id"]}");

					$order_items = db_fetch_array($resitems);

					$frameArr = array();

					if(!empty($order_items))

					{

						foreach($order_items as $frame)

						{

							$frameQuery = mysql_query("SELECT product_name FROM products WHERE id =".$frame['frame_id']);

							$framesFetch = mysql_fetch_row($frameQuery);

							array_push($frameArr, $framesFetch[0]);

						}

					}



					if(!empty($frameArr))

					{

						echo implode(', ', $frameArr);

					}

					else

						echo 'No Frame';

					?></span>

					

					</span></span><br class="auto-style3">

					<span class="auto-style3"><span class="auto-style3">Lenses: 

					<?php 

					$resitems = db_query("SELECT * FROM `order_items` WHERE order_id={$_GET["id"]}");

					$order_items = db_fetch_array($resitems);

					$lensArr = array();

					if(!empty($order_items))

					{

						foreach($order_items as $lens)

						{

							$lensQuery = mysql_query("SELECT lens_name FROM lenses WHERE id =".$lens['lense_id']);

							$lensFetch = mysql_fetch_row($lensQuery);

							array_push($lensArr, $lensFetch[0]);

						}

					}



					if(!empty($lensArr))

					{

						echo implode(', ', $lensArr);

					}

					else

						echo 'No Lenses';

					?></span>

					

					</span></span><br>

					<span class="auto-style3">Note:<?php echo ($order["note"]); ?></span><br><span class="auto-style5">Contact Lens</span><br><span class="auto-style3">Right Eye OD <?php echo getArabic('Right Eye OD')?></span><br class="auto-style3">

					<span class="auto-style3">Distance:

					<?php echo ($order["er_cl_sphere"]); ?><?php echo ($order["er_cl_cylinder"]); ?>

					x<?php echo ($order["er_cl_axis"]); ?><br class="auto-style3">

					---------------------</span><br class="auto-style3"><span class="auto-style3">Left Eye OS <?php echo getArabic('Left Eye OS')?></span><br class="auto-style3">

					<span class="auto-style3">Distance:

					<?php echo ($order["el_cl_sphere"]); ?><?php echo ($order["el_cl_cylinder"]); ?>

					x<?php echo ($order["el_cl_axis"]); ?></span></th>

				</tr>

				</table>

</body>

</html>



