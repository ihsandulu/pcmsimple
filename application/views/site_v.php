<!doctype html>
<html>

<head>
    <?php 
	session_start();
	require_once("meta.php");?>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Station</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Station</h1>
			</div>
			
        </div>
		<!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Task";}else{$namabutton='name="create"';$judul="New station";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							  <div class="form-group">
								<label class="control-label col-sm-2" for="station_name">Name:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="station_name" name="station_name" placeholder="Enter station" value="<?=$station_name;?>">
								</div>
							  </div>
							  <div class="col-md-offset-2 col-md-10 alert alert-danger alert-dismissable fade in" id="cekemail" style="display:none;">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Perhatian!</strong> Email telah digunakan.
							</div>

							  <script>
							  $("#station_email").keyup(function(){
								  $.get("<?=Station_url("cekstation");?>",{id:$("#station_email").val()})
								  .done(function(data){
								  	if(data>0){
								  		$("#cekemail").fadeIn();$("#submit").prop("disabled","disabled");
									}else{
										$("#cekemail").fadeOut();$("#submit").prop("disabled","");
									}
								  });
							  });
							  </script>
							  <script>
								  function getregion(){
								  	$.get("<?=Station_url("regionshow");?>",{department_id:$("#department_id").val()}).done(function(data){
											$("#region_id").html(data);
											getstation();
										});
									}
								  function getstation(){
								  	$.get("<?=Station_url("stationshow");?>",{region_id:$("#region_id").val()}).done(function(data){
											$("#station_id").html(data);
										});
									}
								  $(document).ready(function(){
								  <?php if($region_id==0){echo "getregion();";}?>
								  <?php if($station_id==0){echo "getstation();";}?>
								  });
								  </script>									  
							  <input type="hidden" name="station_id" value="<?=$station_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=station_url("station");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadstation_picture;?>
							</div>
							<?php }?>
							<span  id="pesan" style="width:200px; height:50px; box-shadow:grey 0px 0px 3px, padding:15px; color:white; border-radius:5px; z-index:100; position:fixed; left:50%; top:50%; transform:translate(-50%,-50%); text-align:center;">
								<label id="pesanisi" style="position:relative; top:5px;  "></label>
							</span >
							<div class="box">
								
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>Station</th>
										    <th>Abe</th>
										    <th>Comark</th>
										    <th>Electrosys</th>
										    <th>Giant</th>
										    <th>Itelco</th>
										    <th>Nec</th>
										    <th>Rs</th>
										    <th>Thales</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->tt
										->get("station");
										foreach($usr->result() as $station){?>
										<tr>
											<td><?=$station->station_name;?></td>
										    <td>
											<?php $sit=$this->db
												->where("station_id",$station->station_id)
												->where("vendor_id","1")
												->get("site");
												if($sit->num_rows()>0){$checked='checked="checked"';}else{$checked='';}
												?>
											<input onClick="cek(this,'<?=$station->station_id;?>','1')" type="checkbox" <?=$checked;?> value="<?=$station->station_id;?>"/></td>
									      <td>
											<?php $sit=$this->db
												->where("station_id",$station->station_id)
												->where("vendor_id","2")
												->get("site");
												if($sit->num_rows()>0){$checked='checked="checked"';}else{$checked='';}
												?>
											<input onClick="cek(this,'<?=$station->station_id;?>','2')" type="checkbox" <?=$checked;?> value="<?=$station->station_id;?>"/></td>
										    <td>
											<?php $sit=$this->db
												->where("station_id",$station->station_id)
												->where("vendor_id","3")
												->get("site");
												if($sit->num_rows()>0){$checked='checked="checked"';}else{$checked='';}
												?>
											<input onClick="cek(this,'<?=$station->station_id;?>','3')" type="checkbox" <?=$checked;?> value="<?=$station->station_id;?>"/></td>
										    <td>
											<?php $sit=$this->db
												->where("station_id",$station->station_id)
												->where("vendor_id","4")
												->get("site");
												if($sit->num_rows()>0){$checked='checked="checked"';}else{$checked='';}
												?>
											<input onClick="cek(this,'<?=$station->station_id;?>','4')" type="checkbox" <?=$checked;?> value="<?=$station->station_id;?>"/></td>
										    <td>
											<?php $sit=$this->db
												->where("station_id",$station->station_id)
												->where("vendor_id","5")
												->get("site");
												if($sit->num_rows()>0){$checked='checked="checked"';}else{$checked='';}
												?>
											<input onClick="cek(this,'<?=$station->station_id;?>','5')" type="checkbox" <?=$checked;?> value="<?=$station->station_id;?>"/></td>
										    <td>
											<?php $sit=$this->db
												->where("station_id",$station->station_id)
												->where("vendor_id","6")
												->get("site");
												if($sit->num_rows()>0){$checked='checked="checked"';}else{$checked='';}
												?>
											<input onClick="cek(this,'<?=$station->station_id;?>','6')" type="checkbox" <?=$checked;?> value="<?=$station->station_id;?>"/></td>
										    <td>
											<?php $sit=$this->db
												->where("station_id",$station->station_id)
												->where("vendor_id","7")
												->get("site");
												if($sit->num_rows()>0){$checked='checked="checked"';}else{$checked='';}
												?>
											<input onClick="cek(this,'<?=$station->station_id;?>','7')" type="checkbox" <?=$checked;?> value="<?=$station->station_id;?>"/></td>
										    <td>
											<?php $sit=$this->db
												->where("station_id",$station->station_id)
												->where("vendor_id","8")
												->get("site");
												if($sit->num_rows()>0){$checked='checked="checked"';}else{$checked='';}
												?>
											<input onClick="cek(this,'<?=$station->station_id;?>','8')" type="checkbox" <?=$checked;?> value="<?=$station->station_id;?>"/></td>
										</tr>
										<?php }?>
									</tbody>
								</table>
								<script>
										function cek(a,b,c){
											if (a.checked){
												$.get("<?=site_url("input_site");?>",{station_id:b,vendor_id:c,ket:"Insert"})
												.done(function(data){											
													$("#pesan").css("display","inline").removeClass("label-danger").addClass("label-success");
													setTimeout(function(){ $("#pesan").css("display","none"); }, 2000);
													$("#pesanisi").html(data);
													//alert(data);
												});
											}else{
												$.get("<?=site_url("input_site");?>",{station_id:b,vendor_id:c,ket:"Delete"}).done(function(data){											
													$("#pesan").css("display","inline").removeClass("label-success").addClass("label-danger");
													setTimeout(function(){ $("#pesan").css("display","none"); }, 2000);
													$("#pesanisi").html(data);
													//alert(data);
												});
											}
											
											
										}
										</script>
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
