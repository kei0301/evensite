<?php require_once 'inc/config.php'; $template['header']='';?>
<?php 
	if(!isset($_SESSION["user"]) || !isset($_SESSION["user"]["user_id"]) || empty($_SESSION["user"]["user_id"])){
		doRedirect("login.php");
	}
	$pageTitle = "Sales Report / تقرير المبيعات";

?>
<?php require_once 'inc/page_menu.php'; ?>
<div class="content-header">
	<div class="header-section">
		<h1><?php echo $pageTitle; ?></h1>
		<?php if(!empty($alertMsg)) { ?><div class="alert alert-<?php echo $alertType; ?>"><?php echo $alertMsg; ?></div><?php } ?>
	</div>
</div>
<style>
table, td, th {    
    border: 1px solid #ddd;
    text-align: left;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 15px;
}
thead tr td{
    font-size: 16px;
    font-weight: 700;
    text-align: center;
}
</style>

<?php 
$currentDay = date('Y-m-d');
$previousDay = date('Y-m-d', strtotime('-1 Days'));
$currentWeekStart = date('Y-m-d',strtotime('last monday'));
$currentWeekEnd = date('Y-m-d',strtotime('next sunday'));

$monday = strtotime("last monday");
$monday = date('W', $monday)==date('W') ? $monday-7*86400 : $monday;
 
$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
$previousWeekStart = date("Y-m-d",$monday);
$previousWeekEnd = date("Y-m-d",$sunday);

$currentMonthStart = date('Y-m-01');
$currentMonthEnd = date('Y-m-t');
$previousMonthStart = date("Y-n-j", strtotime("first day of previous month"));
$previousMonthEnd = date("Y-n-j", strtotime("last day of previous month"));
$currentYearStart = date('Y-01-01');
$currentYearEnd = date('Y-12-31');

$previousYearStart = date("Y-m-d",strtotime("last year January 1st"));
$previousYearEnd = date("Y-m-d",strtotime("last year December 31st"));

$todaySalesQuery = mysql_query("SELECT COUNT(id) as NoOfSales, SUM(price_total) as AmountDiscounted, SUM(price_paid) as PaidOrders FROM `order` WHERE `order_date` >= '".$currentDay."' ");
$todayTotalSales = mysql_fetch_row($todaySalesQuery);

$currentWeekSalesQuery = mysql_query("SELECT COUNT(id) as NoOfSales, SUM(price_total) as AmountDiscounted, SUM(price_paid) as PaidOrders FROM `order` WHERE `order_date` BETWEEN '".$currentWeekStart."' AND '".$currentWeekEnd."' ");
$currentWeekTotalSales = mysql_fetch_row($currentWeekSalesQuery);

$currentMonthSalesQuery = mysql_query("SELECT COUNT(id) as NoOfSales, SUM(price_total) as AmountDiscounted, SUM(price_paid) as PaidOrders FROM `order` WHERE `order_date` BETWEEN '".$currentMonthStart."' AND '".$currentMonthEnd."' ");
$currentMonthTotalSales = mysql_fetch_row($currentMonthSalesQuery);

$currentYearSalesQuery = mysql_query("SELECT COUNT(id) as NoOfSales, SUM(price_total) as AmountDiscounted, SUM(price_paid) as PaidOrders FROM `order` WHERE `order_date` BETWEEN '".$currentYearStart."' AND '".$currentYearEnd."' ");
$currentYearTotalSales = mysql_fetch_row($currentYearSalesQuery);

$previousDaySalesQuery = mysql_query("SELECT COUNT(id) as NoOfSales, SUM(price_total) as AmountDiscounted, SUM(price_paid) as PaidOrders FROM `order` WHERE `order_date` BETWEEN  '".$previousDay."' AND '".$currentDay."'");
$previousDayTotalSales = mysql_fetch_row($previousDaySalesQuery);

$previousWeekSalesQuery = mysql_query("SELECT COUNT(id) as NoOfSales, SUM(price_total) as AmountDiscounted, SUM(price_paid) as PaidOrders FROM `order` WHERE `order_date` BETWEEN '".$previousWeekStart."' AND '".$previousWeekEnd."' ");
$previousWeekTotalSales = mysql_fetch_row($previousWeekSalesQuery);

$previousMonthSalesQuery = mysql_query("SELECT COUNT(id) as NoOfSales, SUM(price_total) as AmountDiscounted, SUM(price_paid) as PaidOrders FROM `order` WHERE `order_date` BETWEEN '".$previousMonthStart."' AND '".$previousMonthEnd."' ");
$previousMonthTotalSales = mysql_fetch_row($previousMonthSalesQuery);

