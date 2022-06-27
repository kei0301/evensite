<?php require_once 'inc/config.php'; $template['header']='';
 
	
	$vat_select = "SELECT * FROM vat";
	$result = mysql_query($vat_select);

	 $vat_fetch = mysql_fetch_assoc($result);

 require_once 'inc/page_menu.php';

?>
<div class="content-header">
	<div class="header-section">
		<h1>Vat</h1>
	</div>
</div>

<div class="block full block-alt-noblabel">
	<form id="LabelForm" method="post">
	<div class="clearfix"></div>
	<div class="table-responsive">
		<table id="general-table" class="table table-striped table-vcenter">
				<tr>
					<td valign="top">vat:<input type="number" class="vat_value" value="<?php echo $vat_fetch['vat']; ?>" id="" name="vat" class="form-control" style="direction: rtl; width:300px;"/></td>
					<td valign="top">vat registeration number:<input type="text" class="vat_registeration_number" value="<?php echo $vat_fetch['registeraion_number']; ?>" id="" name="vat_registeration_number" class="form-control" style="width:300px;"/></td>

					<td><input class="btn btn-sm btn-primary" onClick="UpdateRecord(<?php echo $vat_fetch['id'];?>);" type="button"  value="Update" /></td>
					
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
  	var wat = $(".vat_value").val();
  	var vat_number = $(".vat_registeration_number").val();
      jQuery.ajax({
       type: "POST",
       data: {id: id, wat: wat, number: vat_number},     // <-- put on top
       url: "update.php",
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
