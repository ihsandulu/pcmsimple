<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");?>
	<style>
	.hide{display:none;}
	</style>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Quotation</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<?php if(isset($_GET['product_id'])){$colmd=8;}else{$colmd=10;}?>
			<div class="col-md-<?=$colmd;?>">
				<h1 class="page-header"> Quotation <?=$product_name;?></h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&$this->session->userdata("position_id")!=6&&!isset($_GET['report'])){?>
			<?php if(isset($_GET['product_id'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button type="button" onClick="window.opener.location='<?=site_url("jualan?product_id=".$_GET['product_id']);?>'; window.close();" class="btn btn-warning btn-lg btn-block" style="">Back</button>
				<input type="hidden" name="quotation_id"/>
				</h1>
			</form>
			<?php }?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="quotation_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Quotation";}else{$namabutton='name="create"';$judul="Create Quotation";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							<?php if($this->session->userdata("position_id")!=3){?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_access">
								Access to follow up
								</label>
								<div class="col-sm-10">
								<select class="form-control" id="quotation_access" name="quotation_access">
									<?php 
									$user1=$this->db
									->where("position_id",3)
									->get("user");
									foreach($user1->result() as $user){?>
									<option value="<?=$user->user_id;?>" <?=($user_id==$user->user_id)?"selected":"";?>><?=$user->user_name;?></option>
									<?php }?>
								</select>
								</div>
							</div>
							<?php }?>
							 <?php if($quotation_no!=""){?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_no">Quotation No.</label>
								<div class="col-sm-10">
									<input readonly="" type="text" class="form-control" id="quotation_no" value="<?=$quotation_no;?>">									
								</div>
							</div>
							<?php }?>
							
							<!--
							<?php if($identity->identity_project==1){?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_access">Project</label>
								<div class="col-sm-10">
								<select class="form-control" id="quotation_access" name="quotation_access">
									<?php 
									$project=$this->db
									->where("project_selesai","Belum Selesai")
									->get("project");
									foreach($project->result() as $project){?>
									<option value="<?=$project->project_id;?>" <?=($project_id==$project->project_id)?"selected":"";?>><?=$project->project_name;?></option>
									<?php }?>
								</select>
								</div>
							</div>
							<?php }?>
							-->
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="unit_id">Customer:</label>
								<div class="col-sm-10"><?=($customer_name!="")?$customer_name."<br/>":"";?>
									<input <?=($pilihcustomer=="satu")?"checked":"";?> required="" type="radio" name="pilihcustomer" id="satu" onClick="pilih('satu')" value="satu" aria-required="true"> <label for="satu" style="cursor:pointer;">Single Customer</label>
									<input <?=($pilihcustomer=="banyak")?"checked":"";?> required="" type="radio" name="pilihcustomer" id="banyak" onClick="pilih('banyak')" value="banyak" aria-required="true"> <label for="banyak" style="cursor:pointer;">Multiple Customer (Press CTRL + Left Click)</label>
									<input <?=($pilihcustomer=="grup")?"checked":"";?> required="" type="radio" name="pilihcustomer" id="grup" onClick="pilih('grup')" value="grup" aria-required="true"> <label for="grup" style="cursor:pointer;">Group</label>
									<script>
									function pilih(a){
										$.get("<?=site_url("api/pilihcustomer");?>",{pilih:a})
										.done(function(data){
											$("#pilihcustomer").html(data);
										});
									}
									</script>
									<div id="pilihcustomer">	
									</div>								  
								</div>
							  </div>
							 
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_statusremarks">Remarks</label>
								<div class="col-sm-10">
									<textarea type="text" class="form-control" id="quotation_statusremarks" name="quotation_statusremarks"><?=$quotation_statusremarks;?></textarea>
									<script>
										CKEDITOR.replace('quotation_statusremarks');
									</script>									
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_product">Show Product</label>
								<div class="col-sm-10">
								<select class="form-control" id="quotation_product" name="quotation_product">
									<option value="1" <?=($quotation_product==1)?"selected":"";?>>Ya</option>
									<option value="0" <?=($quotation_product==0)?"selected":"";?>>Tidak</option>
								</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_intro">Intro (Pembuka):</label>
								<div class="col-sm-10">
									<textarea type="text" class="form-control" id="quotation_intro" name="quotation_intro"><?=$quotation_intro;?></textarea>
									<script>
										CKEDITOR.replace('quotation_intro');
									</script>	
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_workscope">Workscope:</label>
								<div class="col-sm-10">
									<textarea type="text" class="form-control" id="quotation_workscope" name="quotation_workscope"><?=$quotation_workscope;?></textarea>
									<script>
										CKEDITOR.replace('quotation_workscope');
									</script>	
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_payment">Payment:</label>
								<div class="col-sm-10">
									<textarea type="text" class="form-control" id="quotation_payment" name="quotation_payment"><?=$quotation_payment;?></textarea>
									<script>
										CKEDITOR.replace('quotation_payment');
									</script>	
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_closing">Closing (Penutup):</label>
								<div class="col-sm-10">
									<textarea type="text" class="form-control" id="quotation_closing" name="quotation_closing"><?=$quotation_closing;?></textarea>
									<script>
										CKEDITOR.replace('quotation_closing');
									</script>	
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_write">Writted By</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="quotation_write" name="quotation_write" value="<?=$quotation_write;?>">									
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="quotation_to">To (Tujuan)</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="quotation_to" name="quotation_to" value="<?=$quotation_to;?>">									
								</div>
							</div>
							  
							  <input type="hidden" name="quotation_id" value="<?=$quotation_id;?>"/>
							  <input type="hidden" name="user_id" value="<?=$this->session->userdata("user_id");?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary btn-lg col-md-5" <?=$namabutton;?> value="OK">Submit</button>									
									<a class="btn btn-warning btn-lg col-md-offset-1 col-md-5" href="<?=site_url("quotation");?>">Back</a>
								</div>
							  </div>
							</form>							
						</div>
						<?php }else{?>	
							<?php if($message!=""){$display="display:block;";}else{$display="display:none;";}?>
							<div id="message" class="alert alert-info alert-dismissable" style="<?=$display;?>">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong id="messageisi"><?=$message;?></strong>
							</div>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Quotation No. </th>
											<th>Revisi</th>
											<th>Marketer</th>
											<th>Customer</th>
											<?php if($identity->identity_project=="1"&&$this->session->userdata("position_id")!=6){?>
											<th>Project</th>
											<?php }?>
											<?php if($this->session->userdata("position_id")!=6){?>
											<th>Status</th>
											<?php }?>
											<?php if(!isset($_GET['report'])){$col="col-md-3";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
											
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['report'])){$disabled='disabled="disabled"';}else{$disabled="";}
										if(isset($_GET['product_id'])){
											$this->db->join("quotationproduct","quotationproduct.quotation_no=quotation.quotation_no","left");
											$this->db->where("product_id",$_GET["product_id"]);
										}
										if($identity->identity_project==1){
											$this->db
											->select("project.project_name")
											->join("project","project.project_id=quotation.project_id","left");
										}
										$usr=$this->db
										->select("quotation.*,customer.*")
										->join("customer","customer.customer_id=quotation.customer_id","left")
										->order_by("quotation_id","desc")
										->get("quotation");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $quotation){
										?>
										<tr>		
											<td><?=$no++;?></td>									
											<td><?=$quotation->quotation_date;?></td>
											<td><?=$quotation->quotation_no;?></td>			
											<td><?=($quotation->quotation_rev>0)?$quotation->quotation_rev:"Original";?></td>
											<td><?=$quotation->quotation_write;?></td>
											<td><?=$quotation->customer_name;?></td>
											<?php if($identity->identity_project=="1"&&$this->session->userdata("position_id")!=6){?>
											<td>
												<select  <?=$disabled;?> onChange="inputproject(this,'<?=htmlspecialchars($quotation->quotation_no, ENT_QUOTES);?>')" id="project_id" name="project_id" class="form-control" required>
													<option value="0" <?=($quotation->project_id=="0")?'selected="selected"':'';?>>Select Project</option>
													<?php if($quotation->project_id!="0"){?>
														<option value="<?=$quotation->project_id;?>" <?=($quotation->project_id!="0")?'selected="selected"':'';?>><?=$quotation->project_name;?></option>
													<?php }?>
													<?php $proj=$this->db
													->select("project.*,quotation.project_id as qp")
													->join("quotation","quotation.project_id=project.project_id","left")
													->where("quotation.project_id",NULL)
													->group_by("project.project_id")
													->get("project");
												  	foreach($proj->result() as $project){?>
													<option value="<?=$project->project_id;?>" <?=($quotation->project_id==$project->project_id)?'selected="selected"':'';?>> (
													  <?=$project->project_code;?>
													  )
													  <?=$project->project_name;?>
													</option>
													<?php }?>
												  </select>
                                                <script>
											  function inputproject(a,b){
											  $.get("<?=site_url("api/inputproject");?>",{project_id:a.value,quotation_no:b})
											  .done(function(data){
											  window.location.href='<?=current_url();?>?message='+data;
											   $("#messageisi").html(data);
											   $("#message").show();
											   setTimeout(function(){$("#message").hide();},2000);
											  });
											  }
											  </script>
                                            </td>
											<?php }?>
											
											<?php if($this->session->userdata("position_id")!=6){?>
											<td>
											<select <?=$disabled;?> onChange="inputstatus(this,'<?=htmlspecialchars($quotation->quotation_no, ENT_QUOTES);?>')" id="quotation_status" name="quotation_status" class="form-control" required>
											  <option value="" <?=($quotation->quotation_status=="")?'selected="selected"':'';?>>Select Status</option>
											  <option value="Lost" <?=($quotation->quotation_status=="Lost")?'selected="selected"':'';?>>Lost</option>
											  <option value="Goal" <?=($quotation->quotation_status=="Goal")?'selected="selected"':'';?>>Goal</option>
											 </select>
											  <script>
											  function inputstatus(a,b){
											  $.get("<?=site_url("api/inputstatus");?>",{quotation_status:a.value,quotation_no:b})
											  .done(function(data){
											   $("#messageisi").html(data);
											   $("#message").show();
											   setTimeout(function(){$("#message").hide();},2000);
											  });
											  }
											  </script>											</td>
											<?php }?>								
											<td style="padding-left:0px; padding-right:0px;"> 
											<?php if(!isset($_GET['report'])&&$this->session->userdata("position_id")!=6){$float="float:right;";?>   									
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Revisi" class="btn btn-sm btn-warning" name="revisi" value="OK"><span class="fa fa-check" style="color:white;"></span> </button>
													<input type="hidden" name="quotation_no" value="<?=$quotation->quotation_no;?>"/>
													<input type="hidden" name="quotation_id" value="<?=$quotation->quotation_id;?>"/>
												</form>	                                      											 									
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>													
													<input type="hidden" name="quotation_id" value="<?=$quotation->quotation_id;?>"/>
													<input type="hidden" name="quotation_no" value="<?=$quotation->quotation_no;?>"/>
												</form>	                                      											
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>													
													<input type="hidden" name="quotation_id" value="<?=$quotation->quotation_id;?>"/>
												</form>	
												<?php if(!isset($_GET['product_id'])){?>
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												  <a data-toggle="tooltip" title="PO" target="_self" href="<?=site_url("poc?quotation_no=".$quotation->quotation_no)."&customer_id=".$quotation->customer_id."&project_id=".$quotation->project_id."&quotation_id=".$quotation->quotation_id;?>" class="btn btn-sm btn-primary " name="edit" value="OK">
												  <span class="fa fa-file-text-o" style="color:white;"></span>											  </a>
												</form> 
												<?php }?>		
											<?php }else{$float="";}?>											
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Print Quotation" target="_blank" href="<?=site_url("quotationprint?quotation_no=".$quotation->quotation_no)."&quotation_id=".$quotation->quotation_id."&customer_id=".$quotation->customer_id;?>" class="btn btn-sm btn-success " name="edit" value="OK"> 
												  <span class="fa fa-print" style="color:white;"></span>												  </a>
												</form>  	
											
											<?php 
											if($identity->identity_lockproduct==1){
											$product=$this->db
											->where("quotation_no",$quotation->quotation_no)
											->get("quotationproduct");
											$boleh=0;
											foreach($product->result() as $product){
												$access=$this->db
												->where("product_id",$product->product_id)
												->where("customer_id",$quotation->customer_id)
												->where("user_id",$this->session->userdata("user_id"))
												->get("access");
												//echo $this->db->last_query();
												if($access->num_rows()>0){$boleh++;}else{$boleh*=0;}
											}
											if($boleh==1){?>  									
											<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
											  <a data-toggle="tooltip" title="Follow Up" href="<?=site_url("followup?quotation_no=".$quotation->quotation_no)."&customer_id=".$quotation->customer_id."&customer_wa=".$quotation->customer_wa;?>" class="btn btn-sm btn-warning " name="edit" value="OK">
											  <span class="fa fa-user" style="color:white;"></span>											  
											  </a>
											</form>  		
											<?php }
											}?>	
											<?php if(!isset($_GET['report'])&&$this->session->userdata("position_id")!=6){?>  
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												  <a data-toggle="tooltip" title="List Product" target="_blank" href="<?=site_url("quotationproduct?quotation_id=".$quotation->quotation_id."&quotation_no=".$quotation->quotation_no)."&customer_id=".$quotation->customer_id;?>" class="btn btn-sm btn-info " name="edit" value="OK">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>											  </a>
												</form> 		
											<?php }?>	
											<?php if($identity->identity_kirimemail=="1"){?>								
											<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
											  <button data-toggle="tooltip" title="Send Email" class="btn btn-sm btn-warning " name="sendemail" value="OK">
											  <input type="hidden" name="quotation_no" value="<?=$quotation->quotation_no;?>"/>
											  <input type="hidden" name="customer_id" value="<?=$quotation->customer_id;?>"/>
											  <span class="fa fa-user" style="color:white;"></span>											  
											  </button>
											</form>  
											<?php }?>			
											</td>
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
