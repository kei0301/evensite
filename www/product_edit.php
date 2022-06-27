<?php 
require_once 'inc/config.php'; 
$template['header']=''; 
  
$product_id = $_GET['id'];

$product_select = "SELECT * FROM products WHERE id='".$product_id."'";
$product_query = mysql_query($product_select);
$product_fetch = mysql_fetch_assoc($product_query); 

$paired_lens_query = mysql_query("SELECT lens_id FROM lens_relation WHERE product_id = '".$product_id."' ");
$pairedLensArray = array();
while($pairedLens = mysql_fetch_assoc($paired_lens_query))
{
	array_push($pairedLensArray, $pairedLens['lens_id']);
}
require_once 'inc/page_menu.php'; 
?>
<link href="css/fSelect.css" rel="stylesheet">
<div class="content-header">
	<div class="header-section">
		<h1>Update Product</h1>
	</div>
</div>
<div class="block full block-alt-noblabel">
	<form id="LabelForm" method="post">
	<div class="clearfix"></div>
	<div class="table-responsive">
		<table id="general-table" class="table table-striped table-vcenter">
			<thead>
				<tr>
					<th></th>
					<th>English</th>
					<th>Arabic</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Product Name</td>
					<td valign="top">
						<input type="text" name="product_name" value="<?php echo $product_fetch['product_name']; ?>" id="product_name" class="form-control" style="direction: rtl; width:300px;">
					<span id="wrong_product_name" class="text-danger"></span> 
					</td>
					<td valign="top">
						<input type="text" value="<?php echo $product_fetch['product_arabic']; ?>" name="product_arabic"  id="product_arabic" class="form-control" style="direction: rtl; width:300px;" />
						<span id="wrong_product_arabic" class="text-danger"></span>
					</td>
				</tr>
				<tr>
					<td>Price</td>
					<td valign="top">
						<input type="number" name="product_price" value="<?php echo $product_fetch['product_price']; ?>" id="product_price" class="form-control" style="direction: rtl; width:300px;">
						<span id="wrong_product_price" class="text-danger"></span> 
					</td>
				</tr>
				<tr>
					<td>Quantity</td>
					<td valign="top">
						<input type="number" name="product_qty"  id="product_qty" class="form-control" value="<?php echo $product_fetch['product_qty']; ?>" style="direction: rtl; width:300px;">
						<span id="wrong_product_qty" class="text-danger"></span> 
					</td>
				</tr>
				<tr>
					<td>Choose Lenses</td>
					<td valign="top">
						<select name="lenses_ids" id="lenses_ids" class="form-control lenses" style="direction: rtl; width:300px;" multiple="multiple">
							<option value="">Select</option>
							<?php 

							$lense_select = "SELECT * FROM lenses";
							$lense_select_query = mysql_query($lense_select);

							if(mysql_num_rows($lense_select_query) > 0) {
								while ($lense_fetch = mysql_fetch_assoc($lense_select_query)) {
							?>
							<option value="<?php echo $lense_fetch['id']; ?>" <?php if(in_array($lense_fetch['id'], $pairedLensArray)) echo 'selected=selected'; ?>><?php echo $lense_fetch['lens_name']; ?></option>
						<?php } }
							?>
						</select>
						<input type="checkbox" id="checkbox" name="selectCheck" style="margin-left:20px;" <?php if($product_fetch['ischecked'] == 1) echo 'checked="checked"'; ?> >Select All
						<span id="wrong_lenses_ids" class="text-danger"></span> 
					</td>
				</tr>
				<tr>
					<td></td>
					<td valign="top"><input type="button" class="form-control btn btn-sm btn-primary" onClick="UpdateRecord(<?php echo $product_fetch['id'];?>);" value="Update" style="width:300px;"> </td>
				</tr>
			</tbody>
		</table>
	</div>
	</form>
	<!-- END Table Styles Content -->
	
</div>

<script>
	(function($) {
	    $(function() {
	        $('.lenses').fSelect({placeholder: 'Select all checkbox'});
	    });
	})(jQuery);

	$("#checkbox").click(function(){
	    if($("#checkbox").is(':checked') )
	    {
	    	$('.g0').each(function(){
	    		$(this).addClass('selected');
	    	});
	    	$("#lenses_ids > option").removeAttr("disabled");
	        $("#lenses_ids > option").prop("selected","selected");
	        $("#lenses_ids").trigger("change");
	        $('.fs-label').html('All Selected');
		}
		else
		{
	    	$('.g0').each(function(){
	    		$(this).removeClass('selected');
	    	});
	    	$("#lenses_ids > option").attr("disabled");
	        $("#lenses_ids > option").removeAttr("selected");
	     	$("#lenses_ids").trigger("change");
	     	$('.fs-label').html('Select lenses');
	     }
	});

	function UpdateRecord(id)
	{
	  	var product_name = $("#product_name").val();
	    var product_arabic = $("#product_arabic").val();
	    var product_price = $("#product_price").val();
	    var product_qty = $("#product_qty").val();
	    var lenses_ids = $("#lenses_ids").val();
	   	var checkbox = 0;
        if($('#checkbox').is(':checked'))
        {
        	checkbox = 1;
        }
	    if(product_name == '')
	    {
	        $('#wrong_product_name').text('Product name is required');
	        $('#wrong_product_name').show();
	        return false;
	    }
	    else 
	    {
	    	$('#wrong_product_name').hide(); 
	    }
	    if(product_arabic == '')
	    {
	        $('#wrong_product_arabic').text('Product arabic is required');
	        $('#wrong_product_arabic').show();
	        return false;
	    }
	    else 
		{
			$('#wrong_product_arabic').hide(); 
		}
	    if(product_price == '')
	    {
	        $('#wrong_product_price').text('Product price is required');
	        $('#wrong_product_price').show();
	        return false;
	    }
	    else 
		{
			$('#wrong_product_price').hide(); 
		}
		if(product_qty == '' || product_qty == 0)
	    {
	        $('#wrong_product_qty').text('Product quantity is required');
	        $('#wrong_product_qty').show();
	        return false;
	    }
	    else 
		{
			$('#wrong_product_qty').hide(); 
		}
	     
	    /*if(lenses_ids === null)
	    {
	        $('#wrong_lenses_ids').text('Lens is required');
	        $('#wrong_lenses_ids').show();
	        return false;
	    }
	    else 
		{
		$('#wrong_lenses_ids').hide(); 
		}*/
      	jQuery.ajax({
       		type: "POST",
       		data: {id: id, product_name: product_name, product_arabic: product_arabic, product_price: product_price, product_qty: product_qty, lenses_ids: lenses_ids, checkbox: checkbox},     // <-- put on top
       		url: "product_update.php",
       		cache: false,
       		success: function(response)
       		{
		    	if(response == 1)
		     		$('.header-section').append('<div class="alert alert-success">Updated successfully<br>تم التحديث بنجاح</div>');
		     	else
		     		$('.header-section').append('<div class="alert alert-warning">Something went wrong. Please try again.<br>هناك خطأ ما. حاول مرة اخرى.</div>');
			}
     	});
 	}
</script>
