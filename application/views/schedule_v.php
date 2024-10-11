<!doctype html>
<html>

<head>
    <?php 
	session_start();
	require_once("meta.php");?>
</head>

<body class="  " onLoad="getposition()">
		<?php require_once("header.php");?>
		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Task Detail</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Task Detail</h1>
			</div>
			
        </div>
		<!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Module";}else{$namabutton='name="create"';$judul="New Module";}?>	
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadequipment_picture;?>
							</div>
							<?php }?>
							<div class="box">
								
								
								<ul id="mytabs" class="nav nav-tabs" role="tablist">
								 <?php
								 $aktif="active";
								 $lis=$this->db->get("header");
								 foreach($lis->result() as $list){
								 ?>
								  <li class="<?=$aktif;?>">
									  <a href="#<?=$list->header_id;?>" role="tab" data-toggle="tab">
										   <?=$list->header_name;?>
									  </a>
								  </li>
								  <?php 
								   $aktif="";
								  }
								  ?>								
								</ul>
    
								<!-- Tab panes -->
								<div class="tab-content">																  
								 <?php
								 $aktif="active";
								 $lis=$this->db->get("header");
								 foreach($lis->result() as $list){
								 ?>
								  <div class="tab-pane fade <?=$aktif;?> in" id="<?=$list->header_id;?>">
									  <h2><?=$list->header_name;?></h2>
									  <div id="collapse4" class="body table-responsive" style=" overflow:scroll; height:500px;">				
										<table id="" class="listtask table table-bordered table-condensed table-hover table-striped">
											<thead>
												<tr>
												<th>Equipment</th>
												<th>Parameter</th>
												<th>Sub Parameter </th>	
												</tr>
											</thead>
											<tbody> 
												<?php 
												$schedul=$this->db
												->select("*,parameter.parameter_id as parid")
												->join("parameter","parameter.equip_id=equipment.equip_id","left")
												->join("subparameter","subparameter.parameter_id=parameter.parameter_id","left")
												->where("equipment.header_id",$list->header_id)
												->get("equipment");
												//echo $this->db->last_query();
												foreach($schedul->result() as $schedule){?>
												<tr>
												<td><?=$schedule->equip_name;?></td>
												<td><?=$schedule->parameter_name; $param="parameter_id"; $paramv=$schedule->parid;$sch=$schedule->parameter_schedule;?></td>
												<td><?=$schedule->subparameter_name; 
												if($schedule->subparameter_name!=""){
													$param="subparameter_id"; 
													$paramv=$schedule->subparameter_id;
													$sch=$schedule->subparameter_schedule;}
												?></td>
												</tr>
												<?php }?>
											</tbody>
										</table>
								</div>
								  </div>
								  <?php 
								   $aktif="";
								  }
								  ?>
								  
								  
								</div>
    
</div>
						<?php }?>
						<script>
						function input(a,b,c){
						$.get("<?=site_url("input_schedule");?>",{schedule:a,param:b,paramv:c})
						.done(function(data){
							$("#pesan").css("display","inline").removeClass("label-danger").addClass("label-success");
							$("#tab5").show();
							setTimeout(function(){ $("#pesan").css("display","none"); }, 2000);
							$("#pesanisi").html(data);
							//alert(data);
						});
						}
						</script>
					</div>
				</div>
			</div>
		</div>
		
		
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
