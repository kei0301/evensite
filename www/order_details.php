<?php require_once 'inc/config.php'; ?>

<?php 

	if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){

		doRedirect("login.php");

	}

	$pageTitle = "Order details / ".getArabic('Order details');

	$order  = array();

	if(isset($_GET["id"])){

		$res = db_query("SELECT * FROM `order` WHERE id={$_GET["id"]}");

		$resitems = db_query("SELECT * FROM `order_items` WHERE order_id={$_GET["id"]}");

		$order_items = db_fetch_array($resitems);

		$order = db_fetch_row($res);

		

	}
	if(!isset($order["id"])){

		doRedirect("home.php");

	}

	if(isset($_POST["id"]) && $_POST["id"] == $_GET["id"]){



		$res = db_query("

			UPDATE `order` SET 

				`client_name` = '".mysql_real_escape_string($_POST["client_name"])."',

				`client_phone` = '".mysql_real_escape_string($_POST["client_phone"])."', 

				`price_total` = '".mysql_real_escape_string($_POST["price_total"])."', 

				`price_paid` = '".mysql_real_escape_string($_POST["price_paid"])."', 

				`price_full` = '".mysql_real_escape_string($_POST["price_full"])."', 

				`price_full_vat` = '".mysql_real_escape_string($_POST["vat"])."',

				`price_discount` = '".mysql_real_escape_string($_POST["price_discount"])."', 

				`er_d_sphere` = '".mysql_real_escape_string($_POST["er_d_sphere"])."', 

				`er_d_cylinder` = '".mysql_real_escape_string($_POST["er_d_cylinder"])."', 

				`er_d_axis` = '".mysql_real_escape_string($_POST["er_d_axis"])."', 

				`er_r_sphere` = '".mysql_real_escape_string($_POST["er_r_sphere"])."', 

				`er_r_cylinder` = '".mysql_real_escape_string($_POST["er_r_cylinder"])."', 

				`er_r_axis` = '".mysql_real_escape_string($_POST["er_r_axis"])."',

				`er_cl_sphere` = '".mysql_real_escape_string($_POST["er_cl_sphere"])."', 

				`er_cl_cylinder` = '".mysql_real_escape_string($_POST["er_cl_cylinder"])."', 

				`er_cl_axis` = '".mysql_real_escape_string($_POST["er_cl_axis"])."', 

				`er_add` = '".mysql_real_escape_string($_POST["er_add"])."', 

				`el_d_sphere` = '".mysql_real_escape_string($_POST["el_d_sphere"])."', 

				`el_d_cylinder` = '".mysql_real_escape_string($_POST["el_d_cylinder"])."', 

				`el_d_axis` = '".mysql_real_escape_string($_POST["el_d_axis"])."', 

				`el_r_sphere` = '".mysql_real_escape_string($_POST["el_r_sphere"])."', 

				`el_r_cylinder` = '".mysql_real_escape_string($_POST["el_r_cylinder"])."', 

				`el_r_axis` = '".mysql_real_escape_string($_POST["el_r_axis"])."',

				`el_cl_sphere` = '".mysql_real_escape_string($_POST["el_cl_sphere"])."', 

				`el_cl_cylinder` = '".mysql_real_escape_string($_POST["el_cl_cylinder"])."', 

				`el_cl_axis` = '".mysql_real_escape_string($_POST["el_cl_axis"])."', 

				`el_add` = '".mysql_real_escape_string($_POST["el_add"])."', 

				`ipd` = '".mysql_real_escape_string($_POST["ipd"])."', 

				`frame` = 'NULL', 

				`note` = '".mysql_real_escape_string($_POST["note"])."', 

				`lenses` = 'NULL', 

				order_date = order_date,

				`isOld` = 0

			WHERE id = {$_POST["id"]}

		");



		if(isset($_POST['frame']) && !empty($_POST['frame']))

		{

			$getFrameLens = db_query("SELECT * FROM `order_items` WHERE order_id={$_POST["id"]}");

			foreach(db_fetch_array($getFrameLens) as $fl)

			{

				db_query("UPDATE `products` SET `product_qty` = `product_qty` + 1 WHERE `id` = ".$fl['frame_id']);

				if($fl['lense_id'] != 0)

					db_query("UPDATE `lenses` SET `lens_quantity` = `lens_quantity` + 1 WHERE id = ".$fl['lense_id']);

			}

			$delete_items = db_query("DELETE FROM `order_items` WHERE order_id={$_POST["id"]}");

			$itemc = 0;



			foreach ($_POST['frame'] as $frame) {

				if(isset($_POST["lenses"][$itemc]) && $_POST["lenses"][$itemc] != '')

				{

					$lenseID = $_POST["lenses"][$itemc];

				} else {

					$lenseID = 0;

				}

				if($frame){

					

					db_query("INSERT INTO `order_items`( `order_id`, `frame_id`, `lense_id`) VALUES ({$_POST["id"]},{$frame},{$lenseID})");

					db_query("UPDATE `products` SET `product_qty` = `product_qty` - 1 WHERE `id` = ".$frame);

					if($lenseID != 0)

						db_query("UPDATE `lenses` SET `lens_quantity` = `lens_quantity` - 1 WHERE id = ".$lenseID);

					

				}

				

				$itemc++;

			}

			

		}

		else

		{

			db_query("DELETE FROM `order_items` WHERE order_id={$_POST["id"]}");

		}

		

		$res = db_query("SELECT * FROM `order` WHERE id={$_GET["id"]}");

		$order = db_fetch_row($res);



		$resitems = db_query("SELECT * FROM `order_items` WHERE order_id={$_GET["id"]} ORDER BY id ASC");

		$order_items = db_fetch_array($resitems);

		

		$alertMsg = "Updated successfully<br/>".getArabic('Updated successfully');

		$alertType = "success";



	}



	/*get vat*/

	$vat_select = "SELECT * FROM vat";

	$result = mysql_query($vat_select);

	$vat_fetch = mysql_fetch_assoc($result);

	$per_vat = $vat_fetch["vat"];

	

?>

<style>

	.print-table { width: 90%; margin: 0 5%; }

	.print-table td{ border: 1px solid; padding: 10px 5px; }

	.print-table th{ border: 1px solid; padding: 10px 15px; }

	.print-table td.noborder, .print-table th.noborder { border: none; }

	.print-table table { width: 100%; }

	.print-table table td { border: none; padding: 0; }

	.print-table .tc{ text-align: center; }

	.print-table .form-control { padding: 2px 3px; }

	.rtl { direction: rtl; }

	.form-control.frame{

		padding: 0;

	    border-color: #fff;

	}

	.form-control.lenses

	{

		padding: 0;

    	border-color: #fff;

	}

	.lenseBox {

    	margin-bottom: 5px;

	}

</style>

<?php require_once 'inc/page_menu.php'; ?>

<link href="css/select2.min.css" rel="stylesheet" />

<div class="content-header">

	<div class="header-section">

		<h1><?php echo $pageTitle; ?></h1>

		<div class="alert alert-success" style="display:none;">Updated successfully<br/> <?php echo getArabic('Updated successfully'); ?>

		</div>

	</div>

</div>

<!-- END Static Layout Header -->



<!-- Dummy Content -->

<div class="block full block-alt-noborder" style="padding-top: 0px;">

	<form  method="post" class="form-horizontal form-bordered" id="OrderDetailsForm">

		<input type="hidden" id="id" name="id" value="<?php echo $order["id"]; ?>" />

            <table class="print-table" style="margin-top: 50px;">

				<tr>

					<td class="noborder" style="width: 12%;"></td>

					<td class="noborder" style="width: 11%;"></td>

					<td class="noborder" style="width: 11%;"></td>

					<td class="noborder" style="width: 11%;"></td>

					<td class="noborder" style="width: 11%;"></td>

					<td class="noborder" style="width: 11%;"></td>

					<td class="noborder" style="width: 11%;"></td>

					<td class="noborder"></td>

				</tr>

				<tr>

					<td colspan="4" class="noborder">

						<table>

							<tr>

								<td style="width: 25%;">Tel.:</td>

								<td class="tc"><input type="text" class="form-control" required="true" name="client_phone" id="client_phone" alt="" value="<?php echo htmlentities($order["client_phone"]); ?>" /></td>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('Tel')?>:</td>

							</tr>

						</table>

					</td>

					<td colspan="4" class="noborder">

						<table>

							<tr>

								<td style="width: 25%;">Name:</td>

								<td class="tc"><input type="text" class="form-control" name="client_name" id="client_name" alt="" value="<?php echo htmlentities($order["client_name"]); ?>" /></td>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('Name')?>:</td>

							</tr>

						</table>

					</td>

				</tr>

				<tr>

					<th colspan="4" class="noborder" style="text-align: right;"><span style="float: left; color: red; font-size: 2em; line-height: 12px;"><?php echo htmlentities($order["bill_number"]); ?></span>Right Eye OD <?php echo getArabic('Right Eye OD')?></th>

					<th colspan="3" class="noborder">Left Eye OS <?php echo getArabic('Left Eye OS')?></th>

					<td>

						<table>

							<tr>

								<td style="width: 25%;">Date & Time</td>

								<td class="tc"><?php echo htmlentities(formatDateTime($order["order_date"])); ?></td>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('Date')?></td>

							</tr>

						</table>

					</td>

				</tr>

				<tr>

					<td></td>

					<td class="tc">Sphere</td>

					<td class="tc">Cylinder</td>

					<td class="tc">Axis</td>

					<td class="tc">Sphere</td>

					<td class="tc">Cylinder</td>

					<td class="tc">Axis</td>

					<td>

						<table>

							<tr>

								<td style="width: 25%;">Total Amount Before VAT</td>

								<td><input type="text" class="form-control" required="true" name="price_full" id="price_full" alt="" value="<?php echo htmlentities($order["price_full"]); ?>" onchange="CalculateBalanceFromTotal()" /></td>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('Total Amount Before VAT'); ?></td>

							</tr>

						</table>

					</td>

				</tr>

				<tr>

					<td>Distance</td>

					<td><input type="text" class="form-control" name="er_d_sphere" id="er_d_sphere" alt="" value="<?php echo htmlentities($order["er_d_sphere"]); ?>" /></td>

					<td><input type="text" class="form-control" name="er_d_cylinder" id="er_d_cylinder" alt="" value="<?php echo htmlentities($order["er_d_cylinder"]); ?>" /></td>

					<td><input type="text" class="form-control" name="er_d_axis" id="er_d_axis" alt="" value="<?php echo htmlentities($order["er_d_axis"]); ?>" /></td>

					<td><input type="text" class="form-control" name="el_d_sphere" id="el_d_sphere" alt="" value="<?php echo htmlentities($order["el_d_sphere"]); ?>" /></td>

					<td><input type="text" class="form-control" name="el_d_cylinder" id="el_d_cylinder" alt="" value="<?php echo htmlentities($order["el_d_cylinder"]); ?>" /></td>

					<td><input type="text" class="form-control" name="el_d_axis" id="el_d_axis" alt="" value="<?php echo htmlentities($order["el_d_axis"]); ?>" /></td>

					<td>

						<table>

							<tr>

								<td style="width: 25%;">Total Amount After VAT</td>

								<td><input type="text" class="form-control" required="true" name="vat" id="vat" alt="" value="<?php if($order["price_full_vat"] != ''){ echo htmlentities($order["price_full"]+($order["price_full"] * ($vat_fetch["vat"]/100))); } ?>" onchange="CalculateBalanceFromDiscount()" /></td>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('Total Amount After VAT'); ?></td>

							</tr>

						</table>

					</td>

				</tr>

				<tr>

					<td>Reading</td>

					<td><input type="text" class="form-control" name="er_r_sphere" id="er_r_sphere" alt="" value="<?php echo htmlentities($order["er_r_sphere"]); ?>" /></td>

					<td><input type="text" class="form-control" name="er_r_cylinder" id="er_r_cylinder" alt="" value="<?php echo htmlentities($order["er_r_cylinder"]); ?>" /></td>

					<td><input type="text" class="form-control" name="er_r_axis" id="er_r_axis" alt="" value="<?php echo htmlentities($order["er_r_axis"]); ?>" /></td>

					<td><input type="text" class="form-control" name="el_r_sphere" id="el_r_sphere" alt="" value="<?php echo htmlentities($order["el_r_sphere"]); ?>" /></td>

					<td><input type="text" class="form-control" name="el_r_cylinder" id="el_r_cylinder" alt="" value="<?php echo htmlentities($order["el_r_cylinder"]); ?>" /></td>

					<td><input type="text" class="form-control" name="el_r_axis" id="el_r_axis" alt="" value="<?php echo htmlentities($order["el_r_axis"]); ?>" /></td>

					<td>

						<table>

							<tr>

								<td style="width: 25%;">VAT (%)</td>

								<td><input type="text" class="form-control" alt="" value="<?php echo htmlentities($vat_fetch["vat"]); ?>" disabled/></td>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('VAT')?></td>

							</tr>

						</table>

					</td>

					

				</tr>

				<tr>

					<td>Add</td>

					<td colspan="3"><input type="text" class="form-control" name="er_add" id="er_add" alt="" value="<?php echo htmlentities($order["er_add"]); ?>" /></td>

					<td colspan="3"><input type="text" class="form-control" name="el_add" id="el_add" alt="" value="<?php echo htmlentities($order["el_add"]); ?>" /></td>
					<td>

						<table>

							<tr>

								<td style="width: 25%;">ToTal VAT</td>

								<td>
									<input type="text" class="form-control" alt="" value="<?php
									if($order["price_full_vat"] != ''){
									echo htmlentities($order["price_full"] * ($vat_fetch["vat"]/100));
								}  ?>" disabled/></td>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('VAT')?></td>

							</tr>

						</table>

					</td>


				</tr>

				<tr>

					<td colspan="3" class="noborder"></td>

					<td colspan="2">

						<table>

							<tr>

								<td style="width: 35%;">I.P.D:</td>

								<td><input type="text" class="form-control" name="ipd" id="ipd" alt="" value="<?php echo htmlentities($order["ipd"]); ?>" /></td>

							</tr>

						</table>

					</td>

					<td colspan="2" class="noborder"></td>
					<td>

						<table>

							<tr>

								<td style="width: 25%;">Discount (%)</td>

								<td><input type="text" class="form-control" required="true" name="price_discount" id="price_discount" alt="" value="<?php echo htmlentities($order["price_discount"]); ?>" onchange="CalculateBalanceFromDiscount()" /></td>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('Discount')?></td>

							</tr>

						</table>

					</td>
					<tr>

						<td colspan="7" style="border: none;"></td>
						<td>

							<table>

								<tr>

									<td style="width: 25%;">Discounted price</td>

									<td><input type="text" class="form-control" required="true" name="price_total" id="price_total" alt="" value="<?php echo htmlentities($order["price_total"]); ?>" onchange="CalculateBalanceFromFinal()" /></td>

									<td class="rtl" style="width: 25%;"><?php echo getArabic('Discounted price')?></td>

								</tr>

							</table>

						</td>

					</tr>

					<tr>

					<td colspan="7" style="border: none;"></td>

					<td>

						<table>

							<tr>

								<td style="width: 25%;">Paid</td>

								<td><input type="text" class="form-control" required="true" name="price_paid" id="price_paid" alt="" value="<?php echo htmlentities($order["price_paid"]); ?>" onchange="CalculateBalance()" /></td>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('Paid')?></td>

							</tr>

						</table>

					</td>

					</tr>
					<tr>
						<td colspan="7" style="border: none;"></td>
						<td>

							<table>

								<tr>

									<td style="width: 25%;">Balance</td>

									<td class="tc"><span id="Balance"><?php echo $order["price_total"]-$order["price_paid"]; ?></span></td>

									<td class="rtl" style="width: 25%;"><?php echo getArabic('Balance')?></td>

								</tr>

							</table>

						</td>
					</tr>

				</tr>

				<tr>

					<td colspan="3" class="noborder">&nbsp;</td>

				</tr>

				<tr>

					<td>Contact Lens</td>

					<td><input type="text" class="form-control" name="er_cl_sphere" id="er_cl_sphere" alt="" value="<?php echo htmlentities($order["er_cl_sphere"]); ?>" /></td>

					<td><input type="text" class="form-control" name="er_cl_cylinder" id="er_cl_cylinder" alt="" value="<?php echo htmlentities($order["er_cl_cylinder"]); ?>" /></td>

					<td><input type="text" class="form-control" name="er_cl_axis" id="er_cl_axis" alt="" value="<?php echo htmlentities($order["er_cl_axis"]); ?>" /></td>

					<td><input type="text" class="form-control" name="el_cl_sphere" id="el_cl_sphere" alt="" value="<?php echo htmlentities($order["el_cl_sphere"]); ?>" /></td>

					<td><input type="text" class="form-control" name="el_cl_cylinder" id="el_cl_cylinder" alt="" value="<?php echo htmlentities($order["el_cl_cylinder"]); ?>" /></td>

					<td><input type="text" class="form-control" name="el_cl_axis" id="el_cl_axis" alt="" value="<?php echo htmlentities($order["el_cl_axis"]); ?>" /></td>

					

				<tr>

					<td colspan="3">

						<table>

							<tr>

								<td style="width: 25%;">Frame</td>

								<?php if($order['isOld'] == 1){ ?>

								<td><input type="text" class="form-control" name="frame" id="frame" alt="" value="<?php echo htmlentities($order["frame"]); ?>" /></td>

								<?php } else{ ?>

								<td id="frameTD">

									

									<?php 

									$frames = $order_items;

									$i=0;

									$frameCount = 1;

									if(!empty($frames))

									{

									foreach($frames as $frame)

									{

									?>

									<div class="frameBox" id="fbox-<?php echo $frameCount; ?>" data-fid="<?php echo $frameCount; ?>">

										<select name="frame[]" data-frame="<?php echo $frameCount; ?>" class="form-control frame frameSelect2">

											<?php 

											$productQuery = mysql_query('SELECT * FROM products');

											if(mysql_num_rows($productQuery) > 0) {

												while ($product_fetch = mysql_fetch_assoc($productQuery))

												{

													

												?>

												<option value="<?php echo $product_fetch['id']; ?>" data-price="<?php echo $product_fetch['product_price']; ?>" <?php if($product_fetch['id'] == $frame['frame_id']){ echo 'selected="selected"'; } else{ echo 'disabled="disabled"'; } ?>><?php echo $product_fetch['product_name']; ?></option>

												<?php 

												}

											}

											else

											{

												echo '<option value="">Select</option>';

											}

											?>

										</select>

										

											<div><a href="javascript:void(0);" class="remove-fl" data-fl="<?php echo $frameCount; ?>" onclick="removePreFrameLens('<?php echo $frameCount; ?>')">Remove</a></div>

										

									</div>

									<?php

									$i++;

									$frameCount++; 

									}

									} else { ?>

										<div class="frameBox" id="fbox-<?php echo $frameCount; ?>" data-fid="<?php echo $frameCount; ?>">

											<select name="frame[]" class="form-control frame frameSelect2" id="frame-1" data-frame="1">

												<option value="">Select</option>

											<?php 

											$productQuery = mysql_query('SELECT * FROM products WHERE product_qty != 0');

											if(mysql_num_rows($productQuery) > 0) {

												while ($product_fetch = mysql_fetch_assoc($productQuery))

												{

													

												?>

												<option value="<?php echo $product_fetch['id']; ?>" data-price="<?php echo $product_fetch['product_price']; ?>"><?php echo $product_fetch['product_name']; ?></option>

												<?php 

												}

											}

											?>	

											</select>

											<div><a href="javascript:void(0);" class="remove-fl" data-fid="1" onclick="removeFrameLens(1);">Remove</a></div>

										</div>

									<?php }

									?>	

									<a href="javascript:void(0);" id="addnew" onclick="addNew();">Add More</a>

								</td>

								<?php } ?>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('Frame')?></td>

								<td class="rtl"></td>

							</tr>

						</table>

						<table>

							<tr>

								<td style="width: 25%;">Note</td>

								<td><input type="text" class="form-control" name="note" id="note" alt="" value="<?php echo htmlentities($order["note"]); ?>" /></td>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('note')?></td>

							</tr>

						</table>



					</td>

					<td colspan="3">

						<table>

							<tr>

								<td style="width: 25%;">Lenses</td>

								<?php if($order['isOld'] == 1){ ?>

								<td><input type="text" class="form-control" name="lenses" id="lenses" alt="" value="<?php echo htmlentities($order["lenses"]); ?>" /></td>

								<?php } else{ ?>

								<td id="lenseTD">

									

									<?php

									$orderLenses = $order_items;

									$i=0;

									$lcount = 1;

									if(!empty($orderLenses))

									{

									foreach($orderLenses as $orderLens)

									{



									?>

									<div class="lenseBox"  data-lid="<?php echo $lcount; ?>" id="lbox-<?php echo $lcount; ?>">

										<select name="lenses[]" data-lens="<?php echo $i+1; ?>" class="form-control lenses lenseSelect2">

										<?php 

										

										$lensesQuery = mysql_query("SELECT lenses.* FROM lens_relation INNER JOIN lenses ON lens_relation.lens_id = lenses.id WHERE lens_relation.product_id = '".$orderLens['frame_id']."' ");

										if(mysql_num_rows($lensesQuery)>0)

										{

											while($lens = mysql_fetch_assoc($lensesQuery))

											{

												if($orderLens['lense_id'] != 0)

												{

											?>

												<option value="<?php echo $lens['id']; ?>" data-price="<?php echo $lens['lens_price']; ?>" <?php if($orderLens['lense_id'] == $lens['id']) { echo 'selected="selected"';} else{ echo 'disabled="disabled"'; } ?>><?php echo $lens['lens_name']; ?></option>	 

											<?php

												}

												else

												{

													echo '<option value="0">Select</option>';

												}	

											} 

										}

										else

										{

											echo '<option value="">Select</option>';

										}

										?>

										</select>

									</div>

									<?php

									$lcount++;

									$i++; 

									}

									} else {

									?>

									<div class="lenseBox" data-lid="<?php echo $lcount; ?>" id="lbox-<?php echo $lcount; ?>">

										<select name="lenses[]" class="form-control lenses lenseSelect2" data-lens="<?php echo $i+1; ?>" id="lense-1">

											<option value="">Select Lens</option>

										</select>

									</div>

									<?php

									}

									?>

								</td>

								<?php } ?>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('Lenses')?></td>

								

							</tr>

						</table>

					</td>

				</tr>

            </table>

		<div class="form-group form-actions">

			<?php if($order['isOld'] == 1){ ?>

			<div class="col-md-9 col-md-offset-3">

				<a href="#" onclick="loadPage('home.php'); return false;" data-toggle="tooltip" data-html="true" title="Back <?php echo getArabic('Back')?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back <?php echo getArabic('Back')?></a>

				<a href="order_print_full_old.php?id=<?php echo htmlentities($order["id"]); ?>" onclick="printUrl('order_print_full_old.php?id=<?php echo $order["id"]; ?>'); return false;" target="_blank" data-toggle="tooltip" data-html="true" title="Print1(Full Table) <?php echo getArabic('Print1(Full Table)')?>" class="btn btn-info"><i class="fa fa-print"></i> LAB <?php echo getArabic('Print1(Full Table)')?></a>

				<a href="order_print_price_old.php?id=<?php echo htmlentities($order["id"]); ?>" onclick="printUrl('order_print_price_old.php?id=<?php echo $order["id"]; ?>'); return false;" target="_blank" data-toggle="tooltip" data-html="true" title="Print2(Price Table) <?php echo getArabic('Print2(Price Table)')?>" class="btn btn-info"><i class="fa fa-print"></i> Client <?php echo getArabic('Print2(Price Table)')?></a>

			</div>

			<?php } else{ ?>

			<div class="col-md-9 col-md-offset-3">

				<input class="btn btn-sm btn-primary" type="submit"  value="<?php if(empty($order["id"])) {?>Save <?php echo getArabic('Save')?><?php } else { ?>Update <?php echo getArabic('Update')?><?php } ?>" />

				<a href="#" onclick="loadPage('home.php'); return false;" data-toggle="tooltip" data-html="true" title="Back <?php echo getArabic('Back')?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back <?php echo getArabic('Back')?></a>

				<a href="order_print_full.php?id=<?php echo htmlentities($order["id"]); ?>" onclick="printUrl('order_print_full.php?id=<?php echo $order["id"]; ?>'); return false;" target="_blank" data-toggle="tooltip" data-html="true" title="Print1(Full Table) <?php echo getArabic('Print1(Full Table)')?>" class="btn btn-info"><i class="fa fa-print"></i> LAB <?php echo getArabic('Print1(Full Table)')?></a>

				<a href="order_print_price.php?id=<?php echo htmlentities($order["id"]); ?>" onclick="printUrl('order_print_price.php?id=<?php echo $order["id"]; ?>'); return false;" target="_blank" data-toggle="tooltip" data-html="true" title="Print2(Price Table) <?php echo getArabic('Print2(Price Table)')?>" class="btn btn-info"><i class="fa fa-print"></i> Client <?php echo getArabic('Print2(Price Table)')?></a>

			</div>

			<?php } ?>

		</div>

		<input type="hidden" value="<?php echo $frameCount; ?>" id="framecount"> 

		<input type="hidden" value="<?php echo $per_vat; ?>" id="vatprice">

	</form>

</div>

<div id="framediv" style="display:none;">

	<div class="frameBox">

		<select name="frame[]" class="form-control frame" id="">

			<option value="">Select</option>

		<?php 

		$productQuery = mysql_query('SELECT * FROM products WHERE product_qty != 0');

		if(mysql_num_rows($productQuery) > 0) {

			while ($product_fetch = mysql_fetch_assoc($productQuery))

			{

				

			?>

			<option value="<?php echo $product_fetch['id']; ?>" data-price="<?php echo $product_fetch['product_price']; ?>"><?php echo $product_fetch['product_name']; ?></option>

			<?php 

			}

		}

		?>	

		</select>

		<div><a href="javascript:void(0);" class="remove-fl">Remove</a></div>

	</div>

</div>



<div id="lensDiv" style="display:none;">

	<div class="lenseBox">

		<select name="lenses[]" class="form-control lenses" id="">

			<option value="">Select Lens</option>

		</select>

	</div>

</div>

<script src="js/select2.min.js"></script>

<script>

$(document).ready(function() {

    $('.frameSelect2').select2();

    $('.lenseSelect2').select2();

});

$(function () {

		setOrderDetailsForm(<?php echo $_GET["id"];?>);

	});

	function CalculateBalanceFromFinal() {

		var price = parseFloat($("#price_total").val());

		var price_full = parseFloat($("#price_full").val());

		if(isNaN(price_full)){

			$("#price_discount").val("");

			$("#price_full").val($("#price_total").val());

			return;

		}

		if(isNaN(price) || isNaN(price_full)){

			$("#price_discount").val("");

			CalculateBalance();

			return;

		}

		var price_discount = parseInt(price*100/price_full);

		$("#price_discount").val((100-price_discount));

		CalculateBalance();

	}

	function CalculateBalanceFromTotal() {

		var price = parseFloat($("#price_total").val());

		var price_full = parseFloat($("#price_full").val());

		if(isNaN(price)){

			$("#price_discount").val("");

			$("#price_total").val($("#price_full").val());

			CalculateBalance();

			return;

		}

		if(price_full == 0){

			$("#price_discount").val($("#price_full").val());

			$("#price_total").val($("#price_full").val());

			$('#vat').val($("#price_full").val());

			$('#price_paid').val($("#price_full").val());

			$('#Balance').html($("#price_full").val());

			CalculateBalance();

			return;

		}

		if(isNaN(price) || isNaN(price_full)){

			$("#price_discount").val("");

			CalculateBalance();

			return;

		}

		var price_discount = parseInt(price*100/price_full);

		$("#price_discount").val((100-price_discount));

		CalculateBalance();

	}

	function CalculateBalanceFromDiscount() {

		var price_full = parseFloat($("#vat").val());

		var price_discount = parseFloat($("#price_discount").val());

		if(isNaN(price_discount) || isNaN(price_full)){

			$("#price_total").val($("#vat").val().toFixed(2));

			CalculateBalance();

			return;

		}

		var price = price_full*(100-price_discount)/100;

		$("#price_total").val(price.toFixed(2));

		CalculateBalance();

	}

	function CalculateBalance(){

		var price_total = parseFloat($("#price_total").val());

		var price_paid = parseFloat($("#price_paid").val());

		if(isNaN(price_total) || isNaN(price_paid)){

			$("#Balance").html("");

			return;

		}

		var Balance = price_total - price_paid;

		$("#Balance").html(Balance);

	}







</script>

<script src="js/app.js"></script>