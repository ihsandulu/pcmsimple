<!DOCTYPE html>
<?php
date_default_timezone_set("Asia/Bangkok");
$identity=$this->db->get("identity")->row();?>
<html>
	<head>
		<title>Print Invoice</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
		<style>
		 @media print {
			html, body, div{
				font-family:Arial, Helvetica, sans-serif;
				font-size:10px;
				margin: 0px !important;
				line-height:100%;
			}
		
			@page {
			  
			}	
			.tebal10{font-size:10px; font-weight:bold;}		
			.tebal12{font-size:12px; font-weight:bold;}	
			.tebal14{font-size:14px; font-weight:bold;}	
			.tebal16{font-size:16px; font-weight:bold;}		
			th, td{padding:2px;}
			.pagebreak{page-break-after: always;}
		} 
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
		
		<div class="col-md-6 col-sm-6 col-xs-5" style="padding:0px; padding-top:5px; border-radius:5px; ">	
			<?php if(isset($customer_name)){?>		
			<div class="col-md-12 col-sm-12 col-xs-12">Customer : <?=$customer_name;?>&nbsp;</div>
			<?php }?>
			<?php if(isset($customer_address)){?>
			<div class="col-md-12 col-sm-12 col-xs-12">Address : <?=$customer_address;?>&nbsp;</div>
			<?php }?>
			<?php if(isset($customer_phone)){?>
			<div class="col-md-12 col-sm-12 col-xs-12">Phone : <?=$customer_phone;?>&nbsp;</div>
			<?php }?>
		</div>
		<div class="col-md-1 col-sm-1 col-xs-2" style="padding:0px; padding-top:5px; border-radius:5px; ">
			<strong style="border-bottom:black solid 1px;">INVOICE</strong>
		</div>
		<div class="col-md-5 col-sm-5 col-xs-5" style="padding:0px; padding-top:5px; border-radius:5px; ">
			<div class="col-md-12 col-sm-12 col-xs-12">Invoice No. : <?=$this->input->get("inv_no");?></div>
			<?php if(isset($inv_date)){?>
			<div class="col-md-12 col-sm-12 col-xs-12">Date : <?=date("d M Y",strtotime($inv_date));?></div>
			<?php }?>
			<?php if(isset($orderno)){?>
			<div class="col-md-12 col-sm-12 col-xs-12">Order No : <?=$orderno;?>&nbsp;</div>
			<?php }?>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
		<?php $task=$this->db
		->where("inv_no", $inv_no)
		->get("task");
		if($task->num_rows()>0){?>
		<div class="" style="">
		SPK : 
		<?php
		foreach($task->result() as $task){?>
		<?=$task->task_no;?>,
		<?php }	?>
		</div>
		<?php }	?>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px;">	
		<?php if($inv_showproduct<=1){?>	
		  <table class="col-md-12 col-sm-12 col-xs-12" border="1">
            <tr>
              <th style="text-align:center;">No</th>
              <th style="text-align:center;">Name</th>
              <th style="text-align:center;">Description</th>
              <th style="text-align:center;">Qty</th>
              <th style="text-align:center;">Unit Price </th>
              <th style="text-align:center;">Total (IDR) </th>
            </tr>
			<?php 
			$no=1;$to=0;
			$prod=$this->db
			->join("product","product.product_id=invproduct.product_id","left")
			->where("inv_no",$this->input->get("inv_no"))
			->order_by("invproduct_id","desc")
			->get("invproduct");
			foreach($prod->result() as $product){?>
            <tr>
              <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
              <td style="text-align:center;"><?=$product->product_name;?>&nbsp;</td>
              <td style="text-align:center;"><?=$product->product_description;?><?=($product->invproduct_remarks!="")?" | ".$product->invproduct_remarks:"";?>&nbsp;</td>
              <td style="text-align:center;"><?=$product->invproduct_qty;?>&nbsp;</td>
              <td style="text-align:right;"><?=number_format($product->invproduct_price,2,",",".");?>&nbsp;</td>
              <td style="text-align:right;"><?=number_format($product->invproduct_qty*$product->invproduct_price,2,",",".");$to+=$product->invproduct_qty*$product->invproduct_price;?>&nbsp;</td>
            </tr>
			<?php }?>
			<?php $discount=$inv_discount;?>	 
			<?php $to-=$discount;?>	 
			<?php $totalsemua=$to;?>
			<tr>
              <td colspan="5" style="text-align:right;">Discount : </td>
			  <td style="text-align:right;"><?=number_format($discount,2,",",".");?>&nbsp;</td>
            </tr>
			<tr>
              <td colspan="5" style="text-align:right;">Total : </td>
			  <td style="text-align:right;"><?=number_format($to,2,",",".");?>&nbsp;</td>
            </tr>
			  
			  <?php if(isset($inv_ppn)&&$inv_ppn!=0){?>
			<tr>
              <td colspan="5" style="text-align:right;">PPN : </td>
			  <td style="text-align:right;"><?=number_format($inv_ppn=$to*$inv_ppn,2,",",".");?>&nbsp;</td>
            </tr>
			  <?php }?>	
			  
			  <?php if(isset($inv_pph)&&$inv_pph!=0){?>
            <tr>
              <td colspan="5" style="text-align:right;">PPH : </td>
			  <td style="text-align:right;"><?=number_format($inv_pph=$to*$inv_pph,2,",",".");?>&nbsp;</td>
            </tr>
			  <?php }?>	
			  
			  <?php if((isset($inv_ppn)&&$inv_ppn!=0)||(isset($inv_pph)&&$inv_pph!=0)){
			  $totalsemua=$to+$inv_ppn-$inv_pph;
			  ?>
			<tr>
              <td colspan="5" style="text-align:right;">Grand Total : </td>
			  <td style="text-align:right;"><?=number_format($totalsemua,2,",",".");?>&nbsp;</td>
			</tr>	
			  <?php }?>	
			   
			  <?php 			  
			  	$bayar=$this->db
				->select("SUM(invpaymentproduct_amount)as bayar")
				->join("invpaymentproduct","invpaymentproduct.invpayment_no=invpayment.invpayment_no","left")
				->where("inv_no",$this->input->get("inv_no"))
				->group_by("inv_no")
				->get("invpayment");
				
				if($bayar->num_rows() > 0){
				$terbayar=$bayar->row()->bayar;
			  ?>
			<tr>
              <td colspan="5" style="text-align:right;">Terbayar : </td>
			  <td style="text-align:right;"><?=number_format($terbayar,2,",",".");?>&nbsp;</td>
            </tr>
			<tr>
              <td colspan="5" style="text-align:right;">Sisa : </td>
			  <td style="text-align:right;"><?=number_format($totalsemua-$terbayar,2,",",".");?>&nbsp;</td>
            </tr>		
			  <?php }?>				 
          </table>
		  <?php }else{?>
		  <table class="col-md-12 col-sm-12 col-xs-12" border="1">
            <tr>
              <th style="text-align:center;">No</th>
              <th style="text-align:center;">Description</th>
              <th style="text-align:center;">Unit Price </th>
              <th style="text-align:center;">Total (IDR) </th>
            </tr>
			<?php 
			$no=1;$to=0;
			$prod=$this->db
			->join("project","project.project_id=inv.project_id","left")
			->where("inv_no",$this->input->get("inv_no"))
			->get("inv");
			foreach($prod->result() as $product){?>
            <tr>
              <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
              <td style="text-align:left;"><?=$product->project_description;?>&nbsp;</td>
              <td style="text-align:right;"><?=number_format($product->project_budget,2,",",".");?>&nbsp;</td>
              <td style="text-align:right;"><?=number_format($product->project_budget,2,",",".");$to+=$product->project_budget;?>&nbsp;</td>
            </tr>
			<?php }?>
			<?php $discount=$inv_discount;?>	 
			<?php $to-=$discount;?>	 
			<?php $totalsemua=$to;?>
			<tr>
              <td colspan="3" style="text-align:right;">Discount : </td>
			  <td style="text-align:right;"><?=number_format($discount,2,",",".");?>&nbsp;</td>
            </tr>
			<tr>
              <td colspan="3" style="text-align:right;">Total : </td>
			  <td style="text-align:right;"><?=number_format($to,2,",",".");?>&nbsp;</td>
            </tr>
			  
			  <?php if(isset($inv_ppn)&&$inv_ppn!=0){?>
			<tr>
              <td colspan="3" style="text-align:right;">PPN : </td>
			  <td style="text-align:right;"><?=number_format($inv_ppn=$to*$inv_ppn,2,",",".");?>&nbsp;</td>
            </tr>
			  <?php }?>	
			  
			  <?php if(isset($inv_pph)&&$inv_pph!=0){?>
            <tr>
              <td colspan="3" style="text-align:right;">PPH : </td>
			  <td style="text-align:right;"><?=number_format($inv_pph=$to*$inv_pph,2,",",".");?>&nbsp;</td>
            </tr>
			  <?php }?>	
			  
			  <?php if((isset($inv_ppn)&&$inv_ppn!=0)||(isset($inv_pph)&&$inv_pph!=0)){
			  $totalsemua=$to+$inv_ppn-$inv_pph;
			  ?>
			<tr>
              <td colspan="3" style="text-align:right;">Grand Total : </td>
			  <td style="text-align:right;"><?=number_format($totalsemua,2,",",".");?>&nbsp;</td>
			</tr>	
			  <?php }?>	
			   
			  <?php 			  
			  	$bayar=$this->db
				->select("SUM(invpaymentproduct_amount)as bayar")
				->join("invpaymentproduct","invpaymentproduct.invpayment_no=invpayment.invpayment_no","left")
				->where("inv_no",$this->input->get("inv_no"))
				->group_by("inv_no")
				->get("invpayment");
				
				if($bayar->num_rows() > 0){
				$terbayar=$bayar->row()->bayar;
			  ?>
			<tr>
              <td colspan="3" style="text-align:right;">Terbayar : </td>
			  <td style="text-align:right;"><?=number_format($terbayar,2,",",".");?>&nbsp;</td>
            </tr>
			<tr>
              <td colspan="3" style="text-align:right;">Sisa : </td>
			  <td style="text-align:right;"><?=number_format($totalsemua-$terbayar,2,",",".");?>&nbsp;</td>
            </tr>		
			  <?php }?>				 
          </table>
		  <?php }?>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
		
		<div class="col-md-6 col-sm-6 col-xs-6">
			<?=$inv_payment;?>&nbsp;
		</div>	
		
		<div class="col-md-6 col-sm-6 col-xs-6">
		<div class="col-md-12 col-sm-12 col-xs-12" style="font-weight:bold; font-size:16px;">Note :</div>
		<br/>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<?=$inv_note;?>&nbsp;
		</div>	
		</div>
		
		<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px !important;">
			
			<div class="col-md-4 col-sm-4 col-xs-4" style="padding:0px;" align="center">
				<i><strong class="tebal10">Diterima Oleh,</strong></i>
				<div style="height:50px;">&nbsp;</div>
				<div style=""><strong><?=$inv_receiver;?></strong></div>
				
			</div>
			
			<div class="col-md-4 col-sm-4 col-xs-4" style="padding:0px;" align="center">
				<i><strong class="tebal10">Approve,</strong></i>
				<div style="height:50px;">&nbsp;</div>
				<div style=""><strong><?=$inv_approved;?></strong></div>
			</div>
			
			<div class="col-md-4 col-sm-4 col-xs-4" style="padding:0px;" align="center">
				<i><strong class="tebal10">Adm,</strong></i>
				<div style="height:50px;">
				<?php if($identity->identity_stempel!=""){?>
				<img src="<?=base_url("assets/images/identity_picture/stempel.png");?>" class="img img-rounded" style="object-fit:contain; width:100%; height:auto;"/></div>
				<?php }?>
				<div style=""><strong><?=$inv_storekeeper;?></strong></div>
			</div>
			
		</div>
	</div>
	</div>
	<?php if($inv_picture!=""){?>
	<div class="pagebreak"></div>
	<?php 
	$file = base_url("assets/images/inv_picture/".$inv_picture);
	$ext = pathinfo($file);
	if($ext['extension']!="pdf"){?>
	<img src="<?=base_url("assets/images/inv_picture/".$inv_picture);?>" style="width:100%; height:auto;"/>
	<?php }else{?>
	<script>
		window.onload = function(){
			 window.open("<?=$file;?>", "_blank");
		}
	</script>
	<?php }?>
	<?php }?>
	</body>
</html>

<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>