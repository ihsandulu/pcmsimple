<!DOCTYPE html>
<html>
	<head>
		<title>Print SJ Keluar</title>
		<meta charset="utf-8">
		<meta name="viewsjkeluarrt" content="width=device-width, initial-scale=1">
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
	
		<div class="col-md-12"><h3 style="text-decoration:underline;">Surat Jalan</h3></div>
		<div class="col-md-6 col-sm-6 col-xs-6" style=" padding:15px; border-radius:5px; height:120px;">
			
			
			<div class="col-md-12 col-sm-12 col-xs-12">Customer : <?=$customer_name;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Address : <?=$customer_address;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Fax : <?=$customer_fax;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Email : <?=$customer_email;?>&nbsp;</div>
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1"></div>
		<div class="col-md-5 col-sm-5 col-xs-5" style="border:grey solid 1px; padding:15px; border-radius:5px; height:120px;">
			<div class="col-md-12 col-sm-12 col-xs-12">SJ No. : <?=$sjkeluar_no;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Date : <?=date("d F Y",strtotime($sjkeluar_date));?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Ekspedisi : <?=$sjkeluar_ekspedisi;?>&nbsp;</div>
		</div>
		<div style="">&nbsp;<br/><br/></div>
		
			<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px; ">		
			  <table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<tr>
				  <th style="text-align:center;">No</th>
				  <th style="text-align:center;">Description</th>
				  <th style="text-align:center;">Qty</th>
			    </tr>
				<?php 
				$no=1;$to=0;
				$prod=$this->db
				->join("product","product.product_id=sjkeluarproduct.product_id","left")
				->where("sjkeluar_no",$this->input->get("sjkeluar_no"))
				->get("sjkeluarproduct");
				foreach($prod->result() as $product){?>
				<tr>
				  <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->product_name;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->sjkeluarproduct_qty;?>&nbsp;</td>
			    </tr>
				<?php }?>
							
			  </table>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
		
			<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:12px; padding:20px;">
				<div align="center">Pengirim :</div>
				<div align="center"><h5><strong><?=$identity_company;?></strong></h5></div>
				<div  style="height:50px;">&nbsp;</div>
				<div align="center"><?=$sjkeluar_pengirim;?>&nbsp;</div>
			</div>
		
			<div class="col-md-2 col-sm-2 col-xs-2">&nbsp;</div>
			<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:12px; padding:20px;">
				<div align="center">Penerima :</div>
				<div align="center"><h5><strong><?=$customer_name;?></strong></h5></div>
				<div  style="height:50px;">&nbsp;</div>
				<div align="center"><?=$sjkeluar_penerima;?>&nbsp;</div>
			</div>
		
		
			<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
		
		
	
		
				
		
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>