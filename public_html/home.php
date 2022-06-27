<?php require_once 'inc/config.php'; $template['header']=''; ?>
<?php 
	
	if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
		doRedirect("login.php");
	}
	if(isset($_POST["top-search"])){
		$_SESSION["top-search"] = $_POST["top-search"];
	}
	if(isset($_GET["action"]) && $_GET["action"] == "hide" && isset($_GET["id"])){
		$res = db_query("
			UPDATE `order` SET 
				`is_hidden` = 1
			WHERE id = {$_GET["id"]}
		");
		$res = db_query("SELECT * FROM `order` WHERE id={$_GET["id"]}");
	}
	if(!isset($_SESSION["top-search"])){
		$_SESSION["top-search"] = "";
	}
	
	$start_rec = 0;
	$page_size = 200;
	$res = db_query("
		SELECT SQL_CALC_FOUND_ROWS *
		FROM `order`
		WHERE is_hidden = 0
			".((empty($_SESSION["top-search"]))?"":" AND (
				client_name LIKE '%{$_SESSION["top-search"]}%'
				 OR client_phone LIKE '%{$_SESSION["top-search"]}%'
				 OR bill_number LIKE '%{$_SESSION["top-search"]}%'
				)")." 
		ORDER BY order_date desc, id desc
		LIMIT {$start_rec}, {$page_size}
	");
	$orders = db_fetch_array($res);
	$res = db_query("SELECT FOUND_ROWS()");
	$recCount = db_fetch_one($res);

?>
<?php require_once 'inc/page_menu.php'; ?>
<div class="content-header">
	<div class="header-section">
		<h1>Orders / <?php echo getArabic('Orders')?></h1>
		<?php if(!empty($alertMsg)) { ?><div class="alert alert-<?php echo $alertType; ?>"><?php echo $alertMsg; ?></div><?php } ?>
	</div>
</div>
<div class="navbar navbar-default" style="margin: -20px -20px 20px;">
	<ul class="nav navbar-nav-custom">
		<li>
			<a href="#" onclick="loadPage('order_new.php'); return false;">
				<i class="fa fa-plus"></i> Add new / <?php echo getArabic('Add new')?>
			</a>
		</li>
	</ul>
	<form id="SearchForm" method="post" class="navbar-form-custom" role="search" style="width: 500px;">
		<div class="form-group">
			<input type="text" id="top-search" name="top-search" class="form-control" placeholder="Search.. / <?php echo getArabic('Search')?>" value="<?php echo $_SESSION["top-search"]; ?>">
		</div>
	</form>
	<!-- END Right Header Navigation -->
</div>

<div class="block full block-alt-noborder">
	<div class="table-responsive">
		<table id="general-table" class="table table-striped table-vcenter">
			<thead>
				<tr>
					<th>Billing Number<br/><?php echo getArabic('Billing Number')?></th>
					<th>Date<br/><?php echo getArabic('Date')?></th>
					<th>Name<br/><?php echo getArabic('Name')?></th>
					<th>Phone Number<br/><?php echo getArabic('Phone Number')?></th>
					<th>Total Amount<br/><?php echo getArabic('Total Amount')?></th>
					<th>Discount<br/><?php echo getArabic('Discount')?></th>
					<th>Amount Discounted<br/><?php echo getArabic('Amount Discounted')?></th>
					<th>Paid<br/><?php echo getArabic('Paid')?></th>
					<th>Balance<br/><?php echo getArabic('Balance')?></th>
					<th style="width: 150px;" class="text-center">Actions<br/><?php echo getArabic('Actions')?></th>
				</tr>
			</thead>
			<tbody>
				<?php $idx = 0; if(is_array($orders)) foreach ($orders as $order) { $idx++; ?>
				<tr<?php if($idx % 2 == 0) { ?> style="background-color:#f0f0f0;"<?php } ?>>
					<td valign="top"><?php echo $order["bill_number"]; ?></td>
					<td valign="top"><?php echo formatDate($order["order_date"]); ?></td>
					<td valign="top"><?php echo $order["client_name"]; ?></td>
					<td valign="top"><?php echo $order["client_phone"]; ?></td>
					<td valign="top"><?php echo $order["price_full"]; ?></td>
					<td valign="top"><?php echo $order["price_discount"]; ?></td>
					<td valign="top"><?php echo $order["price_total"]; ?></td>
					<td valign="top" id="paidbalance-<?php echo $order['id']; ?>"><?php echo $order["price_paid"]; ?></td>
					<td valign="top" id="balance-<?php echo $order['id']; ?>"><?php echo $order["price_total"]-$order["price_paid"]; ?></td>
					<td valign="top" align="center" class="text-center">
						<div class="btn-group btn-group-xs">
							<a href="#" onclick="loadPage('order_details.php?id=<?php echo $order["id"]; ?>'); return false;" data-toggle="tooltip" data-html="true" title="Edit<br/><?php echo getArabic('Edit')?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
					<!-- 		<a href="#" onclick="loadPage('qrcode_print.php?id=<?php echo $order["id"]; ?>'); return false;" data-toggle="tooltip" data-html="true" title="QRCODE<br/><?php echo getArabic('QRCODE')?>" class="btn btn-default"><i class="fa fa-pencil"></i></a> -->
							<a href="order_print_full.php?id=<?php echo htmlentities($order["id"]); ?>" onclick="printUrl('order_print_full.php?id=<?php echo $order["id"]; ?>'); return false;" target="_blank" data-toggle="tooltip" data-html="true" title="Print1(Full Table)<br/><?php echo getArabic('Print1(Full Table)')?>" class="btn btn-info"><i class="fa fa-print"></i></a>
							<a href="order_print_price.php?id=<?php echo htmlentities($order["id"]); ?>" onclick="printUrl('order_print_price.php?id=<?php echo $order["id"]; ?>'); return false;" target="_blank" data-toggle="tooltip" data-html="true" title="Print2(Price Table)<br/><?php echo getArabic('Print2(Price Table)')?>" class="btn btn-info"><i class="fa fa-print"></i></a>
						<!-- 	<a href="#" onclick="if(confirm('Hide Bill? <?php echo getArabic('Hide Bill')?>?')){loadPage('home.php?action=hide&id=<?php echo $order["id"]; ?>');} return false;" data-toggle="tooltip" data-html="true" title="Hide Bill<br/><?php echo getArabic('Hide Bill')?>" class="btn btn-danger"><i class="fa fa-times"></i></a> -->
							<?php if(($order["price_total"]-$order["price_paid"]) != 0){ ?>
							<a id="paid-<?php echo $order["id"]; ?>" href="#" onclick="paidOrder('<?php echo $order["id"]; ?>', '<?php echo $order["price_total"]; ?>'); return false;" data-toggle="tooltip" data-html="true" title="Paid Order" class="btn btn-success" style="margin-left:0.28em;"><i class="fa fa-money"></i></a>
							<?php } ?>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
			<?php if(count($orders) == 0) { ?>
			<tfoot>
				<tr>
					<td colspan="6">
						Currently there are no orders.
					</td>
				</tr>
			</tfoot>
			<?php } ?>
		</table>
	</div>
	<!-- END Table Styles Content -->
	
</div>

<script>
	$(function () {
		setSearchForm();
	});
	function paidOrder(orderid, amount)
	{
		$.ajax({
			method: 'POST',
			dataType: 'json',
			url: 'paidorder.php',
			data: {orderid: orderid, amount: amount},
			success: function(result)
			{
				if(result == 1)
				{
					$('#paid-'+orderid).remove();
					$('#paidbalance-'+orderid).html(amount);
					$('#balance-'+orderid).html('0');
				}
				else
				{
					alert('Something went wrong. Please try again.');
				}
			}
		});
	}
</script>
<script src="js/app.js"></script>
