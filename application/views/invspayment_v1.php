<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");
	$dari=date("Y-m-d");
	$ke=date("Y-m-d");
	if(isset($_REQUEST["dari"])){
		$dari=$_REQUEST["dari"];
		$ke=$_REQUEST["ke"];
	}
	if(!isset($_GET["invs_no"])){		
		$listjudul="Cash Advance";
		$judul="Cash Advance";
	}else{
		$listjudul="Account Payable";
		$judul="Account Payable No. ".$this->input->get("invs_no");
	}
	?>
	<style>
	.btn-sm{margin-bottom:10px;}
	.bmerah{background-color:#FFCCCC;}
	</style>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	
	<div id="approvemodal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Approve CA Request</h4>
		  </div>
		  <div class="modal-body">
			<form method="post">
				<div class="col-md-12 text-center" style="margin-bottom:20px;">
					Are you sure to approve this CA Request?
				</div>
				<div class="col-md-6">
					<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</button>
				</div>
				<div class="col-md-6">
					<button name="approve" value="OK" type="submit" class="btn btn-success btn-block">Approve</button>
				</div>
				<input type="hidden" name="invspayment_id" class="invspaymentid"/>
			</form>
			<div style="clear:both;"></div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
	
	  </div>
	</div>
	
	<div id="caoutmodal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">CA Out</h4>
		  </div>
		  <div class="modal-body">
			<form method="post">
				<div class="col-md-12 text-center" style="margin-bottom:20px;">
					Are you sure to pay this CA Request?
				</div>
				<div class="col-md-6">
					<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</button>
				</div>
				<div class="col-md-6">
					<button name="caout" value="OK" type="submit" class="btn btn-success btn-block">Pay</button>
				</div>
				<input type="hidden" name="invspayment_id" class="invspaymentid"/>
			</form>
			<div style="clear:both;"></div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
	
	  </div>
	</div>
	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active"><?=$listjudul;?></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> <?=$judul;?></h1>
			</div>
			<form method="post" class="col-md-4">							
				<h1 class="page-header col-md-12"> 		
				<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&!isset($_POST['settlement'])){?>		
				<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
				<?php if(isset($_GET["invs_no"])){?>
				<button type="button" onClick="window.close()" class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</button>
				<?php }?>
				<input type="hidden" name="invspayment_id" value="0"/>
				<?php }else{?>
				<a type="button"  href="<?=site_url("invspayment");?>" class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</a>
				<?php }?>
				</h1>
			</form>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<?php
						if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5||$this->session->userdata("position_id")==7)&&$invspayment_status==""){
							$show="display:block;";
							$invspayment_status="CA Out";
						}elseif(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5||$this->session->userdata("position_id")==7)&&$invspayment_status!="CA Request"){
							$show="display:block;";
						}elseif($this->session->userdata("position_id")!=5&&$invspayment_status==""){
							$show="display:none;";
							$invspayment_status="CA Request";
						}else{
							$show="display:none;";
						}?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update ".$invspayment_status;}else{$namabutton='name="create"';$judul="New ".$invspayment_status;}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							<?php if(isset($_POST['settlement'])){$readonly='readonly=""';}else{$readonly='';}?>
							
							  <div class="form-group" style="<?=$show;?>">
								<label class="control-label col-sm-2" for="unit_id">Payment:</label>
								<div class="col-sm-10">
									<select name="methodpayment_id" class="form-control">
										<option value="" <?=($methodpayment_id=="")?"selected":"";?>>
											Choose Payment
										</option>
									<?php $met=$this->db->get("methodpayment");
									foreach($met->result() as $meth){?>
										<option value="<?=$meth->methodpayment_id;?>" <?=($meth->methodpayment_id==$methodpayment_id)?"selected":"";?>>
											<?=$meth->methodpayment_name;?>
										</option>
									<?php }?>
								  	</select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_payto">Pay to :</label>
								<div class="col-sm-10">
								  <input type="text" <?=$readonly;?> autofocus class="form-control" id="invspayment_payto" name="invspayment_payto"  value="<?=$invspayment_payto;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_prepareby">Prepared By :</label>
								<div class="col-sm-10">
								  <input type="text" <?=$readonly;?> autofocus class="form-control" id="invspayment_prepareby" name="invspayment_prepareby"  value="<?=$invspayment_prepareby;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_receivedby">Received By :</label>
								<div class="col-sm-10">
								  <input type="text" <?=$readonly;?> autofocus class="form-control" id="invspayment_receivedby" name="invspayment_receivedby"  value="<?=$invspayment_receivedby;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_approvedby">Approve By :</label>
								<div class="col-sm-10">
								  <input type="text" <?=$readonly;?> autofocus class="form-control" id="invspayment_approvedby" name="invspayment_approvedby"  value="<?=$invspayment_approvedby;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspayment_date">Date:</label>
								<div class="col-sm-10">
								  <input type="text" <?=$readonly;?> autofocus class="form-control date" id="invspayment_date" name="invspayment_date" placeholder="Enter Date" value="<?=$invspayment_date;?>">
								</div>
							  </div>
							  <?php if($user_id==""||$user_id=="0"){?>
							  <input type="hidden" name="user_id" value="<?=$this->session->userdata("user_id");?>"/>
							  <?php }?>
							  <input type="hidden" name="invspayment_status" value="<?=$invspayment_status;?>"/>	
							  <input type="hidden" name="invspayment_id" value="<?=$invspayment_id;?>"/>	
							  <input type="hidden" name="invs_no" value="<?=$this->input->get("invs_no");?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("invspayment");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }elseif(isset($_POST['settlement'])){?>		
					<?php if($uploadinvspaymentpicture_name!=""){$display="display:block;";}else{$display="display:none;";}?>
						<div id="message" class="alert alert-info alert-dismissable" style="<?=$display;?>">
						  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						  <strong id="messageisi"><?=$uploadinvspaymentpicture_name;?></strong>
						</div>				
						<div class="">							
							<div class="lead"><h3>Settlement</h3></div>
							<div id="collapse4" class="body table-responsive">				
								<table id="" class="table table-condensed table-hover">
									<thead>
										<tr>
										  	<th>Date</th>
										  	<th>Creator</th>
											<th>Status</th>
											<th>Payment No. </th>
											<th>Payment</th>
											<th>Amount</th>
											<?php if($identity->identity_project=="1"){?>
											<th>Project</th>
											<?php }?>
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['invs_no'])){											
											$this->db->where("invs_no",$this->input->get("invs_no"));
										}else{
											$this->db->where("invs_no","");
										}
										if($this->session->userdata("position_id")!=1&&$this->session->userdata("position_id")!=5&&$this->session->userdata("position_id")!=7){
											$this->db->where("invspayment.user_id",$this->session->userdata("user_id"));
										}	
										$usr=$this->db
										->join("project","project.project_id=invspayment.project_id","left")
										->join("methodpayment","methodpayment.methodpayment_id=invspayment.methodpayment_id","left")
										->join("user","user.user_id=invspayment.user_id","left")	
										->where("invspayment_id",$this->input->post("invspayment_id"))									
										->get("invspayment");
										$no=1;
										//echo $this->db->last_query();
										foreach($usr->result() as $invspayment){
											$invsppro_amount=0;
											$pr=$this->db
											->select("*,SUM(invspaymentproduct_amount*invspaymentproduct_qty)As invsppro_amount")
											->where("invspayment_no",$invspayment->invspayment_no)
											->group_by("invspayment_no")
											->get("invspaymentproduct");
											if($pr->num_rows()>0){$invsppro_amount=$pr->row()->invsppro_amount;}
											if($invspayment->invspayment_status=="CA Request"){
											$bmerah="bmerah";?>
											<script>
											setTimeout(function(){$(".bmerah").css({"background-color":"#FFCCCC"});},200);
											</script>
											<?php }else{
											$bmerah="";
											}
										?>
										<tr class="<?=$bmerah;?>">
										  	<td><?=$invspayment->invspayment_date;?></td>											
											<td><?=$invspayment->user_name;?></td>										
											<td><?=$invspayment->invspayment_status;?></td>
											<td><?=$invspayment->invspayment_no;?></td>
											<td><?=$invspayment->methodpayment_name;?></td>
											<td><?=number_format($invsppro_amount,0,",",".");?></td>
											<?php if($identity->identity_project=="1"){?>
											<td><?=$invspayment->project_name;?></td>
											<?php }?>
										</tr>
										<?php }?>
									</tbody>
								</table>
						  </div>
						  	<div class="lead">
							<h3>Charge Item</h3>
							<div>
								<a data-toggle="tooltip" title="Charge Item" target="_blank" href="<?=site_url("invspaymentproduct?invspayment_no=".$invspayment->invspayment_no."&invs_no=".$invs_no."&supplier_id=");?>" class="btn btn-sm btn-info" style="margin:20px;">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>	Change Charge Item										  </a>
								<div style="clear:both;"></div>
							</div>
							</div>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
										  	<th>Source</th>
											<th>Description</th>
											<th>Qty</th>
											<th>Price</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->where("invspayment_no",$this->input->post("invspayment_no"))
										->order_by("invspaymentproduct_id","desc")
										->get("invspaymentproduct");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $invspaymentproduct){
										if($invspaymentproduct->invspaymentproduct_source=="petty_id"){$source="Petty Cash";}else{$source="Big Cash";}
										?>
										<tr>
											<td><?=$no++;?></td>
											<td><?=$source;?></td>											
											<td><?=$invspaymentproduct->invspaymentproduct_description;?></td>
											<td><?=$invspaymentproduct->invspaymentproduct_qty;?></td>
											<td><?=number_format($invspaymentproduct->invspaymentproduct_amount,0,",",".");?></td>
											<td><?=number_format($invspaymentproduct->invspaymentproduct_amount*$invspaymentproduct->invspaymentproduct_qty,0,",",".");?></td>
											
										</tr>
										<?php }?>
									</tbody>
								</table>
								</div>
							</div>
						  	<div class="lead"><h3>File for Evidence</h3></div>
							<form class="form-horizontal col-md-6" method="post" enctype="multipart/form-data">	
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspaymentpicture_name">Picture:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file" class="form-control" id="invspaymentpicture_name" name="invspaymentpicture_name"><br/>							
								  <img id="invspaymentpicture_name_image" src="<?=base_url("assets/images/invspaymentpicture/noimage.png");?>" style="width:100%; height:auto;"/>
								  <script>
								  	function readURL(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();
								
											reader.onload = function (e) {
												$('#invspaymentpicture_name_image').attr('src', e.target.result);
											}
								
											reader.readAsDataURL(input.files[0]);
										}
									}
								
									$("#invspaymentpicture_name").change(function () {
										readURL(this);
									});
								  </script>
								</div>
							  </div>
							  <input type="hidden" name="invspayment_id" value="<?=$this->input->post("invspayment_id");?>"/> 
							  <input type="hidden" name="settlement" value="OK"/>  
							  <div class="form-group"> 
								<div class="col-sm-12">
									<button type="submit" id="submit" class="btn btn-primary col-md-12" nama="settle" value="OK">Submit</button>
								</div>
							  </div>
							</form>
							<div class="col-md-6" style="padding:5px;">
								<?php 
								$pic=$this->db
								->where("invspayment_id",$this->input->post("invspayment_id"))
								->get("invspaymentpicture");
								foreach($pic->result() as $pic){?>
								<div class="col-md-4">
									<img onClick="tampil(this)" src="<?=base_url("assets/images/invspaymentpicture/".$pic->invspaymentpicture_name);?>" style="width: 100%; height: 150px; object-fit: cover; box-shadow:grey 1px 1px 1px; cursor:pointer;"/>
									<div>
										<a target="_blank" href="<?=base_url("assets/images/invspaymentpicture/".$pic->invspaymentpicture_name);?>" class="btn btn-xs btn-warning" style="position:absolute; bottom:0px; right:15px;"><i class="fa fa-print"></i></a>
										<form method="post">
										<button name="deletegambar" value="<?=$pic->invspaymentpicture_id;?>" class="btn btn-xs btn-danger" style="position:absolute; bottom:0px; left:15px;"><i class="fa fa-close"></i></button>
							  			<input type="hidden" name="settlement" value="OK"/>  
										</form>
									</div>
								</div>
								<?php }?>
								<script>
								function tampil(a){
									var gambar=$(a).attr("src");
									$("#imgumum").attr("src",gambar);
									$("#myImage").modal("show");
								}
								</script>
							</div>
						</div>
						<?php }else{?>		
							<?php if($message!=""){$display="display:block;";}else{$display="display:none;";}?>
							
							<div id="message" class="alert alert-info alert-dismissable" style="<?=$display;?>">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong id="messageisi"><?=$message;?></strong>
							</div>
							<div class="box">
								<div style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
								<form class="form-inline">
								  <div class="form-group">
									<label for="email">From:</label>
									<input autocomplete="off" type="text" class="form-control date" name="dari" value="<?=$dari;?>">
								  </div>
								  <div class="form-group">
									<label for="pwd">To:</label>
									<input autocomplete="off" type="text" class="form-control date" name="ke" value="<?=$ke;?>">
								  </div>
								  <?php if(isset($_GET['report'])){?>
									<input type="hidden" name="report" value="ok">
								 <?php }?>
								  <button style="margin-right:30px;" type="submit" class="btn btn-default">Search</button>
								  
								  
								</form>
							
								</div>
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
										  	<th>Date</th>
										  	<th>Creator</th>
											<th>Status</th>
											<th>Payment No. </th>
											<th>Payment</th>
											<th>Amount</th>
											<?php if($identity->identity_project=="1"){?>
											<th>Project</th>
											<?php }?>
											<th class="col-md-2">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['dari'])){
											$this->db->where("invspayment_date >=",$this->input->get("dari"));
										}else{
											$this->db->where("invspayment_date >=",date("Y-m-d"));
										}
										
										if(isset($_GET['ke'])){
											$this->db->where("invspayment_date <=",$this->input->get("ke"));
										}else{
											$this->db->where("invspayment_date <=",date("Y-m-d"));
										}
										if(isset($_GET['invs_no'])){											
											$this->db->where("invs_no",$this->input->get("invs_no"));
										}else{
											$this->db->where("invs_no","");
										}
										if($this->session->userdata("position_id")!=1&&$this->session->userdata("position_id")!=5&&$this->session->userdata("position_id")!=7){
											$this->db->where("invspayment.user_id",$this->session->userdata("user_id"));
										}	
										$usr=$this->db
										->join("methodpayment","methodpayment.methodpayment_id=invspayment.methodpayment_id","left")
										->join("user","user.user_id=invspayment.user_id","left")	
										->order_by("invspayment_id","desc")									
										->get("invspayment");
										$no=1;
										//echo $this->db->last_query();
										foreach($usr->result() as $invspayment){
											$invsppro_amount=0;
											$pr=$this->db
											->select("*,SUM(invspaymentproduct_amount*invspaymentproduct_qty)As invsppro_amount")
											->where("invspayment_no",$invspayment->invspayment_no)
											->group_by("invspayment_no")
											->get("invspaymentproduct");
											if($pr->num_rows()>0){$invsppro_amount=$pr->row()->invsppro_amount;}
											if($invspayment->invspayment_status=="CA Request"){
											$bmerah="bmerah";?>
											<script>
											setTimeout(function(){$(".bmerah").css({"background-color":"#FFCCCC"});},200);
											</script>
											<?php }else{
											$bmerah="";
											}
										?>
										<tr class="<?=$bmerah;?>">
											<td><?=$no++;?></td>
										  	<td><?=$invspayment->invspayment_date;?></td>											
											<td><?=$invspayment->user_name;?></td>										
											<td><?=$invspayment->invspayment_status;?></td>
											<td><?=$invspayment->invspayment_no;?></td>
											<td><?=$invspayment->methodpayment_name;?></td>
											<td><?=number_format($invsppro_amount,0,",",".");?></td>
											<?php if($identity->identity_project=="1"){?>
											<td>
                                            <select  
                                            onChange="inputproject(this,'<?=htmlspecialchars($invspayment->invspayment_no, ENT_QUOTES);?>')" 
                                            id="project_id" name="project_id" class="form-control" required>
                                            
                                                <option value="0" <?=($invspayment->project_id=="0")?'selected="selected"':'';?>>
                                                Select Project                                                </option>
                                                
                                                <?php if($invspayment->project_id!="0"){?>
                                                <option value="<?=$invspayment->project_id;?>" <?=($invspayment->project_id!="0")?'selected="selected"':'';?>>
                                                  <?=$invspayment->project_name;?>
                                              	</option>
                                                <?php }?>
                                                
                                                <?php $proj=$this->db->get("project");
												  	foreach($proj->result() as $project){?>
                                                <option value="<?=$project->project_id;?>" <?=($invspayment->project_id==$project->project_id)?'selected="selected"':'';?>> (
                                                  <?=$project->project_code;?>
                                                  )
                                                  <?=$project->project_name;?>
                                                </option>
                                                <?php }?>
                                              </select>
                                              
                                              <script>
											  function inputproject(a,b){
											  $.get("<?=site_url("api/inputproject_paymentsupplier");?>",{project_id:a.value,invspayment_no:b})
											  .done(function(data){
											  window.location.href='<?=current_url();?>?message='+data;
											   $("#messageisi").html(data);
											   $("#message").show();
											   setTimeout(function(){$("#message").hide();},2000);
											  });
											  }
											  </script>                                            </td>
											<?php }?>
											<td style="padding-left:0px; padding-right:0px;">	 
												<form method="POST" class="col-md-3" style="padding:0px;">
													<?php if(isset($_GET['invs_no'])){$invs_no=$_GET['invs_no'];}else{$invs_no="";}?>
													<?php if(isset($_GET['supplier_id'])){$supplier_id=$_GET['supplier_id'];}else{$supplier_id="";}?>
												  <a data-toggle="tooltip" title="Charge Item" target="_blank" href="<?=site_url("invspaymentproduct?invspayment_no=".$invspayment->invspayment_no."&invs_no=".$invs_no."&supplier_id=".$supplier_id);?>" class="btn btn-sm btn-info" style="margin:0px;">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>											  </a>
												</form> 
												<?php if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5||$this->session->userdata("position_id")==7)&&isset($_GET['invs_no'])&&$_GET['invs_no']!=""){?>		 
												<form method="POST" class="col-md-3" style="padding:0px;">
												  <a data-toggle="tooltip" title="Print Payment" target="_blank" href="<?=site_url("invspaymentprint?invspayment_no=".$invspayment->invspayment_no);?>" class="btn btn-sm btn-success" style="margin:0px;">
												  <span class="fa fa-print" style="color:white;"></span>											  </a>
												</form> 
												<?php }?>
												<?php //if($this->session->userdata("position_id")!=5&&$invspayment->invspayment_status=="CA Request"){?>		<?php if(($invspayment->user_id==$this->session->userdata("user_id"))||$this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5){?>
												<form method="post" class="col-md-3" style="padding:0px;">
													<button class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;margin:0px;"></span> </button>
													<input type="hidden" name="invspayment_id" value="<?=$invspayment->invspayment_id;?>"/>
												</form>
												<?php }?>
												<form method="post" class="col-md-3" style="padding:0px;">
													<button class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;margin:0px;"></span> </button>
													<input type="hidden" name="invspayment_id" value="<?=$invspayment->invspayment_id;?>"/>
													<input type="hidden" name="invspayment_no" value="<?=$invspayment->invspayment_no;?>"/>
												</form>		
											
												<?php if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==7)&&$invspayment->invspayment_status=="CA Request"){?>	
												<form method="post" class="col-md-3" style="padding:0px;">
													<button type="button" title="Approve" data-toggle="tooltip" class="btn btn-sm btn-success" onClick="setujui('<?=$invspayment->invspayment_id;?>')"><span class="fa fa-check-square" style="color:white;margin:0px;"></span> </button>
												</form>	
												<?php }?>		
												<?php if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5)&&$invspayment->invspayment_status=="CA Request Approved"){?>	
												<form method="post" class="col-md-3" style="padding:0px;">
													<button type="button" title="Pay CA Request" data-toggle="tooltip" class="btn btn-sm btn-success" onClick="payca('<?=$invspayment->invspayment_id;?>')"><span class="fa fa-money" style="color:white;margin:0px;"></span> </button>
												</form>	
												<?php }?>	
												<?php if(($this->session->userdata("position_id")==1||$this->session->userdata("position_id")==5)&&$invspayment->invspayment_status=="CA Out"){?>		
												<form method="post" class="col-md-3" style="padding:0px;">
													<button title="CA Settlement" data-toggle="tooltip" class="btn btn-sm btn-success " name="settlement" value="OK"><span class="fa fa-edit" style="color:white;margin:0px;"></span> </button>
													<input type="hidden" name="invspayment_id" value="<?=$invspayment->invspayment_id;?>"/>
													<input type="hidden" name="invspayment_no" value="<?=$invspayment->invspayment_no;?>"/>
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
	
	<script>
		function setujui(a){
			$("#approvemodal").modal();
			$(".invspaymentid").val(a);
		}
		function payca(a){
			$("#caoutmodal").modal();
			$(".invspaymentid").val(a);
		}
	</script>
</body>

</html>
