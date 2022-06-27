<?php 
	require_once 'inc/config.php'; 
	$template['header']='';
	if(isset($_POST['id']))
	{
		$lense_id = $_POST['id'];
		$getRelationQuery = mysql_query('SELECT id FROM frame WHERE lense_id = '.$lense_id);
		$getRelation = mysql_fetch_row($getRelationQuery);
		if(!empty($getRelation))
		{
			echo json_encode(array('err'=>true, 'msg'=> 'paired'));
		}
		else
		{
			$lense_delete = "DELETE FROM lense WHERE id = '".$lense_id."'";
			$delete_query = mysql_query($lense_delete);
			if($delete_query)
			{
				echo json_encode(array('err'=>false, 'msg'=>'removed'));
			}
			else
			{
				echo json_encode(array('err'=>true, 'msg'=>'error'));
			}
		}
		exit;
	}
?>