<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");?>
	<style>
	.muncul{display:block;}
	.sembunyi{display:none;}
	</style>
  
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">SJ Keluar</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<?php if(!isset($_GET['inv_no'])){
				$col=10;
			}else{
				$col=6;
			}?>
			<div class="col-md-<?=$col;?>">
				<h1 class="page-header"> SJ Keluar</h1>
			</div>
			<?php if(isset($_GET['inv_no'])){?>
			<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<a href="<?=site_url("inv");?>" name="new" class="btn btn-warning btn-block btn-lg fa fa-mail-reply" value="OK" style="font-size:18px; border-radius:0px;"> &nbsp;Invoice</a>
				</h1>
			</form>
			<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<a href="<?=site_url("invpayment?inv_no=".$_GET['inv_no']."&customer_id=".$_GET['customer_id']."&project_id=".$_GET['project_id']);?>" name="new" class="btn btn-warning btn-block btn-lg fa fa-mail-reply" value="OK" style="font-size:18px; border-radius:0px;"> &nbsp;Payment</a>
				</h1>
			</form>
			<?php }?>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&!isset($_GET['report'])){?>
			<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="height:40px; font-size:18px !important;">New</button>
				<input type="hidden" name="sjkeluar_id"/>
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
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update SJ Keluar";}else{$namabutton='name="create"';$judul="Create SJ Keluar";}?>	
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<?php if(isset($_POST['edit'])){?>
								<div class="form-group">
								<label class="control-label col-sm-2" for="sjkeluar_no1">SJ No.:</label>
                                <div class="col-sm-10" align="left">
									  <input type="text" id="sjkeluar_no" name="sjkeluar_no" class="form-control" value="<?=$sjkeluar_no;?>">
								</div>
                              </div>
							  <?php }?>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="customer_id">Customer:</label>
								<div class="col-sm-10">
								  <select name="customer_id" class="form-control" required>
								  <option value="">Select Customer</option>
								  <?php $prod=$this->db->get("customer");
								  foreach($prod->result() as $customer){?>
								  <option value="<?=$customer->customer_id;?>" <?php if($customer_id==$customer->customer_id||(isset($_GET['customer_id'])&&$_GET['customer_id']==$customer->customer_id)){?>selected="selected"<?php }?>>
								  	<?=$customer->customer_name;?>
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>
													  
							  	
													  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="sjkeluar_pengirim">Pengirim:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="sjkeluar_pengirim" id="sjkeluar_pengirim" value="<?=($sjkeluar_pengirim!="")?$sjkeluar_pengirim:$this->session->userdata("user_name");?>"/>
								</div>
							  </div>	
							  				  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="sjkeluar_penerima">Penerima:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="sjkeluar_penerima" id="sjkeluar_penerima" value="<?=$sjkeluar_penerima;?>"/>
								</div>
							  </div>
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="sjkeluar_date">Date:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control date" name="sjkeluar_date" id="sjkeluar_date" value="<?=($sjkeluar_date!="")?$sjkeluar_date:date("Y-m-d");?>"/>
								</div>
							  </div>	
							  				  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="sjkeluar_ekspedisi">Ekspedisi/Kendaraan:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="sjkeluar_ekspedisi" id="sjkeluar_ekspedisi" value="<?=$sjkeluar_ekspedisi;?>"/>
								</div>
							  </div>
							  				  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="sjkeluar_nopol">No. Pol:</label>
								<div class="col-sm-10">
								  <input type="text" class="form-control" name="sjkeluar_nopol" id="sjkeluar_nopol" value="<?=$sjkeluar_nopol;?>"/>
								</div>
							  </div>
							 <hr/>
							 <h3>Berita Acara</h3>							 
							  
							<div class="form-group">
								<label class="control-label col-sm-2" for="sjkeluar_title">Judul Berita Acara:</label>
								<div class="col-sm-10" align="left">
									  <input type="text" id="sjkeluar_title" name="sjkeluar_title" class="form-control" value="<?=$sjkeluar_title;?>">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="sjkeluar_pemberitugas">Penandatangan Pemberi Tugas:</label>
								<div class="col-sm-10" align="left">
									  <input type="text" id="sjkeluar_pemberitugas" name="sjkeluar_pemberitugas" class="form-control" value="<?=$sjkeluar_pemberitugas;?>">
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-sm-2" for="sjkeluar_penerimatugas">Penandatangan Penerima Tugas:</label>
								<div class="col-sm-10" align="left">
									  <input type="text" id="sjkeluar_penerimatugas" name="sjkeluar_penerimatugas" class="form-control" value="<?=$sjkeluar_penerimatugas;?>">
								</div>
							</div>
							 
							 <input class="form-control" type="hidden" name="inv_no" id="inv_no" value="<?=($inv_no!="")?$inv_no:$this->input->get("inv_no");?>"/>	
							 <input class="form-control" type="hidden" name="sjkeluar_id" id="sjkeluar_id" value="<?=$sjkeluar_id;?>"/>	
							 <input class="form-control" type="hidden" name="branch_id" id="branch_id" value="<?=$this->session->userdata("branch_id");?>"/>					  					  				  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<a class="btn btn-warning col-md-offset-1 col-md-5" href="<?=$currentUrl;?>">Back</a>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadsjkeluar_picture;?>
							</div>
							<?php }?>
							<div class="box">
								<div id="collapse4" class="body table-ressjkeluarnsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Date</th>
											<th>Branch</th>
											<th>SJ Keluar No. </th>
											<th>Customer</th>
											<?php if(!isset($_GET['report'])){$col="col-md-3";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['inv_no'])){$this->db->where("inv_no",$this->input->get("inv_no"));}
										$usr=$this->db
										->join("branch","branch.branch_id=sjkeluar.branch_id","left")
										->join("customer","customer.customer_id=sjkeluar.customer_id","left")
										->order_by("sjkeluar_id","desc")
										->get("sjkeluar");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $sjkeluar){?>
										<tr>	
											<td><?=$no++;?></td>										
											<td><?=$sjkeluar->sjkeluar_date;?></td>					
											<td><?=$sjkeluar->branch_name;?></td>
											<td><?=$sjkeluar->sjkeluar_no;?></td>
											<td><?=$sjkeluar->customer_name;?></td>
											<td style="text-align:center; ">  
											<?php if(!isset($_GET['report'])){$float="float:right;";?>   									
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="sjkeluar_no" value="<?=$sjkeluar->sjkeluar_no;?>"/>
												</form>	                                      											
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="sjkeluar_id" value="<?=$sjkeluar->sjkeluar_id;?>"/>
												</form>	
											<?php }else{$float="";}?>											
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Print Surat Jalan" target="_blank" href="<?=site_url("sjkeluarprint?sjkeluar_no=".$sjkeluar->sjkeluar_no)."&customer_id=".$sjkeluar->customer_id;?>" class="btn btn-sm btn-success " name="edit" value="OK"> 
												  <span class="fa fa-print" style="color:white;"></span> 
												  </a>
												</form>  										
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Print Berita Acara" target="_blank" href="<?=site_url("beritaacaraprint?sjkeluar_no=".$sjkeluar->sjkeluar_no)."&customer_id=".$sjkeluar->customer_id;?>" class="btn btn-sm btn-success " name="edit" value="OK"> 
												  <span class="fa fa-file" style="color:white;"></span> 
												  </a>
												</form>  
											<?php if(!isset($_GET['report'])){?>  
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
												  <a data-toggle="tooltip" title="List Product" target="_blank" href="<?=site_url("sjkeluarproduct?sjkeluar_no=".$sjkeluar->sjkeluar_no)."&customer_id=".$sjkeluar->customer_id;?>" class="btn btn-sm btn-info " name="edit" value="OK">
												  <span class="fa fa-shopping-bag" style="color:white;"></span>											  </a>
												</form> 	
											<?php }?>		
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
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
