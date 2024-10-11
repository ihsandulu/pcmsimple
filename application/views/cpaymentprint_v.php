<!DOCTYPE html>
<html>
	<head>
		<title>Print Customer Payment</title>
		<meta charset="utf-8">
		<meta name="viewinvrt" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
		<?php	
			$dari=date("Y-m-d");
			$ke=date("Y-m-d");
			$customer_id=0;
			$branch_id=0;
			if(isset($_GET['from'])){$dari=$_GET['from'];}
			if(isset($_GET['to'])){$ke=$_GET['to'];}
			if(isset($_GET['customer_id'])){$customer_id=$_GET['customer_id'];}
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
		  <h1 style="text-decoration:underline;">Invoice Customer List </h1>
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
										  <th>Customer</th>
										  <th>Branch</th>
										  <th>Date</th>
										  <th>Due Date</th>
										  <th>No.</th>
									      <th>Amount</th>
									      <th>PPN 10%</th>
									      <th>PPH 2%</th>
									      <th>Total</th>
									      <th>Method</th>
									      <th>Date</th>
									      <th>Amount</th>
									      <th>Total</th>
									  </tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['customer_id'])&&$_GET['customer_id']>0){
											$this->db->where("project.customer_id",$customer_id);
										}
										if(isset($_GET['branch_id'])&&$_GET['branch_id']>0){
											$this->db->where("inv.branch_id",$branch_id);
										}
										$usr=$this->db
										->join("branch","branch.branch_id=inv.branch_id","left")
										->join("project","project.project_id=inv.project_id","left")
										->join("customer","customer.customer_id=project.customer_id","left")
										->join("invpayment","invpayment.inv_no=inv.inv_no","left")
										->join("methodpayment","methodpayment.methodpayment_id=invpayment.methodpayment_id","left")
										->where("invpayment_date >=",$dari)
										->where("invpayment_date <=",$ke)
										->group_by("invpayment_no")
										->order_by("inv_id","desc")
										->order_by("invpayment_date","asc")
										->get("inv");
										
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $invpayment){
										
										 $project=$invpayment->project_name;
										 $customer=$invpayment->customer_name;
										 $dateinv=$invpayment->inv_date;
										 $branch=$invpayment->branch_name;
										 $duedateinv=$invpayment->inv_duedate;
										 $invno=$invpayment->inv_no;	
										 
										 $inppn=$this->db
										 ->where("inv_no",$invno)
										 ->where("inv_customize",2)
										 ->get("inv");
										 if($inppn->num_rows()>0){$invppn="ok";}else{$invppn="";}
										 
										 
										  $inpph=$this->db
										 ->where("inv_no",$invno)
										 ->where("inv_customize",3)
										 ->get("inv");
										 if($inpph->num_rows()>0){$invpph="ok";}else{$invpph="";}	
										
										
										//payment
										$inv_pamount=0;
										$rspan=0;
										$pa=$this->db->select("*,SUM(invpaymentproduct_amount*invpaymentproduct_qty)As inv_pamount,")
										->where("invpayment_no",$invpayment->invpayment_no)
										->group_by("invpayment_no")
										->get("invpaymentproduct");
										//echo $this->db->last_query();
										if($pa->num_rows()>0){$inv_pamount=$pa->row()->inv_pamount;}
										
										//total payment
										$tpamount=0;
										$tp=$this->db
										->select("*, SUM(inv_pamount)As tinv_pamount")
										->join("(SELECT *,SUM(invpaymentproduct_amount*invpaymentproduct_qty)As inv_pamount FROM invpaymentproduct GROUP BY invpayment_no)As invpaymentproduct","invpaymentproduct.invpayment_no=invpayment.invpayment_no","left")
										->where("inv_no",$invno)
										//->group_by("invpayment_no")
										->order_by("invpayment_date","asc")
										->get("invpayment");
										foreach($tp->result() as $tpa){$tpamount=$tpa->tinv_pamount;}
										
										
										//invoice
										$inv_amount=0;
										$inv=$this->db
										->select("*,SUM(invproduct_price*invproduct_qty)As inv_amount")
										->where("inv_no",$invpayment->inv_no)
										->group_by("invproduct_price")
										->get("invproduct");
										if($inv->num_rows()>0){
											if($invppn=="ok"){
												$ppn=$inv->row()->inv_amount*10/100;
											}else{
												$ppn=0;
											}
											if($invpph=="ok"){
												$pph=$inv->row()->inv_amount*2/100;
											}else{
												$pph=0;
											}
											$amount=$inv->row()->inv_amount;
											$inv_amount=$amount+$ppn-$pph;
										}
										
										$rowspan=$this->db
										->where("inv_no",$invno)
										->get("invpayment");
										$rspan=$rowspan->num_rows();
										if($no==1){
										?>
										<tr>
											<td><?=$no++;?></td>
										  	<td rowspan="<?=$rspan;?>"><?=$project;?></td>
											<td rowspan="<?=$rspan;?>"><?=$customer;?></td>
											<td rowspan="<?=$rspan;?>"><?=$branch;?></td>
											<td rowspan="<?=$rspan;?>"><?=$dateinv;?></td>
											<td rowspan="<?=$rspan;?>"><?=$duedateinv;?></td>
											<td rowspan="<?=$rspan;?>"><?=$invno;?></td>
											<td rowspan="<?=$rspan;?>"><?=number_format($amount,0,",",".");?></td>
											<td rowspan="<?=$rspan;?>"><?=number_format($ppn,0,",",".");?></td>
											<td rowspan="<?=$rspan;?>"><?=number_format($pph,0,",",".");?></td>
											<td rowspan="<?=$rspan;?>"><?=number_format($inv_amount,0,",",".");?></td>
											<td><?=$invpayment->methodpayment_name;?></td>
											<td><?=$invpayment->invpayment_date;?></td>
											<td><?=number_format($inv_pamount,0,",",".");?>
										    <?=number_format($tpamount,0,",",".");?></td>
											<td rowspan="<?=$rspan;?>">&nbsp;</td>
											<td rowspan="<?=$rspan;?>"><?=number_format($inv_amount-$tpamount,0,",",".");?></td>
										</tr>
										<?php }else{?>
										<tr>
										  <td><?=$invpayment->methodpayment_name;?></td>
										  <td><?=$invpayment->invpayment_date;?></td>
										  <td><?=number_format($inv_pamount,0,",",".");?></td>
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