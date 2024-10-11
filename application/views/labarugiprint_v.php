<!DOCTYPE html>
<html>
	<head>
		<title>Print Payroll</title>
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
	<?php 
	$identity=$this->db->get("identity")->row();
	if($identity->identity_kop==1){
		require_once("kop.php");
	}
	?>
				<div class="box">
								<div style="margin-bottom:30px !important; border:black solid 1px; border-radius:5px; padding:5px;" align="center">
									<span style=" font-size:16px; font-weight:bold;">L/R Penjualan : <span id="labarugi"></span></span>
									<div>
									<?php 
										if(isset($_GET['dari'])&&$_GET['dari']!=""){echo "From : ".date("d M Y",strtotime($_GET['dari']));}
										
										if(isset($_GET['ke'])&&$_GET['ke']!=""){echo "&nbsp;&nbsp;To : ".date("d M Y",strtotime($_GET['ke']));}
									?>
									</div>									
									
								</div>
								<div style="margin-bottom:10px !important;">
									<span style=" border-bottom:black solid 1px; font-size:16px; font-weight:bold;">Pembelian : <span id="totalpembelian"></span></span>
									
								</div>
								<div id="collapse4" class="body table-responsive">				
									<table id="dataTable" class="table table-condensed table-hover">
										<thead>
											<tr>
												<th>No.</th>
												<th>Date</th>
												<th>Inv No.</th>
												<th>Product</th>
												<th>Qty</th>
												<th>Price</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody> 
											<?php 
										if(isset($_GET['dari'])&&$_GET['dari']!=""){
											$this->db->where("invs_date >=",$_GET['dari']);
										}
									
										if(isset($_GET['ke'])&&$_GET['ke']!=""){
											$this->db->where("invs_date <=",$_GET['ke']);
										}
										$usr=$this->db
											->join("invs","invs.invs_no=invsproduct.invs_no","left")
											->join("product","product.product_id=invsproduct.product_id","left")
											->group_by("invs.invs_no")
											->order_by("invsproduct_id","desc")
											->get("invsproduct");
											$totalpembelian=0;
											//echo $this->db->last_query();
										$no=1;
											foreach($usr->result() as $invsproduct){?>
											<tr>		
												<td><?=$no++;?></td>									
												<td><?=$invsproduct->invs_date;?></td>		
												<td><?=$invsproduct->invs_no;?></td>	
												<td><?=$invsproduct->product_name;?></td>
												<td><?=$invsproduct->invsproduct_qty;?></td>
												<td><?=number_format($invsproduct->invsproduct_price,0,",",".");?></td>
												<td><?=number_format($invsproduct->invsproduct_price*$invsproduct->invsproduct_qty,0,",",".");$totalpembelian+=$invsproduct->invsproduct_price*$invsproduct->invsproduct_qty;?></td>											
											</tr>
											<?php }?>
										</tbody>
									</table>
									<script>
									$("#totalpembelian").html('Rp <?=number_format($totalpembelian,0,",",".");?>');
									</script>
								</div>
								<div style="margin-bottom:10px !important; margin-top:40px;">
									<span style=" border-bottom:black solid 1px; font-size:16px; font-weight:bold;">Penjualan : <span id="totalpenjualan"></span></span>
									
								</div>
								<div id="collapse4" class="body table-responsive">				
									<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>Date</th>
											<th>Inv No.</th>
											<th>Product</th>
											<th>Qty</th>
											<th>Price</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['dari'])&&$_GET['dari']!=""){
											$this->db->where("inv_date >=",$_GET['dari']);
										}
									
										if(isset($_GET['ke'])&&$_GET['ke']!=""){
											$this->db->where("inv_date <=",$_GET['ke']);
										}
										$usr=$this->db
										->join("inv","inv.inv_no=invproduct.inv_no","left")
										->join("product","product.product_id=invproduct.product_id","left")
										->group_by("inv.inv_no")
										->get("invproduct");
										$totalpenjualan=0;
										foreach($usr->result() as $invproduct){?>
										<tr>										
											<td><?=$invproduct->inv_date;?></td>		
											<td><?=$invproduct->inv_no;?></td>			
											<td><?=$invproduct->product_name;?></td>
											<td><?=$invproduct->invproduct_qty;?></td>
											<td><?=number_format($invproduct->invproduct_price,0,",",".");$totalpenjualan+=$invproduct->invproduct_price*$invproduct->invproduct_qty;?></td>
											<td><?=number_format($invproduct->invproduct_price*$invproduct->invproduct_qty,0,",",".");$totalpenjualan+=$invproduct->invproduct_price*$invproduct->invproduct_qty;?></td>																								
										</tr>
										<?php }?>
									</tbody>
								</table>
									<script>
									$("#totalpenjualan").html('Rp <?=number_format($totalpenjualan,0,",",".");?>');
									</script>
								</div>
								
								<script>
								$("#labarugi").html('Rp <?=number_format($totalpenjualan-$totalpembelian,0,",",".");?>');
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