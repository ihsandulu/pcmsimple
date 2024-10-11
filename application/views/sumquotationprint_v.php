<!DOCTYPE html>
<html>
	<head>
		<title>Print Invoice Supplier</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
		<?php 	
		$dari=date("Y-m-d");
		$ke=date("Y-m-d");
		if(isset($_GET['dari'])){$dari=$_GET['dari'];}
		if(isset($_GET['ke'])){$ke=$_GET['ke'];}
		?>
	</head>
	<body>
	<div class="container">
	<div class="row">
		      
	<?php 
	$identity=$this->db->get("identity")->row();
	if($identity->identity_kop==1){
		require_once("kop.php");
	}
	?>
	
		<div class="col-md-12"><h3 style="">Summary Quotation From <label style="font-size:25px; color:#000066; font-weight:bold;"><?=$dari;?></label> To <label style="font-size:25px; color:#000066; font-weight:bold;"><?=$ke;?></label></h3></div>
		
		<div style="">&nbsp;<br/><br/></div>
		
			<div class="col-md-12" style="padding:0px; ">		
			  <table id="dataTable" class="table table-condensed table-hover table-bordered">
									<thead>
										<tr>
											<th>No.</th>
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
										$no=1;
										foreach($usr->result() as $poc){?>
										<tr>		
											<td><?=$no++;?></td>									
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
			<div class="col-md-12">&nbsp;</div>
		
			
	
		
				
		
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>