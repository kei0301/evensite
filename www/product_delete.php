<?php 
	require_once 'inc/config.php'; 
	$template['header']='';
	if(isset($_POST['id']))
	{	
		$frame_id = $_POST['id'];
		$frame_delete = "DELETE FROM products WHERE id = '".$frame_id."'";
		$delete_query = mysql_query($frame_delete);
		if($delete_query)
			echo json_encode(array('err'=> false, 'msg'=>'removed'));
		else
			echo json_encode(array('err'=> true, 'msg'=> 'error'));
		exit;
	}
?>