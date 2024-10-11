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
				<li class="active">Project</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Project</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="project_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Project";}else{$namabutton='name="create"';$judul="Create Project";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="project_name">Project Name  :</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="project_name" id="project_name" value="<?=$project_name;?>"/>
								</div>
							  </div>	
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="project_code">Code  :</label>
								<div class="col-sm-10">
								  <input onKeyUp="cekcode(this)" type="text" class="form-control" name="project_code" id="project_code" value="<?=$project_code;?>"/>
								  <script>
								  function cekcode(a){
								  	$.get("<?=site_url("api/cekproject");?>",{isi:$(a).val()})
									.done(function(data){
										if(data=="ada"){
											$(a).css({"background-color":"red","color":"yellow"});
											alert("The code has been used!");
											$("#submit").attr("disabled","disabled");
										}else
										{
											$(a).css({"background-color":"white","color":"black"});
											$("#submit").removeattr("disabled");
										}
									});
								  }
								  </script>
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="project_budget">Budget  :</label>
								<div class="col-sm-10">
								  <input type="number" class="form-control" name="project_budget" id="project_budget" value="<?=$project_budget;?>"/>
								</div>
							  </div>
							  <?php if($identity->identity_projectwith==0){?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="customer_id">Customer:</label>
								<div class="col-sm-10">
								  <select name="customer_id" class="form-control" required>
								  <option value="">Select Customer</option>
								  <?php $prod=$this->db->get("customer");
								  foreach($prod->result() as $customer){?>
								  <option value="<?=$customer->customer_id;?>" <?=($customer->customer_id==$customer_id)?"selected":"";?>>
								  	<?=$customer->customer_name;?>
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>
							  <?php }?>
							  <?php if($identity->identity_projectwith==1){?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="vendor_id">Vendor:</label>
								<div class="col-sm-10">
								  <select name="vendor_id" class="form-control" required>
								  <option value="">Select Vendor</option>
								  <?php $prod=$this->db->get("vendor");
								  foreach($prod->result() as $vendor){?>
								  <option value="<?=$vendor->vendor_id;?>" <?=($vendor->vendor_id==$vendor_id)?"selected":"";?>>
								  	<?=$vendor->vendor_name;?>
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>
							  <?php }?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="project_description">Description  :</label>
								<div class="col-sm-10">
								  <textarea class="form-control" name="project_description" id="project_description"/><?=$project_description;?></textarea>
								<script>
									CKEDITOR.replace('project_description');
								</script>
								</div>
							  </div>
							  
							    <div class="form-group">
								<label class="control-label col-sm-2" for="project_begin">Begin  :</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control date" name="project_begin" id="project_begin" value="<?=$project_begin;?>"/>
								</div>
							  </div>
							  
							    <div class="form-group">
								<label class="control-label col-sm-2" for="project_end">End  :</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control date" name="project_end" id="project_end" value="<?=$project_end;?>"/>
								</div>
							  </div>
							
							  <div class="form-group">
								<label class="control-label col-sm-2" for="project_selesai">Status Project  :</label>
								<div class="col-sm-10">
								  <select onChange="selesai()" class="form-control" name="project_selesai" id="project_selesai">
								  	<option value="Penawaran" <?=($project_selesai=="Penawaran")?"selected":"";?>>Penawaran</option>
								  	<option value="Negosiasi" <?=($project_selesai=="Negosiasi")?"selected":"";?>>Negosiasi</option>
								  	<option value="Progres" <?=($project_selesai=="Progres")?"selected":"";?>>Progres</option>
								  	<option value="Belum Selesai" <?=($project_selesai=="Belum Selesai")?"selected":"";?>>Belum Selesai</option>
								  	<option value="Selesai" <?=($project_selesai=="Selesai")?"selected":"";?>>Selesai</option>
								  	<option value="Review" <?=($project_selesai=="Review")?"selected":"";?>>Review</option>
								  	<option value="Maintenance" <?=($project_selesai=="Maintenance")?"selected":"";?>>Maintenance</option>
								  </select>								 
								</div>
							  </div>
							  
							    <div class="form-group">
								<label class="control-label col-sm-2" for="project_jenis">Jenis  :</label>
								<div class="col-sm-10">
								  <select class="form-control" name="project_jenis" id="project_jenis">
								  	<option value="" <?=($project_jenis=="")?"selected":"";?>>Pilih Jenis Project</option>
								  	<option value="Personal" <?=($project_jenis=="Personal")?"selected":"";?>>Personal</option>
								  	<option value="Swasta" <?=($project_jenis=="Swasta")?"selected":"";?>>Swasta</option>
								  	<option value="Pemerintah" <?=($project_jenis=="Pemerintah")?"selected":"";?>>Pemerintah</option>
								  </select>
								</div>
								
							  </div> 
							  
							  		
									  
							  <input class="form-control" type="hidden" name="project_id" id="project_id" value="<?=$project_id;?>"/> 
							  <input class="form-control" type="hidden" name="user_id" id="user_id" value="<?=$this->session->userdata("user_id");?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("project");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadproject_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-resprojectnsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
										  	<th>Marketing</th>
										  	<th>Code</th>
											<th>Status</th>
											<th>Mulai</th>
											<th>Akhir</th>
											<th>Jenis</th>
											<th>Project</th>
											<th>Budget</th>
											<th>Customer</th>
											<th>Description</th>
											<?php if(!isset($_GET['report'])){$col="col-md-2";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										if($this->session->userdata("position_id")=="3"){
											$this->db->where("project.user_id",$this->session->userdata("user_id"));
										}
										$usr=$this->db
										->join("user","user.user_id=project.user_id","left")
										->join("customer","customer.customer_id=project.customer_id","left")
										->order_by("project_id","desc")
										->get("project");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $project){?>
										<tr>
											<td><?=$no++;?></td>
										    <td><?=$project->user_name;?></td>
									      <td><?=$project->project_code;?></td>		
										  <td><?=$project->project_selesai;?></td>	
										  <td><?=$project->project_begin;?></td>	
										  <td><?=$project->project_end;?></td>			
										  <td><?=$project->project_jenis;?></td>											
											<td><?=$project->project_name;?></td>
											<td><?=number_format($project->project_budget,2,",",".");?></td>
											<td><?=$project->customer_name;?></td>
											<td><?=$project->project_description;?></td>
											<td style="text-align:center; ">  
											<?php if(!isset($_GET['report'])){$float="display:inline;";?> 	
												<?php if($identity->identity_productcustomer==3){?>
												<form target="_blank" action="projectproduct" method="get" class="col-md-4" style="padding:0px; float:left;">
													<button class="btn  btn-primary " data-toggle="tooltip" title="Product project" name="project_id" value="<?=$project->project_id;?>"><span class="fa fa-shopping-bag" style="color:white;"></span> </button>
													<input type="hidden" name="project_name" value="<?=$project->project_name;?>"/>
												</form>
												<?php }?> 							
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
													<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="project_id" value="<?=$project->project_id;?>"/>
												</form>	 									
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
													<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="project_id" value="<?=$project->project_id;?>"/>
												</form>	                                      				
											<?php }else{$float="";}?>																					</td>
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
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
