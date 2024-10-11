<!DOCTYPE html>
<html>
	<head>
		<title>Print Payment Invoice Supplier</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
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
		
		
		<div class="col-md-6 col-sm-6 col-xs-6" style=" ">			
			<div class="col-md-12 col-sm-12 col-xs-12"><strong>Kwitansi Pembayaran Supplier</strong></div>	
			<div class="col-md-12 col-sm-12 col-xs-12">Pay to : <?=$invspayment_payto;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Payment Method : <?=$methodpayment_name;?>&nbsp;</div>
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1"></div>
		<div class="col-md-5 col-sm-5 col-xs-5" style="">		
			<div class="col-md-12 col-sm-12 col-xs-12"><?=$identity_company;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Invoice No. : <?=$invs_no;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Payment No. : <?=$invspayment_no;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Date : <?=date("d F Y",strtotime($invspayment_date));?>&nbsp;</div>
		</div>
		<!----><div style="">&nbsp;<br/></div>
		
			<div class="col-md-12" style="padding:0px; ">		
			  <table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<tr>
				  <th style="text-align:center;">No</th>
				  <th style="text-align:center;">Description</th>
				  <th style="text-align:center;">Code</th>
				  <th style="text-align:center;">Qty</th>
			      <th style="text-align:center;">Price</th>
			      <th style="text-align:center;">Total</th>
				</tr>
				<?php 
				$no=1;$to=0;
				$prod=$this->db
				->where("invspayment_no",$this->input->get("invspayment_no"))
				->order_by("invspaymentproduct_id","desc")
				->get("invspaymentproduct");
				$total=0;
				foreach($prod->result() as $product){?>
				<tr>
				  <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->invspaymentproduct_description;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->invspaymentproduct_code;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->invspaymentproduct_qty;?>&nbsp;</td>
			      <td style="text-align:center;"><?=number_format($product->invspaymentproduct_amount,2,",",".");?></td>
			      <td style="text-align:center;"><?=number_format($product->invspaymentproduct_amount*$product->invspaymentproduct_qty,2,",",".");$total+=$product->invspaymentproduct_amount*$product->invspaymentproduct_qty;?></td>
				</tr>
				<?php }?>
				<tr>
				  <td colspan="5" style="text-align:center;">TOTAL</td>
				  <td style="text-align:center;"><?=number_format($total,2,",",".");?></td>
			    </tr>
			  </table>
			</div>
			<!--<div style="">&nbsp;<br/><br/></div>-->
		
			<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:20px;">
				<div align="center">Prepared By  : <?=$invspayment_prepareby;?></div>
				<div  style="height:100px;">&nbsp;</div>
			</div>
		
			<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:20px;">
				<div align="center">Received By  : <?=$invspayment_receivedby;?></div>
				<div  style="height:100px;">&nbsp;</div>
			</div>
			
			<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:20px;">
				<div align="center">Approved By  : <?=$invspayment_approvedby;?></div>
				<div  style="height:100px;">&nbsp;</div>
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