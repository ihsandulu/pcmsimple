<?php
	$dari=date("Y-m-d");
	$ke=date("Y-m-d");
	$cap="";
	if(isset($_REQUEST["dari"])){
		$dari=$_REQUEST["dari"];
		$ke=$_REQUEST["ke"];
	}
	if(isset($_REQUEST["cap"])){
		$cap=$_REQUEST["cap"];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Print Payment Invoice Supplier</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
		<style>
		.border{border:#999999 solid 1px;}
		.tebal{border:black solid 2px;}
		.bold{font-weight:bold;}
		.rincian{margin-left:30px;}
		.underline{text-decoration:underline;}
		@media print {
			.break {page-break-after: always;}
		}
		</style>
	</head>
	<body>
	<div class="container">
	<div class="row">
		<div style="margin-bottom:0px; border-bottom:black solid 3px; padding-bottom:10px;">
			<div class="col-md-8 col-sm-8 col-xs-8">
				<div class="col-md-4 col-sm-4 col-xs-4" style="height:50px;">
					<img src="<?=base_url("assets/images/identity_picture/".$identity_picture);?>" style="width:auto; height:100%; max-width:100%; position:relative; left:50%; top:50%; transform:translate(-50%,-50%); "/>
				</div>
				<div class="col-md-8 col-sm-8 col-xs-8" align="left">
					<h5><strong><?=$identity_company;?></strong></h5>
					<span><?=$identity_slogan;?></span>
				</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="line-height: 100%; padding-top:7px;" align="right"><?=$identity_services;?></div>
			<div style="clear:both;"></div>
		</div>
	
		<div class="col-md-6 col-sm-6 col-xs-6" style="font-weight:bold; font-size:14px; margin:15px 0px 15px;">CASH ADVANCE</div>
		<div class="col-md-6 col-sm-6 col-xs-6" style="text-align:left; border:black solid 1px; padding:5px;  margin:10px 0px 10px;">Voucher No. :<?=$_REQUEST['invspayment_no'];?></div>
		
		<div class="col-md-3 col-sm-3 col-xs-3 border">Date of Request</div>
		<div class="col-md-9 col-sm-9 col-xs-9 border"><?=date("d F Y",strtotime($invspayment_date));?>&nbsp;</div>
		<div class="col-md-3 col-sm-3 col-xs-3 border">Requestor Name</div>
		<div class="col-md-9 col-sm-9 col-xs-9 border"><?=$invspayment_payto;?>&nbsp;</div>
		<div class="col-md-3 col-sm-3 col-xs-3 border">Depart.</div>
		<div class="col-md-9 col-sm-9 col-xs-9 border"><?=$invspayment_department;?>&nbsp;</div>
		<div class="col-md-3 col-sm-3 col-xs-3 border">Purpose</div>
		<div class="col-md-9 col-sm-9 col-xs-9 border"><?=$invspayment_purpose;?>&nbsp;</div>
		<div class="col-md-3 col-sm-3 col-xs-3 border">Client</div>
		<div class="col-md-9 col-sm-9 col-xs-9 border"><?=$invspayment_receivedby;?>&nbsp;</div>
		<div class="col-md-3 col-sm-3 col-xs-3 border">Project</div>
		<div class="col-md-9 col-sm-9 col-xs-9 border" style="margin-bottom:20px;"><?=$project_name;?>&nbsp;</div>
		
		
			<div class="col-md-12" style="padding:0px; margin-top:20px !important;">
				<table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<tr>
				  <th style="text-align:center;">No</th>
				  <th style="text-align:center;">Description</th>
				  <th style="text-align:center;">Quantity</th>
				  <th style="text-align:center;">Unit Price</th>
				  <th style="text-align:center;">Total</th>
				</tr>	
			 
				<?php 
				function is_decimal( $val )
				{
					return is_numeric( $val ) && floor( $val ) != $val;
				}
				$no=1;$to=0;
				
		
			
				$this->db->where("invspayment.project_id >",0);
				$prod=$this->db
				->join("biaya","biaya.biaya_id=invspaymentproduct.biaya_id","left")
				->join("invspayment","invspaymentproduct.invspayment_no=invspayment.invspayment_no","left")
				->where("invspayment.invspayment_no",$invspayment_no)
				->order_by("invspaymentproduct_id","desc")
				->get("invspaymentproduct");
				$total=0;
				$rowspan=0;
				foreach($prod->result() as $product){
				
				//cek row per payment
				$rprod=$this->db
				->where("invspayment_no",$product->invspayment_no)
				->get("invspaymentproduct");
				$rowspan=$rprod->num_rows();
				
				if($product->biaya_id>0){
					$invspaymentproduct_description=$product->biaya_name;
				}else{
					$invspaymentproduct_description=$product->invspaymentproduct_description;
				}
				?>
				<tr>
				
				  <td style="text-align:center; padding:5px;"><?=$no++;?></td>
				  <td style="text-align:left; padding:5px;"><?=$invspaymentproduct_description;?></td>
				  <td style="text-align:center; padding:5px;"><?=number_format($product->invspaymentproduct_qty,0,",",".");?></td>	
				  <td style="text-align:right; padding:5px;"><?=number_format($product->invspaymentproduct_amount,0,",",".");?></td>	
				  <td style="text-align:right; padding:5px;"><?=number_format($product->invspaymentproduct_amount*$product->invspaymentproduct_qty,0,",",".");$total+=($product->invspaymentproduct_amount*$product->invspaymentproduct_qty);?></td>				 
				</tr>
				<?php }?>
				<tr>
				  <td colspan="4" style="text-align:center; padding:5px;">Total Cash Advance</td>
				  <td style="text-align:right; padding:5px;"><?=number_format($total,0,",",".");?></td>
			    </tr>
			  </table>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px; margin-top:20px;">
			<table class="table" border="1" cellspacing="0" style="margin:0px;">
			<thead>
			  <tr>
				<th style="text-align:center;" rowspan="2">Request By </th>
				<th style="text-align:center;" rowspan="2">Received By </th>
				<th style="text-align:center;" colspan="2">Finance</th>
				<th style="text-align:center;" rowspan="2">Director</th>
			  </tr>
			  <tr>
			    <th>Petty Cash </th>
		        <th>Cash In Bank </th>
			  </tr>
			  </thead>
			  <tbody>
			  <tr style="height:70px;">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  </tbody>
			  <tfoot>
			  <tr>
				<th style="text-align:center;"><?=$invspayment_payto;?></th>
				<th style="text-align:center;"><?=$invspayment_receivedby;?></th>
				<th style="text-align:center;"><?=$invspayment_prepareby;?></th>
				<th style="text-align:center;">&nbsp;</th>
				<th style="text-align:center;"><?=$invspayment_approvedby;?></th>
			  </tr>
			  </tfoot>
			</table>

			</div>
			
	</div>
	</div>
	
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>