<?php require_once 'inc/config.php'; $template['header']=''; ?>
<?php 

if(isset($_GET["logout"]) && $_GET["logout"] == "true"){
	$_SESSION["user"] = array();
}
if(isset($_POST["username"]) && isset($_POST["passwd"])){
	$username = $_POST["username"];
	$password = $_POST["passwd"];
	$passwd = md5("c-Eainy-Dalaa_".$password);
	$res = db_query("SELECT * FROM users WHERE username='{$username}' AND passwd='{$passwd}'");
	$user = db_fetch_row($res);
	if(!empty($user["user_id"])) {
		$_SESSION["user"] = $user;
		doRedirect("home.php");
	}
	else {
		$alertMsg = "Wrong username or password";
	}
}
	

?>
<header class="navbar navbar-default" style="margin: -20px;">
   <div id="horizontal-menu-collapse" class="collapse navbar-collapse">
		<ul class="nav navbar-nav">
			<li>
				<a>Kwwatul Basar Optical</a>
			</li>
		</ul>
	</div>
	<!-- END Horizontal Menu + Search -->

</header>
<div class="content-header">
	<div class="header-section">
		<h1><strong>Login</strong> <?php //echo md5("c-Eainy-Dalaa_"."Eainy2015Dalaa")?></h1>
		<?php if(!empty($alertMsg)) { ?><div class="alert alert-<?php echo $alertType; ?>"><?php echo $alertMsg; ?></div><?php } ?>
	</div>
</div>
<div class="block full block-alt-noborder">
	<form method="post" id="form-login" class="form-horizontal form-bordered">
		<div class="form-group">
			<div class="col-xs-12">
				<div class="input-group">
					<span class="input-group-addon"><i class="gi gi-envelope"></i></span>
					<input type="text" id="username" name="username" class="form-control input-lg" placeholder="Username" required="true">
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-12">
				<div class="input-group">
					<span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
					<input type="password" id="passwd" name="passwd" class="form-control input-lg" placeholder="Password" required="true">
				</div>
			</div>
		</div>
		<div class="form-group form-actions">
			<div class="col-xs-8">
				<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Login</button>
			</div>
			<div class="col-xs-4">
			</div>
		</div>
	</form>
</div>

<script>
	$(function () {
		setLoginForm();
	});
</script>
