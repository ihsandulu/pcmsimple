<!DOCTYPE html>
<html>
	<head>
		<title>Print Permintaan Barang</title>
		<meta charset="utf-8">
		<meta name="viewpermintaanrt" content="width=device-width, initial-scale=1">
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
	
		<div class="col-md-12"><h3 style="text-decoration:underline;">Goods Request Letter</h3></div>
		<div class="col-md-6 col-sm-6 col-xs-6" style="">
			<div class="col-md-12 col-sm-12 col-xs-12">Request No. : <?=$permintaan_no;?>&nbsp;</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6" style="">
			<div class="col-md-12 col-sm-12 col-xs-12">Date : <?=$permintaan_date;?>&nbsp;</div>
		</div>
		<div style="">&nbsp;<br/></div>
		
			<div class="col-md-12" style="padding:0px; margin-bottom:20px;">		
			  <table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<tr>
				  <th style="text-align:center;">No</th>
				  <th style="text-align:center;">Project</th>
				  <th style="text-align:center;">Product</th>
				  <th style="text-align:center;">Qty</th>
				  <th style="text-align:center;">Name</th>
				  <th style="text-align:center;">Tlp.</th>
			    </tr>
				<?php 
				$no=1;$to=0;
				$prod=$this->db
				->join("project","project.project_id=permintaanproduct.project_id","left")
				->join("product","product.product_id=permintaanproduct.product_id","left")
				->where("permintaan_id",$this->input->get("permintaan_id"))
				->get("permintaanproduct");
				foreach($prod->result() as $product){?>
				<tr>
				  <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->project_name;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->product_name;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->permintaanproduct_qty;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->permintaanproduct_nama;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->permintaanproduct_tlp;?>&nbsp;</td>
			    </tr>
				<?php }?>
							
			  </table>
			</div>
			
			<div class="col-md-12 col-sm-12 col-xs-12">&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Processing Time : <?=$permintaan_pengerjaan;?></div>
			<div class="col-md-12 col-sm-12 col-xs-12">Retention Time : <?=$permintaan_retensi;?></div>
			<div class="col-md-12 col-sm-12 col-xs-12">Worker : <?=$permintaan_tukang;?></div>
			
			
			<div style="">&nbsp;<br/></div>
			
			
			<table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<thead>
					<tr>
						<td class="col-md-3 col-sm-3 col-xs-3" style="text-align:center;">Actual Usage of Goods</td>
						<td class="col-md-3 col-sm-3 col-xs-3">&nbsp;</td>
						<td class="col-md-3 col-sm-3 col-xs-3">&nbsp;</td>
						<td class="col-md-3 col-sm-3 col-xs-3">&nbsp;</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="height:120px; padding:10px;"><?=$permintaan_pemakaian;?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</tbody>
			</table>

		
		
		
			<div style="">&nbsp;<br/><br/></div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:20px;" align="left">
				<div align="left">Note :</div>
				<div align="left"><?=$permintaan_catatan;?>&nbsp;</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:20px; border:black solid 1px;">
				<div align="center">Witness :</div>
				<div  style="height:50px;">&nbsp;</div>
				<div align="center"><?=$permintaan_mengetahui;?>&nbsp;</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:20px; border:black solid 1px;">
				<div align="center">Finance :</div>
				<div  style="height:50px;">&nbsp;</div>
				<div align="center"><?=$permintaan_finance;?>&nbsp;</div>
			</div>
				
		
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>