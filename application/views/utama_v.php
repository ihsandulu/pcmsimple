<!DOCTYPE html>
<html>
<head>
<?php require_once("meta.php");?>
<script src="<?=base_url('assets/code/highcharts.js');?>"></script>
<script src="<?=base_url('assets/code/modules/exporting.js');?>"></script>
<script src="<?=base_url('assets/code/modules/export-data.js');?>"></script>
<style>
.panel-kuning{background-color:#FFFF80;}
</style>


</head>

<body>
<?php require_once("header.php");?>
	
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div>
		
		<?php if($_SESSION['position_id']=="1"||$_SESSION['position_id']=="5"||$_SESSION['position_id']=="7"){?>
		
		<div class="row">
		
			<?php if($identity->identity_project==1){?>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-american-sign-language-interpreting iconutama" style="font-size:18px;"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php
							$i=$this->db
							->where("project_selesai","Selesai")		
							->get("project");
							echo $i->num_rows();
							?>
							</div>
							<div class="text-muted">Project Selesai</div>
						</div>
					</div>
				</div>
			</div>
		
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-american-sign-language-interpreting iconutama" style="font-size:18px;"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php
							$i=$this->db
							->where("project_selesai","Belum Selesai")		
							->get("project");
							echo $i->num_rows();
							?>
							</div>
							<div class="text-muted">Project Belum Selesai</div>
						</div>
					</div>
				</div>
			</div>
			<?php }?>
			
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-money iconutama" style="font-size:18px;"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php
							$p=$this->db
							->get("invpaymentproduct");
							$pembayaran=0;
							foreach($p->result() as $p){
								$pembayaran+=($p->invpaymentproduct_qty*$p->invpaymentproduct_amount);
							}
							echo number_format($pembayaran,0,".",",");
							?>
							</div>
							<div class="text-muted">Uang Masuk</div>
						</div>
					</div>
				</div>
			</div>
		
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-money iconutama" style="font-size:18px;"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php
							$p=$this->db
							->get("invspaymentproduct");
							$pengeluaran=0;
							foreach($p->result() as $p){
								$pengeluaran+=($p->invspaymentproduct_qty*$p->invspaymentproduct_amount);
							}
							echo number_format($pengeluaran,0,".",",");
							?>
							</div>
							<div class="text-muted">Uang Keluar</div>
						</div>
					</div>
				</div>
			</div>
		
			<a href="<?=site_url("inv?awal=OK");?>" class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-kuning panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-money iconutama" style="font-size:18px;"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php
							$usr=$this->db
							->group_by("inv_no")
							->order_by("inv_id","desc")
							->get("inv");
							$no=1;
							$invoice=0;
							$pembayaran=0;
							foreach($usr->result() as $inv){
								$i=$this->db
								->where("inv_no",$inv->inv_no)
								->get("invproduct");
								foreach($i->result() as $i){
									$invoice+=($i->invproduct_qty*$i->invproduct_price);
								}
								$p=$this->db
								->join("invpayment","invpaymentproduct.invpayment_no=invpayment.invpayment_no","left")
								->where("inv_no",$inv->inv_no)
								->get("invpaymentproduct");
								foreach($p->result() as $p){
									$pembayaran+=($p->invpaymentproduct_qty*$p->invpaymentproduct_amount);
								}
							}
							echo number_format($invoice-$pembayaran,0,".",",");
							?>
							</div>
							<div class="text-muted">Piutang Invoice</div>
						</div>
					</div>
				</div>
			</a>
		
			<a href="<?=site_url("inv?awal=OK");?>" class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-kuning panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-money iconutama" style="font-size:18px;"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php
							$usr=$this->db
							->where("project_id >","0")
							->group_by("inv_no")
							->order_by("inv_id","desc")
							->get("inv");
							$no=1;
							$invoice=0;
							$pembayaran=0;
							foreach($usr->result() as $inv){
								$i=$this->db
								->where("inv_no",$inv->inv_no)
								->get("invproduct");
								foreach($i->result() as $i){
									$invoice+=($i->invproduct_qty*$i->invproduct_price);
								}
								$p=$this->db
								->join("invpayment","invpaymentproduct.invpayment_no=invpayment.invpayment_no","left")
								->where("inv_no",$inv->inv_no)
								->get("invpaymentproduct");
								foreach($p->result() as $p){
									$pembayaran+=($p->invpaymentproduct_qty*$p->invpaymentproduct_amount);
								}
							}
							echo number_format($invoice-$pembayaran,0,".",",");
							?>
							</div>
							<div class="text-muted">Piutang Project</div>
						</div>
					</div>
				</div>
			</a>
		
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-money iconutama" style="font-size:18px;"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php
							$i=$this->db
							->select("kas_inout, SUM(kas_count)As masuk")
							->where("kas_inout","in")
							->group_by("kas_inout")							
							->get("kas");							
							if($i->num_rows()>0){$in=$i->row()->masuk;}else{$in=0;}
							// $this->db->last_query();
							
							$ou=$this->db
							->select("kas_inout, SUM(kas_count)As keluar")
							->where("kas_inout","out")
							->group_by("kas_inout")
							->get("kas");
							if($ou->num_rows()>0){$out=$ou->row()->keluar;}else{$out=0;}
							echo "Rp. ".number_format($tcash=$in-$out,0,",",".");
							?>
							</div>
							<div class="text-muted">Big Cash</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-money iconutama" style="font-size:18px;"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php
							$i=$this->db
							->select("petty_inout, SUM(petty_amount)As masuk")
							->where("petty_inout","in")
							->group_by("petty_inout")							
							->get("petty");							
							if($i->num_rows()>0){$in=$i->row()->masuk;}else{$in=0;}
							// $this->db->last_query();
							
							$ou=$this->db
							->select("petty_inout, SUM(petty_amount)As keluar")
							->where("petty_inout","out")
							->group_by("petty_inout")
							->get("petty");
							if($ou->num_rows()>0){$out=$ou->row()->keluar;}else{$out=0;}
							echo "Rp. ".number_format($tcash=$in-$out,0,",",".");
							?>
						</div>
							<div class="text-muted">Petty Cash</div>
						</div>
					</div>
				</div>
			</div>
		
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-file-o iconutama" style="font-size:18px;"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php 			
							$opnt=$this->db
							->group_by("inv_no")
							->get_where("inv");
							echo $opnt->num_rows();							
							?>
							</div>
							<div class="text-muted">Invoice</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-info panel-widget" style="background-color:#C6F3F9;">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-file-o iconutama" style="font-size:18px;"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php 			
							$opnt=$this->db
							->group_by("quotation_no")
							->get_where("quotation");
							echo $opnt->num_rows();							
							?>
							</div>
							<div class="text-muted">Quotation</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-info panel-widget" style="background-color:#D1FB99;">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-file-o iconutama" style="font-size:18px;"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php 			
							$opnt=$this->db
							->group_by("po_no")
							->get_where("po");
							echo $opnt->num_rows();							
							?>
							</div>
							<div class="text-muted">PO</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-info panel-widget" style="background-color:#FCD0B6;">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-arrow-circle-right iconutama" style="font-size:18px; color:#36A012"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php 			
							$opnt=$this->db
							->get_where("sjmasuk");
							echo $opnt->num_rows();							
							?>
							</div>
							<div class="text-muted">SJ Masuk</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-info panel-widget" style="background-color:#FDC8BB">
					<div class="row no-padding">
						<div class="col-sm-2 col-lg-2 widget-left">
							<i class="fa fa-arrow-circle-o-left iconutama" style="font-size:18px; color:#CA4004"></i>
						</div>
						<div class="col-sm-10 col-lg-10 widget-right">
							<div class="large" style="font-size:18px;">
							<?php 			
							$opnt=$this->db
							->get_where("sjkeluar");
							echo $opnt->num_rows();							
							?>
							</div>
							<div class="text-muted">SJ Keluar</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
		
		

		<div style="font-size:18px; font-weight:bold; margin-top:40px; margin-bottom:20px;">Supplier</div>	
		
		<div class="col-md-6 col-sm-12 col-xs-12" id="dipesankesupplier" style=" margin: 10px 0 30px 0 ; padding:30px 5px 5px 5px;"></div>
		<script>
		// Radialize the colors
		Highcharts.setOptions({
			colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
				return {
					radialGradient: {
						cx: 0.5,
						cy: 0.3,
						r: 0.7
					},
					stops: [
						[0, color],
						[1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
					]
				};
			})
		});
		
		// Build the chart
		Highcharts.chart('dipesankesupplier', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Sepuluh product paling banyak di pesan'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.y} pcs</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {point.y} pcs',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						},
						connectorColor: 'silver'
					}
				}
			},
			series: [{
				name: 'Jumlah',
				data: [
					<?php $dipesankesupplier=$this->db
					->select("product_name,SUM(invsproduct_qty)AS jml")
					->join("product","product.product_id=invsproduct.product_id","left")
					->order_by("jml","desc")
					->limit("10")
					->get("invsproduct");
					foreach($dipesankesupplier->result() as $a){?>
					{ name: '<?=$a->product_name;?>', y: <?=$a->jml;?> },
					<?php }?>
				]
			}]
		});
		</script>
		
		<div class="col-md-6 col-sm-12 col-xs-12" id="termurah" style=" margin: 10px 0 30px 0; padding:30px 5px 5px 5px;"></div>
		<script>
		Highcharts.chart('termurah', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Sepuluh Product Termurah (dalam ribu)'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>Rp {point.y}</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: Rp {point.y}',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				name: 'Harga',
				colorByPoint: true,
				data: [<?php $dipesankesupplier=$this->db
					->select("product_name,invsproduct_price")
					->join("product","product.product_id=invsproduct.product_id","left")
					->order_by("invsproduct_price","asc")
					->limit("10")
					->get("invsproduct");
					$l=$this->db->last_query();
					foreach($dipesankesupplier->result() as $a){?>
					{ name: '<?=$a->product_name;?>', y: <?=number_format($a->invsproduct_price/1000,0,",",".");?> },
					<?php }?>]
			}]
		});
		</script>
		
		<div class="col-md-12 col-sm-12 col-xs-12" id="supplier" style="margin: 10px 0 30px 0; padding:30px 5px 5px 5px;"></div>
		<script>
		Highcharts.chart('supplier', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Supplier Product'
			},
			xAxis: {
				categories: [<?php $product=$this->db->get("product");foreach($product->result() as $product){echo "'".$product->product_name."',";}?>]
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Product Supplier'
				},
				stackLabels: {
					enabled: true,
					style: {
						fontWeight: 'bold',
						color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
					}
				}
			},
			legend: {
				align: 'right',
				x: -30,
				verticalAlign: 'top',
				y: 25,
				floating: true,
				backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
				borderColor: '#CCC',
				borderWidth: 1,
				shadow: false
			},
			tooltip: {
				headerFormat: '<b>{point.x}</b><br/>',
				pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
			},
			plotOptions: {
				column: {
					stacking: 'normal',
					dataLabels: {
						enabled: true,
						color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
					}
				}
			},
			series: [
			<?php $supplier=$this->db->get("supplier");
			foreach($supplier->result() as $supplier){?>
			{    name: '<?=$supplier->supplier_name;?>',
				data: [
				<?php 
				$product=$this->db->get("product");
				foreach($product->result() as $product){
					$supplierproduct=$this->db
					->where("product_id",$product->product_id)
					->where("supplier_id",$supplier->supplier_id)
					->get("supplierproduct");
					if($supplierproduct->num_rows()>0){echo "1,";}else{echo "0,";}
				}?>
				]
			},
			<?php }?>]
		});
		</script>
		
		<div style="font-size:18px; font-weight:bold; margin-top:40px; margin-bottom:20px;">Customer</div>	
		
		<div class="col-md-6 col-sm-12 col-xs-12" id="banyakdibeli" style=" margin: 10px 0 30px 0; padding:30px 5px 5px 5px;"></div>
		<script>
		Highcharts.chart('banyakdibeli', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Sepuluh Product Banyak Dibeli'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.y} pcs</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {point.y} pcs',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				name: 'Jumlah',
				colorByPoint: true,
				data: [
				
					<?php $dipesankesupplier=$this->db
					->select("*,SUM(invproduct_qty)AS jml")
					->join("product","product.product_id=invproduct.product_id","left")
					->group_by("invproduct.product_id")
					->order_by("jml","desc")
					->limit("10")
					->get("invproduct");
					$l=$this->db->last_query();
					foreach($dipesankesupplier->result() as $a){?>
					{ name: '<?=$a->product_name;?>', y: <?=$a->jml;?> },
					<?php }?>
				
				]
			}]
		});
		</script>
		
		<div class="col-md-6 col-sm-12 col-xs-12" id="sedikitdibeli" style=" margin: 10px 0 30px 0; padding:30px 5px 5px 5px;"></div>
		<script>
		Highcharts.chart('sedikitdibeli', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Sepuluh Product Sedikit Dibeli'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.y} pcs</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {point.y} pcs',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				name: 'Jumlah',
				colorByPoint: true,
				data: [
				
					<?php $dipesankesupplier=$this->db
					->select("*,SUM(invproduct_qty)AS jml")
					->join("product","product.product_id=invproduct.product_id","left")
					->group_by("invproduct.product_id")
					->order_by("jml","asc")
					->limit("10")
					->get("invproduct");
					$l=$this->db->last_query();
					foreach($dipesankesupplier->result() as $a){?>
					{ name: '<?=$a->product_name;?>', y: <?=$a->jml;?> },
					<?php }?>
				
				]
			}]
		});
		</script>
		
		<div class="col-md-6 col-sm-12 col-xs-12" id="dikembalikan" style=" margin: 10px 0 30px 0; padding:30px 5px 5px 5px;"></div>
		<script>
		Highcharts.chart('dikembalikan', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Sepuluh Product Sering Return'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.y} pcs</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {point.y} pcs',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				name: 'Jumlah',
				colorByPoint: true,
				data: [
				
					<?php $dipesankesupplier=$this->db
					->select("*,SUM(gudang_qty)AS jml")
					->join("product","product.product_id=gudang.product_id","left")
					->where("gudang_return","1")
					->group_by("gudang.product_id")
					->order_by("jml","desc")
					->limit("10")
					->get("gudang");
					$l=$this->db->last_query();
					foreach($dipesankesupplier->result() as $a){?>
					{ name: '<?=$a->product_name;?>', y: <?=$a->jml;?> },
					<?php }?>
				
				]
			}]
		});
		</script>
		
		<div class="col-md-6 col-sm-12 col-xs-12" id="po" style=" margin: 10px 0 30px 0; padding:30px 5px 5px 5px;"></div>
		<script>
		Highcharts.chart('po', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Sepuluh Product Sering Dipesan'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.y} pcs</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {point.y} pcs',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				name: 'Jumlah',
				colorByPoint: true,
				data: [
				
					<?php $dipesankesupplier=$this->db
					->select("*,SUM(pocproduct_qty)AS jml")
					->join("product","product.product_id=pocproduct.product_id","left")
					->group_by("pocproduct.product_id")
					->order_by("jml","desc")
					->limit("10")
					->get("pocproduct");
					$l=$this->db->last_query();
					foreach($dipesankesupplier->result() as $a){?>
					{ name: '<?=$a->product_name;?>', y: <?=$a->jml;?> },
					<?php }?>
				
				]
			}]
		});
		</script>
		
		<div class="col-md-6 col-sm-12 col-xs-12" id="termahal" style=" margin: 10px 0 30px 0; padding:30px 5px 5px 5px;"></div>
		<script>
		Highcharts.chart('termahal', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Sepuluh Product Termahal (dalam juta)'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>Rp {point.y}</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: Rp {point.y}',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				name: 'Jumlah',
				colorByPoint: true,
				data: [
				
					<?php $termahal=$this->db
					//->join("product","product.product_id=customerproduct.product_id","left")
					->order_by("product_sell","desc")
					->limit("10")
					->get("product");
					$l=$this->db->last_query();
					foreach($termahal->result() as $a){?>
					{ name: '<?=$a->product_name;?>', y: <?=number_format($a->product_sell/1000000,0,",",".");?> },
					<?php }?>
				
				]
			}]
		});
		</script>
		
		<div class="col-md-6 col-sm-12 col-xs-12" id="murah" style=" margin: 10px 0 30px 0; padding:30px 5px 5px 5px;"></div>
		<script>
		Highcharts.chart('murah', {
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Sepuluh Product Termurah (dalam juta)'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>Rp {point.y}</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: Rp {point.y}',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			},
			series: [{
				name: 'Jumlah',
				colorByPoint: true,
				data: [
				
					<?php $termahal=$this->db
					//->join("product","product.product_id=customerproduct.product_id","left")
					->order_by("product_sell","asc")
					->limit("10")
					->get("product");
					$l=$this->db->last_query();
					foreach($termahal->result() as $a){?>
					{ name: '<?=$a->product_name;?>', y: <?=number_format($a->product_sell/1000000,0,",",".");?> },
					<?php }?>
				
				]
			}]
		});
		</script>
		
		<div class="col-md-12 col-sm-12 col-xs-12" id="pembelian" style=" margin: 10px 0 30px 0; padding:30px 5px 5px 5px;"></div>
		<script>
		
		Highcharts.chart('pembelian', {
			chart: {
				type: 'bar'
			},
			title: {
				text: 'Pembelian'
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: [
				<?php $product=$this->db
				->join("product","product.product_id=invsproduct.product_id","left")
				->group_by("invsproduct.product_id")
				->order_by("invsproduct.product_id","asc")
				->get("invsproduct");
				foreach($product->result() as $product){?>
				'<?=$product->product_name;?>',
				<?php }?>
				],
				title: {
					text: null
				}
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Jumlah',
					align: 'high'
				},
				labels: {
					overflow: 'justify'
				}
			},
			tooltip: {
				valueSuffix: ' pcs'
			},
			plotOptions: {
				bar: {
					dataLabels: {
						enabled: true
					}
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -40,
				y: 80,
				floating: true,
				borderWidth: 1,
				backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
				shadow: true
			},
			credits: {
				enabled: false
			},
			series: [
			<?php $invs=$this->db
			->group_by("invs_date")
			->get("invs");
			$l=$this->db->last_query();
			foreach($invs->result() as $invs){
			?>
			{
				name: '<?=$invs->invs_date;?>',
				data: [
				<?php $product=$this->db
				->group_by("product_id")
				->order_by("product_id","asc")
				->get("invsproduct");
				foreach($product->result() as $product){
					$ijml=$this->db
					->select("SUM(invsproduct_qty)As jml")
					->join("invs","invs.invs_no=invsproduct.invs_no","left")
					->where("invs.invs_date",$invs->invs_date)
					->where("product_id",$product->product_id)
					->get("invsproduct");
					$l=$this->db->last_query();
					$jml=0;
					foreach($ijml->result() as $ijml){
						$jml=$ijml->jml;
						if($jml==""){$jml=0;}
					}
				?>
				<?=$jml;?>,
				<?php }?>
				]
			},
			<?php }?>
			]
		});
		</script>
		
		<div class="col-md-12 col-sm-12 col-xs-12" id="penjualan" style=" margin: 10px 0 30px 0; padding:30px 5px 5px 5px;"></div>
		<script>
		
		Highcharts.chart('penjualan', {
			chart: {
				type: 'bar'
			},
			title: {
				text: 'Penjualan'
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: [
				<?php $product=$this->db
				->join("product","product.product_id=invproduct.product_id","left")
				->group_by("invproduct.product_id")
				->order_by("invproduct.product_id","asc")
				->get("invproduct");
				foreach($product->result() as $product){?>
				'<?=$product->product_name;?>',
				<?php }?>
				],
				title: {
					text: null
				}
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Jumlah',
					align: 'high'
				},
				labels: {
					overflow: 'justify'
				}
			},
			tooltip: {
				valueSuffix: ' pcs'
			},
			plotOptions: {
				bar: {
					dataLabels: {
						enabled: true
					}
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -40,
				y: 80,
				floating: true,
				borderWidth: 1,
				backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
				shadow: true
			},
			credits: {
				enabled: false
			},
			series: [
			<?php $inv=$this->db
			->group_by("inv_date")
			->get("inv");
			$l=$this->db->last_query();
			foreach($inv->result() as $inv){
			?>
			{
				name: '<?=$inv->inv_date;?>',
				data: [
				<?php $product=$this->db
				->group_by("product_id")
				->order_by("product_id","asc")
				->get("invproduct");
				foreach($product->result() as $product){
					$ijml=$this->db
					->select("SUM(invproduct_qty)As jml")
					->join("inv","inv.inv_no=invproduct.inv_no","left")
					->where("inv.inv_date",$inv->inv_date)
					->where("product_id",$product->product_id)
					->get("invproduct");
					$l=$this->db->last_query();
					$jml=0;
					foreach($ijml->result() as $ijml){
						$jml=$ijml->jml;
						if($jml==""){$jml=0;}
					}
				?>
				<?=$jml;?>,
				<?php }?>
				]
			},
			<?php }?>
			]
		});
		</script>
		
		
		<div class="col-md-12 col-sm-12 col-xs-12" id="poo" style=" margin: 10px 0 30px 0; padding:30px 5px 5px 5px;"></div>
		<script>
		
		Highcharts.chart('poo', {
			chart: {
				type: 'bar'
			},
			title: {
				text: 'PO'
			},
			xAxis: {
				categories: [
				<?php $tgl=$this->db
				->group_by("poc_date")
				->order_by("poc_date","desc")
				->get("poc");
				foreach($tgl->result() as $tgl){?>
				'<?=$tgl->poc_date;?>',
				<?php }?>
				]
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Total fruit consumption'
				}
			},
			legend: {
				reversed: true
			},
			plotOptions: {
				series: {
					stacking: 'normal'
				}
			},
			series: [
			<?php $customer=$this->db
			->join("customer","customer.customer_id=poc.customer_id","left")
			->group_by("poc.customer_id")
			->get("poc");
			foreach($customer->result() as $customer){?>
			{
				name: '<?=$customer->customer_name;?>',
				data: [
				<?php $tgl=$this->db
				->group_by("poc_date")
				->order_by("poc_date","desc")
				->get("poc");
				foreach($tgl->result() as $tgl){
					$ijml=$this->db
					->where("customer_id",$customer->customer_id)
					->where("poc_date",$tgl->poc_date)
					->get("poc");
					if($ijml->num_rows()>0){$jml=1;}else{$jml=0;}?>
					<?=$jml;?>,
				<?php }?>
				]
			}, 
			<?php }?>
			]
		});
		</script>		
			
		<div class="col-md-12 col-sm-12 col-xs-12" id="overview" style="margin: 10px 0 30px 0; "></div>
		<script>
		Highcharts.chart('overview', {
			chart: {
				type: 'column',
				backgroundColor:'rgba(255, 255, 255, 0.5)'
			},
			title: {
				text: 'Overview Big Cash'
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				categories: [<?php 
				for($x=-11;$x<1;$x++){
				echo "'".date("M",strtotime("+".$x."month"))."',";
				}
				?>],
				title: {
					text: null
				}
			},
			yAxis: {
				min: 0,
				title: {
					text: '',
					align: 'high'
				},
				labels: {
					formatter: function () {
						return this.value / 1000 + ' ribu';
					},
					overflow: 'justify'
				}
			},
			tooltip: {
				valueSuffix: ' Cash'
			},
			plotOptions: {
				bar: {
					dataLabels: {
						enabled: true
					}
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -40,
				y: 80,
				floating: true,
				borderWidth: 1,
				backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
				shadow: true
			},
			credits: {
				enabled: false
			},
			series: [{
				name: 'Kas Masuk',
				color: 'rgba(186,255,201,1)',
				data: [<?php 
				for($x=-11;$x<1;$x++){
				$date=date("Y-m",strtotime("+".$x."month"));
				$kasm=$this->db
				->select("kas_date, kas_inout, SUM(kas_count)As masuk")
				->where("SUBSTR(kas_date,1,7)",$date)
				->where("kas_inout","in")
				->group_by("kas_count")
				->get("kas");
				if($kasm->num_rows()>0){echo $kasm->row()->masuk.",";}else{echo "0,";}
				}
				?>]
			}, {
				name: 'Kas Keluar',
				color: 'rgba(255,170,165,1)',
				data: [<?php 
				for($x=-11;$x<1;$x++){
				$date=date("Y-m",strtotime("+".$x."month"));
				$kask=$this->db
				->select("kas_date, kas_inout, SUM(kas_count)As keluar")
				->where("SUBSTR(kas_date,1,7)",$date)
				->where("kas_inout","out")
				->group_by("kas_count")
				->get("kas");
				if($kask->num_rows()>0){echo $kask->row()->keluar.",";}else{echo "0,";}
				}
				?>]
			}]
		});
		</script>
		
		
		<div id="flowcash" class="col-md-12 col-sm-12 col-xs-12" style="margin: 10px 0 30px 0; "></div>
		<script>
		Highcharts.chart('flowcash', {
			chart: {
				type: 'areaspline',
				backgroundColor:'rgba(255, 255, 255, 0.5)'
			},
			title: {
				text: 'Cash Flow Big Cash'
			},
			legend: {
				layout: 'vertical',
				align: 'left',
				verticalAlign: 'top',
				x: 150,
				y: 100,
				floating: true,
				borderWidth: 1,
				backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
			},
			xAxis: {
				categories: [
				<?php 
				for($x=-11;$x<1;$x++){
				echo "'".date("M",strtotime("+".$x."month"))."',";
				}
				?>
				   
				],
				plotBands: [{ // visualize the weekend
					from: 4.5,
					to: 6.5,
					color: 'rgba(68, 170, 213, .2)'
				}]
			},
			yAxis: {
				title: {
					text: ''
				}
			},
			tooltip: {
				shared: true,
				valueSuffix: ' Rupiah'
			},
			credits: {
				enabled: false
			},
			plotOptions: {
				areaspline: {
					fillOpacity: 0.5
				}
			},
			series: [{
				name: 'Cash Flow',
				color: 'rgba(201,201,255,0.5)',
					
				data: [<?php 
				for($x=-11;$x<1;$x++){
				
					$in=0; $out=0;
				$date=date("Y-m",strtotime("+".$x."month"));
				
					$i=$this->db
					->select("kas_inout, SUM(kas_count)As masuk")
					->where("kas_inout","in")
					->where("SUBSTR(kas_date,1,7)",$date)
					->group_by("kas_inout")
					->get("kas");
					if($i->num_rows()>0){ $in=$i->row()->masuk;}else{$in=0;}
					
					$ou=$this->db
					->select("kas_inout, SUM(kas_count)As keluar")
					->where("kas_inout","out")
					->where("SUBSTR(kas_date,1,7)",$date)
					->group_by("kas_inout")
					->get("kas");			
					if($ou->num_rows()>0){ $out=$ou->row()->keluar;}else{$out=0;}
					
					echo $in-$out.",";
				}
				?>	]
			}]
		});
		$( ".highcharts-plot-band" ).attr("visibility","hidden");
		</script>
		
	<?php }else{?>
		<div class="well" style="color:black !important; text-shadow:#999999 1px 1px; text-align:center; padding:50px;">
			<h1 style="color:#000066; font-size:36px;">Project Cost Manajement</h1>
			<h1>Welcome <?=ucfirst($_SESSION['user_name']);?>, <?=$data["position_name"];?></h1>
			<h2>Branch : <?=ucfirst($_SESSION['branch_name']);?></h2>
			<?php if($data["user_picture"]!=""){$user_image="assets/images/user_picture/".$data["user_picture"];}else{$user_image="assets/img/user.gif";}?>
			<br/><br/>
			<img class="" alt="User Picture" width="100" height="100" src="<?=base_url($user_image);?>">
			<br/><br/><br/><br/>
		</div>
		<?php }?>
	</div>
	
	
</body>

</html>
