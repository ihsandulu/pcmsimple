<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");
	?>
	<style>
	.cari{margin:0px 0px 10px 0px;}
	.carikonten{}
	</style>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Warehouse Inventory</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<?php if(isset($_GET['daurulang'])&&!isset($_POST['new'])&&!isset($_POST['edit'])){$coltitle="col-md-8";}else{$coltitle="col-md-10";}?>
			<div class="<?=$coltitle;?>">
				<h1 class="page-header"> Warehouse Inventory</h1>
			</div>
			<?php if(isset($_GET['daurulang'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button onClick="tutup()" class="btn btn-danger btn-block btn-lg" value="OK" style="">Close</button>
				<script>
				function tutup(){
					window.opener.location.reload();
					window.close();
				}
				</script>
				</h1>
			</form>
			<?php }?>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<?php if(!isset($_GET['report'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="gudang_id"/>
				</h1>
			</form>
			<?php }?>
			<?php }?>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Stock";}else{$namabutton='name="create"';$judul="Add Stock";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
								<?php if(isset($_GET['daurulang'])){
									$gudang_qty=$this->input->get("gudang_qty");
									$gudang_inout=$this->input->get("gudang_inout");
									$gudang_keterangan=$this->input->get("gudang_keterangan");
								}?>
								<div class="form-group">
								<label class="control-label col-sm-2" for="unit_id">Product:</label>
								<div class="col-sm-10">
									<datalist id="product">
										<?php $uni=$this->db->get("product");
										  foreach($uni->result() as $cusprod){?>											
										  <option id="<?=$cusprod->product_id;?>" value="<?=$cusprod->product_name;?>">
										<?php }?>
									</datalist>	  
									<input autofocus onChange="productid(this)" class="form-control" list="product" value="<?=$product_name;?>">	
									<input type="hidden" list="product" id="product_id" name="product_id" value="<?=$product_id;?>">
									<script>
										function productid(a){
											var opt = $('option[value="'+$(a).val()+'"]');
											$("#product_id").val(opt.attr('id'));
										}
									</script>	
								  
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gudang_qty">Qty:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" id="gudang_qty" name="gudang_qty" placeholder="" value="<?=$gudang_qty;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gudang_inout">In / Out:</label>
								<div class="col-sm-10">
								<div class="radio">
									<label><input value="in" type="radio" <?php if($gudang_inout=="in"){echo'checked="checked"';}?> name="gudang_inout">In</label>
								</div>
								<div class="radio">
									<label><input value="out" type="radio" <?php if($gudang_inout=="out"){echo'checked="checked"';}?> name="gudang_inout">Out</label>
								</div>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="gudang_keterangan">Remarks:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="gudang_keterangan" name="gudang_keterangan" placeholder="" value="<?=$gudang_keterangan;?>">
								</div>
							  </div>
							  
							  <?php if(isset($_GET['daurulang'])){?>							  
							  <input type="hidden" name="gudang_return" value="1"/>	
							  <?php }?>
							  <input type="hidden" name="gudang_id" value="<?=$gudang_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("gudang");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadgudang_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div class="carikonten well">
								<form class="form-inline cari">
									<div class="form-group">
										<label for="from">From</label>
										<input name="from" type="date" class="form-control" value="<?=(isset($_GET['from']))?$_GET['from']:date("Y-m-d");?>"/>
									</div>
									<div class="form-group cari">
										<label for="to">To</label>
										<input name="to" type="date" class="form-control" value="<?=(isset($_GET['to']))?$_GET['to']:date("Y-m-d");?>"/>
									</div>
									<?php if($identity->identity_projectwith==1){?>
									<br/>
									<br/>
									<div class="form-group cari">
										<label for="to">Project</label>
										<select name="project" class="form-control">
											<option value="0" <?=(isset($_GET['project'])&&$_GET['project']=="")?"selected":"";?>>Select Project</option>
											<?php 
											if($this->session->userdata("position_id")!=1 && $this->session->userdata("position_id")!=7){
												$this->db->where("project_id",$this->session->userdata("user_project"));
											}
											$pro=$this->db->get("project");
											foreach($pro->result() as $project){?>
											<option value="<?=$project->project_id;?>" <?=(isset($_GET['project'])&&$_GET['project']==$project->project_id)?"selected":"";?>><?=$project->project_name;?></option>
											<?php }?>
										</select>
									</div>
									<div class="form-group cari">
										<label for="customer">Customer</label>
										<select id="customer" name="customer" class="form-control">
											<option value="0" <?=(isset($_GET['customer'])&&$_GET['customer']=="")?"selected":"";?>>Select Customer</option>
											<?php 
											$pro=$this->db->get("customer");
											foreach($pro->result() as $customer){?>
											<option value="<?=$customer->customer_id;?>" <?=(isset($_GET['customer'])&&$_GET['customer']==$customer->customer_id)?"selected":"";?>><?=$customer->customer_name;?></option>
											<?php }?>
										</select>
									</div>
									<?php }?>
									<div class="form-group cari">
										<label for="to">Product</label>
										<select name="product" class="form-control">
											<option value="0" <?=(isset($_GET['product'])&&$_GET['product']=="")?"selected":"";?>>Select Product</option>
											<?php 
											if($identity->identity_project==1){
											$this->db->join("projectproduct","projectproduct.product_id=product.product_id","left");
											$this->db->join("project","project.project_id=projectproduct.project_id","left");
											if($this->session->userdata("position_id")!=1 && $this->session->userdata("position_id")!=7&&$identity->identity_productcustomer==3){
												$this->db->where("projectproduct.project_id",$this->session->userdata("user_project"));
											}
											}
											$product=$this->db->get("product");
											foreach($product->result() as $product){?>
											<option value="<?=$product->product_id;?>" <?=(isset($_GET['product'])&&$_GET['product']==$product->product_id)?"selected":"";?>><?=$product->product_name;?></option>
											<?php }?>
										</select>
									</div>
									<?php if(isset($_GET['report'])){?>
									<input type="hidden" name="report" value="ok"/>
									<?php }?>
									<button name="search" class="btn btn-primary">
										<i class="fa fa-search"></i>
									</button>
									<?php 
									if(isset($_GET['from'])){$from=$_GET['from'];}else{$from="";}
									if(isset($_GET['to'])){$to=$_GET['to'];}else{$to="";}
									if(isset($_GET['project'])){$project=$_GET['project'];}else{$project="";}
									if(isset($_GET['product'])){$product=$_GET['product'];}else{$product="";}
									if(isset($_GET['search'])){$search=$_GET['search'];}else{$search="";}
									
									if(isset($_GET['report'])&&$_GET['report']=='ok'){?>
									<a target="_blank" href="<?=site_url("gudangprint?from=".$from."&to=".$to."&project=".$project."&product=".$product."&search=".$search."");?>" class="btn btn-success">
										<i class="fa fa-print"></i>
									</a>
									<?php }?>
								</form>
								</div>
							  <div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Project</th>
											<th>Customer</th>
											<th>Product</th>
											<th>In / Out</th>
											<th>SJ No.</th>
											<th>Qty</th>
											<?php if($this->session->userdata("position_id")!=-1){?>
											<th>Price</th>
											<?php }?>
											<th class="col-md-1">Info</th>
											<th class="col-md-1">Picture</th>
											<?php if(!isset($_GET['report'])){?>
											<th class="col-md-1">Action</th>
											<?php }?>
										</tr>
									</thead>
									<tbody> 
										<?php 
										$tqty=0;
										$tprice=0;
										if(isset($_GET['search'])){
											if(isset($_GET['from'])&&$_GET['from']!=""){
												$this->db->where("SUBSTR(gudang_datetime,1,10) >=",$_GET['from']);
											}
											if(isset($_GET['to'])&&$_GET['to']!=""){
												$this->db->where("SUBSTR(gudang_datetime,1,10) <=",$_GET['to']);
											}
											if(isset($_GET['product'])&&$_GET['product']!="0"){
											$this->db->where("gudang.product_id",$_GET['product']);
											}
											if(isset($_GET['customer'])&&$_GET['customer']!="0"){
											$this->db->where("sjkeluar.customer_id",$_GET['customer']);
											}
										}else{
											$this->db->where("SUBSTR(gudang_datetime,1,10) >=",date("Y-m-d"));
											$this->db->where("SUBSTR(gudang_datetime,1,10) <=",date("Y-m-d"));
										}
										
										if($identity->identity_project=1){
											/*$this->db
											->join("invproduct","invproduct.invproduct_id=gudang.invproduct_id","left")
											->join("(SELECT * FROM inv GROUP BY inv_no)as inv","inv.inv_no=invproduct.inv_no","left")
											->join("project","project.project_id=inv.project_id","left");*/	
											
											$this->db
											->join("(SELECT * FROM inv GROUP BY inv_no)as inv","inv.inv_no=gudang.inv_no","left")
											->join("project","project.project_id=inv.project_id","left");									
										}
										
										if($identity->identity_projectwith==1){
										
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
										
										if($this->session->userdata("position_id")==-1){
											$this->db->join("projectproduct","projectproduct.product_id=gudang.product_id","left");
											$this->db->where("projectproduct_tampil","1");
										}
										
										$usr=$this->db
										->join("branch","branch.branch_id=gudang.branch_id","left")
										->join("product","product.product_id=gudang.product_id","left")
										->join("sjmasuk","sjmasuk.sjmasuk_no=gudang.sjmasuk_no","left")
										->join("supplier","supplier.supplier_id=sjmasuk.supplier_id","left")
										->join("sjkeluar","sjkeluar.sjkeluar_no=gudang.sjkeluar_no","left")
										->join("customer","customer.customer_id=sjkeluar.customer_id","left")
										->order_by("gudang.gudang_id","desc")
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
											<?php
											if($gudang->sjkeluar_no!=""){$customer_name=$gudang->customer_name;}else{$customer_name="";}
											?>
											<td><?=$customer_name;?></td>
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
											<td><img onClick="tampil(this)" src="<?=base_url("assets/images/product_picture/".$gambar);?>" style="width:20px; height:20px;">
											<script>
											function tampil(a){
												var gambar=$(a).attr("src");
												$("#imgumum").attr("src",gambar);
												$("#myImage").modal("show");
											}
											</script>											</td>
											<?php if(!isset($_GET['report'])){?>
											<td style="padding-left:0px; padding-right:0px;">
											<?php if($this->session->userdata("branch_id")==$gudang->branch_id){?>												
												<form method="post" class="" style="padding:0px; margin:2px; float:left;">
													<button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="gudang_id" value="<?=$gudang->gudang_id;?>"/>
												</form>
											
												<form method="post" class="" style="padding:0px; margin:2px; float:left;">
													<button class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="gudang_id" value="<?=$gudang->gudang_id;?>"/>
												</form>	
											<?php }?>											</td>
											<?php }?>	
										</tr>
										<?php }?>
									</tbody>
									<tfoot>
										<tr>
											
										  <th style="text-align:right; font-size:18px; font-weight:bold; background-color:#CCCCCC;" colspan="7">Total</th>
										  <th style="text-align:center;"><?=$tqty;?></th>
										<?php if($this->session->userdata("position_id")!=-1){?>
										  <th><span style="text-align:center;">
										    <?=number_format($tprice,2,",",".");?>
										  </span></th>
										  <?php }?>
										  <th>&nbsp;</th>
										  <th>&nbsp;</th>
										  <th style="padding-left:0px; padding-right:0px;">&nbsp;</th>
									  	</tr>
									  </tfoot>
								</table>
							  </div>
							</div>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
