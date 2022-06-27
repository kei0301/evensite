<?php require_once 'inc/config.php'; $template['header']=''; ?>
<?php require_once 'inc/template_start.php'; ?>
<?php require_once 'inc/page_head.php'; ?>

<div id="page-content">
<?php
	if($_GET["id"]){
		include 'order_detail.php';
	} 
	else if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
		include 'login.php';
	}
	else {
		include 'home.php';
		//include 'order_details.php';
	}

?>
</div>
<iframe id="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>

<script>
function printUrl(url) {
	console.log(url, "url")
	document.getElementById("print_frame").src=""+url;
}
</script>
<script>
	var Ajax_currRequest;
	function loadPage(url) {
		SITE_showLoader();
		if (Ajax_currRequest)
			Ajax_currRequest.abort();
		Ajax_currRequest = $.ajax({
			type: "GET",
			url: url,
			success: function (html) {
				$("#page-content").html(""+html);
				Ajax_currRequest = null;
				SITE_hideLoader();
			}
		});
	}
	function setLoginForm() {
		$('#form-login').ajaxForm({
			url: 'login.php',
			beforeSend: function() {
				SITE_showLoader();
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			success: function() {
			},
			complete: function(xhr) {
				$("#page-content").html(""+xhr.responseText);
				SITE_hideLoader();
			}
		}); 
	}
	function setLabelForm() {
		$('#LabelForm').ajaxForm({
			url: 'label.php',
			beforeSend: function() {
				SITE_showLoader();
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			success: function() {
			},
			complete: function(xhr) {
				$("#page-content").html(""+xhr.responseText);
				SITE_hideLoader();
			}
		}); 
	}
	function setLabelNewForm() {
		$('#LabelNewForm').ajaxForm({
			url: 'label.php',
			beforeSend: function() {
				SITE_showLoader();
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			success: function() {
			},
			complete: function(xhr) {
				$("#page-content").html(""+xhr.responseText);
				SITE_hideLoader();
			}
		}); 
	}
	function setSearchForm() {
		$('#SearchForm').ajaxForm({
			url: 'home.php',
			beforeSend: function() {
				SITE_showLoader();
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			success: function() {
			},
			complete: function(xhr) {
				$("#page-content").html(""+xhr.responseText);
				SITE_hideLoader();
			}
		}); 
	}
	function setOrderNewForm() {
		$('#OrderNewForm').ajaxForm({
			url: 'order_new.php',
			beforeSend: function() {
				SITE_showLoader();
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			success: function() {
			},
			complete: function(xhr) {
				$("#page-content").html(""+xhr.responseText);
				SITE_hideLoader();
			}
		}); 
	}
	function setOrderDetailsForm(id) {
		$('#OrderDetailsForm').ajaxForm({
			url: 'order_details.php?id='+id,
			beforeSend: function() {
				SITE_showLoader();
			},
			uploadProgress: function(event, position, total, percentComplete) {
			},
			success: function() {
			},
			complete: function(xhr) {
				$("#page-content").html(""+xhr.responseText);
				SITE_hideLoader();
			}
		}); 
	}
</script>

<?php require_once 'inc/page_footer.php'; ?>
<?php require_once 'inc/template_scripts.php'; ?>
<?php require_once 'inc/template_end.php'; ?>