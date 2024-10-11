		
	
		
		<div class="row judul">
			<div class="col-md-8">
				Charge Item No. <?=$this->input->get("invspayment_no");?>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
			<form method="post" class="col-md-4">							
							
				<button type="button" onClick="baru('0','<?=$this->input->get("invspayment_no");?>')" name="new" class="btn btn-info btn-sm" value="OK" style=" float:right;margin:2px;">New</button>
				<?php if(isset($_GET['supplier_id'])){$supplier_id=$_GET['supplier_id'];}else{$supplier_id="";}?>
				<?php if(isset($_GET['invs_no'])&&$_GET['invs_no']!=""){
					$invs_no=$_GET['invs_no'];
					$kembali=site_url("invspayment?invs_no=".$invs_no."&supplier_id=".$supplier_id);
				}else{
					$invs_no="";
					$kembali=site_url("invspayment");
				}?>				
				<input type="hidden" name="invspaymentproduct_id" value="0"/>
				
			</form>
			<?php }?>
		</div>	
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='change';$judul="Update Product";}else{$namabutton='create';$judul="New Product";}?>	
							<div class="well text-center"><h5><?=$judul;?></h5></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label class="control-label col-sm-2" for="unit_id">Source:</label>
									<div class="col-sm-10">
                                        <input type="hidden" id="invspaymentproduct_source" name="invspaymentproduct_source" value="<?=($invspaymentproduct_source=="")?"petty_id":$invspaymentproduct_source;?>"/>
                            			<?php if(isset($_POST['edit'])){$disabled="disabled";}else{$disabled="";}?>
										<label><input onclick="pilihsource('kas_id')" <?=$disabled;?> required type="radio" name="invspaymentproductsource" id="kas_id" value="kas_id" <?=($invspaymentproduct_source=="kas_id")?'checked="checked"':"";?> >Big Cash</label>
										<label><input onclick="pilihsource('petty_id')" <?=$disabled;?> required type="radio" name="invspaymentproductsource" id="petty_id" value="petty_id" <?=($invspaymentproduct_source=="petty_id"||$invspaymentproduct_source=="")?'checked="checked"':"";?>>Petty Cash</label>
									</div>
								  </div>
								  <script>
								  function pilihsource(a){
								  	$("#invspaymentproduct_source").val(a);
								  }
								  </script>
							<?php if(isset($_GET['invs_no'])&&$_GET['invs_no']!=""){?>							
							  <input type="hidden" id="biaya_id" name="biaya_id" value="0"/>		
							<?php }else{?>
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
							  <?php }?>
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
							  
							  <input type="hidden" id="invspaymentproduct_id1" name="invspaymentproduct_id" value="<?=$invspaymentproduct_id;?>"/>	
							  <input type="hidden" id="invspayment_no" name="invspayment_no" value="<?=$this->input->get("invspayment_no");?>"/>	
							  <input type="hidden" id="petty_id1" name="petty_id" value="<?=$petty_id;?>"/>	
							  <input type="hidden" id="kas_id1" name="kas_id" value="<?=$kas_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button onClick="cu('<?=$namabutton;?>',$('#invspaymentproduct_source').val(),$('#biaya_id').val(),$('#invspaymentproduct_description').val(),$('#invspaymentproduct_amount').val(),$('#invspaymentproduct_qty').val(),$('#invspaymentproduct_id1').val(),$('#petty_id1').val(),$('#kas_id1').val(),$('#invspayment_no').val())" type="button" id="submit" class="btn btn-primary col-md-5" name="<?=$namabutton;?>" value="OK">Submit</button>
									<button onClick="awal('<?=$_POST["invspayment_no"];?>')" class="btn btn-warning col-md-offset-1 col-md-5" type="button">Back</button>
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
										  	<?php if(!isset($_GET['invs_no'])||$_GET['invs_no']==""){?>
											<th>Type of Cost</th>
											<?php }?>
											<th>Description</th>
											<th>Qty</th>
											<th>Price</th>
											<th>Total</th>
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
											<?php if(!isset($_GET['invs_no'])||$_GET['invs_no']==""){?>										
											<td><?=$biayaid;?></td>
											<?php }?>
											<td><?=$invspaymentproduct_description;?></td>
											<td><?=$invspaymentproduct->invspaymentproduct_qty;?></td>
											<td><?=number_format($invspaymentproduct->invspaymentproduct_amount,0,",",".");?></td>
											<td>
											<?=number_format($invspaymentproduct->invspaymentproduct_amount*$invspaymentproduct->invspaymentproduct_qty,0,",",".");?>
											</td>
											<td style="padding-left:0px; padding-right:0px;">
												<form method="post" class="col-md-6" style="padding:0px;">
													<button type="button" onClick="edita('<?=$invspaymentproduct->invspaymentproduct_id;?>','<?=$this->input->get("invspayment_no");?>')" class="btn btn-warning btn-xs" name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="invspaymentproduct_id" value="<?=$invspaymentproduct->invspaymentproduct_id;?>"/>
												</form>
											
												<form method="post" class="col-md-6" style="padding:0px;" id="deleta">
													<button onClick="deleta('<?=$this->input->get("invspayment_no");?>','<?=$invspaymentproduct->invspaymentproduct_id;?>','<?=$invspaymentproduct->invspaymentproduct_source;?>','<?=$invspaymentproduct->kas_id;?>','<?=$invspaymentproduct->petty_id;?>')" type="button" class="btn btn-danger btn-xs delete" id="delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" id="invspaymentproduct_id" name="invspaymentproduct_id" value="<?=$invspaymentproduct->invspaymentproduct_id;?>"/>
													<input type="hidden" id="invspaymentproduct_source" name="invspaymentproduct_source" value="<?=$invspaymentproduct->invspaymentproduct_source;?>"/>
													<input type="hidden" id="kas_id" name="kas_id" value="<?=$invspaymentproduct->kas_id;?>"/>
													<input type="hidden" id="petty_id" name="petty_id" value="<?=$invspaymentproduct->petty_id;?>"/>
												</form>
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

