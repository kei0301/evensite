<?php
error_reporting(E_ALL ^ E_DEPRECATED);
	function trimText($str, $maxLength = 0) {
		$str = trim($str);
    	if(ini_get('magic_quotes_gpc') == 0) {
    		$str = addslashes($str);
    		//$str = mysql_escape_string($str);
    	}
    	if($maxLength != 0) {
    		$str = substr($str, 0, $maxLength);
    	}
    	return $str;
	}
        
    function db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE) {
		$link = mysql_connect($server, $username, $password) or db_error("Connect Error", mysql_errno(), mysql_error());
		if ($link) $db = mysql_select_db($database, $link) or db_error("Select Database", mysql_errno(), mysql_error());
		mysql_query("SET NAMES 'utf8'");
		mysql_query("SET CHARACTER SET 'utf8'");
		mysql_query("SET character_set_client = 'utf8'");
		mysql_query("SET character_set_results = 'utf8'");
		mysql_query("SET character_set_connection = 'utf8'");
    	return $link;
  	}

  	function db_close($link = 'db_link') {
		mysql_close($link);
  	}

  	function db_query($query, $link = "link_db") {
    	$res = mysql_query($query) or db_error($query, mysql_errno(), mysql_error());
   		return $res;
  	}

  	function db_fetch_array($res) {
    	$result = array();
    	while($array = mysql_fetch_array($res, MYSQL_ASSOC)) {
        	$result[count($result)] = $array;       
    	}
    	@mysql_free_result($res);
    	return $result;
  	}
  
  	function db_fetch_row($res) {                   
    	$array = mysql_fetch_array($res, MYSQL_ASSOC);
    	@mysql_free_result($res);
    	return $array;
  	}
  
  	function db_fetch_one($res) {                   
    	$array = mysql_fetch_array($res, MYSQL_NUM);
    	@mysql_free_result($res);
    	return $array[0];
  	}
  	
  	function db_error($query, $errNo, $errDesc) {
  		//header("location:".BASE_URL);
  		echo "<font color=red>Err No : {$errNo}, detail : {$errDesc}</font>{$query}";
  		exit();
  	}
  	
  	function db_last_insert_id() {
  		$res = db_query("SELECT LAST_INSERT_ID()");
  		return  db_fetch_one($res);
  	}

	function getCurrentDate() {
    	$rightnow = date('Y-m-d H:i:s');
    	return $rightnow;
    }
    
    function convertDateToTimeStamp($str) {
    	$str = explode("-", $str);
    	if(count($str) == 3)
    		return mktime(0, 0, 0,intval($str[1]), intval($str[2]), intval($str[0]));
    	else
    		return 0;
    }
	
	function convertDateTimeToTimeStamp($str) {
    	$temp = explode(" ", $str);
    	
    	$date = $temp[0];
    	$date = explode("-", $date);
    	$day = intval($date[2]);
    	$month = intval($date[1]);
    	$year = intval($date[0]);
    	
    	if(count($temp) == 2) {
	    	$time = $temp[1];
	    	$time = explode(":", $time);
	    	$hour = intval($time[0]);
	    	$minute = intval($time[1]);
	    	$second = intval($time[2]);	    	
    	}
    	
    	if(count($date) == 3)
    		return mktime($hour, $minute, $second, $month, $day, $year);
    	else
    		return 0;
    }
	function formatDate($dbDate) {
		$dateTimeStamp = convertDateToTimeStamp($dbDate);
		//$Ar = new I18N_Arabic('Date');
		//$fix = $Ar->dateCorrection ($dateTimeStamp);
		//return $Ar->date('l dS F Y h:i:s A',  $dateTimeStamp, $fix); 
		return date(DATE_FORMAT, $dateTimeStamp);
	}
	
	function formatDateTime($dbDate) {
		$dateTimeStamp = convertDateTimeToTimeStamp($dbDate);
		return date(DATETIME_FORMAT, $dateTimeStamp);
	}
	
	function doRedirect($url) {
    	header("Location:".$url);
    	exit();
    }
	
	function generatePagingData($baseUrl, $startRec, $pageSize, $recCount) {
        $currentPageNo = $startRec/$pageSize+1;
		$maxPage = intval(ceil($recCount/$pageSize));
        $nextLink = array();
        $prevLink = array();
        for($i = 0, $j = 1; $j <= $maxPage; $i+=$pageSize, $j++) {
            $pagination[] = array(
                "number"    => $j,
                "startRec"  => $i,
                "method"    => $baseUrl."&amp;start_rec=".$i."&amp;page_size=".$pageSize
            );
        }
        
        if($startRec == 0 && $recCount < $pageSize) {
			$nextLink = "";
			$prevLink = "";
		}
		else if($startRec == 0 && $recCount > $pageSize) {
			$nextLink = array(
				"startRec"  => $startRec+$pageSize,
				"method"    => $baseUrl."&amp;start_rec=".($startRec+$pageSize)."&amp;page_size=".$pageSize
			);
			$prevLink = "";
		}
		else if($startRec+$pageSize >= $recCount && $startRec != 0) {
			$nextLink = "";
			$prevLink = array(
				"startRec"  => $startRec-$pageSize,
				"method"    => $baseUrl."&amp;start_rec=".($startRec-$pageSize)."&amp;page_size=".$pageSize
			);
		}
		else if($recCount > $pageSize) {
			$nextLink = array(
				"startRec"  => $startRec+$pageSize,
				"method"    => $baseUrl."&amp;start_rec=".($startRec+$pageSize)."&amp;page_size=".$pageSize
			);
			$prevLink = array(
				"startRec"  => $startRec-$pageSize,
				"method"    => $baseUrl."&amp;start_rec=".($startRec-$pageSize)."&amp;page_size=".$pageSize
			);
		}
		$pagingData = array(
			"recCount"	=> $recCount,
			"startRec"	=> $startRec,
			"curPageNo"	=> $currentPageNo,
			"pageSize"	=> $pageSize,
			"pagination"=> $pagination,
			"nextLink"	=> $nextLink,
			"prevLink"	=> $prevLink
		);
		return $pagingData;
	}
	
?>
