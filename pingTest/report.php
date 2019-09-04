<?php
	$dateFrom	= date('Y-m-01');
	$dateTo		= date('Y-m-d');
	if(isset($_POST['btnSubmit']))
	{
		$dateFrom	= (strtotime($_POST['txtDateFrom'])>0)?$_POST['txtDateFrom']:$dateFrom;
		$dateTo		= (strtotime($_POST['txtDateTo'])>0)?$_POST['txtDateTo']:$dateTo;
	}
	include('db.php');
	$lmsSql	= "SELECT date(timestamp) as date, sum(case when status = 'worked' then 1 else 0 end) as totalWorked, sum(case when status = 'failed' then 1 else 0 end) as totalFailed FROM t_sys_ping_report where portal = 'lms' AND (date(timestamp) BETWEEN '$dateFrom' AND '$dateTo') group by date(timestamp);";
	$lmsResult	= dbConnect($lmsSql);
	$egovSql	= "SELECT date(timestamp) as date, sum(case when status = 'worked' then 1 else 0 end) as totalWorked, sum(case when status = 'failed' then 1 else 0 end) as totalFailed FROM t_sys_ping_report where portal = 'egov' AND (date(timestamp) BETWEEN '$dateFrom' AND '$dateTo') group by date(timestamp);";
	$egovResult	= dbConnect($egovSql);
