<!DOCTYPE html>
<html>
	<head>
		<title>Print PO</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
		<style>
		.border{border:black solid 1px;}
		</style>
	<body>
	<div class="container">
	<div class="row">      
	<?php 
	$identity=$this->db->get("identity")->row();
	if($identity->identity_kop==1){
		require_once("kop.php");
	}
	?>
		<?php $t=array("","Supplier","Vendor");?>
		<h4 style="text-decoration:underline;">PO to <?=$t[$supplier_type];?></h4>
		<div class="col-md-6 col-sm-6 col-xs-6" style="padding:0px;">
			<div class="col-md-12 col-sm-12 col-xs-12"><?=$t[$supplier_type];?> : <?=$supplier_name;?>&nbsp;</div>
			<!--<div class="col-md-12 col-sm-12 col-xs-12">Attention : <?=$attention;?>&nbsp;</div>-->
			<div class="col-md-12 col-sm-12 col-xs-12">Address : <?=$supplier_address;?>&nbsp;</div>
			<!--<div class="col-md-12 col-sm-12 col-xs-12">Fax : <?=$supplier_fax;?>&nbsp;</div>-->
			<div class="col-md-12 col-sm-12 col-xs-12">Email :<?=$supplier_email;?>&nbsp;</div>
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1"></div>
		<div class="col-md-5 col-sm-5 col-xs-5" style="padding:0px;">			
			<div class="col-md-12 col-sm-12 col-xs-12"><?=$identity_company;?></div>
			<div class="col-md-12 col-sm-12 col-xs-12">PO No. : <?=$po_no;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Date : <?=date("d F Y",strtotime($po_date));?>&nbsp;</div>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px; margin-top:20px;">Kebutuhan:</div>
		<?php if($po_jasa!=""){?>
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px; font-weight:bold;">	
		Jasa : <?=$po_jasa;?>
		</div>
		<?php }?>
		<?php 
		$prod=$this->db
		->join("product","product.product_id=poproduct.product_id","left")
		->where("po_no",$this->input->get("po_no"))
		->order_by("poproduct_id","desc")
		->get("poproduct");
		if($prod->num_rows()>0){?>
			<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px;  margin-top:20px;  font-weight:bold;">Material :</div>	
			<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px;  margin-top:0px;">		
			  <table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<tr>
				  <th style="text-align:center;">No</th>
				  <th style="text-align:center;">Product</th>
				  <th style="text-align:center;">Description</th>
				  <th style="text-align:center;">Qty</th>
				  <th style="text-align:center;">Unit Price </th>
				  <th style="text-align:center;">Total (IDR) </th>
				</tr>
				<?php 
				$no=1;$to=0;
				
				$no=1;
				foreach($prod->result() as $product){?>
				<tr>
				  <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->product_name;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->product_description;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->poproduct_qty;?>&nbsp;</td>
				  <td style="text-align:right;"><?=number_format($product->poproduct_price,0,",",".");?> &nbsp;</td>
				  <td style="text-align:right;"><?=number_format($to=+$product->poproduct_qty*$product->poproduct_price,0,",",".");?> &nbsp;</td>
				</tr>
				<?php }?>
				 
				  <td colspan="5" class="text-right">Total : &nbsp;</td><td style="text-align:right;"><?=number_format($to,0,",",".");?> &nbsp;</td></tr>
				  <?php
				  if($po_ppn=="1"||$po_pph=="1"){
				  $potong=0;
				  if($po_ppn=="1"){?>
				   <tr>
				  <td colspan="5" class="text-right">PPN : &nbsp;</td><td style="text-align:right;"><?=number_format($potong=$to*10/100,0,",",".");?> &nbsp;</td></tr>
				  
				  <?php }?>
				  <?php
				  if($po_pph=="1"){?>
				   <tr>
				  <td colspan="5" class="text-right">PPH : &nbsp;</td><td style="text-align:right;"><?=number_format($to*2/100,0,",",".");$potong-=($to*2/100)?> &nbsp;</div>
				  <?php }?>
				   <tr>
				  <td colspan="5" class="text-right">Grand Total : &nbsp;</td><td style="text-align:right;"><?=number_format($to+$potong,0,",",".");?> &nbsp;</td></tr>	
				  	<?php }?>	 	
			  </table>
			</div>
			
		<?php }?>
		<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:0px;">
			<div class="col-md-12 col-sm-12 col-xs-12" style="font-size:14px; font-weight:bold; padding:0px;">Term & condition :</div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="font-size:12px; padding:0px;"><?=$po_term;?></div>
		</div>
		<?php if($po_prepare!=""){?>
			<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:10px;">
				<div align="center">Prepared by :</div>
				<div  style="height:30px;">&nbsp;</div>
				<div align="center"><?=$po_prepare;?>&nbsp;</div>
			</div>
		<?php }
		if($po_approve!=""){?>
			<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:10px;">
				<div align="center">Approved by :</div>
				<div  style="height:30px;">&nbsp;</div>
				<div align="center"><?=$po_approve;?>&nbsp;</div>
			</div>
		<?php }?>
		
	
		
				
		
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>