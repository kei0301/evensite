<?php require_once 'inc/config.php'; ?>
<?php 
	if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
		doRedirect("login.php");
	}
	$pageTitle = "Order details / ".getArabic('Order details');
	$order  = array();
	if(isset($_GET["id"])){
		$res = db_query("SELECT * FROM `order` WHERE id={$_GET["id"]}");
		$order = db_fetch_row($res);
	}
	if(!isset($order["id"])){
		doRedirect("home.php");
	}

	/*get vat*/
	$vat_select = "SELECT * FROM vat";
	$result = mysql_query($vat_select);
	$vat_fetch = mysql_fetch_assoc($result);
	$per_vat = $vat_fetch["vat"];
?>
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
								<td style="width: 25%;">Date</td>
								<td class="tc"><?php echo htmlentities(formatDate($order["order_date"])); ?></td>
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
								<td class="rtl" style="width: 25%;"><?php echo getArabic('Total Amount')?></td>
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
								<td><input type="text" class="form-control" required="true" name="vat" id="vat" alt="" value="<?php if($order["price_full_vat"] != ''){ echo htmlentities($order["price_full_vat"]); }else{ echo htmlentities($order["price_full"] + ($order["price_full"] * ($vat_fetch["vat"]/100))); } ?>" onchange="CalculateBalanceFromDiscount()" /></td>
								<td class="rtl" style="width: 25%;"><?php echo getArabic('Discount')?></td>
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
								<td style="width: 25%;">Discount (%)</td>
								<td><input type="text" class="form-control" required="true" name="price_discount" id="price_discount" alt="" value="<?php echo htmlentities($order["price_discount"]); ?>" onchange="CalculateBalanceFromDiscount()" /></td>
								<td class="rtl" style="width: 25%;"><?php echo getArabic('Discount')?></td>
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
								<td style="width: 25%;">Discounted price</td>
								<td><input type="text" class="form-control" required="true" name="price_total" id="price_total" alt="" value="<?php echo htmlentities($order["price_total"]); ?>" onchange="CalculateBalanceFromFinal()" /></td>
								<td class="rtl" style="width: 25%;"><?php echo getArabic('Discounted price')?></td>
							</tr>
						</table>
					</td>
					<tr>
						<td colspan="7" style="border: none;"></td>
						<td>
						<table>
							<tr>
								<td style="width: 25%;">Paid</td>
								<td><input type="text" class="form-control" required="true" name="price_paid" id="price_paid" alt="" value="<?php echo htmlentities($order["price_paid"] + ($order["price_paid"] * ($vat_fetch["vat"]/100))); ?>" onchange="CalculateBalance()" /></td>
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
								<td>
									<div id="framediv" data-frameclass="frame-1" style="display:none;">

										<select name="frame[]" class="frameGet form-control" disabled="disabled">
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
									</div>
									<?php 
									$frames = unserialize($order["frame"]);
									$frameCount = 1;
									if(!empty($frames))
									{
									foreach($frames as $frame)
									{
									?>
									<select name="frame[]" data-frame="<?php echo $frameCount; ?>" class="form-control frame">
										<?php 
										$productQuery = mysql_query('SELECT * FROM products WHERE product_qty != 0');
										if(mysql_num_rows($productQuery) > 0) {
											while ($product_fetch = mysql_fetch_assoc($productQuery))
											{
												
											?>
											<option value="<?php echo $product_fetch['id']; ?>" data-price="<?php echo $product_fetch['product_price']; ?>" <?php if($product_fetch['id'] == $frame){ echo 'selected="selected"'; } else{ echo 'disabled="disabled"'; } ?>><?php echo $product_fetch['product_name']; ?></option>
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
									<?php
									$frameCount++; 
									}
									}
									?>	 
									<input type="hidden" value="<?php echo $per_vat; ?>" id="vatprice">
									<div class="appendFrame"></div>
									<a href="javascript:void(0);" onclick="addNew();">Add More</a>
								</td>

								<td class="rtl" style="width: 25%;"><?php echo getArabic('Frame')?></td>
								<td class="rtl"></td>
							</tr>
						</table>
						<table>
							<tr>
								<td style="width: 25%;">Note</td>
								<td><input type="text" class="form-control" name="note" id="note" alt="" value="<?php echo htmlentities($order["note"]); ?>" /></td>
								<td class="rtl" style="width: 25%;"><?php echo getArabic('Note')?></td>
							</tr>
						</table>

					</td>
					<td colspan="3">
						<table>
							<tr>
								<td style="width: 25%;">Lenses</td>
								<td>
									<div id="lensdiv" data-lens="2" data-lensclass="lens-1" style="display:none;">
										<select name="lenses[]" class="form-control lens-1" disabled="disabled">
											<option value="">Select Lens</option>
										</select>
									</div>
									<?php
									$orderLenses = unserialize($order["lenses"]);
									$i=0;
									if(!empty($orderLenses))
									{
									foreach($orderLenses as $orderLens)
									{

									?>
									<select name="lenses[]" data-lens="<?php echo $i+1; ?>" class="form-control lenses">
									<?php 
									$lensesQuery = mysql_query("SELECT lenses.* FROM lens_relation INNER JOIN lenses ON lens_relation.lens_id = lenses.id WHERE lens_relation.product_id = '".$frames[$i]."' ");
									if(mysql_num_rows($lensesQuery)>0)
									{
										while($lens = mysql_fetch_assoc($lensesQuery))
										{
										?>
											<option value="<?php echo $lens['id']; ?>" data-price="<?php echo $lens['lens_price']; ?>" <?php if($orderLens == $lens['id']) { echo 'selected="selected"';} else{ echo 'disabled="disabled"'; } ?>><?php echo $lens['lens_name']; ?></option>	 
										<?php
										} 
									}
									else
									{
										echo '<option value="">Select</option>';
									}
									?>
									</select>
									<?php
									$i++; 
									}
									}
									?>
									<div class="appendLens"></div>
								</td>
								<td class="rtl" style="width: 25%;"><?php echo getArabic('Lenses')?></td>
								
							</tr>
						</table>
					</td>
				</tr>
            </table>
            <select class="same">
            	<option value="1">1</option>
            	<option value="2">2</option>
            	<option value="3">3</option>
            </select>
            <select class="same">
            	<option value="1">1</option>
            	<option value="2">2</option>
            	<option value="3">3</option>
            </select>
            <select class="same">
            	<option value="1">1</option>
            	<option value="2">2</option>
            	<option value="3">3</option>
            </select>
		<div class="form-group form-actions">
			<div class="col-md-9 col-md-offset-3">
				<input class="btn btn-sm btn-primary" type="submit"  value="<?php if(empty($order["id"])) {?>Save <?php echo getArabic('Save')?><?php } else { ?>Update <?php echo getArabic('Update')?><?php } ?>" />
				<a href="#" onclick="loadPage('home.php'); return false;" data-toggle="tooltip" data-html="true" title="Back <?php echo getArabic('Back')?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back <?php echo getArabic('Back')?></a>
				<a href="order_print_full.php?id=<?php echo htmlentities($order["id"]); ?>" onclick="printUrl('order_print_full.php?id=<?php echo $order["id"]; ?>'); return false;" target="_blank" data-toggle="tooltip" data-html="true" title="Print1(Full Table) <?php echo getArabic('Print1(Full Table)')?>" class="btn btn-info"><i class="fa fa-print"></i> LAB <?php echo getArabic('Print1(Full Table)')?></a>
				<a href="order_print_price.php?id=<?php echo htmlentities($order["id"]); ?>" onclick="printUrl('order_print_price.php?id=<?php echo $order["id"]; ?>'); return false;" target="_blank" data-toggle="tooltip" data-html="true" title="Print2(Price Table) <?php echo getArabic('Print2(Price Table)')?>" class="btn btn-info"><i class="fa fa-print"></i> Client <?php echo getArabic('Print2(Price Table)')?></a>
			</div>
		</div>
	</form>