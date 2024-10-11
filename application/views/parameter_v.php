<!doctype html>
<html>

<head>
    <?php 
		require_once("meta.php");?>
<style type="text/css">
<!--
.backungu1 {	background-color:#718CAA; 
    background: -webkit-linear-gradient(#718CAA, #8A9FB8); 
    background: -o-linear-gradient(#718CAA, #8A9FB8); 
    background: -moz-linear-gradient(#718CAA, #8A9FB8); 
    background: linear-gradient(#718CAA, #8A9FB8);
}
-->
</style>
</head>

<body class="  " >
<?php require_once("header.php");?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Parameter</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Parameter</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="parameter_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Parameter";}else{$namabutton='name="create"';$judul="New Parameter";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label class="control-label col-sm-2" for="header_id">header :</label>
								<div class="col-sm-10"> 
								 <select class="form-control" id="header_id" onChange="equipment()">
								 <option></option>
								 	<?php $eq=$this->db
									->get("header");
									foreach($eq->result() as $equ){?>
									<option value="<?=$equ->header_id;?>" <?=$header_id==$equ->header_id?"selected":"";?>><?=$equ->header_name;?></option>
									<?php }?>
								  </select>
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="equip_id">Equipment :</label>
								<div class="col-sm-10"> 
								 <select class="form-control" id="equip_id" name="equip_id">
								 <option></option>
									<?php $eq=$this->db->get("equipment");
									foreach($eq->result() as $equ){?>
									<option value="<?=$equ->equip_id;?>" <?=$equip_id==$equ->equip_id?"selected":"";?>><?=$equ->equip_name;?></option>
									<?php }?>
								  </select>
								</div>
							  </div>
							  <script>
							  	function equipment(){
									var header_id = $("#header_id").val();
									$.get("<?=site_url("equipid");?>",{header_id:header_id})
									.done(function(data){
									$("#equip_id").html(data);
									});
								}
							  </script>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="parameter_name">Parameter :</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="parameter_name" name="parameter_name" placeholder="Enter Parameter" value="<?=$parameter_name;?>">
								</div>
							  </div>
							  <div class="col-md-offset-2 col-md-10 alert alert-danger alert-dismissable fade in" id="cekemail" style="display:none;">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Perhatian!</strong> Email telah digunakan.
							</div>

							  
							  									  
							  <input type="hidden" name="parameter_id" value="<?=$parameter_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button header="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("header");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadparameter_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="parameter" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th class="col-md-1">Delete</th>
											<th class="col-md-1">Update</th>
											<th>Header</th>
											<th>Equipment</th>
											<th>Parameter</th>
										</tr>
									</thead>
									<tbody> 
										<?php $par=$this->db
										->join("equipment","equipment.equip_id=parameter.equip_id","left")
										->join("header","header.header_id=equipment.header_id","left")
										->get("parameter");
										foreach($par->result() as $para){?>
										<tr>
											<td>
												<form method="post">
													<button class="btn btn-default delete" name="delete" value="OK"><span class="fa fa-window-close"></span> Delete</button>
													<input type="hidden" name="parameter_id" value="<?=$para->parameter_id;?>"/>
												</form>											</td>
											<td>
												<form method="post">
													<button class="btn btn-default" name="edit" value="OK"><span class="fa fa-edit"></span> Update</button>
													<input type="hidden" name="parameter_id" value="<?=$para->parameter_id;?>"/>
												</form>											</td>
											<td><?=$para->header_name;?></td>
											<td><?=$para->equip_name;?></td>
											<td><?=$para->parameter_name;?></td>
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
