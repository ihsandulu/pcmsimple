<?php 
  date_default_timezone_set("Asia/Bangkok");
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
 
 
	
	?>
<!DOCTYPE html>
<html>
	<head>
		<title>Print Payment Invoice Customer</title>
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
	
		<div class="col-md-12"><h4 style="text-decoration:underline;">Kwitansi Pembayaran Customer</h4></div>
		<div class="col-md-6 col-sm-6 col-xs-6" style=" padding:15px; border-radius:5px; ">			
			<!--<div class="col-md-12 col-sm-12 col-xs-12">Pay from : <?=$invpayment_payfrom;?>&nbsp;</div>	-->
			<div class="col-md-12 col-sm-12 col-xs-12" style="font-weight:bold;">Faktur Pajak : <?=$invpayment_faktur;?></div>
			<div class="col-md-12 col-sm-12 col-xs-12" style="font-weight:bold;">Pembayaran Ke : <?=$this->input->get("nom");?></div>
			<div class="col-md-12 col-sm-12 col-xs-12">Payment Method : <?=$methodpayment_name;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Customer : <?=$customer_name;?><br/><?=$customer_address;?></div>
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1"></div>
		<div class="col-md-5 col-sm-5 col-xs-5" style="border:grey solid 1px; padding:15px; border-radius:5px;">
			<div class="col-md-12 col-sm-12 col-xs-12">PO No. : <?=$poc_no;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Invoice No. : <?=$inv_no;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Payment No. : <?=$invpayment_no;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Date : <?=date("d F Y",strtotime($invpayment_date));?>&nbsp;</div>
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
				->where("invpayment_no",$this->input->get("invpayment_no"))
				->where("invpaymentproduct_id",$this->input->get("invpaymentproduct_id"))
				->order_by("invpaymentproduct_id","desc")
				->get("invpaymentproduct");
				$total=0;
				foreach($prod->result() as $product){?>
				<tr>
				  <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->invpaymentproduct_description;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->invpaymentproduct_code;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->invpaymentproduct_qty;?>&nbsp;</td>
			      <td style="text-align:center;"><?=number_format($product->invpaymentproduct_amount,2,",",".");?></td>
			      <td style="text-align:center;"><?=number_format($product->invpaymentproduct_amount*$product->invpaymentproduct_qty,2,",",".");$total+=$product->invpaymentproduct_amount*$product->invpaymentproduct_qty;?></td>
				</tr>
				<?php }?>
				<tr>
				  <td colspan="5" style="text-align:center;">TOTAL</td>
				  <td style="text-align:center;"><?=number_format($total,2,",",".");?></td>
			    </tr>
			  </table>
			</div>
			<div class="col-md-8 col-sm-8 col-xs-8" style="font-size:12px; padding:20px;">
			<!-- Terbilang : <strong># <?=ucfirst(terbilang($total));?> Rupiah</strong> -->
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:20px;">
				<div align="center"><?=$identity_company;?>, <?=date("d F Y",strtotime($invpayment_date));?></div>
				<div  style="height:100px;">
				<?php if($identity_stempel!=""){?>
				<img src="<?=base_url("assets/images/identity_picture/".$identity_stempel);?>" style="height:100%; width:auto;"/>
				<?php }?>
				</div>
				<?php if($invpayment_prepareby==""){$ttd="_____________________";}else{$ttd=$invpayment_prepareby;}?>
				<div align="center">( <?=$ttd;?> )</div>
			</div>
						
			<!--<div style="">&nbsp;<br/></div>-->
		
			<!--<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:20px;">
				<div align="center">Prepared By  : <?=$invpayment_prepareby;?></div>
				<div align="center">Date</div>
				<div  style="height:100px;">&nbsp;</div>
			</div>
		
			<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:20px;">
				<div align="center">Received By  : <?=$invpayment_receivedby;?></div>
				<div align="center">Date</div>
				<div  style="height:100px;">&nbsp;</div>
			</div>
			
			<div class="col-md-4 col-sm-4 col-xs-4" style="font-size:12px; padding:20px;">
				<div align="center">Approved By  : <?=$invpayment_approvedby;?></div>
				<div align="center">Date</div>
				<div  style="height:100px;">&nbsp;</div>
			</div>-->
		
		
			<div class="col-md-12">&nbsp;</div>
		
		
	
		
				
		
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>