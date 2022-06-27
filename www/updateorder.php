<?php require_once 'inc/config.php'; $template['header']=''; ?>
<?php 
	if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
		doRedirect("login.php");
	}
	
	if(isset($_POST)){
		// unset($_POST['frame'][0]);
		// unset($_POST['lenses'][0]);
		$frame = serialize($_POST['frame']);
		$lenses = serialize($_POST['lenses']);

		$res = db_query("
			UPDATE `order` SET 
				`client_name` = '".mysql_real_escape_string($_POST["client_name"])."', 
				`client_phone` = '".mysql_real_escape_string($_POST["client_phone"])."', 
				`price_total` = '".mysql_real_escape_string($_POST["price_total"])."', 
				`price_paid` = '".mysql_real_escape_string($_POST["price_paid"])."', 
				`price_full` = '".mysql_real_escape_string($_POST["price_full"])."', 
				`price_full_vat` = '".mysql_real_escape_string($_POST["vat"])."',
				`price_discount` = '".mysql_real_escape_string($_POST["price_discount"])."', 
				`er_d_sphere` = '".mysql_real_escape_string($_POST["er_d_sphere"])."', 
				`er_d_cylinder` = '".mysql_real_escape_string($_POST["er_d_cylinder"])."', 
				`er_d_axis` = '".mysql_real_escape_string($_POST["er_d_axis"])."', 
				`er_r_sphere` = '".mysql_real_escape_string($_POST["er_r_sphere"])."', 
				`er_r_cylinder` = '".mysql_real_escape_string($_POST["er_r_cylinder"])."', 
				`er_r_axis` = '".mysql_real_escape_string($_POST["er_r_axis"])."',
				`er_cl_sphere` = '".mysql_real_escape_string($_POST["er_cl_sphere"])."', 
				`er_cl_cylinder` = '".mysql_real_escape_string($_POST["er_cl_cylinder"])."', 
				`er_cl_axis` = '".mysql_real_escape_string($_POST["er_cl_axis"])."', 
				`er_add` = '".mysql_real_escape_string($_POST["er_add"])."', 
				`el_d_sphere` = '".mysql_real_escape_string($_POST["el_d_sphere"])."', 
				`el_d_cylinder` = '".mysql_real_escape_string($_POST["el_d_cylinder"])."', 
				`el_d_axis` = '".mysql_real_escape_string($_POST["el_d_axis"])."', 
				`el_r_sphere` = '".mysql_real_escape_string($_POST["el_r_sphere"])."', 
				`el_r_cylinder` = '".mysql_real_escape_string($_POST["el_r_cylinder"])."', 
				`el_r_axis` = '".mysql_real_escape_string($_POST["el_r_axis"])."',
				`el_cl_sphere` = '".mysql_real_escape_string($_POST["el_cl_sphere"])."', 
				`el_cl_cylinder` = '".mysql_real_escape_string($_POST["el_cl_cylinder"])."', 
				`el_cl_axis` = '".mysql_real_escape_string($_POST["el_cl_axis"])."', 
				`el_add` = '".mysql_real_escape_string($_POST["el_add"])."', 
				`ipd` = '".mysql_real_escape_string($_POST["ipd"])."', 
				`frame` = '".mysql_real_escape_string($frame)."', 
				`note` = '".mysql_real_escape_string($_POST["note"])."', 
				`lenses` = '".mysql_real_escape_string($lenses)."', 
				order_date = order_date
			WHERE id = {$_POST["id"]}
		");
		
		if($res)
		{
			echo $_POST["id"];
			exit;
		}
	}
	
?>