?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Downtime Report</title>
<style>
.panel.with-nav-tabs .panel-heading{
    padding: 5px 5px 0 5px;
}
.panel.with-nav-tabs .nav-tabs{
	border-bottom: none;
}
.panel.with-nav-tabs .nav-justified{
	margin-bottom: -1px;
}
/********************************************************************/
/*** PANEL DEFAULT ***/
.with-nav-tabs.panel-default .nav-tabs > li > a,
.with-nav-tabs.panel-default .nav-tabs > li > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li > a:focus {
    color: #777;
}
.with-nav-tabs.panel-default .nav-tabs > .open > a,
.with-nav-tabs.panel-default .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-default .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-default .nav-tabs > li > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li > a:focus {
    color: #777;
	background-color: #ddd;
	border-color: transparent;
}
.with-nav-tabs.panel-default .nav-tabs > li.active > a,
.with-nav-tabs.panel-default .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li.active > a:focus {
	color: #555;
	background-color: #fff;
	border-color: #ddd;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #f5f5f5;
    border-color: #ddd;
}
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #777;   
}
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #ddd;
}
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    color: #fff;
    background-color: #555;
}
/********************************************************************/
/*** PANEL PRIMARY ***/
.with-nav-tabs.panel-primary .nav-tabs > li > a,
.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
    color: #fff;
}
.with-nav-tabs.panel-primary .nav-tabs > .open > a,
.with-nav-tabs.panel-primary .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
	color: #fff;
	background-color: #3071a9;
	border-color: transparent;
}
.with-nav-tabs.panel-primary .nav-tabs > li.active > a,
.with-nav-tabs.panel-primary .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.active > a:focus {
	color: #428bca;
	background-color: #fff;
	border-color: #428bca;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #428bca;
    border-color: #3071a9;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #fff;   
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #3071a9;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    background-color: #4a9fe9;
}
/********************************************************************/
/*** PANEL SUCCESS ***/
.with-nav-tabs.panel-success .nav-tabs > li > a,
.with-nav-tabs.panel-success .nav-tabs > li > a:hover,
.with-nav-tabs.panel-success .nav-tabs > li > a:focus {
	color: #3c763d;
}
.with-nav-tabs.panel-success .nav-tabs > .open > a,
.with-nav-tabs.panel-success .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-success .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-success .nav-tabs > li > a:hover,
.with-nav-tabs.panel-success .nav-tabs > li > a:focus {
	color: #3c763d;
	background-color: #d6e9c6;
	border-color: transparent;
}
.with-nav-tabs.panel-success .nav-tabs > li.active > a,
.with-nav-tabs.panel-success .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-success .nav-tabs > li.active > a:focus {
	color: #3c763d;
	background-color: #fff;
	border-color: #d6e9c6;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #dff0d8;
    border-color: #d6e9c6;
}
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #3c763d;   
}
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #d6e9c6;
}
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    color: #fff;
    background-color: #3c763d;
}
/********************************************************************/
/*** PANEL INFO ***/
.with-nav-tabs.panel-info .nav-tabs > li > a,
.with-nav-tabs.panel-info .nav-tabs > li > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li > a:focus {
	color: #31708f;
}
.with-nav-tabs.panel-info .nav-tabs > .open > a,
.with-nav-tabs.panel-info .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-info .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-info .nav-tabs > li > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li > a:focus {
	color: #31708f;
	background-color: #bce8f1;
	border-color: transparent;
}
.with-nav-tabs.panel-info .nav-tabs > li.active > a,
.with-nav-tabs.panel-info .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li.active > a:focus {
	color: #31708f;
	background-color: #fff;
	border-color: #bce8f1;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #d9edf7;
    border-color: #bce8f1;
}
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #31708f;   
}
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #bce8f1;
}
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    color: #fff;
    background-color: #31708f;
}
/********************************************************************/
/*** PANEL WARNING ***/
.with-nav-tabs.panel-warning .nav-tabs > li > a,
.with-nav-tabs.panel-warning .nav-tabs > li > a:hover,
.with-nav-tabs.panel-warning .nav-tabs > li > a:focus {
	color: #8a6d3b;
}
.with-nav-tabs.panel-warning .nav-tabs > .open > a,
.with-nav-tabs.panel-warning .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-warning .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-warning .nav-tabs > li > a:hover,
.with-nav-tabs.panel-warning .nav-tabs > li > a:focus {
	color: #8a6d3b;
	background-color: #faebcc;
	border-color: transparent;
}
.with-nav-tabs.panel-warning .nav-tabs > li.active > a,
.with-nav-tabs.panel-warning .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-warning .nav-tabs > li.active > a:focus {
	color: #8a6d3b;
	background-color: #fff;
	border-color: #faebcc;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #fcf8e3;
    border-color: #faebcc;
}
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #8a6d3b; 
}
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #faebcc;
}
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    color: #fff;
    background-color: #8a6d3b;
}
/********************************************************************/
/*** PANEL DANGER ***/
.with-nav-tabs.panel-danger .nav-tabs > li > a,
.with-nav-tabs.panel-danger .nav-tabs > li > a:hover,
.with-nav-tabs.panel-danger .nav-tabs > li > a:focus {
	color: #a94442;
}
.with-nav-tabs.panel-danger .nav-tabs > .open > a,
.with-nav-tabs.panel-danger .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-danger .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-danger .nav-tabs > li > a:hover,
.with-nav-tabs.panel-danger .nav-tabs > li > a:focus {
	color: #a94442;
	background-color: #ebccd1;
	border-color: transparent;
}
.with-nav-tabs.panel-danger .nav-tabs > li.active > a,
.with-nav-tabs.panel-danger .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-danger .nav-tabs > li.active > a:focus {
	color: #a94442;
	background-color: #fff;
	border-color: #ebccd1;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #f2dede; /* bg color */
    border-color: #ebccd1; /* border color */
}
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #a94442; /* normal text color */  
}
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #ebccd1; /* hover bg color */
}
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    color: #fff; /* active text color */
    background-color: #a94442; /* active bg color */
}
</style>
<link href="./css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="./css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="./css/buttons.dataTables.min.css">
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="./css/datepicker.css">
<script src="./js/jquery.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script src="./js/jquery.dataTables.min.js"></script>
<script src="./js/bootstrap-datepicker.js"></script>
<script src="./js/dataTables.bootstrap.min.js"></script>
<script src="./js/dataTables.buttons.min.js"></script>
<script src="./js/jszip.min.js"></script>
<script src="./js/pdfmake.min.js"></script>
<script src="./js/vfs_fonts.js"></script>
<script src="./js/buttons.html5.min.js"></script>
<script type="text/javascript">
$(document).ready( function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [ {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data'
        },{
                extend: 'pdfHtml5',
				exportOptions: {// quali colonne vengono mandate in stampa (indice posizionale)
					columns: [ 0,1,2]
				},
				customize : function(doc){
				/*var colCount = new Array();
				$('#example').find('tbody tr:first-child td').each(function(){
					if($(this).attr('colspan')){
						for(var i=1;i<=$(this).attr('colspan');$i++){
							colCount.push('*');
						}
					}else{ colCount.push('*'); }
				});*/
				doc.content[1].table.widths = [ '*','*','*'];
			}
            }]
    } );
    $('#example2').DataTable( {
        dom: 'Bfrtip',
        buttons: [ {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data'
        },{
                extend: 'pdfHtml5',
				exportOptions: {// quali colonne vengono mandate in stampa (indice posizionale)
					columns: [ 0,1,2]
				},
				customize : function(doc){
				/*var colCount = new Array();
				$('#example').find('tbody tr:first-child td').each(function(){
					if($(this).attr('colspan')){
						for(var i=1;i<=$(this).attr('colspan');$i++){
							colCount.push('*');
						}
					}else{ colCount.push('*'); }
				});*/
				doc.content[1].table.widths = [ '*','*','*'];
			}
            } ]
    } );
	
	
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
			format: 'yyyy-mm-dd',
        });
} );
</script>
</head>
<body>
<form method="post" name="frmReport" enctype="multipart/form-data">
<!------ Include the above in your HEAD tag ---------->
<div class="container">
  <div class="page-header">
    <h1>Downtime Report</h1>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel with-nav-tabs panel-info">
		  <div class="pull-right m-t-xs">
			<div>
				<div class="col-sm-5">
					<input type="text" class="form-control date-picker" id="txtDateFrom" name="txtDateFrom" value="<?php echo $dateFrom;?>">
				</div>
				<div class="col-sm-5">
					<input type="text" class="form-control date-picker" id="txtDateTo" name="txtDateTo" value="<?php echo $dateTo;?>">
				</div>
				<div class="col-sm-2">
					<input type="submit" class="btn btn-success" name="btnSubmit" value="Search"> 
				</div>
			</div>
		  </div>
        <div class="panel-heading">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1info" data-toggle="tab">LMS</a></li>
            <li><a href="#tab2info" data-toggle="tab">eGOV</a></li>
          </ul>
        </div>
        <div class="panel-body">
          <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1info">
				<?php if($lmsResult->num_rows>0){?>
				<table id="example" class="table table-bordered">
					<thead>
						<tr>
							<th width="90">Sl No.</th>
							<th>Date</th>
							<th>Total Downtime</th>
							<th>Details</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$ctrLms	= 0;
							while($lmsRow = $lmsResult->fetch_array()){
								$ctrLms++;
						?>
						<tr>
							<td><?php echo $ctrLms;?></td>
							<td><?php echo date('d M Y',strtotime($lmsRow['date']));?></td>
							<td><?php echo $lmsRow['totalFailed'];?> Min.</td>
							<td><a class="btn btn-info btn-xs" href="./report-details.php?date=<?php echo date('Ymd',strtotime($lmsRow['date']));?>&portal=lms">View</a></td>
						</tr>				
						<?php }?>
					</tbody>
				</table>
				<?php }else{?>
				<div class="text-center noRecord"><h1>No Record Found</h1></div>
				<?php }?>
			</div>
            <div class="tab-pane fade" id="tab2info">
				<?php if($egovResult->num_rows>0){?>
				<table id="example2" class="table table-bordered">
					<thead>
						<tr>
							<th width="90">Sl No.</th>
							<th>Date</th>
							<th>Total Downtime</th>
							<th>Details</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$ctrEgov	= 0;
							while($egovRow = $egovResult->fetch_array()){
								$ctrEgov++;
						?>
						<tr>
							<td><?php echo $ctrEgov;?></td>
							<td><?php echo date('d M Y',strtotime($egovRow['date']));?></td>
							<td><?php echo $egovRow['totalFailed'];?> Min.</td>
							<td><a class="btn btn-info btn-xs" href="./report-details.php?date=<?php echo date('Ymd',strtotime($egovRow['date']));?>&portal=egov">View</a></td>
						</tr>				
						<?php }?>
					</tbody>
				</table>
				<?php }else{?>
				<div class="text-center noRecord"><h1>No Record Found</h1></div>
				<?php }?>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
</body>
</html>
