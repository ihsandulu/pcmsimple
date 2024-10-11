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
				<li class="active">Berita Acara Pemusnahan</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Berita Acara Pemusnahan</h1>
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
								window.open('<?=site_url("bapprint?dari=");?>'+$("#dari").val()+'&ke='+$("#ke").val(),'_blank');
							}
							</script>
							</form>
							</div>
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadbap_picture;?>
							</div>
							<?php }?>
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
												<th>No.</th>
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
										->order_by("bap_id","desc")
											->get("bap");
											$totalbap=0;
											//echo $this->db->last_query();
										$no=1;
											foreach($usr->result() as $bap){?>
											<tr>
											<td><?=$no++;?></td>								
												<td><?=date("Y-m-d",strtotime($bap->bap_datetime));?></td>
												<td><?=$bap->product_name;?></td>
												<td><?=$bap->bap_qty;?></td>
												<td><?=number_format($bap->bap_price,0,",",".");?></td>
												<td><?=number_format($bap->bap_price*$bap->bap_qty,0,",",".");$totalbap+=$bap->bap_price*$bap->bap_qty;?></td>	
												<td><?=$bap->bap_remarks;?></td>
												<td><?=$bap->bap_id;?></td>										
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
			</div>
		</div>
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
