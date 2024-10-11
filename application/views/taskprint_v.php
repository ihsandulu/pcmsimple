<!DOCTYPE html>
<html>
	<head>
		<title>Print Task</title>
		<meta charset="utf-8">
		<meta name="viewtaskrt" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
	<body>
	<div class="container">
	<div class="row">      
	<?php 
	$identity=$this->db->get("identity")->row();
	if($identity->identity_kop==1){
		require_once("kop.php");
	}
	?>
		<div class="col-md-12 col-sm-12 col-xs-12" style="border-bottom: black solid 1px; margin-bottom:5px;"><h2 style="">Surat Perintah Kerja</h2></div>
		<div class="col-md-6 col-sm-6 col-xs-6" style="">		
			<strong>Customer Address: </strong>
			<br/><?=$customer_name;?>&nbsp;
			<br/><?=$customer_address;?>, &nbsp;<br/>Fax : <?=$customer_fax;?>, &nbsp;Email : <?=$customer_email;?>&nbsp;
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1"></div>
		<div class="col-md-5 col-sm-5 col-xs-5" style="border-left:grey solid 1px;">
			<div class="col-md-12 col-sm-12 col-xs-12">Task No. : <?=$inv_no;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Date : <?=date("d F Y",strtotime($task_date));?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Teknisi : <?=$user_name;?>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">Customer : <?=$customer_name;?>&nbsp;</div>
		</div>		
		<div class="col-md-12 col-sm-12 col-xs-12" style="border-top: black dashed 1px; margin-top:5px; padding-top:20px;">	
			<div class="col-md-12 col-sm-12 col-xs-12">	
		  	Dengan ini kami mengutus kepada saudara <strong><?=$user_name;?></strong> untuk melakukan pekerjaan "<strong><?=$task_content;?></strong>".
			
			 <?php
		  $usr=$this->db
		->join("product","product.product_id=invproduct.product_id","left")
		->where("inv_no",$this->input->get("inv_no"))
		->order_by("invproduct_id","desc")
		->get("invproduct");
		if($usr->num_rows()>0){
		?>
		<br/>
		  <div id="material" class="col-md-12 col-sm-12 col-xs-12">
		  <div style="font-size:18px; font-weight:bold;" class="col-md-12 col-sm-12 col-xs-12">Material / Product</div>
		  <table id="dataTable" class="table table-condensed table-hover table-bordered col-md-12 col-sm-12 col-xs-12">
									<thead>
										<tr>
											<th style="text-align:center;">No.</th>
											<th style="text-align:center;">Material/Product</th>
											<th style="text-align:center;">Remarks</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $invproduct){
										if($invproduct->invproduct_qty==1){$warna="background-color:#BAFFC9;"; $status="Done";}else{$warna="background-color:#FFB3BA;"; $status="";}
										?>
										<tr style="<?=$warna;?>">
										<td style="text-align:center;"><?=$no++;?></td>
										  <td><?=$invproduct->product_name;?></td>
										  <td><?=$invproduct->invproduct_remarks;?></td>
										</tr>
										<?php }?>
									</tbody>
								</table>
		  </div>
		  <?php }?>
			
			Demikian surat ini dibuat sebagai penugasan resmi.
		  </div>
		 
		  <?php if($task_picture!=""){?>
		  <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:20px; margin-bottom:20px; border:#EBEBEB solid 1px; border-radius:5px; padding:10px;">	
		  <img src="<?=base_url("assets/images/task_picture/".$task_picture);?>" style="height:150px; width:auto;"/>
		  </div>
		  <?php }?>
		</div>
	
		<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:12px; padding:20px;">
			<div align="center"><h4><strong>Disetujui Oleh :</strong></h4></div>
			<div  style="height:50px;">&nbsp;</div>
			<div align="center">_________________________________&nbsp;</div>
		</div>
	
		<div class="col-md-2 col-sm-2 col-xs-2">&nbsp;</div>
		
	
	
		<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:12px; padding:20px;">
			<div align="center"><h4><strong><?=$identity_company;?></strong></h4></div>
			<div  style="height:50px;">&nbsp;</div>
			<div align="center">&nbsp;</div>
		</div>
		
		
	
		
				
		
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>