$previousYearSalesQuery = mysql_query("SELECT COUNT(id) as NoOfSales, SUM(price_total) as AmountDiscounted, SUM(price_paid) as PaidOrders FROM `order` WHERE `order_date` BETWEEN '".$previousYearStart."' AND '".$previousYearEnd."' ");
$previousYearTotalSales = mysql_fetch_row($previousYearSalesQuery);
?>
<div class="block full block-alt-noblabel">
    <div class="clearfix"></div>
    <div class="row">
        <!-- Today Sales --> 
        <div class="col-md-3">           
            <table border=1 cellpadding="0px" cellspacing="0px" width="40%" align="center">
                <thead>
                    <td colspan="3" align="center">Today's Sales</td>
                </thead>
                <tbody>
                    <tr align="center">
                        <td>Total Sales</td>
                        <td>Total Amount</td>
                        <td>Total Paid</td>
                    </tr>
                    <tr align="center" class="slary">
                        <td><?php echo $todayTotalSales[0]; ?></td>
                        <td><?php if($todayTotalSales[1]!= '') { echo $todayTotalSales[1]; } else { echo '0.00'; } ?></td>
                        <td><?php if($todayTotalSales[2]!= '') { echo $todayTotalSales[2]; } else { echo '0.00'; } ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Total Current Week Sales -->
        <div class="col-md-3">           
            <table border=1 cellpadding="0px" cellspacing="0px" width="40%" align="center">
                <thead>
                    <td colspan="3" align="center">Current Week Sales</td>
                </thead>
                <tbody>
                    <tr align="center">
                        <td>Total Sales</td>
                        <td>Total Amount</td>
                        <td>Total Paid</td>
                    </tr>
                    <tr align="center" class="slary">
                        <td><?php echo $currentWeekTotalSales[0]; ?></td>
                        <td><?php if($currentWeekTotalSales[1] != '') { echo $currentWeekTotalSales[1]; } else{ echo '0.00'; } ?></td>
                        <td><?php if($currentWeekTotalSales[2] != '') { echo $currentWeekTotalSales[2]; } else{ echo '0.00'; } ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Total Current Month Sales -->
        <div class="col-md-3">           
            <table border=1 cellpadding="0px" cellspacing="0px" width="40%" align="center">
                <thead>
                    <td colspan="3" align="center">Current Month Sales</td>
                </thead>
                <tbody>
                    <tr align="center">
                        <td>Total Sales</td>
                        <td>Total Amount</td>
                        <td>Total Paid</td>
                    </tr>
                    <tr align="center" class="slary">
                        <td><?php echo $currentMonthTotalSales[0]; ?></td>
                        <td><?php if($currentMonthTotalSales[1] != '') { echo $currentMonthTotalSales[1]; } else{ echo '0.00'; } ?></td>
                        <td><?php if($currentMonthTotalSales[2] != '') { echo $currentMonthTotalSales[2]; } else{ echo '0.00'; } ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Total Current Year Sales -->
        <div class="col-md-3">           
            <table border=1 cellpadding="0px" cellspacing="0px" width="40%" align="center">
                <thead>
                    <td colspan="3" align="center">Current Year Sales</td>
                </thead>
                <tbody>
                    <tr align="center">
                        <td>Total Sales</td>
                        <td>Total Amount</td>
                        <td>Total Paid</td>
                    </tr>
                    <tr align="center" class="slary">
                        <td><?php echo $currentYearTotalSales[0]; ?></td>
                        <td><?php if($currentYearTotalSales[1] != '') { echo $currentYearTotalSales[1]; } else{ echo '0.00'; } ?></td>
                        <td><?php if($currentYearTotalSales[2] != '') { echo $currentYearTotalSales[2]; } else{ echo '0.00'; } ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
 
    </div>
    <br /><br />
    <div class="row"> 
        <!-- Previous Day Total Sales -->
        <div class="col-md-3">           
            <table border=1 cellpadding="0px" cellspacing="0px" width="40%" align="center">
                <thead>
                    <td colspan="3" align="center">Previous Day Sales</td>
                </thead>
                <tbody>
                    <tr align="center">
                        <td>Total Sales</td>
                        <td>Total Amount</td>
                        <td>Total Paid</td>
                    </tr>
                    <tr align="center" class="slary">
                        <td><?php echo $previousDayTotalSales[0]; ?></td>
                        <td><?php if($previousDayTotalSales[1] != '') { echo $previousDayTotalSales[1]; } else{ echo '0.00'; } ?></td>
                        <td><?php if($previousDayTotalSales[2] != '') { echo $previousDayTotalSales[2]; } else{ echo '0.00'; } ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Previous Week Total Sales-->
        <div class="col-md-3">           
            <table border=1 cellpadding="0px" cellspacing="0px" width="40%" align="center">
                <thead>
                    <td colspan="3" align="center">Previous Week Sales</td>
                </thead>
                <tbody>
                    <tr align="center">
                        <td>Total Sales</td>
                        <td>Total Amount</td>
                        <td>Total Paid</td>
                    </tr>
                    <tr align="center" class="slary">
                        <td><?php echo $previousWeekTotalSales[0]; ?></td>
                        <td><?php if($previousWeekTotalSales[1] != '') { echo $previousWeekTotalSales[1]; } else{ echo '0.00'; } ?></td>
                        <td><?php if($previousWeekTotalSales[2] != '') { echo $previousWeekTotalSales[2]; } else{ echo '0.00'; } ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Previous Month Total Sales -->
        <div class="col-md-3">           
            <table border=1 cellpadding="0px" cellspacing="0px" width="40%" align="center">
                <thead>
                    <td colspan="3" align="center">Previous Month Sales</td>
                </thead>
                <tbody>
                    <tr align="center">
                        <td>Total Sales</td>
                        <td>Total Amount</td>
                        <td>Total Paid</td>
                    </tr>
                    <tr align="center" class="slary">
                        <td><?php echo $previousMonthTotalSales[0]; ?></td>
                        <td><?php if($previousMonthTotalSales[1] != '') { echo $previousMonthTotalSales[1]; } else{ echo '0.00'; } ?></td>
                        <td><?php if($previousMonthTotalSales[2] != '') { echo $previousMonthTotalSales[2]; } else{ echo '0.00'; } ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Previous Year Total Sales -->
        <div class="col-md-3">           
            <table border=1 cellpadding="0px" cellspacing="0px" width="40%" align="center">
                <thead>
                    <td colspan="3" align="center">Previous Year Sales</td>
                </thead>
                <tbody>
                    <tr align="center">
                        <td>Total Sales</td>
                        <td>Total Amount</td>
                        <td>Total Paid</td>
                    </tr>
                    <tr align="center" class="slary">
                        <td><?php echo $previousYearTotalSales[0]; ?></td>
                        <td><?php if($previousYearTotalSales[1] != '') { echo $previousYearTotalSales[1]; } else{ echo '0.00'; } ?></td>
                        <td><?php if($previousYearTotalSales[2] != '') { echo $previousYearTotalSales[2]; } else{ echo '0.00'; } ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
 
    </div>
    <br><br>
    <div class="row">
        <h2>Filter Record By Date Range</h2>
        <form method="post" id="filterForm" onsubmit="return false;">
            <div class="form-group col-sm-4">
                <label for="from">From</label>
                <input type="text" id="from" name="from" value="" class="form-control" autocomplete="off">
            </div>
            <div class="form-group col-sm-4">
                <label for="to">to</label>
                <input type="text" id="to" name="to"  class="form-control" autocomplete="off">
            </div>
            <div clas="col-sm-4">
                <input type="submit" name="submit" value="Search" class="btn btn-success" style="margin-top:23px;">
            </div>
        </form>
    </div>
    <div class="row">
        <div id="filterRecord" style="font-size:20px;"></div>
    </div>
    <div class="row print-option" style="margin-top:20px; margin-left:2px;">
    </div>
