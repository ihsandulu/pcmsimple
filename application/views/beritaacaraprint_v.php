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
	
		<div class="col-md-12 col-sm-12 col-xs-12" align="center"><h3 style="text-decoration:underline;">Berita Acara Serah Terima Lapangan</h3></div>
		<div class="col-md-12 col-sm-12 col-xs-12">
		Pada hari ini <?=date("D");?> tanggal <?=date("d");?> bulan <?=date("M");?>, tahun <?=date("Y");?>, telah dilakukan serah terima atas <?=$sjkeluar_title;?> untuk <?=$customer_name;?>.<br/>
		Yang bertanda tangan dibawah ini:
		</div>
		<div style="">&nbsp;<br/></div>
		
		<div class="col-md-3 col-sm-3 col-xs-3" style="">1. <?=$sjkeluar_pemberitugas;?></div>		
		<div class="col-md-9 col-sm-9 col-xs-9" style="border-left:black solid 1px; padding-left:10px;">
		Selaku <strong>Pemberi Tugas</strong>, bertindak untuk <?=$customer_name;?> yang beralamat di <?=$customer_address;?> dan selanjutnya disebut <strong>PIHAK PERTAMA</strong>
		</div>
		<div style="">&nbsp;<br/></div>
		<div class="col-md-3 col-sm-3 col-xs-3" style="">2. <?=$sjkeluar_penerimatugas;?></div>	
		<div class="col-md-9 col-sm-9 col-xs-9" style="border-left:black solid 1px; padding-left:10px;">
		Selaku <strong>Pelaksana Tugas</strong>, bertindak untuk dan atas nama <?=$identity_name;?> yang beralamat di <?=$identity_address;?> dan selanjutnya disebut <strong>PIHAK KEDUA</strong>
		</div>
		
		
		<div style="">&nbsp;<br/></div>
		<div class="col-md-12 col-sm-12 col-xs-12">
		<strong>PIHAK KEDUA</strong> telah menyelesaikan hal tersebut di atas kepada <strong>PIHAK PERTAMA</strong> dengan kondisi baik dan sesuai dengan ketentuan-ketentuan yang berlaku. Adapun pengadaan barang yang termasuk di dalamnya, antara lain:
		</div>
		
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
				  <td style="text-align:left;"><?=$product->product_name;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->sjkeluarproduct_qty;?>&nbsp;</td>
			    </tr>
				<?php }?>
							
			  </table>
			</div>
			
		<div style="">&nbsp;<br/></div>
		<div class="col-md-12 col-sm-12 col-xs-12">
		Demikian berita acara ini dibuat rangkap untuk dipergunakan sebagaimana mestinya dan di distribusikan ke pihak masing-masing yang terkait.
		</div>
		
			<div class="col-md-12 col-sm-12 col-xs-12" align="right"><?=$identity_city;?>, <?=date("d M Y");?></div>
		
			<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:12px; padding:20px;">
				<div align="center">PIHAK PERTAMA :</div>
				<div align="center"><h5><strong><?=$customer_name;?></strong></h5></div>
				<div  style="height:50px;">&nbsp;</div>
				<div align="center">( <?=$sjkeluar_pemberitugas;?> )</div>
			</div>
		
			<div class="col-md-2 col-sm-2 col-xs-2">&nbsp;</div>
			<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:12px; padding:20px;">
				<div align="center">PIHAK KEDUA :</div>
				<div align="center"><h5><strong><?=$identity_company;?></strong></h5></div>
				<div  style="height:50px;">&nbsp;</div>
				<div align="center">( <?=$sjkeluar_penerimatugas;?> )</div>
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