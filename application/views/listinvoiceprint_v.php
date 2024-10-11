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
			$identity=$this->db->get("identity")->row();
			if(isset($_REQUEST["awal"])){
		$dari="";
		$ke="";
		}elseif(isset($_REQUEST["dari"])){
			$dari=$_REQUEST["dari"];
			$ke=$_REQUEST["ke"];
		}else{
			$dari=date("Y-m-d");
			$ke=date("Y-m-d");
		}
		if(isset($_REQUEST["project"])){
			$project=$_REQUEST["project"];
		}else{
			$project="";
		}
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
	
		<div class="col-md-12 col-sm-12 col-xs-12">
		  <h1 style="text-decoration:underline;">Invoice Customer List </h1>
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1"></div>
		<div style="">&nbsp;<br/><br/></div>
		
			<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px; ">		
			  <table id="dataTableinv" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Branch</th>
											<th>Invoice No. </th>
											<th>Customer</th>
											<?php if($identity->identity_project=="1"){?>
											<th>Project</th>
											<?php }?>
											<th>PO No.</th>
											<th>Amount</th>
											<th>Payment</th>
											<th>Receivables (Piutang) </th>
											<?php if(!isset($_GET['report'])){$col="col-md-3";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										$tinvoice=0;
										$tpembayaran=0;
										$tpiutang=0;
										
										$lock=$this->db->get("identity")->row()->identity_lockproduct;
										
										if(isset($_GET['dari'])){
											$this->db->where("inv_date >=",$this->input->get("dari"));
										}elseif(isset($_GET['awal'])){
											
										}else{
											$this->db->where("inv_date >=",date("Y-m-d"));
										}
										
										if(isset($_GET['ke'])){
											$this->db->where("inv_date <=",$this->input->get("ke"));
										}elseif(isset($_GET['awal'])){
											
										}else{
											$this->db->where("inv_date <=",date("Y-m-d"));
										}
										if(isset($_GET['project'])){
											switch($_GET['project']){
												case "OK":
												$this->db->where("project_id >","0");
												break;
												case "Non":
												$this->db->where("project_id","0");
												break;
												default:												
												break;
											}											
										}
										
										//satu customer satu project
										if($this->session->userdata("user_project")!=""&&$lock==1){
											$this->db->where("inv.project_id",$this->session->userdata("user_project"));
										}
										
										//simple payment
										if($identity->identity_simple==1){
											$this->db->join("sjkeluar","sjkeluar.inv_no=inv.inv_no","left");
										}
										
										$usr=$this->db
										->join("branch","branch.branch_id=inv.branch_id","left")
										->join("project","project.project_id=inv.project_id","left")
										->join("customer","customer.customer_id=inv.customer_id","left")
										->group_by("inv.inv_no")
										->order_by("inv_id","desc")
										->get("inv");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $inv){?>
										<tr>		
											<td><?=$no++;?></td>									
											<td><?=$inv->inv_date;?></td>
											<td><?=$inv->branch_name;?></td>
											<td><?=$inv->inv_no;?></td>
											<td>											
											<?=ucwords($inv->customer_name);?>
											</td>
											<?php if($identity->identity_project=="1"){
											if($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==2||$this->session->userdata("position_id")==7){$disproject='';}else{$disproject='disabled="disabled"';}
											?>
											<td>
                                            	<?=$inv->project_name;?>                                      
												</td>
											<?php }?>
											<td>
                                            	<?=$inv->poc_id;?>                                         
											</td>
											<td><?php
											$i=$this->db
											->where("inv_no",$inv->inv_no)
											->get("invproduct");
											$invoice=0;
											foreach($i->result() as $i){
												$invoice+=($i->invproduct_qty*$i->invproduct_price);
											}
											$invoice-=$inv->inv_discount;
											$p=$this->db
											->join("invpayment","invpaymentproduct.invpayment_no=invpayment.invpayment_no","left")
											->where("inv_no",$inv->inv_no)
											->get("invpaymentproduct");
											//echo $this->db->last_query();
											$pembayaran=0;
											foreach($p->result() as $p){
												$pembayaran+=($p->invpaymentproduct_qty*$p->invpaymentproduct_amount);
											}
											echo number_format($invoice,2,".",",");
											$tinvoice+=$invoice;
											$tpembayaran+=$pembayaran;
											$piutang=$invoice-$pembayaran;
											$tpiutang+=$piutang;
											?></td>
											<td><?=number_format($pembayaran,2,".",",");?></td>
											<td>
											<?=number_format($piutang,2,".",",");?></td>
											<td style="text-align:center; ">   	
											<?php 
											 $identity_project=$this->db->get("identity")->row()->identity_project;
							 				if($identity_project!=1 || ($identity_project==1&&$inv->project_id>0)){$boleh=1;}else{$boleh=0;}
											if($boleh==1){
											if(!isset($_GET['report'])){$float="float:right;";?>  									
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="inv_no" value="<?=$inv->inv_no;?>"/>
												</form>	                                      											
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="inv_no" value="<?=$inv->inv_no;?>"/>
												</form>		
											<?php }else{$float="";}?>		 									
												<form method="GET" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Assignment" target="_blank" href="<?=site_url("task?customer_id=".$inv->customer_id."&inv_no=".$inv->inv_no);?>" class="btn btn-sm btn-info " name="task" value="OK"> 
												  <span class="fa fa-hand-lizard-o" style="color:white;"></span>												  </a>
												</form> 
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Print SPK" target="_blank" href="<?=site_url("invprint?printer=spk&inv_no=".$inv->inv_no)."&customer_id=".$inv->customer_id;?>" class="btn btn-sm btn-success " name="edit" value="OK"> 
												  <span class="fa fa-user" style="color:white;"></span>												  </a>
												</form> 								
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Print" target="_blank" href="<?=site_url("invprint?printer=inkjet&inv_no=".$inv->inv_no)."&customer_id=".$inv->customer_id;?>" class="btn btn-sm btn-warning " name="edit" value="OK"> 
												  <span class="fa fa-print" style="color:white;"></span>												  </a>
												</form>  
											<?php if(!isset($_GET['report'])&&$identity->identity_simple!=1){?> 
                                            	<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												  <a data-toggle="tooltip" title="Payment" target="_blank" href="<?=site_url("invpayment?inv_no=".$inv->inv_no)."&customer_id=".$inv->customer_id."&project_id=".$inv->project_id;?>" class="btn btn-sm btn-primary " name="payment" value="OK">
												  <span class="fa fa-money" style="color:white;"></span>											  </a>
												</form> 	
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												  <a data-toggle="tooltip" title="List Product" target="_blank" href="<?=site_url("invproduct?inv_no=".$inv->inv_no)."&customer_id=".$inv->customer_id."&project_id=".$inv->project_id;?>" class="btn btn-sm btn-info " name="edit" value="OK">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>											  </a>
												</form> 			
											<?php }?>
											<?php if($identity->identity_simple==1){?>											
											<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
											  <a data-toggle="tooltip" title="Print Surat Jalan" target="_blank" href="<?=site_url("sjkeluarprint?sjkeluar_no=".$inv->sjkeluar_no)."&customer_id=".$inv->customer_id;?>" class="btn btn-sm btn-success " name="edit" value="OK"> 
											  <span class="fa fa-print" style="color:white;"></span> 
											  </a>
											</form>  			
											<?php }}?>
											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
	  </div>
			<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
		
		
		
			<div class="col-md-2 col-sm-2 col-xs-2">&nbsp;</div>
			
		
		
			<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
		
		
	
		
				
		
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>