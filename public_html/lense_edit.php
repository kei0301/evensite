<?php require_once 'inc/config.php'; $template['header']=''; 
  
    $lense_id = $_GET['id'];

    $lense_select = "SELECT * FROM lenses WHERE id='".$lense_id."'";
    $lense_query = mysql_query($lense_select);

    $lense_fetch = mysql_fetch_assoc($lense_query); 
     
?>


<?php require_once 'inc/page_menu.php'; ?>
<div class="content-header">
	<div class="header-section">
		<h1>Update Lens</h1>
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
					<td>Lens Name</td>
					<td valign="top">
						<input type="text" name="lense_name" value="<?php echo $lense_fetch['lens_name']; ?>" id="lense_name" class="form-control" style="direction: rtl; width:300px;">
					<span id="wrong_lense_name" class="text-danger"></span> 
					</td>
					<td valign="top">
						<input type="text" value="<?php echo $lense_fetch['lens_arabic']; ?>" name="lense_arabic"  id="lense_arabic" class="form-control" style="direction: rtl; width:300px;" />
						<span id="wrong_lense_arabic" class="text-danger"></span>
					</td>
				</tr>
				<tr>
					<td>Price</td>
					<td valign="top">
						<input type="number" name="lense_price" value="<?php echo $lense_fetch['lens_price']; ?>" id="lense_price" class="form-control" style="direction: rtl; width:300px;">
						<span id="wrong_lense_price" class="text-danger"></span> 
					</td>
				</tr>
				<tr>
					<td>Quantity</td>
					<td valign="top">
						<input type="number" name="lense_quantity" value="<?php echo $lense_fetch['lens_quantity']; ?>" id="lense_quantity" class="form-control" style="direction: rtl; width:300px;">
						<span id="wrong_lense_quantity" class="text-danger"></span> 
					</td>
				</tr>
				<tr>
					<td></td>
					<td valign="top"><input type="button" class="form-control btn btn-sm btn-primary" onClick="UpdateRecord(<?php echo $lense_fetch['id'];?>);" value="Submit" style="width:300px;"> </td>
				</tr>
			</tbody>
		</table>
	</div>
	</form>
	<!-- END Table Styles Content -->
	
</div>

<script>
	function UpdateRecord(id)
  	{
	  	var lense_name = $("#lense_name").val();
	    var lense_arabic = $("#lense_arabic").val();
	    var lense_price = $("#lense_price").val();
	    var lense_quantity =  $("#lense_quantity").val();
	    var data =  $("#LabelForm").serialize();
	    if(lense_name == '')
	    {
	        $('#wrong_lense_name').text('lens name is required');
	        $('#wrong_lense_name').show();
	        return false;
	    }
	    else 
	    {
	    	$('#wrong_lense_name').hide(); 
	    }
	    if(lense_arabic == '')
	    {
	        $('#wrong_lense_arabic').text('arabic is required');
	        $('#wrong_lense_arabic').show();
	        return false;
	    }
	    else 
		{
			$('#wrong_lense_arabic').hide(); 
		}
	    if(lense_price == '')
	    {
	        $('#wrong_lense_price').text('price is required');
	        $('#wrong_lense_price').show();
	        return false;
	    }
	    else 
		{
			$('#wrong_lense_price').hide(); 
		}
	     
	    if(lense_quantity == '')
	    {
	    	$('#wrong_lense_quantity').text('quantity is required');
	        $('#wrong_lense_quantity').show();
	        return false;
	    }
	    else 
		{
			$('#wrong_lense_quantity').hide(); 
		}
	      jQuery.ajax({
	       type: "POST",
	       data: {id: id, lense_name: lense_name, lense_arabic: lense_arabic, lense_price: lense_price, lense_quantity: lense_quantity},     // <-- put on top
	       url: "lense_update.php",
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
