<?php 
require_once 'inc/config.php'; $template['header']=''; 
require_once 'inc/page_menu.php'; 
?>
<link href="css/fSelect.css" rel="stylesheet">
<div class="content-header">
	<div class="header-section">
		<h1>Add New Product</h1>
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
						<input type="text" name="product_name" id="product_name" class="form-control" style="direction: rtl; width:300px;">
					<span id="wrong_product_name" class="text-danger"></span> 
					</td>
					<td valign="top">
						<input type="text" name="product_arabic"  id="product_arabic" class="form-control" style="direction: rtl; width:300px;" />
						<span id="wrong_product_arabic" class="text-danger"></span>
					</td>
				</tr>
				<tr>
					<td>Price</td>
					<td valign="top">
						<input type="number" name="product_price"  id="product_price" class="form-control" style="direction: rtl; width:300px;">
						<span id="wrong_product_price" class="text-danger"></span> 
					</td>
				</tr>
				<tr>
					<td>Quantity</td>
					<td valign="top">
						<input type="number" name="product_qty"  id="product_qty" class="form-control" style="direction: rtl; width:300px;">
						<span id="wrong_product_qty" class="text-danger"></span> 
					</td>
				</tr>
				<tr>
					<td>Choose Lenses</td>
					<td valign="top">
						<select name="lenses_ids" id="lenses_ids" class="form-control lenses" style="direction: rtl; width:300px;" multiple="multiple">
							<?php 

							$lense_select = "SELECT * FROM lenses";
							$lense_select_query = mysql_query($lense_select);

							if(mysql_num_rows($lense_select_query) > 0) {
								while ($lense_fetch = mysql_fetch_assoc($lense_select_query)) {
							?>
							<option value="<?php echo $lense_fetch['id']; ?>"><?php echo $lense_fetch['lens_name']; ?></option>
						<?php } }
							?>
						</select>
						<input type="checkbox" id="checkbox" name="selectCheck">Select All
						<span id="wrong_lenses_ids" class="text-danger"></span> 
					</td>
				</tr>
				<tr>
					<td></td>
					<td valign="top"><input type="button" name="submit_frame" class="form-control" id="submit_product_form" value="Submit" style="width:300px;"> </td>
				</tr>
			</tbody>
		</table>
	</div>
	</form>
	<!-- END Table Styles Content -->
	
</div>
<script src="js/select2.min.js"></script>
<script type="text/javascript">
	(function($) {
	    $(function() {
	        $('.lenses').fSelect({placeholder: 'Select lenses'});
	    });
	})(jQuery);
	
	$("#checkbox").click(function(){
    if($("#checkbox").is(':checked') ){
    	$('.g0').each(function(){
    		$(this).addClass('selected');
    	});
    	$("#lenses_ids > option").removeAttr("disabled");
        $("#lenses_ids > option").prop("selected","selected");
        $("#lenses_ids").trigger("change");
        $('.fs-label').html('All Selected');
    }else{
    	$('.g0').each(function(){
    		$(this).removeClass('selected');
    	});
    	$("#lenses_ids > option").attr("disabled");
        $("#lenses_ids > option").removeAttr("selected");
     	$("#lenses_ids").trigger("change");
     	$('.fs-label').html('Select lenses');
     }
	});

	$(document).ready(function(){
	     
	    $("#submit_product_form").click(function(){
	          
	        var product_name = $("#product_name").val();
	        var product_arabic = $("#product_arabic").val();
	        var product_price = $("#product_price").val();
	        var lenses_ids =  $("#lenses_ids").val();
	        var product_qty = $('#product_qty').val();
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
	         
	        $.ajax({
	            type: "POST",
	            url: "product_insert.php",
	            data: { product_name:product_name, product_arabic:product_arabic, product_price:product_price,product_qty:product_qty, lenses_ids:lenses_ids, checkbox: checkbox },
	            dataType: 'json',
	            success: function(data){
	                if(data == 1)
	                {
	                 	$('.header-section').append('<div class="alert alert-success">Inserted successfully<br>تم إدخاله بنجاح</div>');
	                 	$('#LabelForm')[0].reset();
	                 	$(".fs-option").removeClass( 'selected' );
	                 	$('.fs-label').text('Select some options');
	                }
	                else
	         			$('.header-section').append('<div class="alert alert-warning">Something went wrong. Please try again.<br>هناك خطأ ما. حاول مرة اخرى.</div>');
             	}
	        });
	 		return false;
	    });
	});
</script>
