<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");?>
  
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">PO Customer</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> PO Customer</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&!isset($_GET['report'])){?>
			<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="poc_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update PO Customer";}else{$namabutton='name="create"';$judul="Create PO Customer";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
							<?php if(!isset($_GET['quotation_no'])){?>
							<?php 
							$identity_project=$this->db->get("identity")->row()->identity_project;
							if($identity_project==1){?>
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
							  <?php }else{?>
							  	<input type="hidden" readonly="" id="project_id" name="project_id" value="<?=$_GET['project_id'];?>"/>
							  <?php }?>
							  
							  			
													  
							  <?php if($identity->identity_project==1){?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="poc_showproduct">Show product from :</label>
								<div class="col-sm-10">
								  <select class="form-control" name="poc_showproduct" id="poc_showproduct">
								  <option value="0" <?=($poc_showproduct==0)?"selected":"";?>>Pilih product yg akan ditampilkan</option>
								  <option value="1" <?=($poc_showproduct==1)?"selected":($poc_showproduct==0&&$identity->identity_showproduct==1)?"selected":"";?>>From Master Product</option>
								  <option value="2" <?=($poc_showproduct==2)?"selected":($poc_showproduct==0&&$identity->identity_showproduct==2)?"selected":"";?>>From Project</option>
								  </select>
								</div>
							  </div>
							  <?php }?>	
							  
							  <?php if(!isset($_GET['quotation_no'])){?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="customer_id">Customer:</label>
								<div class="col-sm-10">
								  <select name="customer_id" class="form-control" required>
								  <option value="">Select Customer</option>
								  <?php $prod=$this->db->get("customer");
								  foreach($prod->result() as $customer){?>
								  <option value="<?=$customer->customer_id;?>" <?php if($customer_id==$customer->customer_id){?>selected="selected"<?php }?>>
								  	<?=$customer->customer_name;?>
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>
							  <?php }else{?>
							  	<input type="hidden" readonly="" id="customer_id" name="customer_id" value="<?=$_GET['customer_id'];?>"/>
							  <?php }?>			
													  
							  <?php if(isset($_GET['quotation_no'])){?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="quotation_no">Quotation No. :</label>
								<div class="col-sm-10">
								  <input type="text" readonly="" class="form-control" name="quotation_no" id="quotation_no" value="<?=$_GET['quotation_no'];?>"/>
								</div>
							  </div>
							  <?php }?>	
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="poc_no">PO Customer No. :</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="poc_no" id="poc_no" value="<?=$poc_no;?>"/>
								</div>
							  </div>	
							  				  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="poc_date">Date:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control date" name="poc_date" id="poc_date" value="<?=$poc_date;?>"/>
								</div>
							  </div>
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="poc_disc">Discount (%):</label>
								<div class="col-sm-10">
								  <input type="number" class="form-control" name="poc_disc" id="poc_disc" value="<?=$poc_disc;?>"/>
								</div>
							  </div>
							  				  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="poc_vat">Vat (%):</label>
								<div class="col-sm-10">
								  <input type="number" class="form-control" name="poc_vat" id="poc_vat" value="<?=$poc_vat;?>"/>
								</div>
							  </div>
							 
							 <div class="form-group">
								<label class="control-label col-sm-2" for="poc_remarks">Remarks :</label>
								<div class="col-sm-10">
								  <textarea type="text" class="form-control" name="poc_remarks" id="poc_remarks"><?=$poc_remarks;?></textarea>
								  <script>
									CKEDITOR.replace('poc_remarks');
								</script>
								</div>
							  </div>
							  
							 <div class="form-group">
								<label class="control-label col-sm-2" for="poc_prepared">Prepared By :</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="poc_prepared" id="poc_prepared" value="<?=$poc_prepared;?>"/>
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="poc_checked">Checked By :</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="poc_checked" id="poc_checked" value="<?=$poc_checked;?>"/>
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="poc_approved">Approved By :</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="poc_approved" id="poc_approved" value="<?=$poc_approved;?>"/>
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="poc_confirmed">Confirmed By :</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="poc_confirmed" id="poc_confirmed" value="<?=$poc_confirmed;?>"/>
								</div>
							  </div>
							 
                             <div class="form-group">
								<label class="control-label col-sm-2" for="poc_picture">Picture:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file" class="form-control" id="poc_picture" name="poc_picture"><br/>
								<?php if($poc_picture!=""){$user_image="assets/images/poc_picture/".$poc_picture;}else{$user_image="assets/img/user.gif";}?>
								  <img id="poc_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
								  <script>
								  	function readURL(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();
								
											reader.onload = function (e) {
												$('#poc_picture_image').attr('src', e.target.result);
											}
								
											reader.readAsDataURL(input.files[0]);
										}
									}
								
									$("#poc_picture").change(function () {
										readURL(this);
									});
								  </script>
								</div>
							  </div>
                              
							 <input class="form-control" type="hidden" name="poc_id" id="poc_id" value="<?=$poc_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<?php
									if(isset($_GET['quotation_no'])){$quotation_no="&quotation_no=".$_GET['quotation_no']."";}else{$quotation_no="";}
									if(isset($_GET['customer_id'])){$customer_id="&customer_id=".$_GET['customer_id'];}else{$customer_id="";}
									if(isset($_GET['project_id'])){$project_id="&project_id=".$_GET['project_id'];}else{$project_id="";}
									?>
									<a type="button" class="btn btn-warning col-md-offset-1 col-md-5" href="<?=site_url("poc?1=1".$quotation_no.$customer_id.$project_id);?>">Back</a>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadpoc_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-respocnsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<?php if($identity->identity_project=="1"){?>
											<th>Project</th>
											<?php }?>
							  				<?php if(isset($_GET['quotation_no'])){?>
											<th>Quotation No. </th>
											<?php }?>
											<th>PO No. </th>
											<th>Customer</th>
											<th>Picture</th>
											<?php if(!isset($_GET['report'])){$col="col-md-3";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['quotation_no'])){
											$this->db->where("quotation_no",$_GET['quotation_no']);
										}else{
											$this->db->where("quotation_no","");
										}
										$usr=$this->db
										->join("project","project.project_id=poc.project_id","left")
										->join("customer","customer.customer_id=poc.customer_id","left")
										->order_by("poc_id","desc")
										->get("poc");
										$no=1;
										foreach($usr->result() as $poc){?>
										<tr>	
											<td><?=$no++;?></td>										
											<td><?=$poc->poc_date;?></td>
											<?php if($identity->identity_project=="1"){?>
											<td><?=$poc->project_code;?></td>
											<?php }?>
											<?php if(isset($_GET['quotation_no'])){?>
											<td><?=$poc->quotation_no;?></td>
											<?php }?>
											<td><?=$poc->poc_no;?></td>
											<td><?=$poc->customer_name;?></td>
											<td>
											<?php if($poc->poc_picture==""){$poc_picture="noimage.png";}else{$poc_picture=$poc->poc_picture;}?>
											<img onClick="tampilimg(this)" src="<?=base_url("assets/images/poc_picture/".$poc_picture);?>" style="width:25px; height:25px; cursor:pointer; border:grey solid 1px;"/>
											<?php if($poc->poc_picture!=""){?>
											&nbsp;<a class="btn btn-sm btn-warning fa fa-download" href="<?=base_url("assets/images/poc_picture/".$poc->poc_picture);?>" target="_blank"></a>
											<?php }?>                                                                                        
                                            </td>
											<td style="text-align:center; ">  
											<?php if(!isset($_GET['report'])){$float="float:right;";?>   									
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="poc_no" value="<?=$poc->poc_no;?>"/>
												</form>	                                      											
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="poc_id" value="<?=$poc->poc_id;?>"/>
												</form>	
											<?php }else{$float="";}?>											
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Print Invoice" target="_blank" href="<?=site_url("pocprint?poc_no=".$poc->poc_no)."&customer_id=".$poc->customer_id;?>" class="btn btn-sm btn-success " name="edit" value="OK"> 
												  <span class="fa fa-print" style="color:white;"></span>												  </a>
												</form>  
											<?php if(!isset($_GET['report'])){?> 													
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												  <a data-toggle="tooltip" title="List Product" target="_blank" href="<?=site_url("pocproduct?poc_no=".$poc->poc_no)."&customer_id=".$poc->customer_id;?>" class="btn btn-sm btn-info " name="edit" value="OK">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>											  </a>
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
