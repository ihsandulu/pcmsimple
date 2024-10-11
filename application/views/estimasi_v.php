<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");?>
  <style>
  .pembatas{margin-bottom:20px; height:0px; background-color:#E8F3FD;}
  .tableshow{display:none;}
  </style>
  <script>
  $(document).ready( function () {
		 $('#tabledebet').DataTable( {
			"order": [[ 0, "asc" ]],
			 "iDisplayLength": 25
		} );
		 $('#tablekredit').DataTable( {
			"order": [[ 0, "asc" ]],
			 "iDisplayLength": 25
		} );
	} );
  </script>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Estimasi</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Estimasi</h1>
			</div>
			<!--<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="estimasi_id"/>
				</h1>
			</form>
			<?php }?>-->
		</div>
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Estimasi";}else{$namabutton='name="create"';$judul="Create Estimasi";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
							
							  <div class="form-group">
								<label class="control-label col-sm-2" for="project_id">Project:</label>
								<div class="col-sm-10">
								  <select required id="project_id" name="project_id" class="form-control" onChange="cekproject(this.value)">
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
							  <script>
							  	function cekproject(a){
							  		$.get("<?=site_url("api/cekproject");?>",{project_id:a})
									.done(function(data){
										if(data==1){alert("Please choose another project!");$("#submit").hide();}else{$("#submit").show();}
									});
								}
							  </script>
									  
							 
							  <div class="form-group">
								<label class="control-label col-sm-2" for="estimasi_name">Estimasi Name</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="estimasi_name" id="estimasi_name" value="<?=$estimasi_name;?>"/>
								</div>
							  </div>
							 
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="estimasi_mount">Estimasi Amount. :</label>
								<div class="col-sm-10">
								  <input type="number" min="0" class="form-control" name="estimasi_mount" id="estimasi_mount" value="<?=$estimasi_mount;?>"/>
								</div>
							  </div>	
							  				  
							  
                              
							 <input class="form-control" type="hidden" name="estimasi_id" id="estimasi_id" value="<?=$estimasi_id;?>"/>	
							  <input type="hidden" name="estimasi_type" value="<?=$estimasi_type;?>"/>			  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
								<?php
								if($project_id!=0){$display="inline";}else{$display="none";}?>
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK" style="display:<?=$display;?>;">Submit</button>									
									<a type="button" class="btn btn-warning col-md-offset-1 col-md-5" href="<?=site_url("estimasi");?>">Back</a>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadestimasi_picture;?>
							</div>
							<?php }?>
							<div class="box col-md-12 col-sm-12 col-xs-12" style="border-bottom:grey dashed 1px; margin-bottom:50px; padding-bottom:50px;">
								<div class="col-md-12" style="font-size:18px; font-weight:bold; margin-bottom:10px;">Project</div>
								
								<div class="pembatas col-md-12">&nbsp;</div>
								<div id="collapse4" class="body table-resestimasinsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Project</th>
											<th>Customer</th>
											<th>Budget</th>
											<th>Estimasi Debet </th>
											<th>Estimasi Kredit </th>
											<th>Estimasi Total </th>
											<?php if(!isset($_GET['report'])){$col="col-md-3";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php 	
										
										if($this->session->userdata("position_id")=="3"){
											$this->db->where("project.user_id",$this->session->userdata("user_id"));
										}									
										$usr=$this->db
										->join("customer","customer.customer_id=project.customer_id","left")
										->order_by("project_id","desc")
										->get("project");
										$no=1;
										foreach($usr->result() as $estimasi){
											$esdebet=$this->db
											->select("SUM(estimasi_mount)AS totdeb")
											->where("estimasi_type","Debet")
											->where("project_id",$estimasi->project_id)
											->get("estimasi");
											$esdeb=0;
											foreach($esdebet->result() as $esdebet){$esdeb=$esdebet->totdeb;}
											
											$eskredit=$this->db
											->select("SUM(estimasi_mount)AS totkre")
											->where("estimasi_type","Kredit")
											->where("project_id",$estimasi->project_id)
											->get("estimasi");
											$eskre=0;
											foreach($eskredit->result() as $eskredit){$eskre=$eskredit->totkre;}
											?>
										<tr>	
											<td><?=$no++;?></td>						
											<td><?=$estimasi->project_name;?></td>
											<td><?=$estimasi->customer_name;?></td>
											<td><?=number_format($estimasi->project_budget,0,",",".");?></td>
											<td><?=number_format($esdeb,0,",",".");?></td>
											<td><?=number_format($eskre,0,",",".");?></td>
											<td><?=number_format($esdeb-$eskre,0,",",".");?></td>											
											<td style="text-align:center; "> 											  									
												<form method="POST" class="" style="padding:0px; margin:2px;">
													<button type="button" data-toggle="tooltip" title="Choose" class="btn btn-sm btn-info" name="project" value="<?=$estimasi->project_id;?>" onClick="showtable(this.value)"><span class="fa fa-angle-double-down" style="color:white;"></span></button>
												</form>											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
								<script>
									function tableshow(type,project){
										$.get("<?=site_url("api/tableshow");?>",{type:type,project_id:project})
										.done(function(data){
											$("#"+type).html(data);
										});
									}
									function showtable(project){
										$(".tableshow").show();
										tableshow('Debet',project);
										tableshow('Kredit',project);
										$(".projectid").val(project);
									}
								</script>
							  </div>
							</div>
							<div class="box col-md-6 col-sm-6 col-xs-12 tableshow" style="border-right:black solid 1px;">
								<div class="col-md-6" style="font-size:18px; font-weight:bold; margin-bottom:20px;">Debet</div>
								<div class="col-md-6" style="font-size:18px; font-weight:bold; margin-bottom:20px;" align="right">
									<form method="POST">	
										<button name="new" class="btn btn-info btn-xs" value="OK" style="">New</button>
										<input type="hidden" name="estimasi_id"/>
										<input type="hidden" name="estimasi_type" value="Debet"/>
										<input type="hidden" class="projectid" name="project_id" value="0"/>								
									</form>
								</div>
								<div class="pembatas col-md-12">&nbsp;</div>
								<div id="collapse4" class="body table-resestimasinsive">				
								<table id="tabledebet" class="table table-condensed table-hover tableshow">
									<thead>
										<tr>
											<th>No.</th>
											<th>Project</th>
											<th>Estimasi Name</th>
											<th>Amount</th>
											<?php if(!isset($_GET['report'])){$col="col-md-3";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
										</tr>
									</thead>
									<tbody id="Debet"> 
										
									</tbody>
								</table>
							  </div>
							</div>
							<div class="box col-md-6 col-sm-6 col-xs-12 tableshow" style="">
								<div class="col-md-6" style="font-size:18px; font-weight:bold; margin-bottom:20px;">Kredit</div>
								<div class="col-md-6" style="font-size:18px; font-weight:bold; margin-bottom:20px;" align="right">
									<form method="POST">	
										<button name="new" class="btn btn-info btn-xs" value="OK" style="">New</button>
										<input type="hidden" name="estimasi_id"/>
										<input type="hidden" name="estimasi_type" value="Kredit"/>	
										<input type="hidden" class="projectid" name="project_id" value="0"/>												
									</form>
								</div>
								<div class="pembatas col-md-12">&nbsp;</div>
								<div id="collapse4" class="body table-resestimasinsive">				
								<table id="tablekredit" class="table table-condensed table-hover tableshow">
									<thead>
										<tr>
											<th>No.</th>
											<th>Project</th>
											<th>Estimasi Name</th>
											<th>Amount</th>
											<?php if(!isset($_GET['report'])){$col="col-md-3";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
										</tr>
									</thead>
									<tbody id="Kredit"> 
										
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
