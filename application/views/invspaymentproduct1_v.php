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
				<li class="active">Charge Item</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-8">
				<h1 class="page-header"> Charge Item No. <?=$this->input->get("invspayment_no");?></h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-4">							
				<h1 class="page-header col-md-12"> 				
				<button name="new" class="btn btn-info btn-lg" value="OK" style=" float:right;margin:2px;">New</button>
				<?php if(isset($_GET['supplier_id'])){$supplier_id=$_GET['supplier_id'];}else{$supplier_id="";}?>
				<?php if(isset($_GET['invs_no'])&&$_GET['invs_no']!=""){
					$invs_no=$_GET['invs_no'];
					$kembali=site_url("invspayment?invs_no=".$invs_no."&supplier_id=".$supplier_id);
				}else{
					$invs_no="";
					$kembali=site_url("invspayment");
				}?>
				<button type="button" onClick="window.opener.location='<?=$kembali;?>'; window.close();" class="btn btn-warning btn-lg" style=" float:right; margin:2px;"> Back</button>
				<input type="hidden" name="invspaymentproduct_id" value="0"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Product";}else{$namabutton='name="create"';$judul="New Product";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label class="control-label col-sm-2" for="unit_id">Source:</label>
									<div class="col-sm-10">
                            			<?php if(isset($_POST['edit'])){$disabled="disabled";?>
                                        <input type="hidden" name="invspaymentproduct_source" value="<?=$invspaymentproduct_source;?>"/>
                                        <?php }else{$disabled="";}?>
										<label><input <?=$disabled;?> required type="radio" name="invspaymentproduct_source" id="kas_id" value="kas_id" <?=($invspaymentproduct_source=="kas_id")?'checked="checked"':"";?> >Big Cash</label>
										<label><input <?=$disabled;?> required type="radio" name="invspaymentproduct_source" id="petty_id" value="petty_id" <?=($invspaymentproduct_source=="petty_id"||$invspaymentproduct_source=="")?'checked="checked"':"";?>>Petty Cash</label>
									</div>
								  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="biaya_id">Type of Cost:</label>
								<div class="col-sm-10">									 
									<select class="form-control" id="biaya_id" name="biaya_id" onChange="pilihbiaya(this)">
										<option value="0" <?=($biaya_id=="0")?"selected":"";?>>Lain-lain</option>
										<?php $biaya=$this->db->get("biaya");
										foreach($biaya->result() as $biaya){?>
										<option value="<?=$biaya->biaya_id;?>" <?=($biaya_id==$biaya->biaya_id)?"selected":"";?>><?=$biaya->biaya_name;?></option>										
										<?php }?>
									</select>
									<script>
									function pilihbiaya(){
										if($("#biaya_id").val()=='0'){
											$("#invspaymentproductdescription").show();
										}else{
											$("#invspaymentproductdescription").hide();
										}
									}
									$(document).ready(function(){pilihbiaya();});
									
									</script>
								</div>
							  </div>
							  <div class="form-group" id="invspaymentproductdescription" >
								<label class="control-label col-sm-2" for="invspaymentproduct_description">Description:</label>
								<div class="col-sm-10">									 
									<input type="text" class="form-control" id="invspaymentproduct_description" name="invspaymentproduct_description" value="<?=$invspaymentproduct_description;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspaymentproduct_amount">Amount:</label>
								<div class="col-sm-10">
								  <input type="text" autofocus class="form-control" id="invspaymentproduct_amount" name="invspaymentproduct_amount"  value="<?=$invspaymentproduct_amount;?>">
								</div>
							  </div>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspaymentproduct_qty">Qty:</label>
								<div class="col-sm-10">
									<?php if($invspaymentproduct_qty==0){$invspaymentproduct_qty=1;}?>
								  <input type="text" min="1" autofocus class="form-control" id="invspaymentproduct_qty" name="invspaymentproduct_qty" placeholder="Enter Qty" value="<?=$invspaymentproduct_qty;?>">
								</div>
							  </div>
							  <!--
							  <div class="form-group">
								<label class="control-label col-sm-2" for="invspaymentproduct_picture">Picture:</label>
								<div class="col-sm-10" align="left"> 
								  <input type="file" class="form-control" id="invspaymentproduct_picture" name="invspaymentproduct_picture"><br/>
								<?php if($invspaymentproduct_picture!=""){$user_image="assets/images/invspaymentproduct_picture/".$invspaymentproduct_picture;}else{$user_image="assets/img/user.gif";}?>
								  <img id="invspaymentproduct_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
								  <script>
								  	function readURL(input) {
										if (input.files && input.files[0]) {
											var reader = new FileReader();
								
											reader.onload = function (e) {
												$('#invspaymentproduct_picture_image').attr('src', e.target.result);
											}
								
											reader.readAsDataURL(input.files[0]);
										}
									}
								
									$("#invspaymentproduct_picture").change(function () {
										readURL(this);
									});
								  </script>
								</div>
							  </div>-->
							  <input type="hidden" name="invspaymentproduct_id" value="<?=$invspaymentproduct_id;?>"/>	
							  <input type="hidden" name="invspayment_no" value="<?=$this->input->get("invspayment_no");?>"/>	
							  <input type="hidden" name="petty_id" value="<?=$petty_id;?>"/>	
							  <input type="hidden" name="kas_id" value="<?=$kas_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<a class="btn btn-warning col-md-offset-1 col-md-5" href="<?=site_url("invspaymentproduct?invspayment_no=".$_GET["invspayment_no"]."&invs_no=".$_GET["invs_no"]."&supplier_id=".$_GET["supplier_id"]."");?>">Back</a>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadinvspaymentproduct_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
										  <th>Source</th>
											<th>Type of Cost</th>
											<th>Description</th>
											<th>Qty</th>
											<th>Price</th>
											<th>Total</th>
											<!--<th>Picture</th>-->
											<th class="col-md-1">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("biaya","biaya.biaya_id=invspaymentproduct.biaya_id","left")
										->where("invspayment_no",$this->input->get("invspayment_no"))
										->order_by("invspaymentproduct_id","desc")
										->get("invspaymentproduct");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $invspaymentproduct){
										if($invspaymentproduct->invspaymentproduct_source=="petty_id"){$source="Petty Cash";}else{$source="Big Cash";}
										if($invspaymentproduct->biaya_id==0){
											$biayaid="Tidak Tetap";
											$invspaymentproduct_description=$invspaymentproduct->invspaymentproduct_description;
										}else{
											$biayaid="Tetap";
											$invspaymentproduct_description=$invspaymentproduct->biaya_name;
										}
										?>
										<tr>
											<td><?=$no++;?></td>
										  	<td><?=$source;?></td>											
											<td><?=$biayaid;?></td>
											<td><?=$invspaymentproduct_description;?></td>
											<td><?=$invspaymentproduct->invspaymentproduct_qty;?></td>
											<td><?=number_format($invspaymentproduct->invspaymentproduct_amount,0,",",".");?></td>
											<td><?=number_format($invspaymentproduct->invspaymentproduct_amount*$invspaymentproduct->invspaymentproduct_qty,0,",",".");?></td>
											<!--<td><?php if($invspaymentproduct->invspaymentproduct_picture==""){$invspaymentproduct_picture="noimage.png";}else{$invspaymentproduct_picture=$invspaymentproduct->invspaymentproduct_picture;}?>
                                                <img src="<?=base_url("assets/images/invspaymentproduct_picture/".$invspaymentproduct_picture);?>" alt="bukti bayar" style="width:25px; height:25px; cursor:pointer; border:grey solid 1px;" onClick="tampilimg(this)"/>
                                                <?php if($invspaymentproduct->invspaymentproduct_picture!=""){?>
  &nbsp;<a class="btn btn-sm btn-warning fa fa-download" href="<?=base_url("assets/images/invspaymentproduct_picture/".$invspaymentproduct->invspaymentproduct_picture);?>" target="_blank"></a>
  <?php }?>
                                            </td>-->
											<td style="padding-left:0px; padding-right:0px;">
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="invspaymentproduct_id" value="<?=$invspaymentproduct->invspaymentproduct_id;?>"/>
												</form>
											
												<form method="post" class="col-md-6" style="padding:0px;">
													<button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="invspaymentproduct_id" value="<?=$invspaymentproduct->invspaymentproduct_id;?>"/>
													<input type="hidden" name="invspaymentproduct_source" value="<?=$invspaymentproduct->invspaymentproduct_source;?>"/>
													<input type="hidden" name="kas_id" value="<?=$invspaymentproduct->kas_id;?>"/>
													<input type="hidden" name="petty_id" value="<?=$invspaymentproduct->petty_id;?>"/>
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
