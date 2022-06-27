<?php require_once 'inc/config.php'; ?>
<?php

    include('./lib/phpqrcode/qrlib.php');
    if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
        doRedirect("login.php");
    }

    $order  = array();
    if(isset($_GET["id"])){
        $res = db_query("SELECT * FROM `order` WHERE id={$_GET["id"]}");
        $order = db_fetch_row($res);

        $vat_select = "SELECT * FROM vat";
        $result = mysql_query($vat_select);

        $vat_fetch = mysql_fetch_assoc($result);

        $per_vat = $vat_fetch["vat"];
    }

    if(!isset($order["id"])){
        doRedirect("home.php");
    }
    // $QRcode = array("Saller number"=>$order["client_name"], "Tax Number"=>$order["bill_number"], "Time/Date stamp"=>formatDate($order["order_date"]), "Total Amount(+vat)"=>$order["price_full_vat"], "VAT Amount"=>$per_vat);
    $tempDir = dirname(__FILE__)."/qrcode/";
    $codeContents = """لتاريخ / الوقت: 123321\n""".
                    """لتاريخ / الوقت : 123321 \n""".
                    """لتاريخ / الوقت : 123321123123123 \n """;
    // $codeContents = "https://www.eyen.site/"."?id=".urlencode($order["id"])."\n"."اسم الشركة:\n ".$vat_fetch["company_name"]."\nرقم التسجيل الضريبي".$vat_fetch["registeraion_number"]."\nالتاريخ / الوقت:  :".formatDateTime($order["order_date"])."\nإجمالي الفاتورة (+ ضريبة القيمة المضافة): ".$order["price_full_vat"]."\nإجمالي ضريبة القيمة المضافة: ".$order["price_full"] * ($vat_fetch["vat"]/100);
    print_r($codeContents);
    // we need to generate filename somehow, 
    // with md5 or with database ID used to obtains $codeContents...
    $fileName = '005_file_'.md5($codeContents).'.png';
    
    $pngAbsoluteFilePath = $tempDir.$fileName;
    $urlRelativeFilePath = './qrcode/'. $fileName;
      if (!file_exists($pngAbsoluteFilePath)) {
        QRcode::png($codeContents, $pngAbsoluteFilePath);
     
    }
    

    
    // displaying
    echo '<img src="'.$urlRelativeFilePath.'" />';
