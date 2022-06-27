<?php require_once 'inc/config.php'; ?>
<?php 
	if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
		doRedirect("login.php");
	}
	if($_POST['from'] != '' && $_POST['to']!= '')
	{
		$fetchQuery = mysql_query("SELECT COUNT(id) as NoOfSales, SUM(price_total) as AmountDiscounted, SUM(price_paid) as PaidOrders FROM `order` WHERE `order_date` BETWEEN '".$_POST['from']."' AND '".$_POST['to']."' ");
		$fetchData = mysql_fetch_row($fetchQuery);

		if($fetchData[1] != '') { $fetchDataAmount = $fetchData[1]; } else{ $fetchDataAmount = '0.00'; } 
		if($fetchData[2] != '') { $fetchDataPaid = $fetchData[2]; } else{ $fetchDataPaid = '0.00'; } 

		$html = '<div class="col-md-8" style="margin-top:10px;">           
            <table border=1 cellpadding="0px" cellspacing="0px" width="100%" align="center">
                <thead>
                    <td colspan="3" align="center" style="font-size:20px;">Sales Between '.date("m/d/Y", strtotime($_POST["from"])).' to '.date("m/d/Y", strtotime($_POST["to"])).'</td>
                </thead>
                <tbody>
                    <tr align="center">
                        <td style="font-size:16px;">Total Sales</td>
                        <td style="font-size:16px;">Total Amount</td>
                        <td style="font-size:16px;">Total Paid</td>
                    </tr>
                    <tr align="center" class="slary">
                        <td style="font-size:16px;">'.$fetchData[0].'</td>
                        <td style="font-size:16px;">'.$fetchDataAmount.'</td>
                        <td style="font-size:16px;">'.$fetchDataPaid.'</td>
                    </tr>
                </tbody>
            </table>
        </div>';
        echo $html;
        exit;
	}