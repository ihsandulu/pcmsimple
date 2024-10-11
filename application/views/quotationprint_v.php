<?php
$identity=$this->db->get("identity")->row();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Print quotationoice</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
		<style>
		.border{border:#B1B1B1 solid 1px;}
		@media print {
		 .pagebreak{page-break-after: always;}
		}
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
		
		<div class="col-md-12"><h1>Quotation</h1></div>
		<div class="col-md-6 col-sm-6 col-xs-6" style=" padding:15px; border-radius:5px; ">
			<div class="col-md-12 text-left" style="border-bottom:grey dashed 0.5px; margin-bottom:5px; padding:5px;"><strong><?=$customer_name;?></strong></div>
			<?php if($identity_project==1&&$project_name!=""){?>
			<div class="col-md-12 col-sm-12 col-xs-12">Project: <?=$project_name;?>&nbsp;</div>
			<?php }?>
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1"></div>
		<div class="col-md-5 col-sm-5 col-xs-5" style="">
			<div class="col-md-12 col-sm-12 col-xs-12">Date: <?=$quotation_date;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Quotation No.: <?=$this->input->get("quotation_no");?>&nbsp;</div>
			<?php if($quotation_rev>0){?>
			<div class="col-md-12 col-sm-12 col-xs-12">Rev.: <?=$quotation_rev;?>&nbsp;</div>
			<?php }?>
		</div>
		<div style="">&nbsp;<br/><br/><br/></div>
		<?php $loo=$this->db
		->where("quotation_id",$this->input->get("quotation_id"))
		->get("quotation");
		foreach($loo->result() as $quotation){?>
		
		
			<div class="col-md-12" style="padding:0px; ">	
			Dear <?=$quotation->quotation_to;?>
			</div>
		
			<div class="col-md-12" style="padding:0px; ">
			<?=$quotation->quotation_intro;?>
			</div>
			
	
			<div class="col-md-12" style="padding:0px; ">	
			<h5><strong>Workscope</strong></h5>
			<?=$quotation->quotation_workscope;?>
			</div>
	
			<div class="col-md-12" style="padding:0px; ">	
			<h5><strong>Payment</strong></h5>
			<?=$quotation->quotation_payment;?>
			</div>
	
			<div class="col-md-12" style="padding:0px; ">	
			<?=$quotation->quotation_closing;?>
			</div>
	
			<h5><strong>Yours faithfully,</strong></h5>
			<div class="col-md-12" style="padding:0px; ">
			<?=$quotation->quotation_write;?>
			</div>
		
		<div class="col-md-12">&nbsp;</div>
		<?php }?>
		
		
			
		<div class="col-md-12 col-sm-12 col-xs-12" style="height:20px;">&nbsp;</div>
		<?php if($quotation_product=="1"){?>
		<div class="pagebreak"></div>
		<div style=" border-bottom:black solid 1px; padding-top:5px; margin-bottom:30px;">				
			<div class="col-md-4 col-sm-4 col-xs-4" style="">
				<?php if(isset($identity_address)){?>
				<?=$identity_address;?><br/>
				<?php }?>
				<?php if(isset($identity_phone)){?>
				<?=$identity_phone;?><br/>
				<?php }?>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 " style="padding-left:10px;" align="center">
				<?php if(isset($identity_company)){?>
				<span class="tebal14"><?=$identity_company;?></span><br/>
				<?php }?>
				<?php if(isset($identity_services)){?>
				<span><?=$identity_services;?></span>
				<?php }?>
			</div>					
			<div class="col-md-4 col-sm-4 col-xs-4 " style="height:20px; margin:0px;">
				<?php if(isset($identity_picture)){?>
				<img src="<?=base_url("assets/images/identity_picture/".$identity_picture);?>" style="width:auto; height:100%; max-width:100%; position:relative; left:50%; top:50%; transform:translate(-50%,-50%); "/>
				<?php }?>
			</div>
			<div style="clear:both;"></div>
		</div>
		<h5 style="text-decoration:underline;">Lampiran</h5>
		<?php if($quotation_product=="0"){$display="display:none;";}else{$display="";}?>
			<div class="col-md-12" style="padding:0px; <?=$display;?>">		
			  <table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<tr>
				  <th style="text-align:center;">No</th>
				  <th style="text-align:center;">Description</th>
				  <th style="text-align:center;">Qty</th>
				  <th style="text-align:center;">Unit Price </th>
				  <?php if($identity->identity_dimension==1){?>
				  <th style="text-align:center;">Length</th>
				  <th style="text-align:center;">Width</th>
				  <th style="text-align:center;">Height</th>
				  <?php }?>
				  <th style="text-align:center;">Total (IDR) </th>
				</tr>
				<?php 
				$no=1;$to=0;
				$prod=$this->db
				->join("product","product.product_id=quotationproduct.product_id","left")
				->where("quotation_id",$this->input->get("quotation_id"))
				->order_by("quotationproduct_id","desc")
				->get("quotationproduct");
				foreach($prod->result() as $product){?>
				<tr>
				  <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->product_name;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->quotationproduct_qty;?>&nbsp;</td>
				  <td style="text-align:center;"><?=number_format($product->quotationproduct_price,0,",",".");?>&nbsp;</td>
				  <?php if($identity->identity_dimension==1){?>
				  <td style="text-align:center;"><?=$product->quotationproduct_panjang;?></td>
				  <td style="text-align:center;"><?=$product->quotationproduct_lebar;?></td>
				  <td style="text-align:center;"><?=$product->quotationproduct_tinggi;?></td>
				  <?php }?>
				  <td style="text-align:center;"><?=number_format($to=+$product->quotationproduct_qty*$product->quotationproduct_price,0,",",".");?>&nbsp;</td>
				</tr>
				<?php }?>				
			  </table>
			</div>
		
		
		<div id="allpicture" style="padding-top:20px; margin-top:20px !important;"></div> 
		  <script>
		   function tampilpicture(){
				 $.get("<?=site_url("api/allpicture");?>",{table:'qpicture',dir:'quotation',datetime:'<?=$quotation->quotation_datetime;?>'})
				 .done(function(data){
					$('#allpicture').html(data);
				 });
			 }
			 tampilpicture();
		  </script>
		  <div style="clear:both;"></div>
		<?php }?>
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>