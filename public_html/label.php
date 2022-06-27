<?php require_once 'inc/config.php'; $template['header']=''; ?>
<?php 
	
	if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
		doRedirect("login.php");
	}
	if(isset($_POST["new_eng"]) && isset($_POST["new_arabic"])){
		$res = db_query("
			INSERT INTO `label` (`eng`, `arabic`) 
			VALUES ('".mysql_real_escape_string($_POST["new_eng"])."', '".mysql_real_escape_string($_POST["new_arabic"])."')
		");
	}
	if (isset($_POST['label_id']) && is_array($_POST['label_id'])) {
		$array = $_POST["label_id"];
		foreach($array as $value){
			db_query("
				UPDATE 
					`label`
				SET 
					`arabic` = '".mysql_real_escape_string($_POST["arabic_".$value])."'
				WHERE `id` = '{$value}'
				");
		}
	}
	
	$res = db_query("
		SELECT SQL_CALC_FOUND_ROWS *
		FROM `label`
		WHERE 1=1
		ORDER BY `eng`
	");
	$labels = db_fetch_array($res);
	$res = db_query("SELECT FOUND_ROWS()");
	$recCount = db_fetch_one($res);

?>
<?php require_once 'inc/page_menu.php'; ?>
<div class="content-header">
	<div class="header-section">
		<h1>Labels</h1>
		<?php if(!empty($alertMsg)) { ?><div class="alert alert-<?php echo $alertType; ?>"><?php echo $alertMsg; ?></div><?php } ?>
	</div>
</div>
<div class="block full block-alt-noborder" style="display: none;">
	<form  method="post" class="form-horizontal form-bordered" id="LabelNewForm">
		<div class="form-group">
			<label class="col-md-3 control-label">Eng</label>
			<div class="col-md-9">
				<input type="text" class="form-control" required="true" name="new_eng" id="new_eng" alt="" value="" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">Arabic</label>
			<div class="col-md-9">
				<input type="text" class="form-control" required="true" name="new_arabic" id="new_arabic" alt="" value="" />
			</div>
		</div>
		<div class="form-group form-actions">
			<div class="col-md-9 col-md-offset-3">
				<input class="btn btn-sm btn-primary" type="submit"  value="Save" />
			</div>
		</div>
	</form>
</div>
<div class="block full block-alt-noblabel">
	<form id="LabelForm" method="post">
		<div class="form-group form-actions">
			<div class="col-md-9 col-md-offset-3">
				<input class="btn btn-sm btn-primary" type="submit"  value="Save" />
			</div>
		</div>
	<div class="clearfix"></div>
	<div class="table-responsive">
		<table id="general-table" class="table table-striped table-vcenter">
			<thead>
				<tr>
					<th>English</th>
					<th>Arabic</th>
				</tr>
			</thead>
			<tbody>
				<?php $idx = 0; if(is_array($labels)) foreach ($labels as $label) { $idx++; ?>
				<tr<?php if($idx % 2 == 0) { ?> style="background-color:#f0f0f0;"<?php } ?>>
					<td valign="top"><?php echo $label["eng"]; ?><input type="hidden" value="<?php echo $label["id"]; ?>" id="eng_<?php echo $label["id"]; ?>" name="label_id[]" /></td>
					<td valign="top"><input type="text" value="<?php echo ($label["arabic"]); ?>" id="arabic_<?php echo $label["id"]; ?>" name="arabic_<?php echo $label["id"]; ?>" class="form-control" style="direction: rtl; width:300px;" /></td>
				</tr>
				<?php } ?>
			</tbody>
			<?php if(count($labels) == 0) { ?>
			<tfoot>
				<tr>
					<td colspan="6">
						Currently there are no labels.
					</td>
				</tr>
			</tfoot>
			<?php } ?>
		</table>
	</div>
	</form>
	<!-- END Table Styles Content -->
	
</div>

<script>
	$(function () {
		setLabelForm();
		setLabelNewForm();
	});
</script>