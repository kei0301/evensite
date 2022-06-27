<?php require_once 'inc/config.php'; $template['header']=''; ?>
<?php 
	
	$lense_select = "SELECT * FROM lenses ORDER BY id DESC";
	$lense_select_query = mysql_query($lense_select);
?>
<?php require_once 'inc/page_menu.php'; ?>
<div class="content-header">
	<div class="header-section">
		<h1>Lense / <?php echo getArabic('Orders'); ?></h1>
	</div>
</div>
<div class="navbar navbar-default" style="margin: -20px -20px 20px;">
	<ul class="nav navbar-nav-custom">
		<li>
			<a href="#" onclick="loadPage('lense_new.php'); return false;">
				<i class="fa fa-plus"></i> Add new / <?php echo getArabic('Add new')?>
			</a>
		</li>
	</ul>
	<!-- <form id="SearchForm" method="post" class="navbar-form-custom" role="search" style="width: 500px;">
		<div class="form-group">
			<input type="text" id="top-search" name="top-search" class="form-control" placeholder="Search.. / <?php echo getArabic('Search')?>" value="<?php echo $_SESSION["top-search"]; ?>">
		</div>
	</form> -->
	<!-- END Right Header Navigation -->
</div>

<div class="block full block-alt-noborder">
	<div class="table-responsive">
		<table id="general-table" class="table table-striped table-vcenter">
			<thead>
				<tr>
					<th>Serial Number<br/>رقم سري</th>
					<th>Lens Name<br/>اسم العدسة</th>
					<th>Lens Arabic<br/>لنس عربي</th>
					<th>Lens Price<br/>سعر العدسة</th>
					<th>Lens Quantity<br/>كمية العدسة</th>
					<th style="width: 150px;" class="text-center">Actions<br/><?php echo getArabic('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(mysql_num_rows($lense_select_query) > 0) {
						$i = 1;
						while ($lense_fetch = mysql_fetch_assoc($lense_select_query)) {
					?>
				<tr id="lenseid-<?php echo $lense_fetch['id']; ?>">
					<td valign="top"><?php echo $i; ?></td>
					<td valign="top"><?php echo $lense_fetch['lens_name']; ?></td>
					<td valign="top"><?php echo $lense_fetch['lens_arabic']; ?></td>
					<td valign="top"><?php echo $lense_fetch['lens_price']; ?></td>
					<td valign="top"><?php echo $lense_fetch['lens_quantity']; ?></td>
					<td valign="top" align="center" class="text-center">
						<div class="btn-group btn-group-xs">
							<a href="#" onclick="loadPage('lense_edit.php?id=<?php echo $lense_fetch['id']; ?>'); return false;" data-toggle="tooltip" data-html="true" title="Edit<br/><?php echo getArabic('Edit')?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
							<a href="#" onclick="removeLense('<?php echo $lense_fetch['id']; ?>'); return false;" data-toggle="tooltip" data-html="true" title="delete<br/><?php echo getArabic('Edit')?>" class="btn btn-default"><i class="fa fa-times"></i></a>
							
						</div>
					</td>
				</tr>
				<?php $i++; } }?>
			</tbody>
		</table>
	</div>
	<!-- END Table Styles Content -->
	
</div>

<script>
	$(function () {
		setSearchForm();
	});
	function removeLense(id)
	{
		var r = confirm('Are you sure to delete this lens?');
		if(r === true)
		{
			$.ajax({
				method: 'POST',
				dataType: 'json',
				url: 'lense_delete.php',
				data: {id: id},
				success: function(result)
				{
					if(result.err == 1 && result.msg == 'paired')
					{
						$('.block-alt-noborder').prepend('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Danger!</strong> This lens is already paired with frame.</div>');
					}
					else if(result.err == 1 && result.msg == 'error')
					{
						$('.block-alt-noborder').prepend('<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Warning!</strong> Something went wrong. Please try again.</div>');
					}
					else if(result.err == 0 && result.msg == 'removed')
					{
						$('.block-alt-noborder').prepend('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Lens deleted successfully.</div>');
						$('#lenseid-'+id).remove();
					}
				}
			});
		}
	}
</script>
<script src="js/app.js"></script>
