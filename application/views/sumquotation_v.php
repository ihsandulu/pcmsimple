<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");
	$dari=date("Y-m-d");
	$ke=date("Y-m-d");
	if(isset($_GET['dari'])){$dari=$_GET['dari'];}
	if(isset($_GET['ke'])){$ke=$_GET['ke'];}
	?>
  
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Summary Quotation</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Summary Quotation From <label style="font-size:12px; color:#000066;"><?=$dari;?></label> To <label style="font-size:12px; color:#000066;"><?=$ke;?></label></h1>
			</div>
			
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadpoc_picture;?>
							</div>
							<?php }?>
							<div class="box">
							<div style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
							<form class="form-inline">
							  <div class="form-group">
								<label for="email">From:</label>
								<input type="text" class="form-control date" name="dari" value="<?=$dari;?>">
							  </div>
							  <div class="form-group">
								<label for="pwd">To:</label>
								<input type="text" class="form-control date" name="ke" value="<?=$ke;?>">
							  </div>
							  <?php if(isset($_GET['report'])){?>
							 	<input type="hidden" name="report" value="ok">
							 <?php }?>
							  <button style="margin-right:30px;" type="submit" class="btn btn-default">Search</button>				  
							 <a target="_blank" href="<?=site_url("sumquotationprint?dari=".$dari."&ke=".$ke);?>" class="btn btn-warning fa fa-print"> Print</a>
							 
							</form>						
							</div>
								<div id="collapse4" class="body table-respocnsive">				
								<table id="dataTable" class="table table-condensed table-hover table-bordered">
									<thead>
										<tr>
											<th rowspan="2">No.</th>
											<th colspan="3">Quotation </th>
											<th colspan="2">PO</th>
											<th colspan="2">Customer</th>
										</tr>
										<tr>
										  <th>Date Quotation</th>
									      <th>Quotation No.</th>
									      <th>Status</th>
									      <th>Date PO </th>
									      <th>PO No. </th>
									      <th>Name</th>
									      <th>CP</th>
									  </tr>
									</thead>
									<tbody> 
										<?php 
										
										$usr=$this->db
										->join("quotation","quotation.quotation_no=poc.quotation_no","left")
										->join("project","project.project_id=poc.project_id","left")
										->join("customer","customer.customer_id=poc.customer_id","left")
										->where("quotation.quotation_date >=",$dari)
										->where("quotation.quotation_date <=",$ke)
										->group_by("quotation.quotation_no")
										->order_by("poc_id","desc")
										->get("poc");
										//echo $this->db->last_query();
										foreach($usr->result() as $poc){?>
										<tr>											
											<td><?=$poc->quotation_date;?></td>
											<td><?=$poc->quotation_no;?></td>
											<td><?=$poc->quotation_status;?></td>
											<td><?=$poc->poc_date;?></td>
											<td><?=$poc->poc_no;?></td>
											<td><?=$poc->customer_name;?></td>
										    <td><?=$poc->customer_cp;?></td>
										</tr>
										<?php }?>
									</tbody>
								</table>
								</div>
							</div>
						
					</div>
				</div>
			</div>
		</div>
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
