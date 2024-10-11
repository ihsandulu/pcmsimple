<!DOCTYPE html>
<html>
	<head>
		<title>Print SJ Keluar</title>
		<meta charset="utf-8">
		<meta name="viewtaskrt" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
	<body>
	<div class="container">
	<div class="row">
		<!--<div style="">&nbsp;<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></div>-->
		<div class="col-md-12"><h1 style="text-decoration:underline;">Surat Perintah Kerja</h1></div>
		<div class="col-md-6 col-sm-6 col-xs-6" style=" padding:15px; border-radius:5px; height:120px;">
			
			
			<div class="col-md-12 col-sm-12 col-xs-12"><strong>Customer : </strong>
			<br/><?=$customer_name;?>&nbsp;
			<br/><?=$customer_address;?>, &nbsp;<br/>Fax : <?=$customer_fax;?>, &nbsp;Email : <?=$customer_email;?>&nbsp;</div>
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1"></div>
		<div class="col-md-5 col-sm-5 col-xs-5" style="border:grey solid 1px; padding:15px; border-radius:5px; height:120px;">
			<div class="col-md-12 col-sm-12 col-xs-12">Task No. : <?=$task_no;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Date : <?=date("d F Y",strtotime($task_date));?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Teknisi : <?=$user_name;?>&nbsp;</div>
		</div>
		<!----><div style="">&nbsp;<br/></div>
		
			<div class="col-md-12" style="padding:0px; ">		
			  <table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<tr>
				  <th style="text-align:center;">No</th>
				  <th style="text-align:center;">Description</th>
				  <th style="text-align:center;">Qty</th>
			    </tr>
				<?php 
				$no=1;$to=0;
				$prod=$this->db
				->join("product","product.product_id=taskproduct.product_id","left")
				->where("task_no",$this->input->get("task_no"))
				->order_by("taskproduct_id","desc")
				->get("taskproduct");
				$no=1;
				foreach($prod->result() as $product){?>
				<tr>
					<td style="text-align:center;"><?=$no++;?></td>
				  <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->product_name;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->taskproduct_qty;?>&nbsp;</td>
			    </tr>
				<?php }?>
							
			  </table>
			</div>
			<div class="col-md-12">&nbsp;</div>
		
			<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:12px; padding:20px;">
				<div align="center"><strong>Disetujui Oleh :</strong></div>
				<div  style="height:50px;">&nbsp;</div>
				<div align="center">_________________________________&nbsp;</div>
			</div>
		
			<div class="col-md-2 col-sm-2 col-xs-2">&nbsp;</div>
			
		
		
			<div class="col-md-12"><h4><strong><?=$identity_company;?></strong></h4></div>
		
		
	
		
				
		
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>