<!doctype html>
<html>

<head>
    <?php 
	session_start();
	require_once("meta.php");?>
	<script>
		function insert(){
			$.post("<?=site_url("apiw/insert_visual");?>",{
				siaran_id:$("#siaran_id").val(),	
				visual_kualitasvideo:$("#visual_kualitasvideo").val(),
				visual_kualitasstereo:$("#visual_kualitasstereo").val(),
				visual_uwave:$("#visual_uwave").val(),
				visual_downlink:$("#visual_downlink").val(),
				visual_uraian:$("#visual_uraian").val(),
				visual_sebab:$("#visual_sebab").val(),
				user_id:$("#user_id").val()
			})
			.done(function(datas){
				$.each(datas,function(index,data){
					if(index=="message"){window.location.href="<?=site_url("visual?message=");?>"+data}
				});
			});
		}
	</script>
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">visual</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> visual</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="visual_id"/>
				</h1>
			</form>
			<?php }?>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="formedit">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update visual";$onclick="edit()";}else{$namabutton='name="create"';$judul="New visual";$onclick="insert()";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal formlead" method="post" enctype="multipart/form-data">
							
							  <div class="form-group">
								<label class="control-label col-sm-2" for="siaran_id">Siaran:</label>
								<div class="col-sm-10">
								 
								  <?php
									$siaran = $this->db->get('siaran')->result();
									$arr = array();
									$arr[""] = "Pilih Siaran";

									foreach ($siaran as $u) 
									{
										$arr[$u->siaran_id] = $u->siaran_name;
									}							
									echo form_dropdown('siaran_id" id="siaran_id" data-rel="chosen" class="form-control',$arr,$siaran_id);									
								  ?>
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="visual_kualitasvideo">Kualitas Video:</label>
								<div class="col-sm-10">
								 
								  <?php
									$arr = array(""=>"Pilih Kualitas Video","A"=>"A","B"=>"B","C"=>"C","D"=>"D","E"=>"E");																
									echo form_dropdown('visual_kualitasvideo" id="visual_kualitasvideo" data-rel="chosen" class="form-control',$arr,$visual_kualitasvideo);									
								  ?>
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="visual_kualitasstereo">Kualitas Stereo:</label>
								<div class="col-sm-10">
								 
								  <?php
									$arr = array(""=>"Pilih Kualitas Stereo","1"=>"1","2"=>"2");																
									echo form_dropdown('visual_kualitasstereo" id="visual_kualitasstereo" data-rel="chosen" class="form-control',$arr,$visual_kualitasstereo);									
								  ?>
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="visual_uwave">Gangguan Uwave:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="visual_uwave" name="visual_uwave" placeholder="" value="<?=$visual_uwave;?>">
								</div>
							  </div>
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="visual_downlink">Gangguan Downlink:</label>
								<div class="col-sm-10">
								  <input type="text"  class="form-control" id="visual_downlink" name="visual_downlink" placeholder="" value="<?=$visual_downlink;?>">
								</div>
							  </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="visual_sebab">Sebab:</label>
								<div class="col-sm-10">
								  <input type="text"  class="form-control" id="visual_sebab" name="visual_sebab" placeholder="" value="<?=$visual_sebab;?>">
								</div>
							  </div>
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="visual_uraian">Uraian:</label>
								<div class="col-sm-10">
								  <input type="text"  class="form-control" id="visual_uraian" name="visual_uraian" placeholder="" value="<?=$visual_uraian;?>">
								</div>
							  </div>
							  
							  <div class="col-md-offset-2 col-md-10 alert alert-danger alert-dismissable fade in" id="cekemail" style="display:none;">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Perhatian!</strong> Email telah digunakan.
							</div>							  
						  <input type="hidden" id="user_id" name="user_id" value="<?=$this->session->userdata("usid");?>"/>	
						  <input type="hidden" name="visual_id" value="<?=$visual_id;?>"/>				  					  
						  <div class="form-group"> 
							<div class="col-sm-offset-2 col-sm-10">
								<button type="button" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK" onClick="<?=$onclick;?>">Submit</button>
								<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("visual");?>">Back</button>
							</div>
						  </div>
						</form>
						</div>
						<?php }else{?>	
							<?php 
							$message=$this->input->get("message");
							if($message!=""){?>
							<div class="alert alert-info alert-dismissable" id="alert">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong id="isimessage"><?=$message;?></strong><br/><?=$uploadvisual_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover table-bordered table-striped">
									<thead>
										<tr>											
											<th rowspan="2" class="col-md-1">Waktu</th>
											<th rowspan="2" class="col-md-2">Acara</th>
											<th colspan="2" class="col-md-1">Kualitas</th>
											<th colspan="2" class="col-md-2">Gangguan</th>
											<th rowspan="2" class="col-md-2">Uraian</th>
											<th rowspan="2" class="col-md-2">Asal/<br/>Sebab</th>
											<th rowspan="2" class="col-md-1">Teknisi</th>
											<th rowspan="2" class="col-md-1">Action</th>
										</tr>
										<tr>
										  <th >Video</th>
									      <th >Stereo</th>
									      <th >Uwave</th>
									      <th >Downlink</th>
									  </tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("siaran","siaran.siaran_id=visual.siaran_id","left")
										->join("tt_scm.user","tt_scm.user.user_id=pm_scm.visual.user_id","left")
										->get("visual");
										foreach($usr->result() as $visual){?>
										<tr>
											<td style=""><?=$visual->visual_datetime;?></td>
											<td><?=$visual->siaran_name;?></td>
											<td><?=$visual->visual_kualitasvideo;?></td>
											<td><?=$visual->visual_kualitasstereo;?></td>
											<td><?=$visual->visual_uwave;?></td>
											<td><?=$visual->visual_downlink;?></td>
											<td><?=$visual->visual_uraian;?></td>
											<td><?=$visual->visual_sebab;?></td>
											<td><?=$visual->user_name;?></td>
											<td>
											
												<form method="post" class="col-md-6" style="padding:0px; font-size:12px;">
													<button class="btn btn-sm btn-warning" name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="visual_id" value="<?=$visual->visual_id;?>"/>
												</form>
												
												<form method="post" class="col-md-6" style="padding:0px; font-size:12px;">
													<button class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="visual_id" value="<?=$visual->visual_id;?>"/>
												</form>											</td>
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
