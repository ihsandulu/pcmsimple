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
	?>
  <style>
  .ket{margin-top:20px;}
  .judket{color:#AE5700; font-size:18px; font-weight:bold; margin-bottom:10px; padding:5px; padding-top:15px; border-top:#FFF solid 3px; border-bottom:#FFC891 dashed 1px;}
  .isiket{color:#753A00;}
  </style>
  
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Petty Cash</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
			<?php
			$i=$this->db
			->select("petty_inout, SUM(petty_amount)As masuk")
			->where("petty_inout","in")
			->group_by("petty_inout")
			->get("petty");			
			if($i->num_rows()>0){$in=$i->row()->masuk;}else{$in=0;}
			// $this->db->last_query();
			
			$ou=$this->db
			->select("petty_inout, SUM(petty_amount)As keluar")
			->where("petty_inout","out")
			->group_by("petty_inout")
			->get("petty");
			if($ou->num_rows()>0){$out=$ou->row()->keluar;}else{$out=0;}
			$tcash=$in-$out;
			?>
				<h1 class="page-header"> Petty Cash Total (Rp. <?=number_format($tcash,0,",",".");?>)</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&!isset($_GET['report'])){?>
			<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				</h1>
				<input type="hidden" name="petty_id"/>
			</form>
			<?php }?>
			<?php if(isset($_GET['report'])){?>
			<form target="_blank" action="<?=site_url("pettyprint");?>" method="get" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-warning btn-block btn-lg fa fa-print" value="OK" style=""> Print</button>
				<input type="hidden" name="dari" value="<?=$this->input->get("dari");?>"/>
				<input type="hidden" name="ke" value="<?=$this->input->get("ke");?>"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Cash";}else{$namabutton='name="create"';$judul="Create Cash";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<div class="form-group">
								<label class="control-label col-sm-2" for="kas_id">Source:</label>
								<div class="col-sm-10">
									<select onChange="sumber()" class="form-control" name="kas_id" id="kas_id">	
									<option value="-1" <?=($petty_id==-1)?"selected":"";?>>Other</option>
									<option value="<?=$petty_id;?>" <?=($petty_id>0)?"selected":"";?>>Big Cash</option>
									<?php if($identity->identity_saldocustomer==1){?>
									<option value="-2" <?=($petty_id==-2)?"selected":"";?>>Saldo Customer</option>
									<?php }?>
									</select>
								</div>
							  </div>
							  <script>
							  function sumber(){
							  	if($("#kas_id").val()==-2){
									$("#cid").show();
									$("#customerid").attr("required",true);
								}else{
									$("#cid").hide();
									$("#customerid").removeAttr("required");
								}
							  }
							  sumber();
							  </script>	
							  
							<?php if($identity->identity_saldocustomer==1){?>
							  <div class="form-group" id="cid" style="display:none;">
								<label class="control-label col-sm-2" for="customer_id">Customer:</label>
								<div class="col-sm-10">
									<datalist id="customer">
										<?php $uni=$this->db->get("customer");										
										  foreach($uni->result() as $customer){?>											
										  <option id="<?=$customer->customer_id;?>" value="<?=$customer->customer_name;?>">
										<?php }?>
									</datalist>	  
									<input  id="customerid" onChange="rubah(this)" autofocus class="form-control" list="customer" value="<?=$customer_name;?>" autocomplete="off">	
									<input type="hidden" id="customer_id" name="customer_id" value="<?=$customer_id;?>">
									<script>
										function customerid(a){
											var opt = $('option[value="'+$(a).val()+'"]');
											$("#customer_id").val(opt.attr('id'));
											CKEDITOR.instances['petty_remarks'].setData("Saldo Customer : "+$("#customerid").val());
										}
										
										
										function rubah(a){
											customerid(a);
											stoptime();
										}
										
										var timeout;
										function doStuff() {
											timeout = setInterval(function(){customerid('#customerid');},100);
										}
										
										function stoptime(){
											clearTimeout(timeout);
										}
									</script>	
								  
								</div>
							  </div>
							  <?php }?> 
							  <div class="form-group">
								<label class="control-label col-sm-2" for="petty_amount">Amount:</label>
								<div class="col-sm-10">
									<input class="form-control" type="number" name="petty_amount" id="petty_amount" value="<?=$petty_amount;?>"/>	
								</div>
							  </div>	
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="petty_pengirim">Date:</label>
								<div class="col-sm-10">
									<?php if($petty_date==""){$petty_date=date("Y-m-d");}else{$petty_date=$petty_date;}?>
									<input class="form-control date" type="text" name="petty_date" id="petty_date" value="<?=$petty_date;?>"/>	
								</div>
							  </div>	
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="petty_remarks">Remarks:</label>
								<div class="col-sm-10">
									<textarea class="form-control" name="petty_remarks" id="petty_remarks"><?=$petty_remarks;?></textarea>
									<script>
										CKEDITOR.replace('petty_remarks');
									</script>
								</div>
							  </div>	
							 
							 <input class="form-control" type="hidden" name="petty_id" id="petty_id" value="<?=$petty_id;?>"/>
							 <input class="form-control" type="hidden" name="petty_inout" id="petty_inout" value="in"/>
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("petty");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadpetty_picture;?>
							</div>
							<?php }?>
							<div class="box">
							<div style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
							<form class="form-inline">
							  <div class="form-group">
								<label for="email">From:</label>
								<input type="text" class="form-control date" name="dari" value="<?=$dari;?>">
							  </div>
							  <div class="form-group">
								<label for="pwd">To:</label>
								<input type="text" class="form-control date" name="ke" value="<?=$ke;?>">
							  </div>
							  <div class="form-group">
								<select class="form-control" name="project">
									<option value="" <?=($this->input->get("project")=="")?"selected":"";?>>All</option>
									<option value="Project" <?=($this->input->get("project")=="Project")?"selected":"";?>>Project</option>
									<option value="Non Project" <?=($this->input->get("project")=="Non Project")?"selected":"";?>>Non Project</option>
								</select>
							  </div>
							  <div class="form-group">
								<select class="form-control" name="biaya">
									<option value="" <?=($this->input->get("biaya")=="")?"selected":"";?>>All</option>
									<option value="Tetap" <?=($this->input->get("biaya")=="Tetap")?"selected":"";?>>Tetap</option>
									<option value="Tidak Tetap" <?=($this->input->get("biaya")=="Tidak Tetap")?"selected":"";?>>Tidak Tetap</option>
								</select>
							  </div>
							  <?php if(isset($_GET['report'])){?>
							 	<input type="hidden" name="report" value="ok">
							 <?php }?>
							  <button style="margin-right:30px;" type="submit" class="btn btn-default">Search</button>
							  
							  <?php
								//cash sebelumnya
							  	if(isset($_GET['dari'])){
									$this->db->where("petty_date <",$this->input->get("dari"));
								}elseif(isset($_GET['ke'])){
									$this->db->where("petty_date <",$this->input->get("ke"));
								}else{
									$this->db->where("petty_date <",date("Y-m-d"));
								}
							  	
								$mas=$this->db
								->select("petty_inout, SUM(petty_amount)As masuk")
								->where("petty_inout","in")
								->group_by("petty_inout")
								->get("petty");
								
								if($mas->num_rows()>0){
									$smas=$mas->row()->masuk;
								}else{
									$smas=0;
								}
								// $this->db->last_query();
								
								if(isset($_GET['dari'])){
									$this->db->where("petty_date <",$this->input->get("dari"));
								}if(isset($_GET['ke'])){
									$this->db->where("petty_date <",$this->input->get("ke"));
								}else{
									$this->db->where("petty_date <",date("Y-m-d"));
								}
								
								$ker=$this->db
								->select("petty_inout, SUM(petty_amount)As keluar")
								->where("petty_inout","out")
								->group_by("petty_inout")
								->get("petty");
								
								if($ker->num_rows()>0){
									$sker=$ker->row()->keluar;
								}else{
									$sker=0;
								}
								
								$scash=$smas-$sker;
							  ?>							  
							  <?php
								//cash periode ini
							  	if(isset($_GET['dari'])){
									$this->db->where("petty_date >=",$this->input->get("dari"));
								}else{
									$this->db->where("petty_date >=",date("Y-m-d"));
								}
								
								if(isset($_GET['ke'])){
									$this->db->where("petty_date <=",$this->input->get("ke"));
								}else{
									$this->db->where("petty_date <=",date("Y-m-d"));
								}
							  	
								$mas=$this->db
								->select("petty_inout, SUM(petty_amount)As masuk")
								->where("petty_inout","in")
								->group_by("petty_inout")
								->get("petty");
								
								if($mas->num_rows()>0){
									$mas=$mas->row()->masuk;
								}else{
									$mas=0;
								}
								// $this->db->last_query();
								
								if(isset($_GET['dari'])){
									$this->db->where("petty_date >=",$this->input->get("dari"));
								}else{
									$this->db->where("petty_date >=",date("Y-m-d"));
								}
								
								if(isset($_GET['ke'])){
									$this->db->where("petty_date <=",$this->input->get("ke"));
								}else{
									$this->db->where("petty_date <=",date("Y-m-d"));
								}
								
								$ker=$this->db
								->select("petty_inout, SUM(petty_amount)As keluar")
								->where("petty_inout","out")
								->group_by("petty_inout")
								->get("petty");
								
								if($ker->num_rows()>0){
									$ker=$ker->row()->keluar;
								}else{
									$ker=0;
								}
								
								$cash=$mas-$ker;
							  ?>
							  
							</form>
							<div class="col-md-12 ket">
								<div class="col-md-12 judket">Cash</div>
								<div class="col-md-3 isiket"><label>Cash Sebelumnya :</label><label id="cashs"><?=number_format($scash,0,",",".");?></label></div>
								<div class="col-md-3 isiket"><label>Cash Periode Ini :</label><label id="cashp"><?=number_format($cash,0,",",".");?></label></div>
								<div class="col-md-3 isiket"><label>Debet :</label><label id="debet"></label></div>
								<div class="col-md-3 isiket"><label>Credit :</label><label id="credit"></label></div>
							</div>
							<div class="col-md-12 ket">
								<div class="col-md-12 judket">Project/Non Project</div>
								<div class="col-md-3 isiket"><label>Project Debet :</label><label id="cprojectd"></label></div>
								<div class="col-md-3 isiket"><label>Project Credit :</label><label id="cprojectk"></label></div>
								<div class="col-md-3 isiket"><label>Non Project Debet :</label><label id="cnprojectd"></label></div>
								<div class="col-md-3 isiket"><label>Non Project Credit :</label><label id="cnprojectk"></label></div>
							</div>
							<div class="col-md-12 ket">
								<div class="col-md-12 judket">Biaya Tetap/Tidak Tetap</div>
								<div class="col-md-3 isiket"><label>Biaya Tetap :</label><label id="ctetap"></label></div>
								<div class="col-md-3 isiket"><label>Biaya Tidak Tetap :</label><label id="cttetap"></label></div>
							</div>
							<div style="clear:both;"></div>
						
							</div>
							
								<div id="collapse4" class="body table-respettynsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Project</th>
											<th>Description</th>
											<th>Debet  </th>
											<th>Credit</th>
											<th>Type of Cost</th>
											<th>Saldo</th>
											<?php if(!isset($_GET['report'])){?>
											<th>Action</th>
											<?php }?>
										</tr>
									</thead>
									<tbody> 
										<tr>											
											<td>1</td>			
											<td id="dateawal"></td>
											<td style="text-align:left;"></td>
											<td style="text-align:left;">Dari Kantor</td>
											<td style="text-align:right;"><?=number_format($scash,0,",",".");?></td>
											<td style="text-align:right;"></td>
											<td style="text-align:center;"></td>
											<td style="text-align:right;"><?=number_format($scash,0,",",".");?></td>
											<?php if(!isset($_GET['report'])){?>
											<td style="text-align:center; "></td>
											<?php }?>
										</tr>
										<?php 
										if(isset($_GET['project'])){
											switch($_GET['project']){
												case "Project":
												$this->db->where("petty.project_id >","0");
												break;
												case "Non Project":
												$this->db->where("petty.project_id","0");
												break;
											}
										}
										if(isset($_GET['biaya'])){
											switch($_GET['biaya']){
												case "Tetap":
												$this->db->where("petty.biaya_id >","0");
												break;
												case "Tidak Tetap":
												$this->db->where("petty.biaya_id","0");
												break;
											}
										}
										if(isset($_GET['dari'])){
											$this->db->where("petty_date >=",$this->input->get("dari"));
										}else{
											$this->db->where("petty_date >=",date("Y-m-d"));
										}
										
										if(isset($_GET['ke'])){
											$this->db->where("petty_date <=",$this->input->get("ke"));
										}else{
											$this->db->where("petty_date <=",date("Y-m-d"));
										}
										$usr=$this->db
										->select("*,petty.customer_id AS cid")
										->join("project","project.project_id=petty.project_id","left")
										->join("biaya","biaya.biaya_id=petty.biaya_id","left")
										->order_by("petty_id","desc")
										->get("petty");
										$no=2;
										$ctetap=0;
										$cttetap=0;
										$cprojectd=0;
										$cprojectk=0;
										$cnprojectd=0;
										$cnprojectk=0;
										$cash=$scash;
										$debet=$scash;
										$credit=0;
										//echo $this->db->last_query();
										foreach($usr->result() as $petty){	
										if($petty->petty_inout=="in"){$cash+=$petty->petty_amount;$debet+=$petty->petty_amount;}else{$cash-=$petty->petty_amount;$credit+=$petty->petty_amount;}								
										if($petty->biaya_id>0){
											$petty_remarks=$petty->biaya_name;
											if($petty->petty_inout=="in"){
												$biaya="";
											}
											if($petty->petty_inout=="out"){
												$biaya="Tetap";
												$ctetap=+$petty->petty_amount;
											}
										}else{
											$petty_remarks=$petty->petty_remarks;
											if($petty->petty_inout=="in"){
												$biaya="";
											}
											if($petty->petty_inout=="out"){
												$biaya="Tidak Tetap";
												$cttetap=+$petty->petty_amount;
											}
										}
										
										if($petty->project_id>0){
											if($petty->petty_inout=="in"){												
												$cprojectd=+$petty->petty_amount;
											}
											if($petty->petty_inout=="out"){
												$cprojectk=+$petty->petty_amount;
											}
										}else{
											if($petty->petty_inout=="in"){
												$cnprojectd=+$petty->petty_amount;
											}
											if($petty->petty_inout=="out"){
												$cnprojectk=+$petty->petty_amount;
											}
										}								
										?>
										<script>
											$("#ctetap").html("Rp <?=number_format($ctetap,0,",",".");?>");
											$("#cttetap").html("Rp <?=number_format($cttetap,0,",",".");?>");
											$("#cprojectd").html("Rp <?=number_format($cprojectd,0,",",".");?>");
											$("#cprojectk").html("Rp <?=number_format($cprojectk,0,",",".");?>");
											$("#cnprojectd").html("Rp <?=number_format($cnprojectd,0,",",".");?>");
											$("#cnprojectk").html("Rp <?=number_format($cnprojectk,0,",",".");?>");	
											$("#debet").html("Rp <?=number_format($debet,0,",",".");?>");
											$("#credit").html("Rp <?=number_format($credit,0,",",".");?>");	
											
											if('<?=$no;?>'==2){$("#dateawal").html("<?=$petty->petty_date;?>");}									
										</script>
										<tr>											
											<td><?=$no++;?></td>			
											<td><?=$petty->petty_date;?></td>
											<td style="text-align:left;"><?=$petty->project_name;?></td>
											<td style="text-align:left;"><?=$petty_remarks;?></td>
											<td style="text-align:right;"><?=($petty->petty_inout=="in")?number_format($petty->petty_amount,0,",","."):"";?></td>
											<td style="text-align:right;"><?=($petty->petty_inout=="out")?number_format($petty->petty_amount,0,",","."):"";?></td>
											<td style="text-align:center;"><?=$biaya;?></td>
											<td style="text-align:right;"><?=number_format($cash,0,",",".");?></td>
											<?php if(!isset($_GET['report'])){?>
											<td style="text-align:center; ">  
											<?php if(!isset($_GET['report'])&&$petty->petty_inout=="in"){$float="float:right;";?>  	 									
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="petty_id" value="<?=$petty->petty_id;?>"/>
													<input type="hidden" name="kas_id" value="<?=$petty->kas_id;?>"/>
													<input type="hidden" name="customer_id" value="<?=$petty->cid;?>"/>
												</form>	                                      											
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="petty_id" value="<?=$petty->petty_id;?>"/>
												</form>		
											<?php }else{$float="";}?>											
											</td>
											<?php }?>
										</tr>
										<?php }?>
									</tbody>
									<tfoot>
										<tr>
											<th colspan="4" style="text-align:right; padding:9px;">Total : &nbsp;</th>
											<th style="text-align:right; padding:9px;"><?=number_format($debet,0,",",".");?>  </th>
											<th style="text-align:right; padding:9px;"><?=number_format($credit,0,",",".");?></th>
											<th></th>
											<th style="text-align:right; padding:9px;"><?=number_format($cash,0,",",".");?></th>
											<?php if(!isset($_GET['report'])){?>
											<th></th>
											<?php }?>
										</tr>
									</tfoot>
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
