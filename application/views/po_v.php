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
				<li class="active">PO ke Supplier / Makloon</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> PO ke Supplier / Makloon</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&!isset($_GET['report'])){?>
			<form method="post" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="po_id"/>
				</h1>
			</form>
			<?php }?>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])|| isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update PO";}else{$namabutton='name="create"';$judul="Create PO";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="post" enctype="multipart/form-data">
							<?php if($po_no!=""){?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="po_no">PO No.:</label>
                                <div class="col-sm-10" align="left">
									  <input readonly="" type="text" id="po_no" name="po_no" class="form-control" value="<?=$po_no;?>">
								</div>
                              </div>
							  <?php }?>							  
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="supplier_id">Supplier / Makloon:</label>
                                <div class="col-sm-10" align="left">
								<?php $t=array("","Supplier","Makloon");?>
									  <select type="text" id="supplier_id" name="supplier_id" class="form-control">
									  	<option value="0" <?=($supplier_id=="0")?"selected":"";?>>Choose Supplier</option>
										<?php $supplier=$this->db->get("supplier");
										foreach($supplier->result() as $supplier){?>
									  	<option value="<?=$supplier->supplier_id;?>" <?=($supplier_id==$supplier->supplier_id)?"selected":"";?>><?=$supplier->supplier_name;?> ( <?=$t[$supplier->supplier_type];?> )</option>
										<?php }?>
									  </select>
								</div>
                              </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="po_date">Date:</label>
                                <div class="col-sm-10" align="left">
									  <input type="text" id="po_date" name="po_date" class="form-control date" value="<?=$po_date;?>">	
								</div>
                              </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="po_attention">Attention.:</label>
                                <div class="col-sm-10" align="left">
									  <input type="text" id="po_attention" name="po_attention" class="form-control" value="<?=$po_attention;?>">
								</div>
                              </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="po_jasa">Permintaan Jasa:</label>
                                <div class="col-sm-10" align="left">
									  <input type="text" id="po_jasa" name="po_jasa" class="form-control"">
								</div>
                              </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="po_term">Term and Condition:</label>
                                <div class="col-sm-10" align="left">
									<textarea type="text" id="po_term" name="po_term" class="form-control"><?=$po_term;?></textarea>
									<script>
										CKEDITOR.replace('po_term');
									</script>									
								</div>
                              </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="po_prepare">Prepared by:</label>
                                <div class="col-sm-10" align="left">
									  <input type="text" id="po_prepare" name="po_prepare" class="form-control" value="<?=$po_prepare;?>">
								</div>
                              </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="po_approve">Approved by:</label>
                                <div class="col-sm-10" align="left">
									  <input type="text" id="po_approve" name="po_approve" class="form-control" value="<?=$po_approve;?>">
								</div>
                              </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="po_ppn">PPN:</label>
                                <div class="col-sm-10" align="left">
									   <select type="text" id="po_ppn" name="po_ppn" class="form-control">
									  	<option value="0" <?=($po_ppn=="0")?"selected":"";?>>Tidak</option>
									  	<option value="1" <?=($po_ppn=="1")?"selected":"";?>>Ya</option>
									  </select>
								</div>
                              </div>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="po_pph">PPH:</label>
                                <div class="col-sm-10" align="left">
									   <select type="text" id="po_pph" name="po_pph" class="form-control">
									  	<option value="0" <?=($po_pph=="0")?"selected":"";?>>Tidak</option>
									  	<option value="1" <?=($po_pph=="1")?"selected":"";?>>Ya</option>
									  </select>
								</div>
                              </div>
							  
							  
							
							  
							   					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("po");?>">Back</button>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){$display="display:block;";}else{$display="display:none;";}?>
							<div id="message" class="alert alert-info alert-dismissable" style="<?=$display;?>">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong id="messageisi"><?=$message;?></strong>
							</div>
							<div class="box">
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Po No. </th>
											<th>Supplier</th>
											<?php if(!isset($_GET['report'])){$col="col-md-2";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php $usr=$this->db
										->join("supplier","supplier.supplier_id=po.supplier_id","left")
										->order_by("po_id","desc")
										->get("po");
										$no=1;
										foreach($usr->result() as $po){?>
										<tr>	
											<td><?=$no++;?></td>										
											<td><?=$po->po_date;?></td>
											<td><?=$po->po_no;?></td>
											<td><?=$po->supplier_name;?>											
											</td>											
											<td style="padding-left:0px; padding-right:0px;">
											<?php if(!isset($_GET['report'])){$float="float:right;";?>  												
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="po_no" value="<?=$po->po_no;?>"/>
												</form>	                                      											
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="po_no" value="<?=$po->po_no;?>"/>
												</form>		
											<?php }else{$float="";}?>										
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Print PO" target="_blank" href="<?=site_url("poprint?po_no=".$po->po_no)."&supplier_id=".$po->supplier_id;?>" class="btn btn-sm btn-success " name="edit" value="OK"> 
												  <span class="fa fa-print" style="color:white;"></span>												  </a>
												</form>  
											<?php if(!isset($_GET['report'])){
											
											/*$pro=$this->db
											->join("supplier","supplier.supplier_id=po.po_content","left")
											->where("po_customize","1")
											->where("po_content","1")
											->where("po_no",$po->po_no)
											->get("po");
											if($pro->num_rows()>0){*/?>
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												  <a data-toggle="tooltip" title="List Product" target="_blank" href="<?=site_url("poproduct?po_no=".$po->po_no)."&supplier_id=".$po->supplier_id;?>" class="btn btn-sm btn-info " name="edit" value="OK">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>												  </a>
												</form> 		
											<?php //}
											}?>											</td>
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
