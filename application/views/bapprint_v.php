<!DOCTYPE html>
<html>
	<head>
		<title>Print BAP</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>
        <style>
		th,td{text-align:center;}
		</style>
	</head>
	<body>
        <div class="container">
            <div class="row">
				<div class="box">
								<div style="margin-bottom:30px !important; border:black solid 1px; border-radius:5px; padding:5px;" align="center">
									<span style=" font-size:16px; font-weight:bold;">BAP : <span id="bap"></span></span>
									<div>
									<?php 
										if(isset($_GET['dari'])&&$_GET['dari']!=""){echo "From : ".date("d M Y",strtotime($_GET['dari']));}
										
										if(isset($_GET['ke'])&&$_GET['ke']!=""){echo "&nbsp;&nbsp;To : ".date("d M Y",strtotime($_GET['ke']));}
									?>
									</div>									
								</div>
								<div id="collapse4" class="body table-responsive">				
									<table id="dataTable" class="table table-condensed table-hover">
										<thead>
											<tr>
												<th>Date</th>
												<th>Product</th>
												<th>Qty</th>
												<th>Price</th>
												<th>Total</th>
												<th>Remarks</th>
											</tr>
										</thead>
										<tbody> 
											<?php 
										if(isset($_GET['dari'])&&$_GET['dari']!=""){
											$this->db->where("bap_datetime >=",$_GET['dari']);
										}
									
										if(isset($_GET['ke'])&&$_GET['ke']!=""){
											$this->db->where("bap_datetime <=",$_GET['ke']);
										}
										$usr=$this->db
											->join("product","product.product_id=bap.product_id","left")
											->get("bap");
											$totalbap=0;
											//echo $this->db->last_query();
											foreach($usr->result() as $bap){?>
											<tr>	
												<td><?=date("Y-m-d",strtotime($bap->bap_datetime));?></td>							
												<td><?=$bap->product_name;?></td>
												<td><?=$bap->bap_qty;?></td>
												<td><?=number_format($bap->bap_price,0,",",".");?></td>
												<td><?=number_format($bap->bap_price*$bap->bap_qty,0,",",".");$totalbap+=$bap->bap_price*$bap->bap_qty;?></td>	
												<td><?=$bap->bap_remarks;?></td>										
											</tr>
											<?php }?>
										</tbody>
									</table>
								</div>
								
								<script>
								$("#bap").html('Rp <?=number_format($totalbap,0,",",".");?>');
								</script>
							</div>
			</div>
        </div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>