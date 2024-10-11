<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");
   $t=array("","Supplier","Makloon");
   ?>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Invoice Supplier / Makloon</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Invoice Supplier / Makloon</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&!isset($_GET['report'])){?>
			<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="invs_id"/>
				</h1>
			</form>
			<?php }?>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Invoice Supplier / Makloon";}else{$namabutton='name="create"';$judul="Create Invoice Supplier / Makloon";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								
								<?php if($identity->identity_project=="1"){?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="project_id">Project:</label>
								<div class="col-sm-10">
								  <select id="project_id" name="project_id" class="form-control">
								  <option value="">Select Project</option>
								  <?php $proj=$this->db->get("project");
								  foreach($proj->result() as $project){?>
								  <option value="<?=$project->project_id;?>" <?php if($project_id==$project->project_id){?>selected="selected"<?php }?>>
								  	(<?=$project->project_code;?>) <?=$project->project_name;?>
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>
							  <?php }?>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="supplier_id">Supplier / Makloon:</label>
								<div class="col-sm-10">
								  <select name="supplier_id" class="form-control" required>
								  <option value="">Select Supplier / Makloon</option>
								  <?php 
								  $prod=$this->db->get("supplier");
								  foreach($prod->result() as $supplier){?>
								  <option value="<?=$supplier->supplier_id;?>" <?php if($supplier_id==$supplier->supplier_id){?>selected="selected"<?php }?>>
								  	<?=$supplier->supplier_name;?> ( <?=$t[$supplier->supplier_type];?> )
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>			
													  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invs_no">Invoice No. :</label>
								<div class="col-sm-10">
								  <input onClick="this.select()" required type="text" class="form-control" name="invs_no" id="invs_no" value="<?=$invs_no;?>"/>
								</div>
							  </div>	
							  				  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invs_date">Date (Tanggal Terima Invoice):</label>
								<div class="col-sm-10">
								<?php if($invs_date==""){$invs_date=date("Y-m-d");}?>
								  <input type="text" class="form-control date" name="invs_date" id="invs_date" value="<?=$invs_date;?>"/>
								</div>
							  </div>
                              
                              <div class="form-group">
								<label class="control-label col-sm-2" for="invs_duedate">Due Date (Batas Pembayaran):</label>
								<div class="col-sm-10">
								<?php if($invs_duedate==""){$invs_duedate=date("Y-m-d");}?>
								  <input type="text" class="form-control date" name="invs_duedate" id="invs_duedate" value="<?=$invs_duedate;?>"/>
								</div>
							  </div>
							  <!--
							   <div class="form-group">
								<label class="control-label col-sm-2" for="invs_disc">Discount (%):</label>
								<div class="col-sm-10">
								  <input type="number" class="form-control" name="invs_disc" id="invs_disc" value="<?=$invs_disc;?>"/>
								</div>
							  </div>
							  				  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invs_vat">Vat (%):</label>
								<div class="col-sm-10">
								  <input type="number" class="form-control" name="invs_vat" id="invs_vat" value="<?=$invs_vat;?>"/>
								</div>
							  </div>
							 
							 <div class="form-group">
								<label class="control-label col-sm-2" for="invs_confirm">Confirm By :</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="invs_confirm" id="invs_confirm" value="<?=$invs_confirm;?>"/>
								</div>
							  </div>
							  -->
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invs_picture">Scan Invoice:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file"  id="invs_picture" name="invs_picture"><br/>
								<?php if($invs_picture!=""){$user_image="assets/images/invs_picture/".$invs_picture;}else{$user_image="assets/images/invs_picture/image.gif";}?>
								  <img id="invs_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
								  <script>
									function readURL(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();
								
											reader.onload = function (e) {
												$('#invs_picture_image').attr('src', e.target.result);
											}
								
											reader.readAsDataURL(input.files[0]);
										}
									}
								
									$("#invs_picture").change(function () {
										readURL(this);
									});
								  </script>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invs_faktur">Scan Faktur Pajak:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file"  id="invs_faktur" name="invs_faktur"><br/>
								<?php if($invs_faktur!=""){$user_image="assets/images/invs_picture/".$invs_faktur;}else{$user_image="assets/images/invs_picture/image.gif";}?>
								  <img id="invs_faktur_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
								  <script>
									function readURL1(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();
								
											reader.onload = function (e) {
												$('#invs_faktur_image').attr('src', e.target.result);
											}
								
											reader.readAsDataURL(input.files[0]);
										}
									}
								
									$("#invs_faktur").change(function () {
										readURL1(this);
									});
								  </script>
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="">Price :</label>
								<div class="col-sm-10">
								  <?php 
									$usr=$this->db
									->join("product","product.product_id=invsproduct.product_id","left")
									->where("invs_no",$invs_no)
									->group_by("invsproduct.product_id")
									->order_by("invsproduct_id","desc")
									->get("invsproduct");
									$no=1;
									//echo $this->db->last_query();
									foreach($usr->result() as $invsproduct){?>
										<label class="control-label col-sm-6" for=""><?=$invsproduct->product_name;?> :</label>
										<div class="col-sm-6">
										  <input type="number" min="0" class="form-control" name="price<?=$invsproduct->product_id;?>" id="invsproduct_id" value=""/>
										</div>
										<br/>
										<br/>
									<?php }?>
								</div>							
							  </div>
							 
							 <input class="form-control" type="hidden" name="invs_id" id="invs_id" value="<?=$invs_id;?>"/>			  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button type="button" class="btn btn-warning col-md-offset-1 col-md-5" onClick="kembali()">Back</button>
									<script>
									function kembali(){location.href='<?=site_url("invs");?>'}
									</script>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadinvs_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-resinvsnsive">				
								<table id="dataTableinv" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Branch</th>
											<th>Invoice No. </th>
											<th>SJMasuk</th>
											<?php if($identity->identity_project=="1"){?>
											<th>Project</th>
											<?php }?>
											<th>Type</th>
											<th>Supplier / Makloon</th>
											<?php if(!isset($_GET['report'])){$col="col-md-3";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->select("*, invs.supplier_id AS supplier_id")
										->join("branch","branch.branch_id=invs.branch_id","left")
										->join("project","project.project_id=invs.project_id","left")
										->join("customer","customer.customer_id=project.customer_id","left")
										->join("supplier","supplier.supplier_id=invs.supplier_id","left")
										->join("sjmasuk","sjmasuk.sjmasuk_id=invs.sjmasuk_id","left")
										->order_by("invs_id","desc")
										->get("invs");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $invs){
										$tagihan=0;
										$tagihan1=$this->db
										->select("SUM(invsproduct_qty*invsproduct_price)AS tagihan")
										->where("invs_no",$invs->invs_no)
										->group_by("invs_no")
										->get("invsproduct");
										//echo $this->db->last_query();
										foreach($tagihan1->result() as $tagihan2){$tagihan=$tagihan2->tagihan;}
										?>
										<tr>											
											<td><?=$no++;?></td>			
											<td><?=$invs->invs_date;?></td>
											<td><?=$invs->branch_name;?></td>
											<td><?=$invs->invs_no;?></td>
											<td> <?=$invs->sjmasuk_no;?>
											<select class="form-control" id="sjmasuk" onChange="inputsjmasuk_invoice(this.value,'<?=$invs->invs_no;?>','<?=$invs->invs_id;?>')">
                                                	<option value="0">Select SJ Masuk</option>
                                                	<?php $sjmasuk=$this->db
													->get("sjmasuk");
													foreach($sjmasuk->result() as $sjmasuk){
													$invs2=$this->db
													->where("sjmasuk_id",$sjmasuk->sjmasuk_id)
													->get("invs");
													$a=$this->db->last_query();
													if($invs2->num_rows()==0){
													?>
                                                    <option value="<?=$sjmasuk->sjmasuk_id;?>" <?=($invs->sjmasuk_id==$sjmasuk->sjmasuk_id)?"selected":"";?>><?=$sjmasuk->sjmasuk_no;?></option>
                                                    <?php }}?>
                                                </select>
                                                <script>
												function inputsjmasuk_invoice(a,b,c){//alert(a+"/"+b+"/"+c);
												$.get("<?=site_url("api/inputsjmasuk_invoice");?>",{sjmasuk_id:a,invs_no:b,invs_id:c})
												.done(function(data){alert(data);
													if(data=="Update Success"){
														window.location.href='<?=current_url();?>?message='+data;
													}
												   $("#messageisi").html(data);
												   $("#message").show();
												   setTimeout(function(){$("#message").hide();},2000);
												});
												}
												</script>  
											</td>
											<?php if($identity->identity_project=="1"){?>
											<td><?=$invs->project_name;?></td>
											<?php }?>
											<td><?=$t[$invs->supplier_type];?></td>
											<td style="text-align:left;"><?=$invs->supplier_name;?></td>
											<td style="text-align:center; ">  
											<?php if(!isset($_GET['report'])){$float="float:right;";?>   									
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="invs_no" value="<?=$invs->invs_no;?>"/>
												</form>	                                      											
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="invs_id" value="<?=$invs->invs_id;?>"/>
												</form>	
											<?php }else{$float="";}?>											
												<!--<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Print Invoice" target="_blank" href="<?=site_url("invsprint?invs_no=".$invs->invs_no)."&supplier_id=".$invs->supplier_id;?>" class="btn btn-sm btn-success " name="edit" value="OK"> 
												  <span class="fa fa-print" style="color:white;"></span>												  </a>
												</form>  -->
											<?php if(!isset($_GET['report'])){?> 	
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												  <a data-toggle="tooltip" title="Account Payable" target="_blank" href="<?=site_url("invspayment?invs_no=".$invs->invs_no)."&supplier_id=".$invs->supplier_id."&tagihan=".$tagihan;?>" class="btn btn-sm btn-primary " name="payment" value="OK">
												  <span class="fa fa-money" style="color:white;"></span>											  </a>
												</form> 	 
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												  <a data-toggle="tooltip" title="List Product" target="_blank" href="<?=site_url("invsproduct?invs_no=".$invs->invs_no)."&supplier_id=".$invs->supplier_id;?>" class="btn btn-sm btn-info " name="edit" value="OK">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>											  </a>
												</form> <!---->	 
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												   <a style="color:green; border:green solid 2px;" href="<?=base_url("assets/images/invs_picture/".$invs->invs_picture);?>" target="_blank" data-toggle="tooltip" title="Scan Invoice"  type="button" class="btn btn-default" id="myBtn"><span class="fa fa-file-image-o" ></span></a>
												</form> 
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												   <a style="color:blue; border:blue solid 2px;" href="<?=base_url("assets/images/invs_picture/".$invs->invs_faktur);?>" target="_blank" data-toggle="tooltip" title="Scan Faktur"  type="button" class="btn btn-default" id="myBtn"><span class="fa fa-file-image-o"></span></a>
												</form> 
											<?php }?>											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
							  </div>
							</div>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	

   
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
