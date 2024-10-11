<!DOCTYPE html>
<html>
	<head>
		<title>Print SJ Keluar</title>
		<meta charset="utf-8">
		<meta name="viewgudangrt" content="width=device-width, initial-scale=1">
		<link href="<?=base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">	
		<script src="<?=base_url("assets/js/jquery-1.11.1.min.js");?>"></script>
		<script src="<?=base_url('assets/js/bootstrap-datepicker.js');?>"></script>	
		<style>
		.border{border:black solid 1px;}
		.besar{font-size:12px; font-weight:bold;}
		.kecil{font-size:10px;}
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
			<div style="font-size:18px; font-weight:bold;">Warehouse Inventory</div>
		<div class="col-md-12 col-sm-12 col-xs-12" style="padding:0px; margin-top:20px;">		
		  <table id="dataTable" class="table table-condensed table-hover">
				<thead>
					<tr>
						<th>No.</th>
						<th>Date</th>
						<th>Project</th>
						<th>Product</th>
						<th>In / Out</th>
						<th>SJ No.</th>
						<th>Qty</th>
						<?php if($this->session->userdata("position_id")!=-1){?>
						<th>Price</th>
						<?php }?>
						<th class="col-md-1">Info</th>
						<?php if(!isset($_GET['report'])){?>
						<?php }?>
					</tr>
				</thead>
				<tbody> 
					<?php 
					$tqty=0;
					$tprice=0;
					if(isset($_GET['search'])){
						if($_GET['from']!=""){
						$this->db->where("SUBSTR(gudang_datetime,1,10) >=",$_GET['from']);
						}
						if($_GET['to']!=""){
						$this->db->where("SUBSTR(gudang_datetime,1,10) <=",$_GET['to']);
						}
						if($_GET['product']!="0"){
						$this->db->where("gudang.product_id",$_GET['product']);
						}
					}
					
					if($identity->identity_projectwith==1){
						$this->db
						->join("(SELECT * FROM inv GROUP BY inv_no)as inv","inv.inv_no=gudang.inv_no","left")
						->join("project","project.project_id=inv.project_id","left");
					
						if($this->session->userdata("position_id")==3||$this->session->userdata("position_id")==-1){
							$this->db->where("inv.project_id",$this->session->userdata("user_project"));
						}
						
						if($this->session->userdata("position_id")==-1){
							$this->db->where("vendor_id",$this->session->userdata("vendor_id"));
						}
						if(isset($_GET['search'])&&$_GET['project']!=0){
							$this->db->where("inv.project_id",$_GET['project']);
						}
					}
					
					$usr=$this->db
					->join("branch","branch.branch_id=gudang.branch_id","left")
					->join("product","product.product_id=gudang.product_id","left")
					->join("sjmasuk","sjmasuk.sjmasuk_no=gudang.sjmasuk_no","left")
					->join("supplier","supplier.supplier_id=sjmasuk.supplier_id","left")
					->join("sjkeluar","sjkeluar.sjkeluar_no=gudang.sjkeluar_no","left")
					->join("customer","customer.customer_id=sjkeluar.customer_id","left")
					->order_by("gudang_id","desc")
					->get("gudang");
					//echo $this->db->last_query();
					$no=1;
					foreach($usr->result() as $gudang){
					$price=0;
					$price1=$this->db
					->where("inv_no",$gudang->inv_no)
					->where("product_id",$gudang->product_id)
					->get("invproduct");
					foreach($price1->result() as $price1){$price=$price1->invproduct_qty*$price1->invproduct_price;}
					if($gudang->project_name!=null){$project_name=$gudang->project_name;}else{$project_name="";}
					if($gudang->product_picture!=""){$gambar=$gudang->product_picture;}else{$gambar="noimage.png";}
					?>
					<tr>			
						<td><?=$no++;?></td>								
						<td><?=substr($gudang->gudang_datetime,0,10);?></td>
						<td><?=$project_name;?></td>
						<td><?=$gudang->product_name;?></td>
						<td><?=strtoupper($gudang->gudang_inout);?></td>
						<td><?php
						if($gudang->sjmasuk_no!=""){
						$isimasuk="Surat Jalan Masuk ".$gudang->sjmasuk_no."<br/>
						Supplier: ".$gudang->supplier_name."<br/>
						Pengirim: ".$gudang->sjmasuk_pengirim."<br/>
						Penerima: ".$gudang->sjmasuk_penerima."<br/>
						Date: ".$gudang->sjmasuk_date."<br/>
						Ekspedisi: ".$gudang->sjmasuk_ekspedisi;
						?> 
						<a href="#" data-html="true" data-toggle="popover" title="SJ Masuk" data-content="<?=$isimasuk;?>"><?=$gudang->sjmasuk_no;?></a>
						<?php }
						if($gudang->sjkeluar_no!=""){											
						$isikeluar="Surat Jalan Keluar ".$gudang->sjkeluar_no."<br/>
						Supplier: ".$gudang->customer_name."<br/>
						Pengirim: ".$gudang->sjkeluar_pengirim."<br/>
						Penerima: ".$gudang->sjkeluar_penerima."<br/>
						Date: ".$gudang->sjkeluar_date."<br/>
						Ekspedisi: ".$gudang->sjkeluar_ekspedisi;
						?> 
						<a href="#" data-html="true" data-toggle="popover" title="SJ Keluar" data-content="<?=$isikeluar;?>"><?=$gudang->sjkeluar_no;?></a>
						<?php }
						?>											</td>
						<td><?=$gudang->gudang_qty;$tqty+=$gudang->gudang_qty;?></td>
						<?php if($this->session->userdata("position_id")!=-1){?>
						<td><?=number_format($price,2,",",".");$tprice+=$price;?></td>
						<?php }?>
						<td><?=$gudang->gudang_keterangan;?></td>
						<?php if(!isset($_GET['report'])){?>
						<?php }?>	
					</tr>
					<?php }?>
				</tbody>
				<tfoot>
					<tr>
						
					  <th style="text-align:right; font-size:18px; font-weight:bold; background-color:#CCCCCC;" colspan="6">Total</th>
					  <th style="text-align:center;"><?=$tqty;?></th>
					<?php if($this->session->userdata("position_id")!=-1){?>
					  <th><span style="text-align:center;">
						<?=number_format($tprice,2,",",".");?>
					  </span></th>
					  <?php }?>
					  <th>&nbsp;</th>
					</tr>
				  </tfoot>
			</table>
		</div>
				
		
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>