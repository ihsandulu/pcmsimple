<!DOCTYPE html>
<html><head>
		<title>Print PO Customer</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
		<style>
		.border{border:black solid 1px;}
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
	
		<div class="col-md-12 col-sm-12 col-xs-12"><h3 style="text-decoration:underline;">PO Customer</h3></div>
		<div class="col-md-6 col-sm-6 col-xs-6" style="padding: 5px 5px 5px 0px; border-radius:5px;">		
			<div class="col-md-12 col-sm-12 col-xs-12">Customer : <?=$customer_name;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Address : <?=$customer_address;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Fax : <?=$customer_fax;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Email : <?=$customer_email;?>&nbsp;</div>
		 </div>
		<div class="col-md-6 col-sm-6 col-xs-6" style="border:grey solid 1px; padding: 5px 0px 5px 5px; border-radius:5px; margin:0px;">
			<div class="col-md-12 col-sm-12 col-xs-12">PO No. : <?=$poc_no;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Date : <?=date("d F Y",strtotime($poc_date));?>&nbsp;</div>
		</div>
		
		
			<div class="col-md-12 col-sm-12 col-xs-12" style="  margin:0px 0px 10px 0px;">		
				<?php if($poc_showproduct<=1){?>
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
				->join("product","product.product_id=pocproduct.product_id","left")
				->where("poc_no",$this->input->get("poc_no"))
				->order_by("pocproduct_id","desc")
				->get("pocproduct");
				$total=0;
				foreach($prod->result() as $product){?>
				<tr>
				  <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->product_name;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->pocproduct_qty;?>&nbsp;</td>
			      <td style="text-align:right; padding-right:5px;"><?=number_format($product->pocproduct_price,0,",",".");?></td>
			      <td style="text-align:right; padding-right:5px;"><?=number_format($total+=$product->pocproduct_price*$product->pocproduct_qty,0,",",".");?></td>
				</tr>
				<?php }?>
				<tr>
				  <td colspan="4" style="text-align:right;">Sub Total &nbsp;</td>
				  <td style="text-align:right; padding-right:5px;"><?=number_format($total,0,",",".");?></td>
			    </tr>
				<tr>
				  <td colspan="4" style="text-align:right;">Disc &nbsp;</td>
				  <td style="text-align:right; padding-right:5px;"><?=number_format($disc=$poc_disc*$total/100,0,",",".");?></td>
			    </tr>
				<tr>
				  <td colspan="4" style="text-align:right;">Vat &nbsp;</td>
				  <td style="text-align:right; padding-right:5px;"><?=number_format($vat=$poc_vat*($total-$disc)/100,0,",",".");?></td>
			    </tr>
				<tr>
				  <td colspan="4" style="text-align:right;">Total Amount &nbsp;</td>
				  <td style="text-align:right; padding-right:5px;"><?=number_format($tamount=($total-$disc)+$vat,0,",",".");?></td>
			    </tr>
			  </table>
			  <?php }else{?>
			  <table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<tr>
				  <th style="text-align:center;">No</th>
				  <th style="text-align:center;">Description</th>
			      <th style="text-align:center;">Price</th>
			      <th style="text-align:center;">Total</th>
				</tr>
				<?php 
				$no=1;$to=0;
				$prod=$this->db
				->join("project","project.project_id=poc.project_id","left")
				->where("poc_no",$this->input->get("poc_no"))
				->get("poc");
				$total=0;
				//echo $this->db->last_query();
				foreach($prod->result() as $product){?>
				<tr>
				  <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
				  <td style="text-align:left;"><?=$product->project_description;?>&nbsp;</td>
			      <td style="text-align:right; padding-right:5px;"><?=number_format($product->project_budget,0,",",".");?></td>
			      <td style="text-align:right; padding-right:5px;"><?=number_format($total+=$product->project_budget,0,",",".");?></td>
				</tr>
				<?php }?>
				<tr>
				  <td colspan="3" style="text-align:right;">Sub Total &nbsp;</td>
				  <td style="text-align:right; padding-right:5px;"><?=number_format($total,0,",",".");?></td>
			    </tr>
				<tr>
				  <td colspan="3" style="text-align:right;">Disc &nbsp;</td>
				  <td style="text-align:right; padding-right:5px;"><?=number_format($disc=$poc_disc*$total/100,0,",",".");?></td>
			    </tr>
				<tr>
				  <td colspan="3" style="text-align:right;">Vat &nbsp;</td>
				  <td style="text-align:right; padding-right:5px;"><?=number_format($vat=$poc_vat*($total-$disc)/100,0,",",".");?></td>
			    </tr>
				<tr>
				  <td colspan="3" style="text-align:right;">Total Amount &nbsp;</td>
				  <td style="text-align:right; padding-right:5px;"><?=number_format($tamount=($total-$disc)+$vat,0,",",".");?></td>
			    </tr>
			  </table>
			  <?php }?>
			</div>
			
			<div class="col-md-3 col-sm-3 col-xs-3 " style="font-size:12px; ">
				<div class="border" align="center">Prepared By  :</div>
				<div class="border"  style="height:100px;">&nbsp;</div>
				<div class="border" align="center"><?=$poc_prepared;?>&nbsp;</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3 " style="font-size:12px;  ">
				<div class="border" align="center">Checked By  :</div>
				<div class="border"  style="height:100px;">&nbsp;</div>
				<div class="border" align="center"><?=$poc_checked;?>&nbsp;</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3 " style="font-size:12px; ">
				<div class="border" align="center">Approved By  :</div>
				<div class="border"  style="height:100px;">&nbsp;</div>
				<div class="border" align="center"><?=$poc_approved;?>&nbsp;</div>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3 " style="font-size:12px; ">
				<div class="border" align="center">Confirmed By  :</div>
				<div class="border" style="height:100px;">&nbsp;</div>
				<div class="border" align="center"><?=$poc_confirmed;?>&nbsp;</div>
			</div>
				
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>