<?php require_once 'inc/config.php'; ?>
<?php 
	if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
		doRedirect("login.php");
	}
if(isset($_POST["client_name"]) && isset($_POST["client_phone"])){
	db_query("SET time_zone = '+03:00'");
	$res = db_query("
		INSERT INTO `order` (bill_number, bill_year, client_name, client_phone, order_date, isOld) 
		SELECT IFNULL(MAX(bill_number),0)+1, YEAR(CURDATE()), '".mysql_real_escape_string($_POST["client_name"])."', '".mysql_real_escape_string($_POST["client_phone"])."', NOW(), 0
		FROM `order` WHERE bill_year = YEAR(CURDATE())
	");
	$id = db_last_insert_id();
	doRedirect("order_details.php?id=".$id);
}
	$pageTitle = "New Order / ".getArabic('New Order');
?>

<?php require_once 'inc/page_menu.php'; ?>
<div class="content-header">
	<div class="header-section">
		<h1><?php echo $pageTitle; ?></h1>
		<?php if(!empty($alertMsg)) { ?><div class="alert alert-<?php echo $alertType; ?>"><?php echo $alertMsg; ?></div><?php } ?>
	</div>
</div>
<!-- END Static Layout Header -->

<!-- Dummy Content -->
<div class="block full block-alt-noborder">
	<form  method="post" class="form-horizontal form-bordered" id="OrderNewForm">
		<div class="form-group">
			<label class="col-md-3 control-label">Name <?php echo getArabic('Name')?></label>
			<div class="col-md-9">
				<input type="text" class="form-control" required="true" name="client_name" id="client_name" alt="" value="" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Tel <?php echo getArabic('Tel')?></label>
			<div class="col-md-9">
				<input type="text" class="form-control" required="true" name="client_phone" id="client_phone" alt="" value="" />
			</div>
		</div>
		<div class="form-group form-actions">
			<div class="col-md-9 col-md-offset-3">
				<input class="btn btn-sm btn-primary" type="submit"  value="Save <?php echo getArabic('Save')?>" />
				<a href="#" onclick="loadPage('home.php'); return false;" data-toggle="tooltip" data-html="true" title="Back <?php echo getArabic('Back')?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back <?php echo getArabic('Back')?></a>
			</div>
		</div>
	</form>
</div>
<script>
	$(function () {
		setOrderNewForm();
	});
</script>
<script src="js/app.js"></script>