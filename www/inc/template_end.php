<?php
/**
 * template_end.php
 *
 * Author: pixelcave
 *
 * The last block of code used in every page of the template
 *
 * We put it in a separate file for consistency. The reason we
 * separated template_scripts.php and template_end.php is for enabling us
 * put between them extra javascript code needed only in specific pages
 *
 */
?>
<script type="text/javascript">

	var classinc = 1;
	if($('#framecount').length>0)
	{
		var divcount = $('#framecount').val()+2;
	}
	else
	{
		divcount = 3
	}
	
	function addNew()
	{  
		// SITE_showLoader();
		$(this).hide();

		var totalFrames = $('#frameTD').find('.frameBox').length;
		var totalLense = $('#lenseTD').find('.lenseBox').length;
		var frameHtm = $('#framediv').html();
		var lenseHtm = $('#lensDiv').html();

		$(frameHtm).insertBefore("#addnew");
		$('#frameTD').children('.frameBox').last().attr('id','fbox-'+(totalFrames+1));
		$('#frameTD').children('.frameBox').last().attr('data-fid',(totalFrames+1));
		$('#frameTD').children('.frameBox').last().find('select').attr('id','frame-'+(totalFrames+1));
		$('#frameTD').children('.frameBox').last().find('select').attr('data-frame',(totalFrames+1));
		$('#frameTD').children('.frameBox').last().find('.remove-fl').attr('data-fid',(totalFrames+1));
		$('#frameTD').children('.frameBox').last().find('.remove-fl').attr('onclick','removeFrameLens('+(totalFrames+1)+');');
		$('#frameTD').children('.frameBox').last().attr('id','fbox-'+(totalFrames+1)).find('select').select2('destroy').select2();

		$("#lenseTD").append(lenseHtm);
		$("#lenseTD").children('.lenseBox').last().attr('data-lid',''+(totalLense+1));
		$("#lenseTD").children('.lenseBox').last().attr('id','lbox-'+(totalLense+1));
		$("#lenseTD").children('.lenseBox').last().find('select').attr('id','lense-'+(totalLense+1));
		$("#lenseTD").children('.lenseBox').last().find('select').attr('data-lens', (totalLense+1));
		$('#lenseTD').children('.lenseBox').last().attr('id','lbox-'+(totalLense+1)).find('select').select2('destroy').select2();
		/*var frameLength = $('.frameBox').length;
		if(frameLength > 1)
		{
			$('.remove-fl').show();
		}
		/*if($('.appendFrame').length == 0)
			$('<div class="appendFrame"></div>').insertAfter('#vatprice');

		$('.appendFrame').append(selectHtm);
		$('.appendFrame').find('select').attr('disabled', false);
		$('.appendFrame').find('select:last').addClass('frame-'+classinc);
		$('.appendFrame').find('select:last').attr('data-frame', divcount);
		$('<div><a href="javascript:void(0);" class="remove-fl" data-fl="'+divcount+'" onclick="removeFrameLens('+divcount+')">Remove</a></div>').insertAfter($('.appendFrame').find('select:last'));
		$('.frame-'+classinc).fSelect();
		var lensHtm = $('#lensdiv').html();
		$('.appendLens').append(lensHtm);
		$('.appendLens').find('select').attr('disabled', false);
		$('.lens-'+classinc).addClass('lensGet');
		$('.lens-'+divcount).fSelect();
		$('.appendLens').find('select:last').attr('data-lens', divcount);
		divcount++;
		classinc++;
		$('#addnew').html('Add More');
		SITE_hideLoader();*/
	}
	function removeFrameLens(attrId)
	{
		var framePrice = 0;
		var lensPrice = 0;

		$('.frameBox').each( function(){
			if($(this).attr('data-fid') == attrId)
			{
				if($(this).find(':selected').data('price') != undefined)
					framePrice = $(this).find(':selected').data('price');
				/*if($(this).parent().parent().find('.fs-wrap').length > 0)
					$(this).fSelect('destroy');*/
				$(this).remove();
			}
		});
		$('.lenseBox').each( function(){
			if($(this).attr('data-lid') == attrId)
			{
				if($(this).find(':selected').data('price') != undefined)
					lensPrice = $(this).find(':selected').data('price');
				/*if($(this).parent().parent().find('.fs-wrap').length > 0)
					$(this).fSelect('destroy');*/
				$(this).remove();
			}
		});

		/*var frameLength = $('.frameBox').length;
		if((frameLength-1) == 0)
		{
			$('.remove-fl').hide();		
		}*/
		/*$('.remove-fl').each( function(){
			if($(this).attr('data-fid') == attrId)
			{
				$(this).remove();
			}
		});*/

		if($('#price_full').val() != '')
		{
			
			var TotalReduce = parseFloat(framePrice) + parseFloat(lensPrice);
			var price_full = $('#price_full').val();
			var price_full_reduce = parseFloat(price_full) - parseFloat(TotalReduce);
			$('#price_full').val(price_full_reduce.toFixed(2));
			var vat = $('#vatprice').val();
			var reduceVat = parseFloat((price_full_reduce*vat)/100).toFixed(2);
			var price_full_reduce_vat = parseFloat(price_full_reduce)+parseFloat(reduceVat);
			$('#vat').val(price_full_reduce_vat.toFixed(2));
			var price_total = $('#price_total').val();
			var price_total_reduce = parseFloat(price_total) - (parseFloat(TotalReduce)+ ((parseFloat(TotalReduce)*vat)/100));
			$('#price_total').val(price_total_reduce.toFixed(2));
			$("#Balance").html(price_total_reduce.toFixed(2));
			
		}
		
	}
	function removePreFrameLens(attrId)
	{
		SITE_showLoader();
		var framePrice = 0;
		var lensPrice = 0;
		$('.frame').each( function(){
			if($(this).attr('data-frame') == attrId)
			{
				if($(this).find(':selected').data('price') != undefined)
					framePrice = $(this).find(':selected').data('price');
				/*if($(this).parent().parent().find('.fs-wrap').length > 0)
					$(this).fSelect('destroy');*/
				$(this).select2('destroy');	
				$(this).remove();
			}
		});
		$('.lenses').each( function(){
			if($(this).attr('data-lens') == attrId)
			{
				if($(this).find(':selected').data('price') != undefined)
					lensPrice = $(this).find(':selected').data('price');
				/*if($(this).parent().parent().find('.fs-wrap').length > 0)
					$(this).fSelect('destroy');*/
				$(this).select2('destroy');
				$(this).remove();
			}
		});

		$('.remove-fl').each( function(){
			if($(this).attr('data-fl') == attrId)
			{
				$(this).remove();
			}
		});
		if($('#price_full').val() != '')
		{
			if($('#price_full').val() == 0)
			{
				$("#price_discount").val($("#price_full").val());
				$("#price_total").val($("#price_full").val());
				$('#vat').val($("#price_full").val());
				$('#price_paid').val($("#price_full").val());
				$('#Balance').html($("#price_full").val());
			}
			else
			{
				var TotalReduce = parseFloat(framePrice) + parseFloat(lensPrice);
				var price_full = $('#price_full').val();
				var price_full_reduce = parseFloat(price_full) - parseFloat(TotalReduce);

				$('#price_full').val(price_full_reduce.toFixed(2));
				var vat = $('#vatprice').val();
				var reduceVat = parseFloat((price_full_reduce*vat)/100).toFixed(2);
				var price_full_reduce_vat = parseFloat(price_full_reduce)+parseFloat(reduceVat);
				$('#vat').val(price_full_reduce_vat.toFixed(2));
				var price_total = $('#price_total').val();
				var price_total_reduce = parseFloat(price_total) - (parseFloat(TotalReduce)+ ((parseFloat(TotalReduce)*vat)/100));
				// var price_total_reduce = parseFloat(price_total) - parseFloat(TotalReduce);
				$('#price_total').val(price_total_reduce.toFixed(2));
				$("#Balance").html(price_total_reduce.toFixed(2));
			}
		}
		SITE_hideLoader();
	}
	
	

	$(document).on('change', '.frame', function (e) {
		if(this.value != '')
		{
			SITE_showLoader();
			var productid = this.value;
	        var productprice = $(this).find(':selected').data('price');
	        var vat = $('#vatprice').val();
	        var orderid = $('#id').val();
	        var lensselectid = $(this).data('frame');
	        var $this = $(this);
	        $(this).find(':selected').attr('selected', 'selected');
	        $.ajax({
				method: 'POST',
				dataType: 'json',
				url: 'getlense.php',
				data: {productid: productid, vat: vat, orderid: orderid},
				success: function(result)
				{

					var htm = '<option value="">Select Lens</option>';
					var data = {};
					$.each(result.lensesArray, function (k,v) {
						data = {
							    id: v.id,
							    text: v.lens_name
							};
					    htm += '<option value="'+v.id+'" data-price="'+v.lens_price+'">'+v.lens_name+'</option>';
					});

					$('.lenses').each(function(){
						if($(this).attr('data-lens') == lensselectid){
							
							$(this).html(htm);
							// $(this).fSelect();
							$(this).select2();
						}
					});
					// $this.fSelect('destroy');
					// $this.attr('disabled', true);
					$this.find('option').attr('disabled', true);
					$this.find(':selected').attr('disabled', false);
					var totalAmount = $('#price_full').val()-parseFloat(result.prevFramePrice)-parseFloat(result.preLensPrice);
					var productPrice = result.productPrice;
					
					var updatedAmount = parseFloat(totalAmount)+parseFloat(productPrice);
					$('#price_full').val(updatedAmount.toFixed(2));

					var vatPrice = parseFloat((parseFloat(updatedAmount)*parseFloat(vat))/100);
					
					var newUpdateTotal = parseFloat(updatedAmount)+parseFloat(vatPrice);
					
					$('#vat').val(newUpdateTotal.toFixed(2));

					if($('#price_total').val() != '' && $('#price_total').val() != '0.00')
					{
						var discount = $('#price_discount').val();
						var discountPrice = parseFloat($('#price_total').val())-parseFloat(result.prevFramePrice)-parseFloat(result.preLensPrice);
						if(discount != '' && discount == '0.00')
						{
							var newDiscountPrice = parseFloat(newUpdateTotal) - parseFloat((newUpdateTotal*discount)/100);
							/*var newDiscountPrice = (parseFloat(discountPrice)+parseFloat(productPrice)) - parseFloat(discount);
							newDiscountPriceWithVat = (parseFloat(newDiscountPrice)*parseFloat(vat))/100;
							newDiscountPrice = newDiscountPrice+newDiscountPriceWithVat;*/
						}
						else
						{
							var newDiscountPrice = parseFloat(newUpdateTotal) - parseFloat((newUpdateTotal*discount)/100);
							/*var newDiscountPrice = parseFloat(discountPrice)+parseFloat(productPrice);
							newDiscountPriceWithVat = (parseFloat(newDiscountPrice)*parseFloat(vat))/100;
							newDiscountPrice = newDiscountPrice+newDiscountPriceWithVat;*/
						}

						$('#price_total').val(newDiscountPrice.toFixed(2));
					}
					else
					{
						$('#price_total').val(newUpdateTotal.toFixed(2));
					}
					$('#Balance').html(newUpdateTotal.toFixed(2));
					SITE_hideLoader();
				},
				complete: function() {
			        $(this).data('requestRunning', false);
			    }
			});
		}
		return false;
    });
	
	$(document).on('change', '.lenses', function (e) {
		if(this.value != '')
		{
			var lensid = this.value;
	        var lensprice = $(this).find(':selected').data('price');

	        var totalAmount = $('#price_full').val();
			
			var vat = $('#vatprice').val();
			var updatedAmount = parseFloat(totalAmount)+parseFloat(lensprice);
			$('#price_full').val(updatedAmount.toFixed(2));

			var vatPrice = parseFloat((parseFloat(updatedAmount)*parseFloat(vat))/100);
			
			var newUpdateTotal = parseFloat(updatedAmount)+parseFloat(vatPrice);
			
			$('#vat').val(newUpdateTotal.toFixed(2));
			if($('#price_total').val() != '' )
			{
				var discount = $('#price_discount').val();
				var discountPrice = $('#price_full').val();
				if(discount != '')
				{
					var newDiscountPrice = parseFloat(discountPrice) - parseFloat(discount);
					newDiscountPriceWithVat = (parseFloat(newDiscountPrice)*parseFloat(vat))/100;
					newDiscountPrice = newDiscountPrice+newDiscountPriceWithVat;
				}
				else
				{
					var newDiscountPrice = parseFloat(discountPrice);
					newDiscountPriceWithVat = (parseFloat(newDiscountPrice)*parseFloat(vat))/100;
					newDiscountPrice = newDiscountPrice+newDiscountPriceWithVat;
				}
				$('#price_total').val(newDiscountPrice.toFixed(2));
			}
			else
			{
				$('#price_total').val(newUpdateTotal.toFixed(2));
			}
			$('#Balance').html(newUpdateTotal.toFixed(2));
			// $(this).fSelect('destroy');
			$(this).find('option').attr('disabled', true);
			$(this).find(':selected').attr('disabled', false);
		}
    });
</script>
    </body>
</html>