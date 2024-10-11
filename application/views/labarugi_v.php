<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");?>
	<style>
	input{padding:0px !important;}
	</style>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Profit & Lost</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Profit & Lost</h1>
			</div>			
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
							<div class="well">
							<?php 
							if(isset($_GET['dari'])){$dari=$_GET['dari'];}else{$dari="";}
							if(isset($_GET['ke'])){$ke=$_GET['ke'];}else{$ke="";}
							?>
							<form method="get" class="form-inline">
							<div class="form-group">
								<label>From : </label>
								<input id="dari" name="dari" type="date" class="form-control" value="<?=$dari;?>"/>
							</div>
							<div class="form-group">
								<label>To : </label>
								<input id="ke" name="ke" type="date" class="form-control" value="<?=$ke;?>"/>
							</div>
							<button type="submit" class="btn btn-warning fa fa-search"></button>
							<button type="button" onClick="cari()" class="btn btn-success fa fa-print"></button>
							<script>
							function cari(){
								window.open('<?=site_url("labarugiprint?dari=");?>'+$("#dari").val()+'&ke='+$("#ke").val(),'_blank');
							}
							</script>
							</form>
							</div>
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadbranch_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div style="margin-bottom:30px !important; border:black solid 1px; border-radius:5px; padding:5px;" align="center">
									<span style=" font-size:16px; font-weight:bold;">Profit & Lost : <span id="labarugi"></span></span>
									<div>
									<?php 
										if(isset($_GET['dari'])&&$_GET['dari']!=""){echo "From : ".date("d M Y",strtotime($_GET['dari']));}
										
										if(isset($_GET['ke'])&&$_GET['ke']!=""){echo "&nbsp;&nbsp;To : ".date("d M Y",strtotime($_GET['ke']));}
									?>
									</div>									
								</div>
								<div style="margin-bottom:10px !important;">
									<span style=" border-bottom:black solid 1px; font-size:16px; font-weight:bold;">Lost : <span id="totalpembelian"></span></span>
									
								</div>
								<div id="collapse4" class="body table-responsive">				
									<table id="dataTable" class="table table-condensed table-hover">
										<thead>
											<tr>
												<th>No.</th>
												<th>Date</th>
												<th>Inv No.</th>
												<th>Description</th>
												<th>Qty</th>
												<th>Price</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody> 
											<?php 
											if(isset($_GET['dari'])&&$_GET['dari']!=""){
												$this->db->where("invspayment_date >=",$_GET['dari']);
											}
										
											if(isset($_GET['ke'])&&$_GET['ke']!=""){
												$this->db->where("invspayment_date <=",$_GET['ke']);
											}
										
											$usr=$this->db
											->join("invspaymentproduct","invspaymentproduct.invspayment_no=invspayment.invspayment_no","left")
											->join("biaya","biaya.biaya_id=invspaymentproduct.biaya_id","left")
											->order_by("invspayment.invspayment_date","desc")
											->get("invspayment");
											$totalpembelian=0;
											//echo $this->db->last_query();
											$no=1;
											foreach($usr->result() as $invsproduct){
											if($invsproduct->biaya_id==0){
												$invspaymentproduct_description=$invsproduct->invspaymentproduct_description;
											}else{
												$invspaymentproduct_description=$invsproduct->biaya_name;
											}
											
											?>
											<tr>	
												<td><?=$no++;?></td>										
												<td><?=$invsproduct->invspayment_date;?></td>											
												<td><?=$invsproduct->invs_no;?></td>	
												<td style="text-align:left;"><?=$invspaymentproduct_description;?></td>
												<td><?=$invsproduct->invspaymentproduct_qty;?></td>
												<td style="text-align:right;"><?=number_format($invsproduct->invspaymentproduct_amount,0,",",".");?></td>
												<td style="text-align:right;"><?=number_format($invsproduct->invspaymentproduct_amount*$invsproduct->invspaymentproduct_qty,0,",",".");$totalpembelian+=$invsproduct->invspaymentproduct_amount*$invsproduct->invspaymentproduct_qty;?></td>											
											</tr>
											<?php }?>
										</tbody>
									</table>
									<script>
									$("#totalpembelian").html('Rp <?=number_format($totalpembelian,0,",",".");?>');
									</script>
								</div>
								<div style="margin-bottom:10px !important; margin-top:40px;">
									<span style=" border-bottom:black solid 1px; font-size:16px; font-weight:bold;">Profit : <span id="totalpenjualan"></span></span>
									
								</div>
								<div id="collapse4" class="body table-responsive">				
									<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>Date</th>
											<th>Inv No.</th>
											<th>Description</th>
											<th>Qty</th>
											<th>Price</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['dari'])&&$_GET['dari']!=""){
											$this->db->where("invpayment_date >=",$_GET['dari']);
										}
									
										if(isset($_GET['ke'])&&$_GET['ke']!=""){
											$this->db->where("invpayment_date <=",$_GET['ke']);
										}
										$usr=$this->db
										->join("invpaymentproduct","invpaymentproduct.invpayment_no=invpayment.invpayment_no","left")
										->order_by("invpayment.invpayment_date","desc")
										->get("invpayment");
										$totalpenjualan=0;
										foreach($usr->result() as $invproduct){?>
										<tr>										
											<td><?=$invproduct->invpayment_date;?></td>		
											<td><?=$invproduct->inv_no;?></td>			
											<td style="text-align:left;"><?=$invproduct->invpaymentproduct_description;?></td>
											<td><?=$invproduct->invpaymentproduct_qty;?></td>
											<td style="text-align:right;"><?=number_format($invproduct->invpaymentproduct_amount,0,",",".");?></td>	
											<td style="text-align:right;"><?=number_format($invproduct->invpaymentproduct_amount*$invproduct->invpaymentproduct_qty,0,",",".");$totalpenjualan+=$invproduct->invpaymentproduct_amount*$invproduct->invpaymentproduct_qty;?></td>																			
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
			</div>
		</div>
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
