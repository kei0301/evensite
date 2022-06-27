<?php require_once 'inc/config.php'; $template['header']='';
 
	
	$vat_select = "SELECT * FROM vat";
	$result = mysql_query($vat_select);

	 $vat_fetch = mysql_fetch_assoc($result);

 require_once 'inc/page_menu.php';

?>
<div class="content-header">
	<div class="header-section">
		<h1>Company</h1>
	</div>
</div>

<div class="block full block-alt-noblabel">
	<form id="LabelForm" method="post">
	<div class="clearfix"></div>
	<div class="table-responsive">
		<table id="general-table" class="table table-striped table-vcenter">
				<tr>
					<td valign="top"><input type="text" class="company_name" value="<?php echo $vat_fetch['company_name']; ?>" id="" name="company_name" class="form-control" style="direction: rtl; width:300px;"/></td>
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
  	var wat = $(".company_name").val();
  	console.log(wat)
      jQuery.ajax({
       type: "POST",
       data: {id: id, wat: wat },     // <-- put on top
       url: "update-company.php",
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