</div>


<script>
$( function() {
    var dateFormat = "yy-mm-dd",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
} );

$(document).on('submit', '#filterForm',function () {
    var from = $('#from').val();
    var to = $('#to').val();
    $('#filterRecord').html('');
    
    if($('#filterRecord').hasClass('alert-danger'))
    {
       $('#filterRecord').removeClass('alert alert-danger'); 
    }
    if(from == '')
    {
        $('#filterRecord').html('Please select from date');
        $('#filterRecord').addClass('alert alert-danger');
        return false;
    }
    if(to == '')
    {
        $('#filterRecord').html('Please select to date');
        $('#filterRecord').addClass('alert alert-danger');
        return false;
    }
    var explodeFrom = from.split('/');
    var newFrom = explodeFrom[2]+'-'+explodeFrom[0]+'-'+explodeFrom[1];
    var explodeTo = to.split('/');
    var newTo = explodeTo[2]+'-'+explodeTo[0]+'-'+eval(Number(explodeTo[1])+1);
    
    var fetchFrom = new Date(newFrom);
    var fetchTo = new Date(newTo);
    if(fetchTo<fetchFrom)
    {
        $('#filterRecord').html('To date must be equal to and greater then From date.');
        $('#filterRecord').addClass('alert alert-danger');
        return false;
    }
    $.ajax({
        method: 'POST',
        url: 'getfilterdata.php',
        data: {from: newFrom, to: newTo},
        success: function(result)
        {
            $('#filterRecord').html(result);
            $('.print-option').html('<a href="fetch_print.php?from='+newFrom+'&to='+newTo+'" target="_blank" onclick="printUrl(\'fetch_print.php?from='+newFrom+'&to='+newTo+'\'); return false;;" class="btn btn-info">Print</a>');
        }
    });
});

/*function printDiv(){
    
    var divName = 'filterRecord';
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    $( function() {
        var dateFormat = "yy-mm-dd",
          from = $( "#from" )
            .datepicker({
              defaultDate: "+1w",
              changeMonth: true,
              numberOfMonths: 1
            })
            .on( "change", function() {
              to.datepicker( "option", "minDate", getDate( this ) );
            }),
          to = $( "#to" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1
          })
          .on( "change", function() {
            from.datepicker( "option", "maxDate", getDate( this ) );
          });
     
        function getDate( element ) {
          var date;
          try {
            date = $.datepicker.parseDate( dateFormat, element.value );
          } catch( error ) {
            date = null;
          }
     
          return date;
        }
    } );
}*/
</script>