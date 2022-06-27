<?php require_once 'inc/config.php'; $template['header']=''; ?>
<?php 
	
	$product_select = "SELECT * FROM products ORDER BY id DESC";
	$product_select_query = mysql_query($product_select);
?>
<?php require_once 'inc/page_menu.php'; ?>
<div class="content-header">
	<div class="header-section">
		<h1>Products / منتجات</h1>
	</div>
</div>
<div class="navbar navbar-default" style="margin: -20px -20px 20px;">
	<ul class="nav navbar-nav-custom">
		<li>
			<a href="#" onclick="loadPage('product_new.php'); return false;">
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
					<th>Product Name<br/>اسم المنتج</th>
					<th>Product Arabic<br/>المنتج العربي</th>
					<th>Product Price<br/>سعر المنتج</th>
					<th>Product Quantity<br/>كمية المنتج</th>
					<th>Lense Name<br/>اسم لينس</th>
					<th style="width: 150px;" class="text-center">Actions<br/><?php echo getArabic('Actions')?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(mysql_num_rows($product_select_query) > 0) {
					$i =1;
						while ($product_fetch = mysql_fetch_assoc($product_select_query)) {
					?>
				<tr id="frameid-<?php echo $product_fetch['id']; ?>">
					<td valign="top"><?php echo $i; ?></td>
					<td valign="top"><?php echo $product_fetch['product_name']; ?></td>
					<td valign="top"><?php echo $product_fetch['product_arabic']; ?></td>
					<td valign="top"><?php echo $product_fetch['product_price']; ?></td>
					<td valign="top"><?php echo $product_fetch['product_qty']; ?></td>
					<td valign="top">
					<?php 
						$lenses_query = mysql_query("SELECT lens_name FROM lenses INNER JOIN lens_relation ON lenses.id = lens_relation.lens_id WHERE lens_relation.product_id = '".$product_fetch['id']."' "); 
						$lensArray = array();
						while( $lenses = mysql_fetch_assoc($lenses_query))
						{
							array_push($lensArray, $lenses['lens_name']);
						}
						echo implode(', ', $lensArray);
					?>
					</td>
					<td valign="top" align="center" class="text-center">
						<div class="btn-group btn-group-xs">
							<a href="#" onclick="loadPage('product_edit.php?id=<?php echo $product_fetch['id']; ?>'); return false;" data-toggle="tooltip" data-html="true" title="Edit<br/><?php echo getArabic('Edit')?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
							<a href="#" onclick="removeFrame('<?php echo $product_fetch['id']; ?>'); return false;" data-toggle="tooltip" data-html="true" title="delete<br/><?php echo getArabic('Edit')?>" class="btn btn-default"><i class="fa fa-times"></i></a>
							
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
	function removeFrame(id)
	{
		var r = confirm('Are you sure to delete this product?');
		if(r === true)
		{
			$.ajax({
				method: 'POST',
				dataType: 'json',
				url: 'product_delete.php',
				data: {id: id},
				success: function(result)
				{
					if(result.err == 1 && result.msg == 'error')
					{
						$('.block-alt-noborder').prepend('<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Warning!</strong> Something went wrong. Please try again.</div>');
					}
					else if(result.err == 0 && result.msg == 'removed')
					{
						$('.block-alt-noborder').prepend('<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Product deleted successfully.</div>');
						$('#frameid-'+id).remove();
					}
				}
			});
		}
	}
	
</script>
<script src="js/app.js"></script>
