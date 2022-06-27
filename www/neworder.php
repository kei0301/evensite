<?php require_once 'inc/config.php'; $template['header']=''; ?>
<?php 
	if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
		doRedirect("login.php");
	}
	if(isset($_POST["client_name"]) && isset($_POST["client_phone"])){
	$res = db_query("
		INSERT INTO `order` (bill_number, bill_year, client_name, client_phone, order_date) 
		SELECT IFNULL(MAX(bill_number),0)+1, YEAR(CURDATE()), '".mysql_real_escape_string($_POST["client_name"])."', '".mysql_real_escape_string($_POST["client_phone"])."', CURDATE()
		FROM `order` WHERE bill_year = YEAR(CURDATE())
	");
	$id = db_last_insert_id();
	echo $id;
	exit();
}