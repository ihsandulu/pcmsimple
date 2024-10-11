<!DOCTYPE html>
<html>
	<head>
		<title>Print SJ Keluar</title>
		<meta charset="utf-8">
		<meta name="viewinvsrt" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
		<?php	
			$dari=date("Y-m-d");
			$ke=date("Y-m-d");	
			$supplier_id=0;
			$branch_id=0;
			if(isset($_GET['from'])){$dari=$_GET['from'];}
			if(isset($_GET['to'])){$ke=$_GET['to'];}
			if(isset($_GET['supplier_id'])){$supplier_id=$_GET['supplier_id'];}
			if(isset($_GET['branch_id'])){$branch_id=$_GET['branch_id'];}
		?>
		
		<style>
			tr>th{text-align:center !important;}
		</style>
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
	
		<div class="col-md-12">
		  <h1 style="text-decoration:underline;">Invoice Supplier List </h1>
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1"></div>
		<div style="">&nbsp;<br/><br/></div>
		
			<div class="col-md-12" style="padding:0px; ">		
			  <table id="dataTable" class="table table-condensed table-hover table-bordered">
									<thead>
										<tr>
											<th rowspan="2">No.</th>
										  	<th colspan="2">Project</th>
											<th colspan="8">Invoice</th>
											<th colspan="4">Payment</th>
											<th rowspan="2">Debt</th>
										</tr>
										<tr>
										  <th>Name</th>
										  <th>Supplier</th>
										  <th>Branch</th>
										  <th>Date</th>
										  <th>Due Date</th>
										  <th>No.</th>
									      <th>Amount</th>
									      <th>Disc</th>
									      <th>Vat</th>
									      <th>Total</th>
									      <th>Method</th>
									      <th>Date</th>
									      <th>Amount</th>
									      <th>Total</th>
									  </tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['supplier_id'])&&$_GET['supplier_id']>0){
											$this->db->where("invs.supplier_id",$supplier_id);
										}
										if(isset($_GET['branch_id'])&&$_GET['branch_id']>0){
											$this->db->where("invs.branch_id",$branch_id);
										}
										$usr=$this->db
										->join("branch","branch.branch_id=invs.branch_id","left")
										->join("project","project.project_id=invs.project_id","left")
										->join("supplier","supplier.supplier_id=invs.supplier_id","left")
										->join("invspayment","invspayment.invs_no=invs.invs_no","left")
										->join("methodpayment","methodpayment.methodpayment_id=invspayment.methodpayment_id","left")
										->where("invspayment_date >=",$dari)
										->where("invspayment_date <=",$ke)
										->group_by("invspayment_no")
										->order_by("invs_id","desc")
										->order_by("invspayment_date","asc")
										->get("invs");
										
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $invspayment){
										
										 $project=$invspayment->project_name;
										 $supplier=$invspayment->supplier_name;
										 $branch=$invspayment->branch_name;
										 $dateinvs=$invspayment->invs_date;
										 $duedateinvs=$invspayment->invs_duedate;
										 $invsno=$invspayment->invs_no;	
										 $invs_disc=$invspayment->invs_disc;
										 $invs_vat=$invspayment->invs_vat;
										
										
										 
										 
										
										
										
										//payment
										$invs_pamount=0;
										$rspan=0;
										$pa=$this->db->select("*,SUM(invspaymentproduct_amount*invspaymentproduct_qty)As invs_pamount,")
										->where("invspayment_no",$invspayment->invspayment_no)
										->group_by("invspayment_no")
										->get("invspaymentproduct");
										//echo $this->db->last_query();
										if($pa->num_rows()>0){$invs_pamount=$pa->row()->invs_pamount;}
										
										//total payment
										$tpamount=0;
										$tp=$this->db
										->select("*, SUM(invs_pamount)As tinvs_pamount")
										->join("(SELECT *,SUM(invspaymentproduct_amount*invspaymentproduct_qty)As invs_pamount FROM invspaymentproduct GROUP BY invspayment_no)As invspaymentproduct","invspaymentproduct.invspayment_no=invspayment.invspayment_no","left")
										->where("invs_no",$invsno)
										//->group_by("invspayment_no")
										->order_by("invspayment_date","asc")
										->get("invspayment");
										foreach($tp->result() as $tpa){$tpamount=$tpa->tinvs_pamount;}
										
										
										//invoice
										$invs_amount=0;
										$invs=$this->db
										->select("*,SUM(invsproduct_price*invsproduct_qty)As invs_amount")
										->where("invs_no",$invspayment->invs_no)
										->group_by("invsproduct_price")
										->get("invsproduct");
										if($invs->num_rows()>0){
											
											$invs_mount = $invs->row()->invs_amount;
											$disc = ($invs_mount * $invs_disc / 100);
											$invs_amount_disc = $invs_mount - $disc;
											$vat = $invs_mount * $invs_vat / 100;
											$invs_amount = $invs_amount_disc + $vat;
											
										}
										
										$rowspan=$this->db
										->where("invs_no",$invsno)
										->order_by("invspayment_id","desc")
										->get("invspayment");
										$rspan=$rowspan->num_rows();
										if($no==1){
										?>
										<tr>
											<td><?=$no++;?></td>
										  	<td rowspan="<?=$rspan;?>"><?=$project;?></td>
											<td rowspan="<?=$rspan;?>"><?=$supplier;?></td>
											<td rowspan="<?=$rspan;?>"><?=$branch;?></td>
											<td rowspan="<?=$rspan;?>"><?=$dateinvs;?></td>
											<td rowspan="<?=$rspan;?>"><?=$duedateinvs;?></td>
											<td rowspan="<?=$rspan;?>"><?=$invsno;?></td>
											<td rowspan="<?=$rspan;?>"><?=number_format($invs_mount,0,",",".");?></td>
											<td rowspan="<?=$rspan;?>"><?=number_format($disc,0,",",".");?></td>
											<td rowspan="<?=$rspan;?>"><?=number_format($vat,0,",",".");?></td>
											<td rowspan="<?=$rspan;?>"><?=number_format($invs_amount,0,",",".");?></td>
											<td><?=$invspayment->methodpayment_name;?></td>
											<td><?=$invspayment->invspayment_date;?></td>
											<td><?=number_format($invs_pamount,0,",",".");?></td>
											<td rowspan="<?=$rspan;?>"><?=number_format($tpamount,0,",",".");?></td>
											<td rowspan="<?=$rspan;?>"><?=number_format($invs_amount-$tpamount,0,",",".");?></td>
										</tr>
										<?php }else{?>
										<tr>
										  <td><?=$invspayment->methodpayment_name;?></td>
										  <td><?=$invspayment->invspayment_date;?></td>
										  <td><?=number_format($invs_pamount,0,",",".");?></td>
										</tr>
										<?php 
										}
										if($no==$rspan){$no=1;}else{$no++;}
										}?>
									</tbody>
								</table>
	  </div>
			<div class="col-md-12">&nbsp;</div>
		
		
		
			<div class="col-md-2 col-sm-2 col-xs-2">&nbsp;</div>
			
		
		
			<div class="col-md-12">&nbsp;</div>
		
		
	
		
				
		
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>