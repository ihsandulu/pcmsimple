<!DOCTYPE html>
<html>
	<head>
		<title>Print Invoice Supplier</title>
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
	
		<div class="col-md-12"><h3 style="text-decoration:underline;">Invoice Supplier</h3></div>
		<div class="col-md-6 col-sm-6 col-xs-6" style=" padding:15px; border-radius:5px; ">
			
			
			<div class="col-md-12 col-sm-12 col-xs-12">Supplier : <?=$supplier_name;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Address : <?=$supplier_address;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Fax : <?=$supplier_fax;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Email : <?=$supplier_email;?>&nbsp;</div>
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1"></div>
		<div class="col-md-5 col-sm-5 col-xs-5" style="border:grey solid 1px; padding:15px; border-radius:5px;;">
			<div class="col-md-12 col-sm-12 col-xs-12">Invoice No. : <?=$invs_no;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Date : <?=date("d F Y",strtotime($invs_date));?>&nbsp;</div>
		</div>
		<div style="">&nbsp;</div>
		
			<div class="col-md-12" style="padding:0px; ">		
			  <table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<tr>
				  <th style="text-align:center;">No</th>
				  <th style="text-align:center;">Description</th>
				  <th style="text-align:center;">Qty</th>
			      <th style="text-align:center;">Price</th>
			      <th style="text-align:center;">Total</th>
				</tr>
				<?php 
				$no=1;$to=0;
				$prod=$this->db
				->join("product","product.product_id=invsproduct.product_id","left")
				->where("invs_no",$this->input->get("invs_no"))
				->order_by("invsproduct_id","desc")
				->get("invsproduct");
				$total=0;
				foreach($prod->result() as $product){?>
				<tr>
				  <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->product_name;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->invsproduct_qty;?>&nbsp;</td>
			      <td style="text-align:center;"><?=number_format($product->invsproduct_price,2,",",".");?></td>
			      <td style="text-align:center;"><?=number_format($product->invsproduct_price*$product->invsproduct_qty,2,",",".");$total+=$product->invsproduct_price*$product->invsproduct_qty;?></td>
				</tr>
				<?php }
				$totalsemua=$total;
				?>
				<tr>
				  <td colspan="4" style="text-align:right;">Total &nbsp;</td>
				  <td style="text-align:center;"><?=number_format($total,2,",",".");?></td>
			    </tr>
				<?php if($invs_disc!=0){?>
				<tr>
				  <td colspan="4" style="text-align:right;">Disc &nbsp;</td>
				  <td style="text-align:center;"><?=number_format($disc=$invs_disc*$total/100,2,",",".");?></td>
			    </tr>
				<?php }?>
				<?php if($invs_vat!=0){?>
				<tr>
				  <td colspan="4" style="text-align:right;">Vat &nbsp;</td>
				  <td style="text-align:center;"><?=number_format($vat=$invs_vat*($total-$disc)/100,2,",",".");?></td>
			    </tr>
				<?php }?>
				<?php if($invs_disc!=0||$invs_vat!=0){
				$totalsemua=($total-$disc)+$vat;
				?>
				<tr>
				  <td colspan="4" style="text-align:right;">Total Amount &nbsp;</td>
				  <td style="text-align:center;"><?=number_format($totalsemua,2,",",".");?></td>
			    </tr>
				<?php }?>
				<?php 
				$bayar=$this->db
				->select("SUM(invspaymentproduct_amount)as bayar")
				->join("invspaymentproduct","invspaymentproduct.invspayment_no=invspayment.invspayment_no","left")
				->where("invs_no",$this->input->get("invs_no"))
				->group_by("invs_no")
				->get("invspayment");
				
				if($bayar->num_rows() > 0){
				$terbayar=$bayar->row()->bayar;
				?>
				<tr>
				  <td colspan="4" style="text-align:right;">Terbayar &nbsp;</td>
				  <td style="text-align:center;"><?=number_format($terbayar,2,",",".");?></td>
			    </tr>
				<tr>
				  <td colspan="4" style="text-align:right;">Sisa &nbsp;</td>
				  <td style="text-align:center;"><?=number_format($totalsemua-$terbayar,2,",",".");?></td>
			    </tr>
				<?php }?>
			  </table>
			</div>
			
		
			<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:12px; padding:20px;">
				<div align="center">Confirm By  :</div>
				<div align="center"><h4><strong><?=$identity_company;?></strong></h4></div>
				<div  style="height:100px;">&nbsp;</div>
				<div align="center"><?=$invs_confirm;?>&nbsp;</div>
			</div>
		
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